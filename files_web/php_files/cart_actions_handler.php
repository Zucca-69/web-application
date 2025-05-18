<?php
// Process cart actions if form was submitted
if (isset($_POST['cart_action']) && isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $action = $_POST['cart_action'];
    $quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    
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
                          (FKuserId, FKproductId, FKcartId, tipologia, timestamp)
                          VALUES (?, ?, ?, 'carrello', NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iii", $userId, $productId, $cartId);
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
    }
    
    // Refresh page to show changes
    header("Location: mostra-prodotti.php?productId=" . $productId);
    exit();
}