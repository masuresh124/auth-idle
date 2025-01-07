//Must me added below the jQuery
$(document).ready(function () {
    let idleTime = 0;

    function resetAuthIdleTimer() {
        idleTime = 0;
    }

    // Increment the idle time counter every minute.
    setInterval(() => {
        idleTime++;
        var timeout = "{{config('auth-idle.timeout')}}";
        timeout = timeout ? timeout : 30;
        if (idleTime >= "{{config('auth-idle.timeout')}}") { // 30 minutes
            alert("You have been logged out due to inactivity.");
            window.location = "{{ route('logout') }}";
        }
    }, 60000);

    // Reset idle timer on user activity.
    document.onmousemove = resetIdleTimer;
    document.onkeypress = resetIdleTimer;


});


