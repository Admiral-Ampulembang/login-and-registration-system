<?php
    // start session
    session_start();

    // SESSION email is not active and is empty
    if (!isset($_SESSION['email']) && empty($_SESSION['email']))
    {
        // directs back to login form
        header("Location: login_form.php"); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php
        // dbconnect file
        include "dbconnect.php";

        try
        {
            // build connection to database using dbconnect file
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SESSION email
            $email = $_SESSION['email'];

            // SQL statement -> search user that has the logged in email from the user database
            $sql = $conn -> prepare("SELECT * FROM user WHERE email = '$email'");
            $sql -> execute();

            $row = $sql -> fetch();

            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $fullname = $firstname . ' ' . $lastname;
            $profile_picture = $row['image'];

            // display user's details
            echo '
                <div class="card">
                    <div class="card_image">
                        <img src="wallpaper.jpg" alt="Wallpaper">
                    </div>

                    <div class="profile_image">
                        <img src="uploads/'.$profile_picture.'" alt="Profile Picture">
                    </div>

                    <div class="card_content">
                        <div class="fullname">'.$fullname.'</div>
                        
                        <div class="email">'.$email.'</div>

                        <div class="description">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                            Unde, ullam explicabo? Sunt, neque! Impedit, ex fugiat, delectus error nihil eos 
                            ad optio quaerat esse est culpa numquam repellendus voluptate beatae!
                        </div>
                    </div>

                    <div class="form_input">
                        <a href="logout.php"><button id="logout_btn">Logout</button></a>
                    </div>
                </div>
            ';
        }

        catch(PDOException $e)
        {
            // error message
            echo $sql . "<br>" . $e->getMessage(); //If we are not successful we will see an error
        }
    ?>
</body>
</html>