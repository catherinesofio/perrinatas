<?php
    function get_alert($type, $content) {
        $alert = <<<ALERT
            <div class='alert alert-{$type}' role='alert'>
                <h5>{$content}</h5>
            </div>
ALERT;

        return $alert;
    }
?>