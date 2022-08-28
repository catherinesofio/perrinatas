<?php
    if (isset($_GET["logout"])) {
        session_destroy();

        echo "<script type='text/javascript' src='/perrinatas/scripts/session_storage.js'></script>
        <script type='text/javascript'>
            logout();
        </script>";
    }
?>