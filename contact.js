
    const form = document.getElementById("contactForm");
    const successMsg = document.getElementById("successMsg");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // page reload stop

        // Show success message
        successMsg.style.display = "block";

        // Clear form after submit
        form.reset();

        // Hide message after 5 seconds (optional)
        setTimeout(() => {
            successMsg.style.display = "none";
        }, 5000);
    });
