// Profile form validation
document.getElementById("editForm").addEventListener("submit", function(e) {
    let name = document.getElementById("name").value.trim();
    let mobile = document.getElementById("mobile").value.trim();
    let nid = document.getElementById("nid").value.trim();

    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Name must contain only letters and spaces.");
        e.preventDefault();
        return;
    }
    if (!/^\d{11}$/.test(mobile)) {
        alert("Mobile must be exactly 11 digits.");
        e.preventDefault();
        return;
    }
    if (!/^\d{10}$/.test(nid)) {
        alert("NID must be exactly 10 digits.");
        e.preventDefault();
        return;
    }
});

// Password validation
document.getElementById("passwordForm").addEventListener("submit", function(e) {
    let newPass = document.getElementById("new_password").value;
    let confirmPass = document.getElementById("confirm_password").value;

    let strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/;
    if (!strongRegex.test(newPass)) {
        alert("Password must be 8-20 characters, include upper, lower, and a digit.");
        e.preventDefault();
        return;
    }
    if (newPass !== confirmPass) {
        alert("Passwords do not match.");
        e.preventDefault();
    }
});

// Profile image upload and preview using XMLHttpRequest
document.getElementById("profile_image").addEventListener("change", function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview = document.getElementById("preview");
            const avatarImage = document.querySelector(".avatar");

            // Directly set the uploaded image to the avatar image
            avatarImage.src = ev.target.result;  // This directly replaces the profile image in the circle

            // Optionally, show a success message
            alert('Profile image updated successfully!');
        }
        reader.readAsDataURL(file);

        // Create FormData to send the image to the server
        const formData = new FormData();
        formData.append("profile_image", file);

        // Create XMLHttpRequest to send the image to the server
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "citizen_profile.php", true);

        // Handle the response from the server
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    // If the image upload was successful, update the profile image immediately
                    const newImage = 'data:image/jpeg;base64,' + data.image;
                    const avatarImage = document.querySelector(".avatar");
                    avatarImage.src = newImage; // Update the profile image in the circle
                } else {
                    alert(data.message); // Show error message if update failed
                }
            } else {
                alert('Error uploading the image.');
            }
        };

        // Send the FormData object to the server
        xhr.send(formData);
    }
});