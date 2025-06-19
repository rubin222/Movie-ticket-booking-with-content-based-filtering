function showSignIn() {
    document.getElementById("signInForm").style.display = "block";
    document.getElementById("signUpForm").style.display = "none";
}

function showSignUp() {
    document.getElementById("signInForm").style.display = "none";
    document.getElementById("signUpForm").style.display = "block";
}

// Google Sign-In
function handleCredentialResponse(response) {
    console.log("Google Token: ", response.credential);
    // Send this token to your backend for verification
    fetch("google_auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "token=" + response.credential
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "homepage.php"; // Redirect on successful login
        } else {
            alert("Google authentication failed.");
        }
    })
    .catch(error => console.error("Error:", error));
}

window.onload = function () {
    google.accounts.id.initialize({
        client_id: "871626432020-usd0pr6mncdqdo557i433j937us6c21l.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
        document.getElementById("googleSignIn"),
        { theme: "filled_blue", size: "large", width: "300px" }
    );

    const signInForm = document.getElementById("signInForm");
    const signUpForm = document.getElementById("signUpForm");

    if (signInForm) {
        signInForm.addEventListener("submit", function (event) {
            event.preventDefault();  // Prevent default form submission
            console.log("Sign In Form Submitted");
            this.reset();
            setTimeout(() => window.location.href = "homepage.php", 500); // Temporary redirect to homepage for testing
        });
    }

    if (signUpForm) {
        signUpForm.addEventListener("submit", function (event) {
            event.preventDefault();
            this.reset();
            setTimeout(() => window.location.href = "signin.php", 500);
        });
    }
};
