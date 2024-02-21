<?php
    // dbconnect file
    require 'dbconnect.php';

    if (isset($_POST['token']) || isset($_POST['password']))
    {
        // build connection to database using dbconnect file
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $token = $_POST['token'];
        $password = $_POST['password'];

        // token and password are not empty
        if (!empty($token) && !empty($password))
        {
            // create a hashed token value
            $token_hash = hash("sha256", $token);

            // SQL statement -> search user with the (hashed) token value from the user database
            $sql = $conn -> prepare("SELECT * FROM user WHERE token = '$token_hash'");
            $sql -> execute();

            // data found
            if ($sql -> rowCount())
            {
                $row = $sql -> fetch(PDO::FETCH_ASSOC);

                // token is expired
                if (strtotime($row["token_expiry"]) <= time())
                {
                    // error message
                    die("Token has expired!");
                }

                // token is valid
                else
                {
                    // password does not match one of the password strength requirements
                    if ((strlen($_POST['password']) <= '8') || (!preg_match("#[0-9]+#", $password))
                    || (!preg_match("#[A-Z]+#", $password)) || (!preg_match("#[a-z]+#", $password))
                    || (!preg_match("#[!£$%^&*()+=\-\[\]\";,.\/{}|':<>?~\\\\]+#", $password)))
                    {
                        // error message
                        echo 'Password is not strong enough!';
                    }

                    // no error
                    else
                    {
                        // create a hashed password
                        $hash = md5($password);
                        $id = $row['id'];

                        // SQL statement -> update the user database with NULL values in the token and token expiry with the user id
                        $sql1 = "UPDATE user SET password = '$hash', token = NULL, token_expiry = NULL WHERE id = '$id'";
                        $conn -> exec($sql1);

                        // successful message
                        echo 'Your password has been successfully updated!';
                    }
                }
            }

            // token and/or password are empty
            else
            {
                // error message
                die("Token is invalid!");
            }
        }

        // password is empty
        else
        {
            echo 'Password is not strong enough!';
        }
    }
?>