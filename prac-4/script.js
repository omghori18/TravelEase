document.addEventListener('DOMContentLoaded', () => {
    // --- Popup Functionality ---
    const notificationPopup = document.getElementById('notification');
    const closePopupButton = document.getElementById('closePopup');

    // Show the popup when the page loads
    if (notificationPopup) {
        notificationPopup.style.display = 'block';
    }

    // Hide the popup when the close button is clicked
    if (closePopupButton) {
        closePopupButton.addEventListener('click', () => {
            if (notificationPopup) {
                notificationPopup.style.display = 'none';
            }
        });
    }

    // Optional: Hide popup after a few seconds automatically
    setTimeout(() => {
        if (notificationPopup) {
            notificationPopup.style.display = 'none';
        }
    }, 5000); // Popup will disappear after 5 seconds


    // --- FAQ Toggle Functionality ---
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.closest('.faq-item'); // Get the parent .faq-item
            if (faqItem) {
                faqItem.classList.toggle('active'); // Toggle the 'active' class
            }
        });
    });
});