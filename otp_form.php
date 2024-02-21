<?php
    // start session
    session_start();

    // dbconnect file
    include 'dbconnect.php';

    // build connection to database using dbconnect file
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SESSION id is not active and is empty
    if (!isset($_SESSION['id']) && empty($_SESSION['id']))
    {
        // directs back to login form
        header("Location: login_form.php");
    }

    else
    {
        // SESSION id
        $id = $_SESSION['id'];

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

                // SQL statement -> update the user database with NULL values in the otp and otp expiry with the user id
                $sql1 = "UPDATE user SET otp = NULL, otp_expiry = NULL WHERE id = '$id'";
                $conn -> exec($sql1);

                // directs back to login form
                header("Location: login_form.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="form">
        <form id="otp_form">
            <div class="form_title">Enter OTP Code</div>

            <div class="form_message"></div>

            <div class="form_otp">
                <label for="otp">Your OTP has been sent to your email address!</label>

                <div class="otp_input">
                    <input type="number" name="otp1" id="otp1" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp2" id="otp2" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false" disabled>
                    <input type="number" name="otp3" id="otp3" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false" disabled>
                    <input type="number" name="otp4" id="otp4" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false" disabled>
                    <input type="number" name="otp5" id="otp5" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false" disabled>
                    <input type="number" name="otp6" id="otp6" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false" disabled>
                </div>
            </div>

            <div class="form_input">
                <input type="submit" name="verify" id="verify_btn" value="Verify OTP">
            </div>
        </form>
    </div>

    <script type="text/javascript">
        // user clicks verify button
        $(document).ready(function() {
            $("#otp_form").on('submit', function(e) {
                e.preventDefault();

                var otp1 = $("#otp1").val();
                var otp2 = $("#otp2").val();
                var otp3 = $("#otp3").val();
                var otp4 = $("#otp4").val();
                var otp5 = $("#otp5").val();
                var otp6 = $("#otp6").val();

                $.ajax({
                    type: "POST", // POSt type
                    url: "otp.php", // processed in otp.php
                    data: {otp1: otp1, otp2: otp2, otp3: otp3, 
                        otp4: otp4, otp5: otp5, otp6: otp6}, // take inputted values OTP

                    success: function(data) {
                        // display message
                        $(".form_message").css("display", "block");
                        $(".form_message").html(data);
                    }
                });
            }); 
        });
    </script>

    <script type="text/javascript">
        const otp = document.querySelectorAll('.otp_field');

        otp[0].focus();
        otp.forEach((field, index) => {
            field.addEventListener('keydown', (e) => {
                // Number 0 - 9 is pressed
                if (e.key >= 0 && e.key <= 9)
                {
                    otp[index].value = "";
                    setTimeout(() => {
                        otp[index + 1].removeAttribute("disabled");
                        otp[index + 1].focus();
                    }, 6);
                }

                // TODO
                // Backspace is pressed
                else if (e.key === 'Backspace')
                {
                    otp[index - 1].value = "";
                    setTimeout(() => {
                        otp[index].setAttribute("disabled", true);
                        otp[index - 1].focus();
                    }, 6);
                }
            })
        })
    </script>
</body>
</html>