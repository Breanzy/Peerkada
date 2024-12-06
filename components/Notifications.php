<?php

function renderNotification($type, $message)
{
    $icon = $type === 'error' ? 'fa-warning' : 'fa-check';
    $alertClass = $type === 'error' ? 'alert-danger' : 'alert-success';

    echo "
        <div id='notification' class='alert {$alertClass} alert-dismissible fade show notification fadee' role='alert'>
            <h4 class='alert-heading text-nowrap'><i class='icon fa {$icon}'></i> " . ucfirst($type) . "!</h4>
            <span class='text-nowrap'>" . htmlspecialchars($message) . "</span>
        </div>
        <script>
            setTimeout(function() {
                var notification = document.getElementById('notification');
                if (notification) {
                    notification.fadeOut(1000, function() {
                        this.style.display = 'none';
                    });
            }, 4000);
        </script>
    ";
}

echo "<div class='notification-container' style='position: relative;'>";

if (isset($_SESSION['error'])) {
    renderNotification('error', $_SESSION['error']);
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    renderNotification('success', $_SESSION['success']);
    unset($_SESSION['success']);
}

echo "</div>"; // Close the notification container
?>

<style>
    #notification {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        z-index: 1000;
    }
</style>