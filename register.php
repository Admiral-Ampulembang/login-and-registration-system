<?php
    // dbconnect file
    include 'dbconnect.php';
    
    $response = array (
        "status" => 0,
        "message" => "You're here by mistake!"
    );

    $uploadDir = 'uploads/';
    $errorEmpty = false;
    $errorEmail = false;
    $errorPassword = false;

    if (isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['email'])
    || isset($_POST['password']) || isset($_POST['file']) || isset($_POST['g-recaptcha-response']))
    {
        // build connection to database using dbconnect file
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $recaptcha = $_POST['g-recaptcha-response'];

        // input values are not empty
        if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) 
        && !empty($_FILES['file']['name']) && !empty($recaptcha))
        {
            // email is not in the correct format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // error message
                $response['message'] = "Invalid email address!";
                $errorEmail = true;
            }

            // password does not match one of the password strength requirements
            else if ((strlen($password) < '8') || (!preg_match("#[0-9]+#", $password))
            || (!preg_match("#[A-Z]+#", $password)) || (!preg_match("#[a-z]+#", $password)) 
            || (!preg_match("#[!£$%^&*()+=\-\[\]\";,.\/{}|':<>?~\\\\]+#", $password)))
            {
                // error message
                $response['message'] = "Password is not strong enough!";
                $errorPassword = true;
            }
            
            // no errors
            else
            {
                if ($errorEmpty == false && $errorEmail == false && $errorPassword == false)
                {
                    $uploadStatus = 1;
                    $uploadFile = '';

                    // image file is not empty
                    if (!empty($_FILES['file']['name']))
                    {
                        // filename and targeted file path
                        $fileName = basename($_FILES['file']['name']);
                        $targetFilePath = $uploadDir . $fileName;
                        
                        // image file exceeds 5MB
                        if ($_FILES['file']['size'] > 5000000)
                        {
                            // error message
                            $response['message'] = "Your file is too large!";
                            $uploadStatus = 0;
                        }
                    }

                    if ($uploadStatus == 1)
                    {
                        // create a hashed password
                        $hash = md5($password);

                        // SQL statement -> search user with the inputted email from the user database
                        $sql = $conn -> prepare("SELECT * FROM user WHERE email = '$email'");
                        $sql -> execute();

                        // data found
                        if ($sql -> rowCount())
                        {
                            // error message
                            $response['message'] = "Email address already exists!";
                        }

                        // data not found
                        else
                        {
                            // upload image file to the targeted file path
                            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath))
                            {
                                $uploadFile = $fileName;
                                $uploadStatus = 1;
                            }

                            // error occured
                            else
                            {
                                // error message
                                $response['message'] = "Sorry! An error occured!";
                                $uploadStatus = 0;
                            }

                            // SQL statement -> insert inputted values to the user database
                            $sql1 = "INSERT INTO user (firstname, lastname, email, password, image)
                            VALUES ('$firstname', '$lastname', '$email', '$hash', '$uploadFile')";
                            $conn -> exec($sql1);

                            // successful message
                            $response['message'] = "Thank you for registering!";
                            $response['status'] = 1;
                        }
                    }
                }
            }
        }

        // input values are emtpy
        else
        {
            // error message
            $response['message'] = "Empty input field!";
            $errorEmpty = true;
        }
    }

    echo json_encode($response);
?>