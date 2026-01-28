/* ================= Dark Mode ================= */

document.getElementById('day-night-icon')?.addEventListener('click', function () {
    const body = document.body;
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta?.getAttribute("content");

    // Toggle dark mode class
    body.classList.toggle('dark-mode');

    // Determine current theme based on class
    const isDark = body.classList.contains('dark-mode');
    const newTheme = isDark ? 'dark' : 'light';
    const newIconClass = isDark ? 'ti-shine text-white' : 'fa-solid fa-moon';

    // Update icon
    document.getElementById('theme-icon').className = newIconClass;

    // Send AJAX request to update session (Laravel)
    fetch('/update-theme', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ theme: newTheme })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Theme updated in session:', newTheme);
        } else {
            console.error('Error updating theme in session');
        }
    })
    .catch(err => console.error('Fetch error:', err));

    dynamicBG();
});

/* ================= Dark Mode ================= */


// For dynamic background updates based on [data-bg-color]
function dynamicBG() {
    const isDark = document.body.classList.contains('dark-mode');
    document.querySelectorAll('[data-bg-color]').forEach(elm => {
        if (!isDark) {
            elm.style.setProperty('background', elm.dataset.bgColor);
        } else {
            elm.style.removeProperty('background');
        }
    });
}
