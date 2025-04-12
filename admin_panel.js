$(document).ready(function () {
    // Your other code...
    loadMaterials()

    $('#materialForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $formMessage = $('#formMessage');

        // Validate required fields
        let isValid = true;
        $('.form-control[required], .custom-select[required]').each(function () {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            $formMessage.addClass('alert-danger')
                .text('Please fill all required fields')
                .show();
            return false;
        }

        // Disable button and show spinner
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        $formMessage.hide().removeClass('alert-danger alert-success').empty();

        // Create FormData
        const formData = new FormData(this);

        // Debug: Log FormData contents
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // AJAX request
        $.ajax({
            url: 'save_material.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 30000,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                try {
                    // Parse response if string
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    if (response.success) {
                        $formMessage.addClass('alert-success').text(response.message).show();
                        $form[0].reset();
                        loadMaterials();

                        if (response.notified_subscribers) {
                            setTimeout(() => {
                                $formMessage.removeClass('alert-success')
                                    .addClass('alert-info')
                                    .text('Subscribers notified: ' +
                                        response.notification_result.sent_count + ' succeeded, ' +
                                        response.notification_result.failed_count + ' failed');
                            }, 1500);
                        }
                    } else {
                        throw new Error(response.message || 'Operation failed');
                    }
                } catch (e) {
                    $formMessage.addClass('alert-danger')
                        .html(`<i class="fas fa-exclamation-circle"></i> ${e.message}`)
                        .show();
                    console.error('Error:', e);
                }
            },
            error: function (xhr, status, error) {
                let message = 'Operation failed';
                let responseText = '';

                try {
                    responseText = xhr.responseText;
                    console.log('Raw response:', responseText);

                    if (responseText.startsWith('{') || responseText.startsWith('[')) {
                        const json = JSON.parse(responseText);
                        message = json.message || message;

                        // Check if the operation actually succeeded despite the error
                        if (json.success) {
                            $formMessage.addClass('alert-success')
                                .html(`<i class="fas fa-check-circle"></i> ${message}`)
                                .show();
                            $form[0].reset();
                            loadMaterials();
                            return;
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                $formMessage.addClass('alert-danger')
                    .html(`<i class="fas fa-exclamation-circle"></i> ${message}<br>
                        <small>${responseText.substring(0, 200)}</small>`)
                    .show();
                console.error('AJAX Error:', status, error, xhr.responseText);
            },
            complete: function () {
                $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Material');
            }
        });
    });

    // Function to load materials..........
    function loadMaterials() {
        $.ajax({
            url: 'get_material.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let html = '';

                if (!response.data || response.data.length === 0) {
                    html = '<div class="alert alert-info">No materials found.</div>';
                } else {
                    response.data.forEach(material => {
                        html += `
                                <div class="material-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5>${material.title}</h5>
                                        <span class="level-badge ${material.level}">
                                            ${material.level.charAt(0).toUpperCase() + material.level.slice(1)}
                                        </span>
                                    </div>
                                    <p class="text-muted">${material.description}</p>
                                    <div class="d-flex justify-content-between">
                                        <small><strong>Category:</strong> ${material.category}</small>
                                        <small><strong>Type:</strong> ${material.type}</small>
                                        <small><strong>Duration:</strong> ${formatDuration(material.duration)}</small>
                                    </div>
                                </div>
                            `;
                    });
                }

                $('#materialsContainer').html(html);
            },
            error: function (xhr, status, error) {
                $('#materialsContainer').html(`
                        <div class="alert alert-danger">
                            Failed to load materials. Error: ${error}
                        </div>
                    `);
                console.error('Error loading materials:', error);
            }
        });
    }

    // Helper function to format duration
    function formatDuration(minutes) {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return hours > 0 ? `${hours}h ${mins}m` : `${mins}m`;
    }
});