document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const nextButton = document.getElementById('next');
    const prevButton = document.getElementById('prev');
    const slideWidth = slides[0].clientWidth + 20; // Width of each slide + gap
    let currentIndex = 0;

    function updateSlider() {
        const offset = -currentIndex * slideWidth;
        slider.style.transform = `translateX(${offset}px)`;
    }

    nextButton.addEventListener('click', () => {
        if (currentIndex < slides.length - 3) { // Ensure at least 3 items remain in view
            currentIndex++;
        } else {
            currentIndex = 0; // Loop back to the start
        }
        updateSlider();
    });

    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = slides.length - 3; // Loop to the last full set of slides
        }
        updateSlider();
    });
});
