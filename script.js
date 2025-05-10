$(document).ready(function() {
    // Form submission handling
    $('#ajaxForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Get form data
        var formData = $(this).serialize();
        
        // Disable submit button to prevent multiple submissions
        $('#submit').prop('disabled', true).html('Processing...');
        
        // Send Ajax request
        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Show success message
                    $('#message').removeClass('error').addClass('success').html(response.message).fadeIn();
                    
                    // Reset the form
                    $('#ajaxForm')[0].reset();
                } else {
                    // Show error message
                    $('#message').removeClass('success').addClass('error').html(response.message).fadeIn();
                }
                
                // Re-enable submit button
                $('#submit').prop('disabled', false).html('Submit');
                
                // Hide the message after 5 seconds
                setTimeout(function() {
                    $('#message').fadeOut();
                }, 5000);
            },
            error: function(xhr, status, error) {
                // Show error message
                $('#message').removeClass('success').addClass('error').html('An error occurred. Please try again.').fadeIn();
                
                // Re-enable submit button
                $('#submit').prop('disabled', false).html('Submit');
                
                // Log error to console
                console.error(xhr.responseText);
            }
        });
    });
});