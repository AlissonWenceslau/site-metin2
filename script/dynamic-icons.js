document.addEventListener("DOMContentLoaded", function() {
    let path = window.location.pathname.split("/").pop();
    const currentPage = (path === "" || path === "/") ? "index.php" : path;

    const navLinks = document.querySelectorAll('#mainNav .nav-link');

    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');

        if (linkHref.includes(currentPage)) {
            link.classList.add('active');

            const icon = link.querySelector('i');
            if (icon) {
                const iconClass = icon.classList[1]; 
                if (iconClass && !iconClass.includes('-fill')) {
                    icon.classList.replace(iconClass, `${iconClass}-fill`);
                }
            }
        }
    });
});