/*const inputs = document.querySelectorAll('.otp_field');

inputs.foreach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        const currentInput = input,
        nextInput = input.nextElementSibling,
        prevInput = input.previousElementSibling;

        if (currentInput.value.length > 1)
        {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "")
        {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (e.key === "Backspace")
        {
            inputs.forEach((input, index2) => {
                if (index1 <= index2 && prevInput)
                {
                    input.setAttribute("disabled", true);
                    currentInput.value = "";
                    prevInput.focus();
                }
            });
        }
    });
});

window.addEventListener("load", () => otp[0].focus());*/

const inputs = document.querySelectorAll(".otp_field");

// iterate over all inputs
inputs.forEach((input, index1) => {
    input.addEventListener("keyup", (e) => {
        // This code gets the current input element and stores it in the current variable
        // This code gets the next sibling element of the current input and stores it in the nextInput variable
        // This code gets the previous sibling elemtn of the current input element and stores it in the prevInput variable
        const currentInput = input,
        nextInput = input.nextElementSibling,
        prevInput = input.previousElementSibling;

        // if the value has more than one character then clear it
        if (currentInput.value.length > 1)
        {
            currentInput.value = "";
            return;
        }

        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "")
        {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        // if the backspace key is pressed
        if (e.key === "Backspace")
        {
            // iterate over all inputs again
            inputs.forEach((input, index2) => {
                if (index1 <= index2 && prevInput)
                {
                    input.setAttribute("disabled", true);
                    currentInput.value = "";
                    prevInput.focus();
                }
            });
        }
    });
});

// focus the first input which index is 0 on window load
window.addEventListener("load", () => inputs[0].focus());