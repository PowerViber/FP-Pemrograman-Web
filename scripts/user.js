document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.getElementById('user-icon');
    const userDropdown = document.getElementById('user-dropdown');

    if (userIcon && userDropdown) {
        userIcon.addEventListener('click', (event) => {
            event.preventDefault();
            userDropdown.classList.toggle('active');  // Toggle visibility
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', (event) => {
            if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove('active');
            }
        });
    }
});