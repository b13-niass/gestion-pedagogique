<style>
    .legend {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .legend div {
        margin: 0 1rem;
        display: flex;
        align-items: center;
    }
    .legend span {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 0.5rem;
        border-radius: 50%;
    }
    .legend .completed { background-color: #38a169; }
    .legend .cancelled { background-color: #e53e3e; }
    .legend .upcoming { background-color: #d69e2e; }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.3/sweetalert2.all.js" integrity="sha512-ch8WSvHL/CKOt82FEwjcjYN5LyzX6Na2l4pdFPzTkVlWsvpkncRn3S/Ih2iIT66XfLCalZqmOb3SqRLwm2v/qA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.js" integrity="sha512-3I+0zIxy2IkeeCvvhXUEu+AFT3zAGuHslHLDmM8JBv6FT7IW6WjhGpUZ55DyGXArYHD0NshixtmNUWJzt0K32w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="bg-box-dark rounded-10 sm:p-[40px] p-[20px]">
    <div class="grid grid-cols-12 sm:gap-[25px]">
        <div class="col-span-12">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',  // Set the locale to French
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                { title: 'Session 1', start: '2024-07-01', status: 'completed' },
                { title: 'Session 2', start: '2024-07-05', status: 'cancelled' },
                { title: 'Session 3', start: '2024-07-10', status: 'upcoming' },
                { title: 'Session 4', start: '2024-07-15', status: 'completed' },
                { title: 'Session 5', start: '2024-07-20', status: 'cancelled' },
                { title: 'Session 6', start: '2024-07-25', status: 'upcoming' }
            ],
            eventClassNames: function(arg) {
                if (arg.event.extendedProps.status === 'completed') {
                    return 'bg-green-500 text-white';
                } else if (arg.event.extendedProps.status === 'cancelled') {
                    return 'bg-red-500 text-white';
                } else {
                    return 'bg-yellow-500 text-white';
                }
            },
            selectable: true,
            eventClick: function(info) {
                if (info.event.extendedProps.status === 'upcoming') {
                    Swal.fire({
                        title: 'Demande d\'annulation',
                        text: `Voulez-vous annuler la session de cours "${info.event.title}" ?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, annuler',
                        cancelButtonText: 'Non'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("eventHandler.php", {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ request_type: 'cancelEvent', event_id: info.event.id })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status == 1) {
                                        Swal.fire('Session annulée avec succès!', '', 'success');
                                        calendar.refetchEvents();
                                    } else {
                                        Swal.fire(data.error, '', 'error');
                                    }
                                })
                                .catch(console.error);
                        }
                    });
                }
            }
        });

        calendar.render();
    });
</script>