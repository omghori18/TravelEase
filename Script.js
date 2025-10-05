document.addEventListener('DOMContentLoaded', () => {
    const faqPopup = document.getElementById('faqWelcome');
    const closeBtn = document.getElementById('closeFaqPopup');
    const overlay = document.getElementById('overlay');

    if (faqPopup && overlay) {
        faqPopup.style.display = 'block';
        overlay.style.display = 'block';
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            faqPopup.style.display = 'none';
            overlay.style.display = 'none';
        });
    }

    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.closest('.faq-item');
            if (faqItem) {
                faqItem.classList.toggle('active');
            }
        });
    });
});
