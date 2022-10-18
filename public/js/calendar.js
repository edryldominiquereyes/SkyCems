$(document).ready(function () {
    $(".sidebar-btn").click(function () {
        $(".wrapper").toggleClass("hide");
    });
    
    $('#calendar').fullCalendar({
        
        eventLimit: false, // allow "more" link when too many events
        eventLimitText: "More", //sets the text for more events
        displayEventTime : false, //Display time besides event name
        height: 545,
        header: {
            center: 'title',
            left: 'prev next today',
            right: ''
        },
       
        events: bookings,

        eventRender: function (events, element) {
            element.find('.fc-title').append("<br/> Start at: " + events.start.format('h:mm a ddd MMM Do YYYY') + " <br/> End at: " +
                events.end.format('h:mm a ddd MMM Do YYYY'));
        },
        eventClick: function(events) {
            alert('Event: ' + events.title + ' Start at: ' + events.start.format('h:mm a ddd MMM Do YYYY') + ' End at: ' + events.end.format('h:mm a ddd MMM Do YYYY'));
    
        },
        
    
    })

    $('.fc-event').css('color', 'white');

});


// var today = new Date();
// var dd = String(today.getDate()).padStart(2, '0');
// var mm = String(today.getMonth() + 1).padStart(2, '0');
// var yyyy = today.getFullYear();

// today = yyyy + '-' + mm + '-' + dd;
// $('#date').attr('min', today);

// var today = new Date();
// var past = new Date().toISOString().slice(0, 16);
// today = new Date(today.setDate(today.getDate() + 50)).toISOString().slice(0, 16);

// document.getElementsByName("start_datetime")[0].min = past;
// document.getElementsByName("end_datetime")[0].min = past;

// document.getElementsByName("start_datetime")[0].max = today;
// document.getElementsByName("end_datetime")[0].max = today;

