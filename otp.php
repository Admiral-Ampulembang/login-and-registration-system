<?php 
    // start session
    session_start();

    // dbconnect file
    include 'dbconnect.php';

    // build connection to database using dbconnect file
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SESSION id
    $id = $_SESSION['id'];

    // SESSION id is not active and is empty
    if (!isset($_SESSION['id']) && empty($_SESSION['id']))
    {
        // directs back to login form
        header("Location: login_form.php");
    }

    // SESSION is active and empty
    else
    {
        // SQL statement -> search user with the user id from the user database
        $sql = $conn -> prepare("SELECT * FROM user WHERE id = '$id'");
        $sql -> execute();
    
        // data found
        if ($sql -> rowCount())
        {
            $row = $sql -> fetch(PDO::FETCH_ASSOC);
            
            // OTP is already expired
            if (strtotime($row["otp_expiry"]) <= time())
            {
                // destroy session
                session_destroy();

                // SQL statement -> update the user database with NULL values in the OTP and OTP expiry with the user id
                $sql1 = "UPDATE user SET otp = NULL, otp_expiry = NULL WHERE id = '$id'";
                $conn -> exec($sql1);

                // directs back to login form
                echo "<script>window.location = 'login_form.php'</script>";
            }

            // OTP is valid
            else
            {
                $otp1 = $_POST['otp1'];
                $otp2 = $_POST['otp2'];
                $otp3 = $_POST['otp3'];
                $otp4 = $_POST['otp4'];
                $otp5 = $_POST['otp5'];
                $otp6 = $_POST['otp6'];

                // OTP (concatenation)
                $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;
            
                // create a hashed OTP value
                $otp_hash = md5($otp);
            
                // OTP is not empty
                if (!empty($otp))
                {
                    // SQL statement -> search user with the (hashed) OTP value from the user database
                    $sql2 = $conn -> prepare("SELECT * FROM user WHERE otp = '$otp_hash'");
                    $sql2 -> execute();
            
                    // data found
                    if ($sql2 -> rowCount())
                    {
                        $row2 = $sql2 -> fetch(PDO::FETCH_ASSOC);
            
                        // OTP is expired
                        if (strtotime($row2["otp_expiry"]) <= time())
                        {
                            // destroy session
                            session_destroy();

                            // SQL statement -> update the user database with NULL values in the OTP and OTP expiry with the user id
                            $sql3 = "UPDATE user SET otp = NULL, otp_expiry = NULL WHERE id = '$id'";
                            $conn -> exec($sql3);

                            //header("Location: login_form.php");
                            echo "<script>window.location = 'login_form.php'</script>";
                        }
            
                        // OTP is valid
                        else
                        {
                            // SQL statement -> update the user database with NULL values in the OTP and OTP expiry with the user id
                            $sql4 = "UPDATE user SET otp = NULL, otp_expiry = NULL WHERE id = '$id'";
                            $conn -> exec($sql4);
                            
                            // create a session to access account page ($_SESSION['email'] = $row2['email'])
                            $_SESSION['email'] = $row2['email'];

                            // unset session id
                            unset($_SESSION['id']);
            
                            // directs to the user's account page
                            echo "<script>window.location = 'account.php'</script>";
                        }
                    }
            
                    // data not found
                    else
                    {
                        // error message
                        echo 'Invalid OTP!';
                    }
                }
            
                // OTP is empty
                else
                {
                    // error message
                    echo 'Invalid OTP!';
                }
            }
        }
    }

    
?>