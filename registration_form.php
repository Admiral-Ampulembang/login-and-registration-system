<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="form">
        <form id="register_form" autocomplete="off">
            <div class="form_title">Register</div>

            <div class="form_message"></div>

            <div class="form_input">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter your first name!">
            </div>

            <div class="form_input">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your last name!">
            </div>

            <div class="form_input">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address!">
            </div>

            <div class="form_input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password!">
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
                <label for="file">Upload profile image</label>
                <input type="file" name="file" id="file">
            </div>

            <div class="captcha">
                <label for="captcha_input">Captcha</label>
                <div class="captcha_form">
                    <!-- DATA SITEKEY acquire from Google Account
                    1. Go to this website: https://www.google.com/recaptcha/about/
                    2. Click the v3 Admin console
                    3. Search for the + sign (Create) and click it
                    4. Fill the label with the name of your project
                    5. Choose which reCAPTCHA type to use (reCAPTCHA v2 or v3)
                    6. Fill the domain with localhost if you are running the program in your laptop using XAMPP
                    7. Click submit, then it will display the site key
                    8. Copy the site-key and paste it here -->
                    <div class="g-recaptcha" data-sitekey="your_site_key"></div>
                </div>
            </div>

            <div class="form_input">
                <input type="submit" name="register" id="register_btn" value="Register">
            </div>

            <div class="login_link">
                Already have an account? <a href="login_form.php">Login!</a>
            </div>           
        </form>
    </div>

    <script type="text/javascript">
        // user clicks register button
        $(document).ready(function() {
            $("#register_form").on('submit', function(e){
                e.preventDefault();
                
                $.ajax({
                    type: "POST", // POST type
                    url: "register.php", // processed in register.php
                    data: new FormData(this), // take inputted values
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
                            $("#register_form")[0].reset();
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

            $("#file").change(function()
            {
                var file = this.files[0];
                var fileType = file.type;
                var match = ['image/jpeg', 'image/jpg', 'image/png'];

                // image file is not in the format of JPEG, JPG, and PNG files
                if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2])))
                {
                    // display error message
                    alert("Only JPEG, JPG, and PNG files are allowed to upload!");
                    $('#file').val('');
                    return false;
                }
            });
        });
    </script>

    <!-- GOOGLE RECAPTCHA SCRIPT -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="script.js"></script>
</body>
</html>