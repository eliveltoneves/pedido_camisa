document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.querySelector('.progress-bar');
    let width = 0;

    const interval = setInterval(function() {
        if (width >= 100) {
            clearInterval(interval);
            window.location.href = '../templates/index.html';
        } else {
            width++;
            progressBar.style.width = width + '%';
        }
    }, 50);
});
