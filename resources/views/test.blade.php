<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('de78cb5d7124e33189ac', {
        cluster: 'ap1',
        forceTLS: true,
        encrypted: true
    });

    var userChannel = pusher.subscribe('c95ded77c0d61d126cecb336918aea939fa08115');
    userChannel.bind('talk-send-message', function (data) {
        console.log(data);
    });

</script>
