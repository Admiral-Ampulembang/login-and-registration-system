<?php
    $response = array(
        "status" => 0,
        "message" => "You're here by mistake!"
    );

    // start session
    session_start();

    $errorEmpty = false;
    $errorEmail = false;

    // dbconnect file
    include('dbconnect.php');

    if (isset($_POST['email']) || isset($_POST['password']))
    {
        // build connection to database using dbconnect file
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST['email'];
        $password = $_POST['password'];

        // email and password are not empty
        if (!empty($email) && !empty($password))
        {
            // email is not in the correct format
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // error message
                $response['message'] = "Invalid email!";
                $errorEmail = true;
            }

            // email is in the correct format
            else
            {
                // no error
                if ($errorEmpty == false && $errorEmail == false)
                {
                    // create a hashed password value
                    $password_hash = md5($password);

                    // SQL statement -> search user with the inputted email and (hashed) password from the user database
                    $sql = $conn -> prepare("SELECT * FROM user WHERE email = '$email' AND password = '$password_hash'");
                    $sql -> execute();

                    // data found
                    if ($sql -> rowCount())
                    {
                        $row = $sql -> fetch();

                        // create a random number for (hashed) OTP and OTP expiry
                        $otp = rand(100000, 999999);
                        $otp_hash = md5($otp);
                        $expiry = date("Y-m-d H:i:s", time() + 60);

                        // mailer file
                        // prepare mail to send OTP to the inputted email
                        $mail = require 'mailer.php';
                        $mail->setFrom("your_email_address"); // change to your email
                        $mail->addAddress($email);
                        $mail->Subject = "Verify OTP";
                        $mail->Body = <<<END

                            Your OTP for login authentication is <p style="font-weight: bold;">$otp</p>

                        END;

                        try {
                            // send email
                            $mail -> send();

                            // SQL statement -> update the user database with the hashed OTP and its expiry using the inputted email
                            $sql1 = "UPDATE user SET otp = '$otp_hash', 
                                otp_expiry = '$expiry' WHERE email  = '$email'";
                            $conn -> exec($sql1);

                            // unset SESSION['id'] if it is already set
                            if (isset($_SESSION['id']))
                            {
                                unset($_SESSION['id']);
                            }

                            // create a session to access OTP form ($_SESSION['id'] = $row['id'])
                            $_SESSION['id'] = $row['id'];
                        
                            // directs to the OTP form
                            $response['message'] = "<script>window.location = 'otp_form.php'</script>";
                        }

                        catch (Exception $e) {
                            // error message
                            $response['message'] = "Message could not be sent. Mailer error: {$email -> ErrorInfo}";
                        }
                    }

                    // data not found
                    else
                    {
                        // error message
                        $response['message'] = "Incorrect email and/or password!";
                    }
                }
            }
        }

        // empty email and/or password
        else
        {
            // error message
            $response['message'] = "Incorrect email and/or password!";
            $errorEmpty = true;
        }
    }

    else
    {
        // error message
        $response['message'] = "Not set";
    }

    echo json_encode($response);
?>