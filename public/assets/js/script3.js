let circularProgress3 = document.querySelector(".circular-progress3");

let progressValue3 = document.querySelectorAll(".progress-value3");

let progressStartValue3 = 0,
    progressEndValue3 = Math.round(((window.count - 0) / window.count) * 100),
    speed3 = 100;

let progress3 = setInterval(() => {
    if (progressStartValue3 == progressEndValue3) {
        clearInterval(progress3);
    }

    progressStartValue3++;

    circularProgress3.style.background = `conic-gradient(#f1b82d ${progressStartValue3 * 3.6}deg, #ededed 0deg)`;

}, speed3);
// edea15