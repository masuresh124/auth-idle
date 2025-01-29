<script>
    let inactiveTimeOutConfig = "{{ config('auth-idle.timeout') }}";

    const LAST_ACTIVITY_KEY = 'lastActivityTime';
    const WARNING_TIMEOUT = parseInt((inactiveTimeOutConfig - 1) * 60); //seconds
    const WARNING_TIMEOUT_KEY = 'warningTimeoutKey';
    let warningDialogVisible = false;
    let warningTimeoutInterval;


    // Update the last activity time in localStorage
    function updateLastActivity() {
        if (warningDialogVisible) return;

        let currentTime = Date.now();
        currentTime = new Date(currentTime);
        localStorage.setItem(LAST_ACTIVITY_KEY, currentTime.getTime());

    }

    // Check inactivity across all tabs
    function checkInactivity() {
        const lastActivityTime = localStorage.getItem(LAST_ACTIVITY_KEY);
        let currentTime = Date.now();
        currentTime = new Date(currentTime);

        var remaingTime = parseInt(currentTime.getTime()) - parseInt(lastActivityTime);

        if (lastActivityTime && (remaingTime >= (WARNING_TIMEOUT * 1000))) {
            if ($('.auto-logout-bootbox').length != 1) {
                confirmSessionBootbox();
            }
        } else {
            getInAjax('{{ route('activity.checkActivity') }}', function() {

            });
        }

    }

    // Logout the user and notify all tabs
    function logOutUser() {
        clearInterval(warningTimeoutInterval);
        localStorage.removeItem(LAST_ACTIVITY_KEY);
        localStorage.setItem('logout', Date.now());
        warningDialogVisible = false;
        console.log('Session Logout.')
        logOutAllSessionTabs();
    }


    function extendSession() {
        clearInterval(warningTimeoutInterval);
        localStorage.setItem('extend', Date.now());
        warningDialogVisible = false;
        updateLastActivity();
        extentAllSessionTabs();
    }

    function updateWaningTimout() {

        const lastActivityTime = localStorage.getItem(LAST_ACTIVITY_KEY);

        let currentTime = Date.now();
        currentTime = new Date(currentTime);
        var remainSecon = currentTime.getSeconds();
        var remaingTime = parseInt(currentTime.getTime()) - parseInt(lastActivityTime);

        if (localStorage.getItem(WARNING_TIMEOUT_KEY) === null) {
            localStorage.setItem(WARNING_TIMEOUT_KEY, 60);
        }

        var warningTimeoutCount = localStorage.getItem(WARNING_TIMEOUT_KEY);

        if (remaingTime < (WARNING_TIMEOUT * 1000)) {
            extendSession();
        } else if (warningTimeoutCount <= 0) {
            $('.auto-logout-bootbox .bootbox-body').html(
                '<h5 class = "modal-title text-center">Thank You!</h5>');
            $('.auto-logout-bootbox .modal-footer').html('');
            $('.logout-section button').trigger('click');
            logOutUser();
        } else if (lastActivityTime && (remaingTime >= (WARNING_TIMEOUT * 1000))) {
            warningTimeoutCount = warningTimeoutCount - 1;
            localStorage.setItem(WARNING_TIMEOUT_KEY, warningTimeoutCount);
            if (warningTimeoutCount > 0) {
                $('#auth-timeout-second').html(parseInt(warningTimeoutCount));
            }
        }

    }


    function confirmSessionBootbox() {

        warningTimeoutInterval = setInterval(updateWaningTimout, 1000); // Check every second
        warningDialogVisible = true;
        var sessionExpiredIcon = "{{ asset('img/icons/session-expired.svg') }}";
        bootbox.dialog({
            className: "auto-logout-bootbox animate__headShake",
            title: '<div class="modal-header-content"><div class="modal-img mx-auto"><img src="' +
                sessionExpiredIcon + '" alt="Alert" class="img-fluid"></div></div>',
            message: '<h5 class = "modal-title text-center" id = "auth-idle-modal" >Taking a Break?</h5 > <p class = "text-center" >Your access is about to time out in <span id = "auth-timeout-second" ></span> seconds. </p><h5 class="text-center">Do you want to stay signed in ?<h5/>',
            closeButton: false,
            centerVertical: true,
            buttons: {
                ok: {
                    label: "Yes, Keep me signed in",
                    className: "btn btn-danger",
                    callback: function() {
                        extendSession();
                        return true;

                    },
                },
            },
        });
    }

    function logOutAllSessionTabs() {
        window.addEventListener('storage', (event) => {

            if (event.key === 'logout') {
                $('.logout-section button').trigger('click');
            }
        });
    }

    function extentAllSessionTabs() {
        window.addEventListener('storage', (event) => {
            if (event.key === 'extend') {
                console.log('Extend Session');

            }
        });
    }

    $(document).ready(function() {

        localStorage.removeItem('extend');
        localStorage.removeItem('logout');
        localStorage.removeItem(WARNING_TIMEOUT_KEY);

        // // Handle logout notification from other tabs
        logOutAllSessionTabs();
        extentAllSessionTabs();

        // Attach event listeners to detect user activity
        ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
            window.addEventListener(event, updateLastActivity);
        });

        // Initialize the last activity time and start checking for inactivity
        updateLastActivity();
        setInterval(checkInactivity, 1000 * 10); // Check every 1 second

    });
</script>
