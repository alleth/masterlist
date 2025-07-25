// js/inactivity.js
function initializeInactivity(lastActivity) {
    const inactivityTimeout = 30 * 60 * 1000; // 30 minutes in milliseconds

    function updateLastActivity() {
        lastActivity = new Date().getTime();
        fetch('update_activity.php', { method: 'POST' })
            .catch(error => console.error('Error updating activity:', error));
    }

    function checkInactivity() {
        const now = new Date().getTime();
        if (now - lastActivity > inactivityTimeout) {
            window.location.href = '../logout.php';
        }
    }

    window.addEventListener('mousemove', updateLastActivity);
    window.addEventListener('click', updateLastActivity);
    window.addEventListener('keydown', updateLastActivity);

    setInterval(checkInactivity, 60 * 1000);
    updateLastActivity();
}