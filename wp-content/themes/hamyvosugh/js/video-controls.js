document.addEventListener('DOMContentLoaded', function () {
    var video = document.getElementById("myVideo");
    var playPauseBtn = document.getElementById("playPauseBtn");
    var playIcon = document.getElementById("playIcon");
    var replayBtn = document.getElementById("replayBtn");
    var muteBtn = document.getElementById("muteBtn");
    var muteIcon = document.getElementById("muteIcon");

    // Play/Pause Toggle Button
    playPauseBtn.addEventListener("click", function () {
        if (video.paused) {
            video.play();
            playIcon.className = "fa fa-pause";
        } else {
            video.pause();
            playIcon.className = "fa fa-play";
        }
    });

    // Replay Button
    replayBtn.addEventListener("click", function () {
        video.currentTime = 0;
        video.play();
        playIcon.className = "fa fa-pause";
    });

    // Mute/Unmute Toggle Button
    muteBtn.addEventListener("click", function () {
        if (video.muted) {
            video.muted = false;
            muteIcon.className = "fa fa-volume-up";
        } else {
            video.muted = true;
            muteIcon.className = "fa fa-volume-mute";
        }
    });
});