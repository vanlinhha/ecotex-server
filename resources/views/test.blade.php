<script src="https://js.pusher.com/3.2/pusher.min.js"></script>
<script>

    console.log(0);

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('de78cb5d7124e33189ac', {
        cluster: 'ap1',
        forceTLS: true,
        encrypted: true
    });

    var userChannel = pusher.subscribe('ecotex-user-2');
    userChannel.bind('Webcast', function (data) {
        console.log(1);
        console.log(data);
    });
    console.log(2);

</script>
