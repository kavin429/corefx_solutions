    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".user-time").forEach(el => {
        const utcTime = el.getAttribute("data-utc");
        if (utcTime) {
            const localTime = new Date(utcTime);
            el.textContent = localTime.toLocaleString([], { 
                year: 'numeric', month: 'short', day: '2-digit',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: true
            });
        }
    });
});