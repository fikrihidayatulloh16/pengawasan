<link rel="stylesheet" href="../../css/successAlert.css">

<div id="success-alert" class=" container alert success-alert">
    <span class="closebtn" onclick="hideSuccessAlert()">&times;</span> 
    <i class='bx bx-check-circle'></i>Aksi Berhasil
    <strong id="alert-message">Success Alert!</strong>
</div>

<script>
    function showSuccessAlert(message) {
    var alert = document.getElementById("success-alert");
    var alertMessage = document.getElementById("alert-message");
    alertMessage.textContent = message;
    alert.style.display = "block";
    setTimeout(function() {
        alert.style.opacity = "1";
    }, 10); // Delay for animation effect

    setTimeout(function() {
        alert.style.opacity = "0";
        setTimeout(function() {
            alert.style.display = "none";
        }, 600); // Wait for opacity transition to complete before hiding
    }, 3000); // Alert will disappear after 3 seconds
}

function hideSuccessAlert() {
    var alert = document.getElementById("success-alert");
    alert.style.opacity = "0";
    setTimeout(function() {
        alert.style.display = "none";
    }, 600); // Wait for opacity transition to complete before hiding
}
 
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    
    const previousMessage = sessionStorage.getItem('previousMessage');
    
    // Check if alert has been shown before and if message is different
    if (sessionStorage.getItem('navigated') === 'true') {
        // Check if the page has been navigated to
            showSuccessAlert(message);
            sessionStorage.removeItem('navigated'); // Mark as navigated
        // Update the stored message
        sessionStorage.setItem('previousMessage', message);
    } else {
        // Reset navigated status on subsequent loads if needed
        sessionStorage.removeItem('navigated');
    }
};


</script>