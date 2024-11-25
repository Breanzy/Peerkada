<?php

// For index
if (isset($_SESSION['error'])) {
    echo "
        <div id='error-notification' class='p-2 alert alert-danger alert-dismissible fadee'>
            <h4><i class='icon fa fa-warning fadee'></i> Error!</h4>
            " . $_SESSION['error'] . "
        </div>
        <script>
            // Set a timeout to remove the notification after 4 seconds
            setTimeout(function() {
                var notification = document.getElementById('error-notification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }, 4000);
        </script>
    ";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "
        <div id='success-notification' class='p-2 success alert-success alert-dismissible fadee'>
            <h4><i class='icon fa fa-check'></i> Success!</h4>
            " . $_SESSION['success'] . "
        </div>
        <script>
            // Set a timeout to remove the notification after 4 seconds
            setTimeout(function() {
                var notification = document.getElementById('success-notification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }, 4000); 
        </script>
        ";
    unset($_SESSION['success']);
}
