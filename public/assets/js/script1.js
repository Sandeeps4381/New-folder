let circularProgress1 = document.querySelector(".circular-progress1");

let progressValue1 = document.querySelectorAll(".progress-value1");

let progressStartValue1 = 0,
progressEndValue1 = 100,
speed1 = 100;

let progress1 = setInterval(() => {
if (progressStartValue1 == progressEndValue1) {
clearInterval(progress1);
}

progressStartValue1++;

circularProgress1.style.background = `conic-gradient(#828c7a ${progressStartValue1 * 3.6}deg, #ededed 0deg)`;

}, speed1);                