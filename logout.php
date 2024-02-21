<?php
    // start session
    session_start();
    
    //destory session
    session_destroy();

    // directs to login form
    echo "<script>window.location = 'login_form.php'</script>";
?>