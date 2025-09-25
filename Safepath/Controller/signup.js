// Password strength validation
function validatePassword() {
    var password = document.getElementById("password").value;
    var message = document.getElementById("passwordMessage");

    var regexWeak = /^[a-zA-Z0-9]{6,12}$/; // Weak password (alphanumeric, 6-12 chars)
    var regexStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/; // Strong password (mix of upper, lower, number)

    if (password.match(regexStrong)) {
        message.innerHTML = "Password is strong.";
        message.style.color = "green";
    } else if (password.match(regexWeak)) {
        message.innerHTML = "Password is weak.";
        message.style.color = "orange";
    } else {
        message.innerHTML = "Password is invalid. It should be between 8 to 20 characters, and include both letters and numbers.";
        message.style.color = "red";
    }
}

// Name validation (only letters and spaces)
function validateName() {
    var name = document.getElementById("name").value;
    var message = document.getElementById("nameMessage");

    var regexName = /^[a-zA-Z\s]+$/;  // Only letters and spaces

    if (!regexName.test(name)) {
        message.innerHTML = "Name should only contain letters and spaces.";
        message.style.color = "red";
        return false;
    } else {
        message.innerHTML = "";
        return true;
    }
}

// Mobile number validation (exactly 11 digits)
function validateMobile() {
    var mobile = document.getElementById("mobile").value;
    var message = document.getElementById("mobileMessage");

    var regexMobile = /^\d{11}$/; // Exactly 11 digits

    if (!regexMobile.test(mobile)) {
        message.innerHTML = "Mobile number must be exactly 11 digits.";
        message.style.color = "red";
        return false;
    } else {
        message.innerHTML = "";
        return true;
    }
}

// NID validation (exactly 10 digits)
function validateNid() {
    var nid = document.getElementById("nid").value;
    var message = document.getElementById("nidMessage");

    var regexNid = /^\d{10}$/; // Exactly 10 digits

    if (!regexNid.test(nid)) {
        message.innerHTML = "NID must be exactly 10 digits.";
        message.style.color = "red";
        return false;
    } else {
        message.innerHTML = "";
        return true;
    }
}

// Age validation (18 years or older)
function validateAge() {
    var dob = document.getElementById("dob").value;
    var message = document.getElementById("dobMessage");

    var birthDate = new Date(dob);
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var month = today.getMonth() - birthDate.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 18) {
        message.innerHTML = "You must be at least 18 years old to register.";
        message.style.color = "red";
        return false;
    } else {
        message.innerHTML = "";
        return true;
    }
}

// Combine all validations before submitting the form
function validateForm() {
    if (validateName() && validateMobile() && validateNid() && validateAge()) {
        return true;
    } else {
        return false;
    }
}
