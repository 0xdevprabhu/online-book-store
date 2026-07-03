//Main Application JS


document.addEventListener('DOMContentLoaded', () => {
    highlightActiveNavbarLink();
    initializeAlertDismissals();
    initializeSearchInteraction();
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
