<?php
    if (isset($_GET["logout"])) {
        trigger_logout();
    }

    function trigger_logout() {
        unset($_SESSION["id"]);
        unset($_SESSION["username"]);
        unset($_SESSION["type"]);
        unset($_SESSION["instant"]);

        session_destroy();

        $logout_action = <<<LOGOUT
            <script type='text/javascript'>
                function logout() {
                    sessionStorage.clear();
                
                    window.location.replace("/perrinatas/login.php");
                }
                
                logout();
            </script>
        LOGOUT;

        echo($logout_action);
    }
?>