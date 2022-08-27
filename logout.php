<?php
    if (isset($_GET["logout"])) {
        session_destroy();

        echo "<script type='text/javascript'>
            logout();
        </script>";
    }
?>