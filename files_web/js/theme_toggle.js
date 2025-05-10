// Quando la pagina ha finito di caricarsi...
document.addEventListener('DOMContentLoaded', () => {
    
    // Legge il tema salvato precedentemente (se esiste) dal localStorage
    const currentTheme = localStorage.getItem('theme');

    // Se il tema salvato è 'dark', aggiunge la classe 'dark-mode' al body
    // così il CSS può applicare lo stile scuro
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }

    // Cerca un elemento con ID 'toggle-theme', che dovrebbe essere il bottone per cambiare tema
    const btn = document.getElementById('toggle-theme');

    // Se esiste (quindi se siamo in una pagina che ha questo bottone)
    if (btn) {
        // Aggiunge un listener per il click sul bottone
        btn.addEventListener('click', () => {
            // Alterna la classe 'dark-mode' al body: se c'è la rimuove, se non c'è la aggiunge
            document.body.classList.toggle('dark-mode');

            // Controlla se ora il tema è dark (cioè se la classe è presente)
            const isDark = document.body.classList.contains('dark-mode');

            // Salva la preferenza nel localStorage come 'dark' o 'light'
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    }
});
