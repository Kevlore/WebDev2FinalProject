let password = document.getElementById("password");
let passwordConfirm = document.getElementById("passwordConfirm");

function validatePassword() {
    if(password.value != passwordConfirm.value) {
        passwordConfirm.setCustomValidity("Passwords don't match.");
    }
    else
    {
        passwordConfirm.setCustomValidity('');
    }
}

password.onchange = validatePassword;
passwordConfirm.onkeyup = validatePassword;