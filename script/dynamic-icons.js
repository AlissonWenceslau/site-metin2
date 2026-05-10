document.addEventListener("DOMContentLoaded", function() {
    // 1. Pega o nome do arquivo atual pela URL (ex: download.php)
    const currentPage = window.location.pathname.split("/").pop();

    // 2. Seleciona todos os links do seu menu
    const navLinks = document.querySelectorAll('#mainNav .nav-link');

    navLinks.forEach(link => {
        // Pega o href do link (ex: index.php ou ./pages/download.php)
        const linkHref = link.getAttribute('href');

        // 3. Verifica se o link aponta para a página atual
        if (linkHref.includes(currentPage) && currentPage !== "") {
            
            // Adiciona a classe active do Bootstrap caso não tenha
            link.classList.add('active');

            // 4. Seleciona o ícone e faz a mágica do -fill
            const icon = link.querySelector('i');
            if (icon) {
                // Pega a segunda classe (ex: bi-house-door) e adiciona o -fill
                const iconClass = icon.classList[1]; 
                if (!iconClass.includes('-fill')) {
                    icon.classList.replace(iconClass, `${iconClass}-fill`);
                }
            }
        }
    });
});