function toggleMenu() {
    document.querySelector(".nav-links").classList.toggle("show");
}

document.addEventListener('DOMContentLoaded', function () {
    fetchProjectCards();
});

function fetchProjectCards() {
    const container = document.querySelector('.container');
    if (!container) return;

    container.innerHTML = '<div class="loading">Loading projects...</div>';

    fetch('index_get_materials.php?category=projects&limit=5')
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            if (data.success && data.data.length > 0) {
                displayProjectCards(data.data);
            } else {
                container.innerHTML = '<p class="no-projects">No projects found</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = `<p class="error">Error loading projects: ${error.message}</p>`;
        });
}

function formatDuration(minutes) {
    if (!minutes) return 'N/A';
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return hours > 0 ? `${hours}h ${mins}m` : `${mins}m`;
}

function displayProjectCards(projects) {
    const container = document.querySelector('.container');
    if (!container) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'cards-wrapper';

    // Create two copies of cards for seamless looping
    const cards = [...projects, ...projects].map(project => {
        return `
            <div class="card">
                <div class="card-inner">
                    <div class="card-front">
                        <h3>${project.title}</h3>
                        <p class="category">${project.category.toUpperCase()}</p>
                        <span class="level ${project.level}">${project.level.toUpperCase()}</span>
                    </div>
                    <div class="card-back">
                        <p class="description">${project.description}</p>
                        <div class="meta">
                            <span><i class="fas fa-file-alt"></i> ${project.type}</span>
                            <span><i class="fas fa-clock"></i> ${formatDuration(project.duration)}</span>
                        </div>
                        <div class="actions">
                            <a href="${project.file_url}" class="btn download" target="_blank" download>
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="${project.preview_link}" class="btn preview">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    wrapper.innerHTML = cards;
    container.innerHTML = '';
    container.appendChild(wrapper);

    initCardAnimation();
    setupAnimationControls();
    initCardHover();
}

function initCardHover() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.querySelector('.card-inner').style.transform = 'rotateY(180deg)';
        });
        card.addEventListener('mouseleave', () => {
            card.querySelector('.card-inner').style.transform = '';
        });
    });
}

function initCardAnimation() {
    const wrapper = document.querySelector('.cards-wrapper');
    if (!wrapper) return;

    const cardWidth = 300; // Must match your CSS card width
    const gap = 20; // Must match your CSS gap
    const totalWidth = (cardWidth + gap) * wrapper.children.length / 2; // Divide by 2 since we duplicated

    wrapper.style.width = `${totalWidth * 2}px`; // Double width for seamless looping

    // Adjust animation speed (lower duration = faster)
    const baseDuration = 20; // Base duration in seconds
    const duration = (baseDuration * (wrapper.children.length / 2)) / 5;
    wrapper.style.animation = `scroll ${duration}s linear infinite`;
}

function setupAnimationControls() {
    const container = document.querySelector('.container');
    const wrapper = document.querySelector('.cards-wrapper');

    if (!container || !wrapper) return;

    let isScrolling = false;
    let scrollTimeout;

    container.addEventListener('mouseenter', () => {
        wrapper.style.animationPlayState = 'paused';
    });

    container.addEventListener('mouseleave', () => {
        if (!isScrolling) {
            wrapper.style.animationPlayState = 'running';
        }
    });

    // Handle manual scrolling
    container.addEventListener('scroll', () => {
        isScrolling = true;
        wrapper.style.animationPlayState = 'paused';

        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            isScrolling = false;
            wrapper.style.animationPlayState = 'running';
        }, 1000); // Resume after 1 second of inactivity
    });
}