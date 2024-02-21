<?php
    // dbconnect file
    require "dbconnect.php";

    // build connection to database using dbconnect file
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['email']))
    {
        $email = $_POST['email'];

        // email is not empty
        if (!empty($email))
        {
            // SQL statement -> search user with the inputted email from the user database
            $sql = $conn -> prepare("SELECT * FROM user WHERE email = '$email'");
            $sql -> execute();
    
            // data found
            if ($sql -> rowCount())
            {
                // create token and token expiry
                $token = bin2hex(random_bytes(16));

                // create a hashed token
                $token_hash = hash("sha256", $token);
                $expiry = date("Y-m-d H:i:s", time() + 60 * 10);
    
                // SQL statement -> update the user database with the hashed token and its expiry using the inputted email
                $sql1 = "UPDATE user SET token = '$token_hash',
                token_expiry = '$expiry' WHERE email = '$email'";
                $conn -> exec($sql1);
    
                // mailer file
                // prepare mail to send Reset Password form to the inputted email with the hashed token
                $mail = require 'mailer.php';
                $mail->setFrom("jazzydonut123@gmail.com", "JazzyD"); // change to your email
                $mail->addAddress($email);
                $mail->Subject = "Password Reset";
                $mail->Body = <<<END
    
                Click <a href="http://localhost/login_and_registration_system/reset_password_form.php?token=$token">here</a>
                to reset your password.
    
                END;
    
                try {
                    // send email
                    $mail->send();
    
                    // successful message
                    echo "Message sent; please check your email!";
                }
                
                catch (Exception $e) {
                    // error message
                    echo "Message could not be sent. Mailer error: {$email->ErrorInfo}";
                }
            }
            
            // data not found
            else
            {
                // error message
                echo "Invalid email address";
            }
        }
        
        // email is empty
        else
        {
            // error message
            echo "Invalid email address!";
        }
    }
?>