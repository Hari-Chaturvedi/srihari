document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;

    // Set loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        });

        // First check if we got a response
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Try to parse JSON
        const data = await response.json().catch(err => {
            throw new Error('Invalid server response');
        });

        // Handle response
        if (data.success) {
            alert(data.message);
            form.reset();
        } else {
            throw new Error(data.error || 'Request failed');
        }
    } catch (error) {
        console.error('Submission error:', error);
        alert(error.message);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});