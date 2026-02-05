// Sabhi buttons ko select karna
const buttons = document.querySelectorAll('.btn');

buttons.forEach((button) => {
    button.addEventListener('click', function() {
        // Card ke andar se Plan ka naam nikalna
        const planName = this.parentElement.querySelector('h2').innerText;
        
        // Ek simple message dikhana
        alert("Shukriya! Aapne " + planName + " select kiya hai. Hum jald hi aap se sampark karenge.");
        
        // Button ka text thodi der ke liye change karna
        this.innerText = "Selected ✅";
        this.style.backgroundColor = "#27ae60"; // Green color
    });
});