<style>
@import url('https://fonts.googleapis.com/css2?family=Gasoek+One&family=Lobster&display=swap');

#snowflake {
    width: 20px;
}

.snow {
    font-size: 20px;
    position: fixed;
    top: -5vh;
    transform: translateY(0);
    transform: rotate(180deg);
    animation: fall 7s linear forwards;
}

@keyframes fall {
    to {
        transform: translateY(105vh);
    }
}




.iced-text {
    font-family: 'Gasoek One', cursive;
    font-size: 11vmin;
    text-align: center;
    line-height: 1em;
    position: relative;
    letter-spacing: -0.02em;
    padding: 120px 50px 0px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (orientation: landscape) {
    .iced-text {
        font-size: 7vmax;
    }
}

.iced-text-back {
    position: absolute;
    top: 0;
    left: 0;
    color: white;
    z-index: -1;
    -webkit-text-stroke: 0.1em white;
    filter: drop-shadow(0 0 0.05em #0c6dbd);
}

.iced-text-front {
    color: #D5AD6D;
    /*if no support for background-clip*/
    background: -webkit-linear-gradient(transparent, transparent),
        -webkit-linear-gradient(top, rgba(213, 173, 109, 1) 0%, rgba(213, 173, 109, 1) 26%, rgba(226, 186, 120, 1) 35%, rgba(163, 126, 67, 1) 45%, rgba(145, 112, 59, 1) 61%, rgba(213, 173, 109, 1) 100%);
    background: -o-linear-gradient(transparent, transparent);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    -webkit-background-clip: text;
    -webkit-text-stroke: 0.03em white;
}

#canvas {
    position: absolute;
}



.countdown-container h1 {
    font-size: 4rem;
    letter-spacing: 0.2rem;
}

#timer {
    font-size: 7.5rem;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: 128px 80px;
    justify-items: center;
    grid-column-gap: 40px;
    font-family: "Patua One", cursive;
    color: #fff;
    -webkit-text-stroke: 0.05em black;
}

#timer .animated {
    animation-name: pulse;
    animation-duration: 1s;
    animation-timing-function: linear;
    animation-fill-mode: both;
    animation-iteration-count: infinite;
}

.label {
    font-size: 2.5rem;
    color: #fec54d;
    -webkit-text-stroke: 0.05em black;
}



/* Media Queries */
@media screen and (max-width: 690px) {
    #timer {
        font-size: 5.5rem;
    }

    h1 {
        text-align: center;
    }

    .start-quiz-btn {
        visibility: hidden;
    }


}

@media screen and (max-width: 518px) {
    #timer {
        font-size: 4rem;
        grid-template-rows: 70px 50px;
    }

    h1 {
        font-size: 2.5rem;
    }

    .label {
        font-size: 1.7rem;
    }
}

@media screen and (max-width: 453px) {
    #timer {
        grid-template-columns: repeat(4, 1fr);
        /* grid-template-rows: repeat(2, 70px 60px); */
        grid-column-gap: 0px;
    }

    #timer span:nth-of-type(-n + 2) {
        grid-row: 2/3;
    }

    .iced-text {
        padding: 50px 50px 0px;
        font-size: 14vmin;
    }

    .content1 {
        height: 100vh;
        /* display:flex;
  justify-content: center;
  align-items: center; */
        background-image: url(https://christmascountdown.app/img/themes/svg/snowman.svg);
        /* background-size: cover;
    background-position: center; */
        background-repeat: no-repeat;
    }

    .countdown-container {
        margin-bottom: 30px;
    }

}



@keyframes pulse {
    100% {
        transform: scaleX(1);
    }

    30%,
    50%,
    80% {
        transform: scale3d(1.1, 1.1, 1.1);
    }

    0% {
        transform: scaleX(1);
    }
}

@media screen and (min-width: 768px) {
    .content1 {
        height: 100vh;
        background-image: url(https://christmascountdown.app/img/themes/svg/snowman.svg);
        background-repeat: space;
        background-position: bottom;
        background-size: cover;
        padding:120px 0px;
    }

    .iced-text {
        font-size: 10vmax;
    }

    .countdown-container {
        margin-bottom: 300px;
    }
}




@media screen and (min-width: 1024px) {
    .content1 {
        height: 100vh;
        background-image: url(https://christmascountdown.app/img/themes/svg/snowman.svg);
        background-repeat: space;
        background-position: bottom;
        background-size: cover;
        padding:0px 0px;
    }

    .iced-text {
        font-size: 10vmax;
    }

    .countdown-container {
        margin-bottom: 210px;
    }
}

@media screen and (min-width: 1366px) {
    .content1 {
        height: 100vh;
        background-image: url(https://christmascountdown.app/img/themes/svg/snowman.svg);
        background-repeat: space;
        background-position: bottom;
        background-size: cover;
        padding:170px 0px;
    }

    .iced-text {
        font-size: 10vmax;
    }

    .countdown-container {
        margin-bottom: 250px;
    }
}

@media screen and (min-width: 1400px) {
    .content1 {
        height: 100vh;
        background-image: url(https://christmascountdown.app/img/themes/svg/snowman.svg);
        background-repeat: space;
        background-position: bottom;
        background-size: cover;
        padding:100px 0px;
    }

    .iced-text {
        font-size: 10vmax;
    }

    .countdown-container {
        margin-bottom: 250px;
    }
}

</style>
<div class="content1">
    <div class="iced-text">
        <div class="iced-text-front">Happy New Year 2024</di>
        </div>
    </div>
    <div class="container">
        <div class="countdown-container">
            <div id="timer">
                <div id="days"></div>
                <div id="hrs"></div>
                <div id="mins"></div>
                <div id="secs" class="animated"></div>
                <span class="label">Days</span>
                <span class="label">Hours</span>
                <span class="label">Mins</span>
                <span class="label">Secs</span>
            </div>
        </div>
    </div>


    <script>
    function createSnow() {
        const snow = document.createElement("div");

        snow.innerHTML =
            "<img id='snowflake' src='https://static.vecteezy.com/system/resources/thumbnails/011/025/390/small/christmas-snowflake-winter-free-png.png'>";
        snow.classList.add("snow");

        document.body.appendChild(snow);

        snow.style.left = Math.random() * 100 + "vw";

        snow.style.animationDuration = math.random() * 5 + 8 + "s";

        setTimeout(() => {
            snow.remove();
        }, 5000);
    }

    setInterval(createSnow, 800);
    var countDownDate = new Date("Jan 1, 2024 00:00:00").getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerHTML = days;

        document.getElementById("hrs").innerHTML = hours;

        document.getElementById("mins").innerHTML = minutes;

        document.getElementById("secs").innerHTML = seconds;
    }, 1000);

    function createSnowFlake() {
        const snow_flake = document.createElement('i');
        snow_flake.classList.add('far');
        snow_flake.classList.add('fa-snowflake');
        snow_flake.style.left = `${Math.random() * window.innerWidth}px`;
        snow_flake.style.animationDuration = `${Math.random() * 3 + 2}s`;
        snow_flake.style.opacity = Math.random();

        body.appendChild(snow_flake);

        setTimeout(() => {
            snow_flake.remove();
        }, 5000);
    }

    setInterval(calculateChristmasCountdown, 1000);
    </script>