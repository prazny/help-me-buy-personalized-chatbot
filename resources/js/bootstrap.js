import Echo from '@ably/laravel-echo';

window.Ably = require('ably');

// Create new echo client instance using ably-js client driver.
window.Echo = new Echo({
    broadcaster: 'ably',
});

// Register a callback for listing to connection state change
window.Echo.connector.ably.connection.on((stateChange) => {
    console.log("LOGGER:: Connection event :: ", stateChange);
    if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
        console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
    }
});
