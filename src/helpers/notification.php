<?php

/**
 * Responsible for adding messages to the "DyoxFy" array for viewing on view
 * @param string $message - The Message to display
 * @param string $type - The type of message
 * @return void
 */
function show_notification(string $message, string $type, string $local = "top-right", int $time = 5000): void
{
    $_SESSION["notifications"][] = [
        "type" => $type,
        "message" => $message,
        "local" => $local,
        "time" => $time,
    ];
}


/**
 * Responsible display messages using js
 * @return void
 */
function viewingNotifications(): void
{
    if (isset($_SESSION["notifications"])) {
        foreach ($_SESSION["notifications"] as $toastKey => $toast) {
            $message = str_replace("'", "\'", $toast['message']);
            $type = $toast['type'];
            $local = $toast["local"];
            $timeRemove = $toast["time"];
            $time = $toastKey * 1000;
            echo "<script>
                setTimeout(() => notificationsToast('{$type}', '{$message}', '{$local}', {$timeRemove}), $time)
            </script>";
        }
        unset($_SESSION["notifications"]);
    }
}



function notification()
{
    return new class {
        public function success(string $m)
        {
            show_notification($m, 'success');
            return $this;
        }

        public function error(string $m)
        {
            show_notification($m, 'error');
            return $this;
        }

        public function warning(string $m)
        {
            show_notification($m, 'warning');
            return $this;
        }
    };
}
