/**
 * Admin Dashboard & Book Management JS
 */

document.addEventListener('DOMContentLoaded', () => {
    initializeNavigationTabs();
    initializeModalControls();
    initializeDeleteModal();
    initializeTableSearch();
    initializeDescriptionCounter();
    initializeFormValidation();
    initializeGoogleBooksAutocomplete();
});

// Panel Navigation Tabs Toggle
function initializeNavigationTabs() {
    const tabButtons = document.querySelectorAll('.sidebar-menu-item, .admin-tab-btn');
    const panels = document.querySelectorAll('.dash-panel');
    
    if (tabButtons.length === 0) return;

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            if (!targetId) return;

            tabButtons.forEach(btn => {
                if (btn.getAttribute('data-target') === targetId) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            panels.forEach(panel => panel.classList.remove('active'));
            const targetPanel = document.getElementById(targetId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
            
            sessionStorage.setItem('admin_active_tab', targetId);
        });
    });

    // Restore active panel on reload
    const savedTab = sessionStorage.getItem('admin_active_tab');
    if (savedTab) {
        const matchingBtn = document.querySelector(`.sidebar-menu-item[data-target="${savedTab}"], .admin-tab-btn[data-target="${savedTab}"]`);
        if (matchingBtn) {
            matchingBtn.click();
        }
    }
}

// Add/Edit Book Modal Controls
function initializeModalControls() {
    const modal = document.getElementById('add-book-modal');
    const openBtn = document.getElementById('btn-trigger-modal');
    const closeBtn = document.getElementById('btn-close-modal');
    const cancelBtn = document.getElementById('btn-cancel-modal');

    const modalForm = document.getElementById('crud-book-form');
    const modalTitleText = document.getElementById('modal-title-text');
    const modalSubmitBtn = document.getElementById('btn-save-modal-text');
    const methodFieldContainer = document.getElementById('method-field-container');

    const titleInput = document.getElementById('title');
    const authorInput = document.getElementById('author');
    const priceInput = document.getElementById('price');
    const availableSelect = document.getElementById('is_available');
    const descriptionTextarea = document.getElementById('description');

    if (!modal) return;

    const openModal = () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        
        if (modalForm) {
            modalForm.querySelectorAll('.input-error-border').forEach(input => {
                input.classList.remove('input-error-border');
            });
            modalForm.querySelectorAll('.input-error-msg').forEach(msg => {
                msg.remove();
            });
        }

        const suggestionsDropdown = document.getElementById('suggestions-list');
        if (suggestionsDropdown) {
            suggestionsDropdown.classList.remove('active');
            suggestionsDropdown.innerHTML = '';
        }
    };

    // Setup Create Mode
    const setAddMode = () => {
        if (!modalForm) return;

        modalTitleText.textContent = "Add New Book";
        modalSubmitBtn.innerHTML = '<i class="fa-solid fa-plus"></i> Save Book';
        modalForm.action = "/admin/books";

        if (methodFieldContainer) {
            methodFieldContainer.innerHTML = '';
        }

        if (titleInput) titleInput.value = '';
        if (authorInput) authorInput.value = '';
        if (priceInput) priceInput.value = '';
        if (availableSelect) availableSelect.value = '1';
        if (descriptionTextarea) {
            descriptionTextarea.value = '';
            descriptionTextarea.dispatchEvent(new Event('input'));
        }

        openModal();
    };

    if (openBtn) openBtn.addEventListener('click', setAddMode);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Setup Edit Mode
    document.addEventListener('click', (e) => {
        const editBtn = e.target.closest('.btn-edit-action');
        if (!editBtn || !modalForm) return;

        e.preventDefault();

        const bookId = editBtn.getAttribute('data-id');
        const bookTitle = editBtn.getAttribute('data-title');
        const bookAuthor = editBtn.getAttribute('data-author');
        const bookPrice = editBtn.getAttribute('data-price');
        const bookAvailable = editBtn.getAttribute('data-available');
        const bookDescription = editBtn.getAttribute('data-description');

        modalTitleText.textContent = `Edit Book: ${bookTitle}`;
        modalSubmitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Update Book';
        modalForm.action = `/admin/books/${bookId}`;

        if (methodFieldContainer) {
            methodFieldContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        }

        if (titleInput) titleInput.value = bookTitle;
        if (authorInput) authorInput.value = bookAuthor;
        if (priceInput) priceInput.value = bookPrice;
        if (availableSelect) availableSelect.value = bookAvailable;
        if (descriptionTextarea) {
            descriptionTextarea.value = bookDescription || '';
            descriptionTextarea.dispatchEvent(new Event('input'));
        }

        modalForm.querySelectorAll('.input-error-border').forEach(input => {
            input.classList.remove('input-error-border');
        });
        modalForm.querySelectorAll('.input-error-msg').forEach(msg => {
            msg.remove();
        });

        openModal();
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}

// Custom Delete Confirmation Modal
function initializeDeleteModal() {
    const deleteModal = document.getElementById('delete-confirm-modal');
    const deleteTitleDisplay = document.getElementById('delete-book-title-display');
    const confirmDeleteBtn = document.getElementById('btn-confirm-delete-action');
    const closeBtn = document.getElementById('btn-close-delete-modal');
    const cancelBtn = document.getElementById('btn-cancel-delete-modal');

    if (!deleteModal) return;

    let targetFormReference = null;

    const openDeleteModal = (bookTitle, form) => {
        targetFormReference = form;
        if (deleteTitleDisplay) {
            deleteTitleDisplay.textContent = `"${bookTitle}"`;
        }
        deleteModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeDeleteModal = () => {
        deleteModal.classList.remove('active');
        document.body.style.overflow = '';
        targetFormReference = null;
    };

    if (closeBtn) closeBtn.addEventListener('click', closeDeleteModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeDeleteModal);

    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && deleteModal.classList.contains('active')) {
            closeDeleteModal();
        }
    });

    document.addEventListener('click', (e) => {
        const deleteTrigger = e.target.closest('.btn-trigger-delete');
        if (!deleteTrigger) return;

        e.preventDefault();
        const bookTitle = deleteTrigger.getAttribute('data-title') || 'this book';
        const form = deleteTrigger.closest('.delete-book-form');

        if (form) {
            openDeleteModal(bookTitle, form);
        }
    });

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', () => {
            if (targetFormReference) {
                targetFormReference.submit();
            }
        });
    }
}

