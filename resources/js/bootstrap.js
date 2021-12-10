window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

// Echo configuration to connect to websocket
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: false,
    forceTLS: false,
});

// POTENTIAL FOR FUTURE DEVELOPMENT
// Total number of connected users
// var total_connected = 0;
// window.Echo.connector.pusher.connection.bind('connected', () => {
//     console.log('connected');
//     total_connected = total_connected + 1;
//     alert(total_connected);
// });

// Subscribes to channel and listen for event
// Teacher view (admin page)
window.Echo.channel('answers-channel').listen('AnswerPollEvent', (e) => {

    // Update the total votes received
    // Grab total_received from document
    var total_received = parseInt(document.getElementById("total-received").textContent);
    // Increment
    total_received = total_received + 1;
    // Update on document
    document.getElementById("total-received").innerHTML = total_received;

    // Current num of votes for clicked answer.
    // Temp variable to concat
    var p = 'progress-answer-';

    // Get the ID of the correct answer
    var base = parseInt(document.getElementById("correct_ans").textContent)

    // Update results progress bars
    // 4 result progress bars ( 4 answers in an individual poll)
    for (var i = 0; i <= 3; i++) {
        var p_id = p.concat(base + i); //e.g. 'progress-answer-1'
        
        // Update the progress bar for the correct answer
        if (e["answer"] == base + i) { 
            var current_value = current_value = parseInt(document.getElementById(p.concat(e["answer"])).textContent) + 1; // 0 -> 1
            document.getElementById(p_id).innerHTML = current_value; // e.g. 'progress-answer-3'

        } else { 
            // Non correct answers current values
            var current_value = document.getElementById(p.concat(base + i)).textContent;// progress-answer-3
        }
        // Update progress bar p_id
        document.getElementById(p_id).setAttribute("style", "width:" + Number(current_value / total_received * 100) + "%");
    }
});

// Subscribes to channel and listen for event
// User view (voting page)
window.Echo.channel('polls-channel').listen('NextPollEvent', (e) => {

    // Poll num
    var poll_num = e["poll_num"];
    // Num of polls
    var num_of_polls = parseInt(document.getElementById('num_of_polls').textContent);
    
    // Update progress bar on voter screen
    var progress = 0
    if (poll_num != 0) {
        var progress = (poll_num * 100) / num_of_polls - (100 / num_of_polls);
    } else {
        progress = 2;
    }
    document.getElementsByClassName("progress-bar").item(0).setAttribute("style", "width:" + Number(progress) + "%");

    // Toggle poll visibilities

    var normalise = poll_num - 1
    //poll_num = 7
    //normalise = 6
    //num_of_polls = 3
    
    for (var i = 1; i <= Number(num_of_polls); i++) {
        if (i == (poll_num - normalise)) { //
            document.getElementsByTagName("form").item(i).style.display = 'block';
        } else {
            document.getElementsByTagName("form").item(i).style.display = 'none';
        }
    };

    // Toggle visibility of the Loading Page gif (before poll starts, and between)
    if (poll_num != 0) {
        document.getElementsByTagName("img").item(0).style.display = 'none';
    } else {
        document.getElementsByTagName("img").item(0).style.display = 'block';
    }
});

// POTENTIAL FOR FUTURE DEVELOPMENT
// Subscribes to channel and listen for event
// When teacher clicks Reveal Answer button, reveal the answer
// on the students voting page.
window.Echo.channel('polls-channel').listen('RevealAnswerEvent', (e) => {

});

