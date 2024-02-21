<?php
    // dbconnect file
    require "dbconnect.php";

    // build connection to database using dbconnect file
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // get token
    $token = $_GET["token"];

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
    }

    // data not found
    else
    {
        // error message
        die("Token is invalid!");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="form">
        <form id="reset_password_form">
            <input type="hidden" id="token" name="token" value="<?= htmlspecialchars_decode($token) ?>">

            <div class="form_title">Reset Password</div>

            <div class="form_message"></div>

            <div class="form_input">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your new password!">
                <span id="toggleBtn"></span>
            </div>

            <div class="form_password">
                <label for="password_strength">
                    Your password is <span id="strength_level">Weak</span>!
                </label>
            </div>

            <div class="password_validation">
                <ul>
                    <li id="length">At least 8 characters</li>
                    <li id="lowercase">At least one lowercase character</li>
                    <li id="uppercase">At least one uppercase character</li>
                    <li id="number">At least one number</li>
                    <li id="special">At least one special character</li>
                </ul>
            </div>

            <div class="form_input">
                <input type="submit" name="reset" id="reset_btn" value="Reset Password">
            </div>
        </form>
    </div>

    <script type="text/javascript">
        // user clicks reset button
        $(document).ready(function() {
            $("#reset_password_form").on('submit', function(e){
                e.preventDefault();
                
                var token = $("#token").val();
                var password = $("#password").val();

                $.ajax({
                    type: "POST", // POST type
                    url: "reset_password.php", // processed in reset_password.php
                    data: {token: token, password: password}, // take inputted values (token and new password)
                    
                    success: function(data) {
                        // display message
                        $(".form_message").css("display", "block");
                        $(".form_message").html(data);
                    }
                });
            });
        });
    </script>

    <script src="script.js"></script>
</body>
</html>