document.addEventListener('DOMContentLoaded', function () {
    fetchProjects();
});

function fetchProjects() {
    const container = document.getElementById('projects-container');

    fetch('fetch_project.php?')
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            if (data.success && data.data.length > 0) {
                displayProjects(data.data);
            } else {
                container.innerHTML = '<p class="no-projects">No projects found</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = `<p class="error">Error loading projects: ${error.message}</p>`;
        });
}

function displayProjects(projects) {
    const container = document.getElementById('projects-container');
    container.innerHTML = '';

    projects.forEach(project => {
        const projectCard = document.createElement('div');
        const projectContent = document.createElement('div');

        projectCard.className = 'project-card';
        projectContent.className = 'project-content';

        // Use a default image if none is provided
        const imageUrl = project.thumbnail_path || 'https://via.placeholder.com/400x225?text=Project+Image';

        // Determine how to display the title (clickable or not)
        const titleDisplay = project.Git_url 
            ? `<a href="${project.Git_url}" target="_blank">${project.title}</a>`
            : project.title;

        // Only show GitHub link if URL exists
        const githubLink = project.Git_url 
            ? `<a href="${project.Git_url}" class="project-link" target="_blank">View on GitHub</a>`
            : '';

        projectCard.innerHTML = `
            <div class="project-image" style="background-image: url(${imageUrl})"></div>
            <div class="project-content">
                <h3>${titleDisplay}</h3>
                <p>${project.description}</p>
                <div class="project-meta">
                    <span class="level ${project.level.toLowerCase()}">${project.level.toUpperCase()}</span>
                    <span class="duration">${formatDuration(project.duration)}</span>
                </div>
                ${githubLink}
                ${project.file_path ? `<a href="${project.file_path}" class="project-link" target="_blank" download>Download Materials</a>` : ''}
                ${project.preview_link ? `<a href="${project.preview_link}" class="project-link" target="_blank">Live Preview</a>` : ''}
            </div>
        `;

        container.appendChild(projectCard);
    });
}

function formatDuration(minutes) {
    if (!minutes) return 'N/A';
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return hours > 0 ? `${hours}h ${mins}m` : `${mins}m`;
}