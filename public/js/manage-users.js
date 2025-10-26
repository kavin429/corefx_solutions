document.addEventListener("DOMContentLoaded", function () {
    // Auto-hide success/error alerts after 4 seconds
    let alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(() => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 4000);
    });
});
