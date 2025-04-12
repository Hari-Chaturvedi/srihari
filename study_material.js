document.addEventListener('DOMContentLoaded', function () {
    // DOM elements
    const materialsGrid = document.getElementById('materialsGrid');
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const sortSelect = document.getElementById('sortSelect');
    const categoryCards = document.querySelectorAll('.category-card');

    // Variable to store materials
    let materialsData = [];

    // Fetch materials from database
    fetchMaterials();

    // Event listeners
    searchButton.addEventListener('click', performSearch);
    searchInput.addEventListener('keyup', function (e) {
        if (e.key === 'Enter') performSearch();
    });
    sortSelect.addEventListener('change', performSort);
    categoryCards.forEach(card => {
        card.addEventListener('click', function () {
            const category = this.getAttribute('data-category');
            filterByCategory(category);
        });
    });

    // Fetch materials from server
    function fetchMaterials() {
        console.log('Attempting to fetch materials...');

        fetch('get_material.php')
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.success) {
                    materialsData = data.data;
                    displayMaterials(materialsData);
                } else {
                    throw new Error(data.error || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                materialsGrid.innerHTML = `
                    <p class="no-results">
                        Error loading materials: ${error.message}<br>
                        Please check your connection and try again.
                    </p>
                `;
            });
    }

    // Main functions
    function displayMaterials(materials) {
        materialsGrid.innerHTML = '';

        if (materials.length === 0) {
            materialsGrid.innerHTML = '<p class="no-results">No materials found matching your criteria.</p>';
            return;
        }

        materials.forEach(material => {
            const card = document.createElement('div');
            card.className = 'material-card';
            card.innerHTML = `
                <div class="card-header">
                    <span class="level-badge ${material.level}">${capitalizeFirstLetter(material.level)}</span>
                    <span class="topic-tag">${material.category.toUpperCase()}</span>
                </div>
                <div class="card-body">
                    <h3 class="card-title">${material.title}</h3>
                    <p class="card-desc">${material.description}</p>
                    <div class="card-meta">
                        <span><i class="${getIconClass(material.type)}"></i> ${material.type}</span>
                        <span><i class="far fa-clock"></i> ${formatDuration(material.duration)}</span>
                    </div>
                </div>
                <div class="card-footer">
                    ${material.file_path ? `<a href="${material.file_path}" class="download-btn" download>Download</a>` : ''}
                    <a href="#" class="preview-btn">Preview</a>
                </div>
            `;
            materialsGrid.appendChild(card);
        });
    }

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const filtered = materialsData.filter(material =>
            material.title.toLowerCase().includes(searchTerm) ||
            material.description.toLowerCase().includes(searchTerm) ||
            (material.tags && material.tags.some(tag => tag.toLowerCase().includes(searchTerm)))
        );
        displayMaterials(filtered);
    }

    function performSort() {
        const sortValue = sortSelect.value;
        let sortedMaterials = [...materialsData];

        switch (sortValue) {
            case 'title-asc':
                sortedMaterials.sort((a, b) => a.title.localeCompare(b.title));
                break;
            case 'title-desc':
                sortedMaterials.sort((a, b) => b.title.localeCompare(a.title));
                break;
            case 'duration-asc':
                sortedMaterials.sort((a, b) => a.duration - b.duration);
                break;
            case 'duration-desc':
                sortedMaterials.sort((a, b) => b.duration - a.duration);
                break;
            case 'level':
                const levelOrder = { beginner: 1, intermediate: 2, advanced: 3 };
                sortedMaterials.sort((a, b) => levelOrder[a.level] - levelOrder[b.level]);
                break;
            default:
                sortedMaterials.sort((a, b) => a.id - b.id);
        }

        displayMaterials(sortedMaterials);
    }

    function filterByCategory(category) {
        const filtered = materialsData.filter(material => material.category === category);
        displayMaterials(filtered);
    }

    // Helper functions
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function formatDuration(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return hours > 0 ? `${hours}h ${mins}m` : `${mins}m`;
    }

    function getIconClass(type) {
        const icons = {
            'PDF': 'far fa-file-pdf',
            'SQL Files': 'far fa-file-code',
            'Jupyter Notebook': 'fas fa-laptop-code',
            'Video Course': 'fas fa-video'
        };
        return icons[type] || 'far fa-file-alt';
    }
    // Newslatter Section
    document.querySelector('.newsletter form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const emailInput = form.querySelector('input[type="email"]');
        const email = emailInput.value.trim();
        const submitBtn = form.querySelector('button');
        const originalBtnText = submitBtn.innerHTML;
    
        // Clear previous messages
        const existingAlert = form.querySelector('.alert');
        if (existingAlert) existingAlert.remove();
    
        // Validate email
        if (!email) {
            showError(form, 'Please enter your email address');
            return;
        }
    
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError(form, 'Please enter a valid email address');
            return;
        }
    
        // UI feedback
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
    
        try {
            const response = await fetch('subscriber.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email })
            });
    
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
    
            const data = await response.json();
    
            if (data.success) {
                if (data.message.includes('could not be sent') || 
                    data.message.includes('not have been sent')) {
                    showSuccess(form, 'Subscription recorded! Please check your spam folder for the confirmation email.');
                } else {
                    showSuccess(form, data.message);
                }
                form.reset();
            } else {
                throw new Error(data.message || 'Subscription failed');
            }
        } catch (error) {
            console.error('Subscription error:', error);
            showError(form, error.message || 'An error occurred. Please try again later.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
    
    // Helper function to show error messages
    function showError(form, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mt-2';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle"></i> ${message}
        `;
        form.appendChild(alertDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // Helper function to show success messages
    function showSuccess(form, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success mt-2';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle"></i> ${message}
        `;
        form.appendChild(alertDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
})