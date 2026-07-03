//Main Application JS

document.addEventListener('DOMContentLoaded', () => {
    highlightActiveNavbarLink();
    initializeAlertDismissals();
    initializeSearchInteraction();
    initializeResponsiveNavbar();
});

function highlightActiveNavbarLink() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        try {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (currentPath === linkPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
                link.classList.add('active');
            }
        } catch (e) {
            console.error('Error parsing link href:', e);
        }
    });
}

function initializeAlertDismissals() {
    const alerts = document.querySelectorAll('.success-alert, .error-alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease, max-height 0.5s ease, padding 0.5s ease, margin 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                alert.style.maxHeight = '0';
                alert.style.paddingTop = '0';
                alert.style.paddingBottom = '0';
                alert.style.marginTop = '0';
                alert.style.marginBottom = '0';
                
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 300);
        }, 4000);
    });
}

function initializeSearchInteraction() {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.querySelector('.search-input');
    
    if (searchForm && searchInput) {
        searchForm.addEventListener('submit', (e) => {
            if (searchInput.value.trim() === '') {
                e.preventDefault();
                searchInput.focus();
                searchInput.classList.add('input-error');
                
                setTimeout(() => {
                    searchInput.classList.remove('input-error');
                }, 500);
            }
        });
    }
}

function initializeResponsiveNavbar() {
    // 1. Client navbar toggle
    const toggleBtn = document.getElementById('nav-toggle');
    const navLinks = document.getElementById('nav-links');
    
    if (toggleBtn && navLinks) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                if (navLinks.classList.contains('active')) {
                    icon.className = 'fa-solid fa-xmark';
                } else {
                    icon.className = 'fa-solid fa-bars';
                }
            }
        });

        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !toggleBtn.contains(e.target)) {
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    const icon = toggleBtn.querySelector('i');
                    if (icon) icon.className = 'fa-solid fa-bars';
                }
            }
        });
    }

    // 2. Admin navbar toggle
    const adminToggleBtn = document.getElementById('admin-nav-toggle');
    const adminNavLinks = document.getElementById('admin-nav-links');

    if (adminToggleBtn && adminNavLinks) {
        adminToggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            adminNavLinks.classList.toggle('active');
            
            const icon = adminToggleBtn.querySelector('i');
            if (icon) {
                if (adminNavLinks.classList.contains('active')) {
                    icon.className = 'fa-solid fa-xmark';
                } else {
                    icon.className = 'fa-solid fa-bars';
                }
            }
        });

        document.addEventListener('click', (e) => {
            if (!adminNavLinks.contains(e.target) && !adminToggleBtn.contains(e.target)) {
                if (adminNavLinks.classList.contains('active')) {
                    adminNavLinks.classList.remove('active');
                    const icon = adminToggleBtn.querySelector('i');
                    if (icon) icon.className = 'fa-solid fa-bars';
                }
            }
        });

        // Sync admin menu selection with panels
        const adminNavItems = adminNavLinks.querySelectorAll('.admin-nav-item');
        adminNavItems.forEach(item => {
            item.addEventListener('click', () => {
                const targetId = item.getAttribute('data-target');
                if (!targetId) return;

                // Sync active classes
                adminNavItems.forEach(btn => {
                    if (btn.getAttribute('data-target') === targetId) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });

                // Simulate click on sidebar menu tab button
                const matchingSidebarBtn = document.querySelector(`.sidebar-menu-item[data-target="${targetId}"]`);
                if (matchingSidebarBtn) {
                    matchingSidebarBtn.click();
                }

                // Hide menu
                adminNavLinks.classList.remove('active');
                const icon = adminToggleBtn.querySelector('i');
                if (icon) icon.className = 'fa-solid fa-bars';
            });
        });
    }
}
