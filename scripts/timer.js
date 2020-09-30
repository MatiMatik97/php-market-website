function check(x) {
    return x < 10 ? `0${x}` : x;
}

// Defining timer() function 
function timer() {
    const date = new Date();
    const hours = check(date.getHours());
    const minutes = check(date.getMinutes());
    const seconds = check(date.getSeconds());
    const time = `${hours}:${minutes}:${seconds}`;
    const timer = document.querySelector("#timer");
    timer.innerHTML = time;
}

timer();

setInterval(function(){
    // Calling timer() function in every second
    timer();
}, 1000);
