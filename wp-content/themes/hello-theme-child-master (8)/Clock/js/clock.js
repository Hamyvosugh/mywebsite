document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;

    const localClock = document.getElementById('local-time');
    const internationalClock = document.getElementById('international-time');
    const timezoneSelect = document.getElementById('timezone-select');

    function updateClock(clock, date) {
        const hourHand = clock.querySelector('.hour-hand');
        const minuteHand = clock.querySelector('.minute-hand');
        const secondHand = clock.querySelector('.second-hand');
        const digitalClock = clock.querySelector('.digital-clock');

        const hours = date.getHours();
        const minutes = date.getMinutes();
        const seconds = date.getSeconds();

        const hourDegrees = (hours % 12) * 30 + (minutes / 2);
        const minuteDegrees = minutes * 6;
        const secondDegrees = seconds * 6;

        hourHand.style.transform = `rotate(${hourDegrees}deg)`;
        minuteHand.style.transform = `rotate(${minuteDegrees}deg)`;
        secondHand.style.transform = `rotate(${secondDegrees}deg)`;

        digitalClock.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function updateLocalClock() {
        const now = new Date();
        updateClock(localClock, now);
    }

    function updateInternationalClock() {
        const selectedTimezone = timezoneSelect.value || 'America/Los_Angeles'; // Default to Los Angeles
        const now = new Date().toLocaleString("en-US", { timeZone: selectedTimezone });
        const date = new Date(now);
        updateClock(internationalClock, date);
    }

    updateLocalClock();
    updateInternationalClock();

    setInterval(updateLocalClock, 1000);
    setInterval(updateInternationalClock, 1000);
    timezoneSelect.addEventListener('change', updateInternationalClock);
});