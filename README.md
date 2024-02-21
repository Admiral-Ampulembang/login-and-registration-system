# Login and Registration System

## Description
A login and registration system that provides an additional layer of security through the integration of a One Time Password (OTP) and Google reCAPTCHA. It also implements a method called hashing, a technique that converts data into a fixed-length string to protect sensitive data such as passwords, OTPs, and tokens. In addition, the system utilises a library called PHPMailer that allows the system to send the OTP code and the Reset Password Form to the inputted email.

## Table of Contents
-	[Installation](#installation)
-	[Usage](#usage)
-	[Credits](#credits)

## Installation
1.	To run the system in your localhost, ensure that you have installed a software called XAMPP Control Panel.
2.	Download the project and put it inside the htdocs folder which can be found by accessing the xampp folder. The path of this project would be more or less similar to this: "C:\xampp\htdocs\login_and_registration_system"
3.	When the XAMPP Control Panel is ready, run the XAMPP Control Panel and press the Start button for both Apache and MySQL.
![XAMPP Control Panel](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture1.png)
4.	Before running this system, you need to import the database (login_and_registration_system.sql) to your MySQL server. You can do this by clicking the Admin, then click the Import button. Choose the SQL file then import it.
![Click Admin button of MySQL](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture2.png)
![Import database](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture3.png)
5.	Go back to the XAMPP Control Panel app then click the Admin button for the Apache.
![Click Admin button of Apache](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture4.png)
6.	Your browser will open the following page:
![Display localhost/phpmyadmin](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture5.png)
7.	Search for the project by typing localhost/login_and_registration_system/ in the search field. You will see the following page:
![Index of /login_and_registration_system](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture6.png)
8.	Before running the system, you need to make some changes. The first change is to replace the data-sitekey for displaying the reCAPTCHA with your personal data-sitekey. The instructions for this replacement can be found in registration_form.php in line 63.
![Instructions to change data-sitekey for display the reCAPTCHA](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture7.png)
9.	The second change is to replace the username (email address) and its password to be able to send the OTP and Reset Password Form. Go to mailer.php then change the username to your personal email address (line 19), while the password (line 27) is acquired from your Google Account. The instructions to change your password are found in mailer.php in line 21.
![Instructions to change username and password](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture8.png)
10.	Go to line 62 in login.php and line 38 in forgot_password.php and change the email to your personal email address.
![Instructions to change username](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture9.png)
![Instructions to change username](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture10.png)
11.	If all changes are executed, you are ready to go.

## Usage
1.	Start the project by clicking the login_form.php (or type in localhost/login_and_registration_system/login_form.php in the search field). You will see the following page:
![Login Form](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture11.png)
2.	Since we have not made an account, we need to do a registration process. To do so, click the Register link and you will see the following page:
![Registration Form](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture12.png)
3.	Input your details to the registration form, and then click the Register button. If the registration is successful, the system will display a successful message saying “Thank you for registering!”.
4.	You can also see that the registration has been inserted in the user database. In addition, the password has been hashed, a technique that protects sensitive information by converting data into a fixed-length string.
![Hashed Password in the database](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture13.png)
5.	If the registration is not successful, the system will display an error message, for example:
-	“Empty input field!” – the input fields are empty
-	“Invalid email address!” – the inputted email address is not in the correct format
-	“Email address already exists!” – the inputted email address has already been registered in the database
-	“Password is not strong enough!" – the inputted password does not meet all of the password strength requirements
-	“Your file is too large!” – the image uploaded exceeds 5MB
-	“Only JPEG, JPG, and PNG files are allowed to upload!” – incorrect file upload format
6.	From the Registration Form, click the Login link which will direct you back to the Login Form.
7.	Try to log in using your email address and password that you just registered. If your credentials are correct, it will display an OTP Form:
![OTP Form](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture14.png)
8.	If there is an error in your inputted credentials, it will display an error message saying “Incorrect email address and/or password!”
9.	When you try to log in using your correct credentials, the system automatically sends an OTP to the inputted email address which is valid for 1 minute. So, you need to check your email address to obtain the OTP.
![Verify OTP Email](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture15.png)
10.	Once obtained, your OTP should be inputted in the OTP Form; if it is correct, you have successfully logged in to your account:
![Account](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture16.png)
11.	If the OTP fails, it may be because of one of the two reasons:
-	The OTP is incorrect
-	The OTP has already expired
12.	Once logged in, you can see your details such as your profile picture, full name, and email address. You can log out from your account by clicking the Logout button. This will direct you back to the Login Form.
13.	Let’s say you forgot your password: you can change your password by clicking the Forgot Password link in the Login Form.
14.	You are now directed to the Forgot Password page which requires you to fill in your email address.
![Forgot Password Form](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture17.png)
15.	If you fill in an invalid email address (incorrect format and/or email address that does not exist in the database), it will display an error message saying “Invalid email address!”
16.	If you fill in a valid email address that exists in the database, it will display a successful message saying “Message sent; please check your email!”. This message means that the Reset Password Form link with a token that associates with the user is sent to the inputted email address.
![Password Reset Email](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture18.png)
17.	Click the Reset Password Form link, and it will open the following page:
![Reset Password Form](https://github.com/Admiral-Ampulembang/login-and-registration-system/blob/main/screenshots/Picture19.png)
18.	The previous step is possible only if the token is valid and has not yet expired. If it is invalid (for example if you change the Reset Password Form link), the system will display an error message saying “Token is invalid!”. Likewise, if it is expired (time limit 10 minutes), the system will display an error message saying “Token has expired!”
19.	You need to input a new password that you can remember. It also needs to meet all of the password strength requirements.
20.	Once the password is labelled strong, you can click the Reset Password button, and it will display a successful message saying “Your password has been successfully updated!”.
21.	If you click the Reset Password button while your token has already expired (time limit of 10 minutes), it will display an error message saying “Token has expired!”. If this happens, you must redo the steps by returning to the Forgot Password Form through the Forgot Password link in the Login Form (instruction no. 13).
22.	Return to the Login Form and use your new password to log in. You can check how to log in by going back to instructions no. 7 – 12.

## Credits
- PHPMAILER library - https://github.com/PHPMailer/PHPMailer
- Registration Form with jQuery - https://youtu.be/a34seCE-3KY?feature=shared
- Login Form with jQuery - https://youtu.be/ljswOt_rH7Q?feature=shared
- OTP Form CSS - https://youtu.be/naVaJDYpptY?feature=shared
- Forgot & Reset Password - https://youtu.be/R9bfts9ZFjs?feature=shared
- Account Page CSS - https://youtu.be/bjyA8S-2tfY?feature=shared
