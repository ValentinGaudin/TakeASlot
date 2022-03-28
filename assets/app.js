/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap-icons/font/bootstrap-icons.css'; 

// start the Stimulus application
import './bootstrap';



// document.addEventListener("DOMContentLoaded", () => {
//     var calendarEl = document.getElementById("calendar-holder");

//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         defaultView: "timeGridWeek",
//         editable: false,
//         eventResizableFromStart: false,
//         events:'',
//         eventSources: [
//             {
//                 url:'data-events-url',
//                 method: "POST",
//                 extraParams: {
//                     filters: JSON.stringify({})
//                 },
//                 failure: () => {
//                     // alert("There was an error while fetching FullCalendar!");
//                 },
//             },
//         ],
//         header: {
//             left: "prev,next today",
//             center: "title",
//             right: "timeGridWeek,timeGridDay",
//         },
//         plugins: [
//         'interaction', 'dayGrid', 'timeGrid'
//         ],
//         timeZone: "UTC",
//     });
//     calendar.render();
// });