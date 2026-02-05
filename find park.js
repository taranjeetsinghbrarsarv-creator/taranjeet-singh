window.onload = function() {
    // Grab all table rows except the header
    const rows = document.querySelectorAll(".slot-status table tr");
    
    let total = 0;
    let available = 0;
    let occupied = 0;

    // Start from 1 to skip header row
    for (let i = 1; i < rows.length; i++) {
        total++;

        // Get the third td in this row (Status)
        const statusCell = rows[i].children[2]; 

        if (statusCell.classList.contains("free")) {
            available++;
        } else if (statusCell.classList.contains("busy")) {
            occupied++;
        }
    }

    // Update the cards
    document.getElementById("totalSlots").innerText = total;
    document.getElementById("availableSlots").innerText = available;
    document.getElementById("occupiedSlots").innerText = occupied;
};