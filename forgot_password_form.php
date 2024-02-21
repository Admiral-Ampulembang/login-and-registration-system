<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="form">
        <form id="forgot_password_form">
            <div class="form_title">Forgot Password</div>
            
            <div class="form_message"></div>

            <div class="form_input">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address!">
            </div>

            <div class="form_input">
                <input type="submit" name="submit" id="submit_btn" value="Submit">
            </div>
        </form>
    </div>

    <script type="text/javascript">
        // user clicks submit button
        $(document).ready(function() {
            $("#forgot_password_form").on('submit', function(e) {
                e.preventDefault();

                var email = $("#email").val();

                $.ajax({
                    type: "POST", // POST type
                    url: "forgot_password.php", // processed in forgot_password.php
                    data: {email: email}, // take email value

                    success: function(data) {
                        // display message
                        $(".form_message").css("display", "block");
                        $(".form_message").html(data);
                    }
                })
            })
        })
    </script>
</body>
</html>