let circularProgress2 = document.querySelector(".circular-progress2");

let progressValue2 = document.querySelectorAll(".progress-value2");

let progressStartValue2 = 0,
    progressEndValue2 = Math.round((0/window.count) * 100),
    speed2 = 100;

let progress2 = setInterval(() => {
    if (progressStartValue2 == progressEndValue2) {
        clearInterval(progress2);
    }

    progressStartValue2++;

    circularProgress2.style.background = `conic-gradient(#5ab015 ${progressStartValue2 * 3.6}deg, #ededed 0deg)`;
    
}, speed2);
