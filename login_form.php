<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="form">
        <form id="login_form" autocomplete="off">
            <div class="form_title">Login</div>

            <div class="form_message"></div>
            
            <div class="form_input">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address!">
            </div>

            <div class="form_input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password!">
                <span id="toggleBtn"></span>
            </div>

            <div class="link">
                <a href="forgot_password_form.php">Forgot Password?</a>
            </div>

            <div class="form_input">
                <input type="submit" name="login" id="login_btn" value="Login">
            </div>

            <div class="register_link">
                Don't have an account? <a href="registration_form.php">Register!</a>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        // user clicks login button
        $(document).ready(function() {
            $("#login_form").on('submit', function(e){
                e.preventDefault();
                
                $.ajax({
                    type: "POST", // POST type
                    url: "login.php", // processed in login.php
                    data: new FormData(this), // take inputted values (email and password)
                    dataType: "json", // json datatype
                    contentType: false,
                    cache: false,
                    processData: false,

                    success: function(response) {
                        // display message
                        $(".form_message").css("display", "block");

                        if(response.status == 1)
                        {
                            // clear inputs when login is successful
                            $("#login_form")[0].reset();
                            $(".form_message").html('<p>' + response.message + '</p>');
                        }

                        else
                        {
                            // display error message
                            $(".form_message").css("display", "block");
                            $(".form_message").html('<p>' + response.message + '</p>');
                        }
                    }
                });
            });
        });
    </script>

    <script src="script.js"></script>
</body>
</html>