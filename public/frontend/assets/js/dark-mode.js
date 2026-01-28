

// document.addEventListener('DOMContentLoaded', function () {
//     const toggleBtns = document.querySelectorAll('.dark-mode-toggle'); // notice plural 'toggleBtns'
//     const body = document.getElementById('bdy');
//     const icon = document.querySelector('.dark-mode-icon');

//     if (toggleBtns.length > 0 && body && icon) {
//         toggleBtns.forEach(function (toggleBtn) {
//             toggleBtn.addEventListener('click', function () {
//                 let isDarkMode = body.classList.contains('dark-mode');

//                 if (isDarkMode) {
//                     body.classList.remove('dark-mode');
//                     icon.className = 'dark-mode-icon fa-solid fa-moon';
//                     updateThemeSession('light');
//                 } else {
//                     body.classList.add('dark-mode');
//                     icon.className = 'dark-mode-icon ti-shine text-white';
//                     updateThemeSession('dark');
//                 }
//             });
//         });
//     }

//     function updateThemeSession(theme) {
//         fetch('/update-theme', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//             },
//             body: JSON.stringify({ theme: theme })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 console.log('Theme updated in session');
//             } else {
//                 console.error('Failed to update theme');
//             }
//         });
//     }
// });


document.addEventListener('DOMContentLoaded', function () {
    const toggleBtns = document.querySelectorAll('.dark-mode-toggle'); // both buttons
    const body = document.getElementById('bdy');
    const icons = document.querySelectorAll('.dark-mode-icon'); // ✅ select all icons

    if (toggleBtns.length > 0 && body && icons.length > 0) {
        toggleBtns.forEach(function (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                let isDarkMode = body.classList.contains('dark-mode');

                if (isDarkMode) {
                    body.classList.remove('dark-mode');

                    // Update all icons
                    icons.forEach(icon => {
                        icon.className = 'dark-mode-icon fa-solid fa-moon';
                    });

                    updateThemeSession('light');
                } else {
                    body.classList.add('dark-mode');

                    // Update all icons
                    icons.forEach(icon => {
                        icon.className = 'dark-mode-icon ti-shine text-white';
                    });

                    updateThemeSession('dark');
                }
            });
        });
    }

    function updateThemeSession(theme) {
        fetch('/update-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ theme: theme })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Theme updated in session');
            } else {
                console.error('Failed to update theme');
            }
        });
    }
});