// Client-Side Search Table Filtering
function initializeTableSearch() {
    const searchInput = document.getElementById('table-search');
    const tableRows = document.querySelectorAll('#inventory-table tbody tr.book-row');

    if (!searchInput || tableRows.length === 0) return;

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const titleElement = row.querySelector('.search-title');
            const authorElement = row.querySelector('.search-author');
            
            const titleText = titleElement ? titleElement.textContent.toLowerCase() : '';
            const authorText = authorElement ? authorElement.textContent.toLowerCase() : '';

            if (titleText.includes(query) || authorText.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Description Textarea Character Counter
function initializeDescriptionCounter() {
    const descriptionTextarea = document.getElementById('description');
    if (!descriptionTextarea) return;

    let counterContainer = document.getElementById('description-counter');
    if (!counterContainer) {
        counterContainer = document.createElement('div');
        counterContainer.id = 'description-counter';
        counterContainer.style.fontSize = '0.85rem';
        counterContainer.style.color = '#64748b';
        counterContainer.style.marginTop = '0.25rem';
        counterContainer.style.textAlign = 'right';
        descriptionTextarea.parentNode.appendChild(counterContainer);
    }

    const maxChars = 2000;

    const updateCounter = () => {
        const currentLength = descriptionTextarea.value.length;
        counterContainer.textContent = `${currentLength} / ${maxChars} characters`;

        if (currentLength >= maxChars) {
            counterContainer.style.color = '#ef4444';
            counterContainer.style.fontWeight = 'bold';
        } else if (currentLength >= maxChars - 100) {
            counterContainer.style.color = '#f59e0b';
            counterContainer.style.fontWeight = 'normal';
        } else {
            counterContainer.style.color = '#64748b';
            counterContainer.style.fontWeight = 'normal';
        }
    };

    updateCounter();
    descriptionTextarea.addEventListener('input', updateCounter);
}

// Client-Side Input Form Validation
function initializeFormValidation() {
    const crudForms = document.querySelectorAll('.crud-form');
    if (crudForms.length === 0) return;

    crudForms.forEach(form => {
        const titleInput = form.querySelector('#title');
        const authorInput = form.querySelector('#author');
        const priceInput = form.querySelector('#price');
        const descriptionTextarea = form.querySelector('#description');

        const inputs = [titleInput, authorInput, priceInput, descriptionTextarea];
        inputs.forEach(input => {
            if (!input) return;
            input.addEventListener('input', () => {
                clearInputError(input);
            });
        });

        form.addEventListener('submit', (e) => {
            let hasErrors = false;

            if (titleInput && titleInput.value.trim() === '') {
                showInputError(titleInput, 'Book title is required.');
                hasErrors = true;
            }

            if (authorInput && authorInput.value.trim() === '') {
                showInputError(authorInput, 'Author name is required.');
                hasErrors = true;
            }

            if (priceInput) {
                const priceVal = parseFloat(priceInput.value);
                if (isNaN(priceVal) || priceInput.value.trim() === '') {
                    showInputError(priceInput, 'Book price is required.');
                    hasErrors = true;
                } else if (priceVal < 0) {
                    showInputError(priceInput, 'Price cannot be less than 0.');
                    hasErrors = true;
                }
            }

            if (descriptionTextarea && descriptionTextarea.value.length > 2000) {
                showInputError(descriptionTextarea, 'Description cannot exceed 2000 characters.');
                hasErrors = true;
            }

            if (hasErrors) {
                e.preventDefault();
                const firstError = form.querySelector('.input-error-border');
                if (firstError) {
                    firstError.focus();
                }
            }
        });
    });
}

function showInputError(input, message) {
    clearInputError(input);
    input.classList.add('input-error-border');
    
    const errorMsg = document.createElement('span');
    errorMsg.className = 'input-error-msg';
    errorMsg.textContent = message;
    errorMsg.style.color = '#ef4444';
    errorMsg.style.fontSize = '0.85rem';
    errorMsg.style.marginTop = '0.25rem';
    errorMsg.style.display = 'block';
    
    input.parentNode.appendChild(errorMsg);
}

function clearInputError(input) {
    input.classList.remove('input-error-border');
    const parent = input.parentNode;
    const errorMsg = parent.querySelector('.input-error-msg');
    if (errorMsg) {
        errorMsg.remove();
    }
}

// Google Books API Autocomplete
function initializeGoogleBooksAutocomplete() {
    const titleInput = document.querySelector('#add-book-modal #title');
    const authorInput = document.querySelector('#add-book-modal #author');
    const descriptionTextarea = document.querySelector('#add-book-modal #description');
    const suggestionsDropdown = document.getElementById('suggestions-list');

    if (!titleInput || !suggestionsDropdown) return;

    let debounceTimeout = null;
    let isApiCooledDown = false;
    const cooldownDuration = 45000;

    titleInput.addEventListener('input', () => {
        const query = titleInput.value.trim();
        clearTimeout(debounceTimeout);

        if (query.length < 3) {
            suggestionsDropdown.classList.remove('active');
            suggestionsDropdown.innerHTML = '';
            return;
        }

        if (isApiCooledDown) {
            searchLocalCatalog(query, "API limit reached. Showing local catalog...");
            return;
        }

        debounceTimeout = setTimeout(() => {
            fetchGoogleBooks(query);
        }, 350);
    });

    document.addEventListener('click', (e) => {
        if (!titleInput.contains(e.target) && !suggestionsDropdown.contains(e.target)) {
            suggestionsDropdown.classList.remove('active');
        }
    });

    async function fetchGoogleBooks(query) {
        try {
            let url = `https://www.googleapis.com/books/v1/volumes?q=intitle:${encodeURIComponent(query)}&maxResults=5`;
            if (window.googleBooksApiKey && window.googleBooksApiKey.trim() !== '') {
                url += `&key=${window.googleBooksApiKey}`;
            }
            const response = await fetch(url);
            
            if (response.status === 429) {
                activateApiCooldown();
                searchLocalCatalog(query, "API limit reached. Showing local catalog...");
                return;
            }

            if (!response.ok) throw new Error('API fetch request failed');
            
            const data = await response.json();
            if (data.items && data.items.length > 0) {
                renderSuggestions(data.items, false);
            } else {
                searchLocalCatalog(query, "No Google results. Checking local database...");
            }
        } catch (error) {
            console.error('Error fetching Google Books metadata:', error);
            searchLocalCatalog(query, "Lookup error. Checking local database...");
        }
    }

    function activateApiCooldown() {
        isApiCooledDown = true;
        setTimeout(() => {
            isApiCooledDown = false;
        }, cooldownDuration);
    }

    function searchLocalCatalog(query, noticeMessage = "") {
        const catalog = window.localBooksCatalog || [];
        const lowercaseQuery = query.toLowerCase();

        const matches = catalog.filter(book => {
            const titleMatch = book.title && book.title.toLowerCase().includes(lowercaseQuery);
            const authorMatch = book.author && book.author.toLowerCase().includes(lowercaseQuery);
            return titleMatch || authorMatch;
        });

        if (matches.length > 0) {
            const simulatedItems = matches.map(book => {
                return {
                    volumeInfo: {
                        title: book.title,
                        authors: [book.author],
                        description: book.description
                    }
                };
            });
            renderSuggestions(simulatedItems, true, noticeMessage);
        } else {
            renderEmptyNotice(noticeMessage ? `${noticeMessage} (No matches found)` : "No local suggestions found.");
        }
    }

    function renderSuggestions(books, isLocal = false, noticeMessage = "") {
        suggestionsDropdown.innerHTML = '';
        
        if (noticeMessage) {
            const noticeDiv = document.createElement('div');
            noticeDiv.className = 'suggestions-dropdown-notice';
            if (isLocal && noticeMessage.includes("limit")) {
                noticeDiv.className += ' warning';
                noticeDiv.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${noticeMessage}`;
            } else {
                noticeDiv.innerHTML = `<i class="fa-solid fa-circle-info"></i> ${noticeMessage}`;
            }
            suggestionsDropdown.appendChild(noticeDiv);
        }

        books.forEach(book => {
            const info = book.volumeInfo;
            if (!info.title) return;

            const authors = info.authors ? info.authors.join(', ') : 'Unknown Author';
            
            const item = document.createElement('div');
            item.className = 'suggestion-item';
            
            item.innerHTML = `
                <span class="suggestion-title">${info.title}</span>
                <span class="suggestion-author">${isLocal ? '[Local Catalog]' : ''} by ${authors}</span>
            `;

            item.addEventListener('click', () => {
                titleInput.value = info.title;
                if (authorInput) authorInput.value = authors;
                
                if (descriptionTextarea) {
                    descriptionTextarea.value = info.description || '';
                    descriptionTextarea.dispatchEvent(new Event('input'));
                }

                suggestionsDropdown.classList.remove('active');
                suggestionsDropdown.innerHTML = '';
            });

            suggestionsDropdown.appendChild(item);
        });

        suggestionsDropdown.classList.add('active');
    }

    function renderEmptyNotice(message) {
        suggestionsDropdown.innerHTML = '';
        
        const noticeDiv = document.createElement('div');
        noticeDiv.className = 'suggestions-dropdown-notice warning';
        noticeDiv.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${message}`;
        
        suggestionsDropdown.appendChild(noticeDiv);
        suggestionsDropdown.classList.add('active');
    }
}
