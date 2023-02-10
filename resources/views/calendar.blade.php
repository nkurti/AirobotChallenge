<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Front test</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    if (!localStorage.getItem('token')) {
      window.location.href = '/'
    }
  </script>
  <style>
    #calendar {
      margin: auto;
      width: 100%;
      max-width: 600px;
    }

    .fc .fc-daygrid-day-frame {
      background-color: #eefff7;
      color: green;
      cursor: pointer;
    }

    .fc-daygrid-body td:hover {
      outline: 1px red solid;
      position: relative;
      z-index: 99;
    }

    .notAvaible {
      color: #fff;
      opacity: 1 !important;
      background-color: #de8e8e !important;
    }
  </style>
</head>

<body>
  <div id="calendar"></div>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>
  <script>
    let events = [];
    document.addEventListener("DOMContentLoaded", async function() {
      var calendarEl = document.getElementById("calendar");
      await fetch(`http://127.0.0.1:8000/api/user/availabilities`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
      }).then(res => res.json()).then(data => {
        events = data.map(ev => ({
          title: "Busy",
          date: ev.date,
          display: "background",
          backgroundColor: "red",
          classNames: ["notAvaible"],
        }));
      })
      var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: "dayGridMonth",
        initialDate: new Date(),
        headerToolbar: {
          left: "prev,next allTime,oneTime",
          right: "title",
        },
        events,
        //   selectable: true,
        dateClick: async function(info) {
          calendar.addEvent({
            title: "Busy",
            start: info.dateStr,
            display: "background",
            backgroundColor: "red",
            classNames: ["notAvaible"],
          });

          const api = `http://127.0.0.1:8000/api/user/availability`;
          const response = await fetch(api, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({
              date: info.dateStr,
              available: false
            })
          });
          const data = await response.json()
        },

        customButtons: {
          allTime: {
            text: "Available all of the time",
            id: "displayText",
            click: async function() {
              var date = new Date(calendar.getDate());
              let formattedDate = moment(date).format("YYYY-MM-DD")
              const api = `http://127.0.0.1:8000/api/update`;
              const response = await fetch(api, {
                method: 'PUT',
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({
                  date: formattedDate,
                  available: 1
                })
              });
              const data = await response.json();
              location.reload();

            },
          },
          oneTime: {
            text: "None of the time",
            click: async function() {

              var date = new Date(calendar.getDate());
              let formattedDate = moment(date).format("YYYY-MM-DD")
              const api = `http://127.0.0.1:8000/api/update`;
              const response = await fetch(api, {
                method: 'PUT',
                headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({
                  date: formattedDate,
                  available: 0
                }),

              });
              location.reload();
              const data = await response.json()
            },
          },
        },
      });

      calendar.render();
    });
  </script>
</body>

</html>