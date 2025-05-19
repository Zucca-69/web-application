<?php
// Process cart actions if form was submitted
if (isset($_POST['cart_action']) && isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $action = $_POST['cart_action'];
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    $productId = $_POST['productId'] ?? null;
    $piattaforma = $_POST['piattaforma'] ?? null;
    $redirect = $_POST['redirect'] ?? null;

    
    // Handle different actions
    switch ($action) {
        case 'add':
            // First check if product already in any cart
            $query = "SELECT c.cartId, c.quantita 
                      FROM interazioni i
                      JOIN carrelli c ON i.FKcartId = c.cartId
                      WHERE i.tipologia = 'carrello'
                      AND i.FKuserId = ?
                      AND i.FKproductId = ?
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update existing cart item
                $item = $result->fetch_assoc();
                $newQty = $item['quantita'] + $quantity;
                
                $query = "UPDATE carrelli SET quantita = ? WHERE cartId = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $newQty, $item['cartId']);
                $stmt->execute();
            } else {
                // Create new cart and interaction
                // 1. Create new cart
                $query = "INSERT INTO carrelli (quantita) VALUES (?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $quantity);
                $stmt->execute();
                $cartId = $stmt->insert_id;
                
                // 2. Create new interaction
                $query = "INSERT INTO interazioni 
                          (FKuserId, FKproductId, FKpiattaforma, FKcartId, tipologia, timestamp)
                          VALUES (?, ?, ?, ?, 'carrello', NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iisi", $userId, $productId, $piattaforma, $cartId);
                $stmt->execute();
            }
            break;
            
        case 'update':
            // Get the cart for this product
            $query = "SELECT i.FKcartId, c.quantita
                      FROM interazioni i
                      JOIN carrelli c ON i.FKcartId = c.cartId
                      WHERE i.tipologia = 'carrello'
                      AND i.FKuserId = ?
                      AND i.FKproductId = ?
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $item = $result->fetch_assoc();
                $cartId = $item['FKcartId'];
                
                if ($quantity <= 0) {
                    // Remove completely
                    $query = "DELETE FROM interazioni 
                              WHERE FKcartId = ? AND tipologia = 'carrello'";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $cartId);
                    $stmt->execute();
                    
                    $query = "DELETE FROM carrelli WHERE cartId = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $cartId);
                } else {
                    // Update quantity
                    $query = "UPDATE carrelli SET quantita = ? WHERE cartId = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ii", $quantity, $cartId);
                }
                $stmt->execute();
            }
            break;
            
        case 'remove':
            // Get the cart for this product
            $query = "SELECT i.FKcartId
                      FROM interazioni i
                      WHERE i.tipologia = 'carrello'
                      AND i.FKuserId = ?
                      AND i.FKproductId = ?
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userId, $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $item = $result->fetch_assoc();
                $cartId = $item['FKcartId'];
                
                // Remove interaction and cart
                $query = "DELETE FROM interazioni 
                          WHERE FKcartId = ? AND tipologia = 'carrello'";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $cartId);
                $stmt->execute();
                
                $query = "DELETE FROM carrelli WHERE cartId = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $cartId);
                $stmt->execute();
            }
        break;
case 'checkout':
    // Start transaction for atomic operations
    $conn->begin_transaction();
    
    try {
        // Recupera tutti i prodotti nel carrello dell'utente
        $query = "SELECT i.FKcartId, i.FKproductId, c.quantita, p.quantitaDisponibile, p.nome
                  FROM interazioni i
                  JOIN carrelli c ON i.FKcartId = c.cartId
                  JOIN prodotti p ON i.FKproductId = p.productId
                  WHERE i.tipologia = 'carrello' AND i.FKuserId = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $outOfStockItems = [];
        
        while ($row = $result->fetch_assoc()) {
            $cartId = $row['FKcartId'];
            $productId = $row['FKproductId'];
            $quantita = $row['quantita'];
            $available = $row['quantitaDisponibile'];
            $productName = $row['nome'];

            // Check stock availability
            if ($available < $quantita) {
                $outOfStockItems[] = [
                    'name' => $productName,
                    'requested' => $quantita,
                    'available' => $available
                ];
                continue;
            }

            // Reduce product quantity
            $updateQuery = "UPDATE prodotti SET quantitaDisponibile = quantitaDisponibile - ? 
                            WHERE productId = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $quantita, $productId);
            $updateStmt->execute();

            // Create order record (you'll need to create this table)
            // $orderQuery = "INSERT INTO ordini (FKuserId, FKproductId, quantita, data_ordine, stato)
            //                VALUES (?, ?, ?, NOW(), 'completato')";
            // $orderStmt = $conn->prepare($orderQuery);
            // $orderStmt->bind_param("iii", $userId, $productId, $quantita);
            // $orderStmt->execute();

            // Remove interaction
            $deleteQuery = "DELETE FROM interazioni WHERE FKcartId = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $cartId);
            $deleteStmt->execute();

            // Remove cart
            $deleteCartQuery = "DELETE FROM carrelli WHERE cartId = ?";
            $deleteCartStmt = $conn->prepare($deleteCartQuery);
            $deleteCartStmt->bind_param("i", $cartId);
            $deleteCartStmt->execute();
        }

        if (!empty($outOfStockItems)) {
            // Handle out of stock items
            $_SESSION['out_of_stock'] = $outOfStockItems;
            $conn->rollback();
            header("Location: carrello.php?error=out_of_stock");
            exit();
        }

        $conn->commit();
        $_SESSION['checkout_success'] = true;
        header("Location: ../php_files/checkout_succes.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['checkout_error'] = $e->getMessage();
        header("Location: carrello.php?error=checkout_failed");
        exit();
    }
    break;
    }

    
    // Refresh page to show changes
    if ($redirect) {
    header("Location: $redirect");
    exit();
}
    exit();
}