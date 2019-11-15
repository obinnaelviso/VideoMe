var session_id = document.getElementById('session_id').value;
var token = document.getElementById('token').value;
var api_key = document.getElementById('api_key').value;
var call_btn = document.getElementById('call_btn');
var notice = document.getElementById('notice');

// connect to open tok api using client side library
var session = OT.initSession(api_key, session_id);

// Handling all of our errors here by alerting them
function handleError(error) {
    if (error) {
        alert(error.message);
    }
}

// when other user is connected we want to show them
// in subscriber div element
session.on('streamCreated', function(event) {
    notice.innerHTML = "";
    session.subscribe(event.stream, 'subscriber', {
        insertMode: 'append',
        width: '100%',
        height: '100%'
    }, handleError);
});


// if we have any connection error let's put an alert box
function call(session_id, token) {
    notice.innerHTML = "";
    // connect to open tok api using client side library
    var session = OT.initSession(api_key, session_id);
    session.connect(token, function (error) {
        if (error) {
            alert(error.message);
        } else {
            session.publish(publisher, handleError);
            var publisher = OT.initPublisher('publisher', {
                insertMode: 'append',
                width: '100%',
                height: '150px'
            }, handleError);
        }
    });
}
// session.on("signal", function (event) {
//     console.log("Signal sent from connection " + event.from.id);
//     // Process the event.data property, if there is any data.
// });
// session.signal(
//     {
//         to: connection1,
//         data: "hello"
//     },
//     function (error) {
//         if (error) {
//             console.log("signal error ("
//                 + error.name
//                 + "): " + error.message);
//         } else {
//             console.log("signal sent.");
//         }
//     }
// );
session.connect(token, function (error) {
    if (error) {
        alert(error.message);
    } else {
        console.log("Session Connected");
        console.log(session)
    }
});