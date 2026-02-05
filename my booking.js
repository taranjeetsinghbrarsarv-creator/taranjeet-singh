// Slot select karne ka function
function selectSlot(slot) {
    // Pehle se selected slot hatao
    const allSlots = document.querySelectorAll(".slot.available");
    allSlots.forEach(s => s.classList.remove("selected"));

    // Current slot select karo
    slot.classList.add("selected");

    // Input field me slot ka naam daalo
    document.getElementById("selectedSlot").value = slot.innerText;
}


// Form submit hone par message dikhana
const form = document.querySelector(".booking-form");

form.addEventListener("submit", function (e) {
    e.preventDefault(); // page reload rokne ke liye

    const name = document.getElementById("name").value;
    const vehicle = document.getElementById("vehicle").value;
    const slot = document.getElementById("selectedSlot").value;

    if (slot === "") {
        alert("❌ Please select a parking slot first!");
        return;
    }

    // Success message
    alert(
        "✅ Booking Confirmed!\n\n" +
        "Name: " + name + "\n" +
        "Vehicle No: " + vehicle + "\n" +
        "Parking Slot: " + slot
    );

    // Optional: form reset
    form.reset();

    // Slot ko booked dikhaana
    const selectedSlotDiv = document.querySelector(".slot.selected");
    if (selectedSlotDiv) {
        selectedSlotDiv.classList.remove("available", "selected");
        selectedSlotDiv.classList.add("booked");
        selectedSlotDiv.onclick = null;
    }
});
