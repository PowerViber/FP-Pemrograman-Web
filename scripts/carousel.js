const nextButton = document.getElementById('next');
const prevButton = document.getElementById('prev');
const contents = document.querySelectorAll('.home-content');

let currentContentIndex = 0;

function showContent(index) {
    contents.forEach((content, i) => {
        content.classList.remove('active');
        if (i === index) {
            content.classList.add('active');
        }
    });
}

nextButton.addEventListener('click', () => {
    currentContentIndex = (currentContentIndex + 1) % contents.length;
    showContent(currentContentIndex);
});

prevButton.addEventListener('click', () => {
    currentContentIndex = (currentContentIndex - 1 + contents.length) % contents.length;
    showContent(currentContentIndex);
});

showContent(currentContentIndex);