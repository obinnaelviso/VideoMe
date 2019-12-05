var session_id = document.getElementById('session_id').value;
var token = document.getElementById('token').value;
var api_key = document.getElementById('api_key').value;
var call_btn = document.getElementById('call_btn');
var notice = document.getElementById('notice');
var answer_btn = document.getElementById('answer');
var call_msg = document.getElementById('call_msg');
var username = document.getElementById('username');
var reject_btn = document.getElementById('reject');
var end_btn = document.getElementById('end_btn');

// call alerts
var calltone = new Audio('audio/call.mp3');
var ringtone = new Audio('audio/ring.mp3');

loopTone(ringtone, calltone);

// var remote_connection;
var connected_users = 0;

// connect to open tok api using client side library
var session = OT.initSession(api_key, session_id);

// Handling all of our errors here by alerting them
function handleError(error) {
    if (error) {
        console.error(error.message);
    }
}

function refreshPage() {
    location.reload();
}

// Connect to its own session
session.connect(token, function (error) {
    if (error) {
        console.error(error.message);
    } else {
        console.log("Session Connected");
    }
});

session.on('streamDestroyed', function (data) {
    refreshPage()
})

session.on('connectionDestroyed', function(event) {
    refreshPage()
})

session.on('signal:callAlert', function (event) {
    call_msg.innerHTML = event.data + " is calling..."
});

session.on('signal:videoCall', function (data) {
    if (data.data === "call") {
        playRingTone()
        $('#myModal').modal('show');
    }
    if(data.data === "answer") {
        if (data.from.connectionId === session.connection.connectionId) {
            $('#myModal').modal('hide');
            clearSpace();
            var publisher = initializePublisher();
            showEndButton();
            publishStream(session, publisher)
            // Click end button to end call
            end_btn.addEventListener("click", function (event) {
                session.unpublish(publisher);
            })

        }
    }
});

session.once('streamCreated', function (event) {
    subscribeStream(session, event);
});




// Place a call to a user by connecting to their session
function call(session_id, token) {
    // connect to session of the client you want to call
    var session = OT.initSession(api_key, session_id);
    session.connect(token, function (error) {
        if (error) {
            console.error(error.message);
        } else {
            var publisher = initializePublisher();
            clearSpace();
            showEndButton();
            session.once('connectionCreated', function (event) {
                playCallTone()
                sendCallSignal(session, event)
                sendUsername(session, event, username.value)
            });

            session.once('streamCreated', function (event) {
               subscribeStream(session, event);
            });

            session.once('signal:videoCall', function (data) {
                publishStream(session, publisher);
                stopCallTone();
            })

            session.once('streamDestroyed', function (data) {
                refreshPage()
            })

            session.once('connectionDestroyed', function (event) {
                refreshPage()
            })

            // Click end button to end call
            end_btn.addEventListener("click", function (event) {
                session.unpublish(publisher);
                refreshPage();
            })
        }
    });
}

// Click answer button to answer call
answer_btn.addEventListener('click', function(event) {
    stopRingTone();
    sendAnswerSignal(session);
});

// Click to reject call
reject_btn.addEventListener("click", function (event) {
    refreshPage()
});





// Function Abstraction
function clearSpace() {
    notice.innerHTML = "";
}

function subscribeStream(session, event) {
    session.subscribe(event.stream, 'subscriber', {
        insertMode: 'append',
        width: '100%',
        height: '100%',
    }, handleError);
};

function initializePublisher() {
    return OT.initPublisher('publisher', {
        insertMode: 'append',
        width: '100%',
        height: '100%',
    }, handleError);
}

function publishStream(session, publisher) {
    session.publish(publisher, handleError);
}

// Call Signal
function sendCallSignal(session, event) {
    session.signal({
        type: "videoCall",
        to: event.connection,
        data: "call"
    }, function (error) {
        if (error) {
            console.log("signal error: " + error.message);
        }
    });
}

// Send Username
function sendUsername(session, event, username) {
    session.signal({
        type: "callAlert",
        to: event.connection,
        data: username
    }, function (error) {
        if (error) {
            console.log("signal error: " + error.message);
        }
    });
}

// Answer Signal
function sendAnswerSignal(session) {
    session.signal({
        type: "videoCall",
        data: "answer"
    }, function (error) {
        if (error) {
            console.error("signal error: " + error.message);
        }
    });
}

function setNotice(data) {
    notice.innerHTML = data
}

function loopTone(ringtone, calltone) {
    // Loop Ring tone
    ringtone.loop = true;
    ringtone.load();

    // Loop Call tone
    calltone.loop = true;
    calltone.load();
}

function stopRingTone() {
    ringtone.pause();
    ringtone.src = ringtone.src;
}
function stopCallTone() {
    calltone.pause();
    calltone.src = calltone.src;
}

function playCallTone() {
    calltone.play()
}

function playRingTone() {
    ringtone.play()
}

function showEndButton() {
    end_btn.style.display = 'inline-block';
}
