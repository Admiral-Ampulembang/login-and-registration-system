let password = document.getElementById('password');
let toggleBtn = document.getElementById('toggleBtn');

// toggle button pressed
toggleBtn.onclick = function() 
{
    if (password.type == 'password') 
    {
        // change password type from 'password' to 'text'
        password.setAttribute('type', 'text');
        toggleBtn.classList.add('hide');
    }

    else
    {
        // change password type from 'text' to 'password'
        password.setAttribute('type', 'password');
        toggleBtn.classList.remove('hide');
    }
}

function checkPassword(data) {
    let minLength = document.getElementById('length');
    let lowerCase = document.getElementById('lowercase');
    let upperCase = document.getElementById('uppercase');
    let digit = document.getElementById('number');
    let specialChar = document.getElementById('special');

    let i = 0;

    // REGEXP
    const length = new RegExp('(?=.{8})');
    const lowercase = new RegExp('(?=.*[a-z])');
    const uppercase = new RegExp('(?=.*[A-Z])');
    const number = new RegExp('(?=.*[0-9])');
    const special = new RegExp('(?=.*[!£$%^&*\(\)+=\\\-\_\[\\\]\";,.\/{}|\'<>?~\\\\])');

    // length
    if (length.test(data))
    {
        minLength.classList.add('valid');
        i++;
    }

    else
    {
        minLength.classList.remove('valid');
    }

    // lowercase
    if (lowercase.test(data))
    {
        lowerCase.classList.add('valid');
        i++;
    }

    else
    {
        lowerCase.classList.remove('valid');
    }

    // uppercase
    if (uppercase.test(data))
    {
        upperCase.classList.add('valid');
        i++;
    }

    else
    {
        upperCase.classList.remove('valid');
    }

    // number
    if (number.test(data))
    {
        digit.classList.add('valid');
        i++;
    }

    else
    {
        digit.classList.remove('valid');
    }

    // special character
    if (special.test(data))
    {
        specialChar.classList.add('valid');
        i++;
    }

    else
    {
        specialChar.classList.remove('valid');
    }

    return i;
}

document.addEventListener("keyup", function(e)
{
    let password = document.querySelector('#password').value;
    let strength_level = document.getElementById("strength_level");
    let strength = checkPassword(password)

    // password strength only matches 2 or less password strength requirements
    if (strength <= 2)
    {
        // Your password is Weak!
        strength_level.innerHTML = "Weak";
    }

    // password strength only matches between 2 to 4 password strength requirements
    else if (strength > 2 && strength <= 4)
    {
        // Your password is Medium!
        strength_level.innerHTML = "Medium";
    }

    // password strength matches all password strength requirements
    else
    {
        // Your password is Strong!
        strength_level.innerHTML = "Strong";
    }
});