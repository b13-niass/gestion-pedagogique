<style>

    /* Modal Background */
    .cancelModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px); /* Background blur effect */
        z-index: 1000; /* Ensure modal is on top */
    }

    /* Modal Container */
    #cancelModal .modal-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        width: 24rem; /* Adjust the width as needed */
        max-width: 90%; /* Ensure it doesn't overflow the screen */
    }

    /* Modal Header */
    #cancelModal .modal-header {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    /* Modal Text */
    #cancelModal .modal-text {
        margin-bottom: 1rem;
    }

    /* Modal Input */
    #cancelModal .modal-input {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.5rem;
        width: 100%;
        margin-bottom: 1rem;
    }

    /* Modal Buttons */
    #cancelModal .modal-buttons {
        display: flex;
        justify-content: flex-end;
    }

    #cancelModal .modal-button {
        background-color: #4caf50;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-left: 0.5rem;
    }

    #cancelModal .modal-button:hover {
        background-color: #45a049;
    }

    #cancelModal .modal-button.cancel {
        background-color: #f44336;
    }

    #cancelModal .modal-button.cancel:hover {
        background-color: #e53935;
    }

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

    .fc-event {
        color: #ffffff!important; /* Fallback color for text */
    }

    /* Apply colors based on status */
    .bg-green-500 {
        background-color: #48bb78!important; /* Customize as needed */
    }

    .bg-red-500 {
        background-color: #f56565!important; /* Customize as needed */
    }

    .bg-yellow-500 {
        background-color: #ecc94b!important; /* Customize as needed */
    }
    .bg-gray-500{
        background-color: #818181!important; /* Customize as needed */
    }

    .text-white {
        color: #ffffff!important;
    }

    /* Make sure these styles apply to the FullCalendar events */
    .fc-daygrid-day-events .fc-event {
        color: #ffffff!important; /* Text color for all events */
    }

    .fc-timegrid-event {
        color: #ffffff!important; /* Text color for time grid events */
    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.1/tippy.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.1/tippy-bundle.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.12.3/sweetalert2.all.js" integrity="sha512-ch8WSvHL/CKOt82FEwjcjYN5LyzX6Na2l4pdFPzTkVlWsvpkncRn3S/Ih2iIT66XfLCalZqmOb3SqRLwm2v/qA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.js" integrity="sha512-3I+0zIxy2IkeeCvvhXUEu+AFT3zAGuHslHLDmM8JBv6FT7IW6WjhGpUZ55DyGXArYHD0NshixtmNUWJzt0K32w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div data-iduser="<?=$user->id?>" class="bg-box-dark rounded-10 sm:p-[40px] p-[20px]">
    <div class="grid grid-cols-12 sm:gap-[25px]">
        <div class="col-span-12">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const user_id = document.querySelector('[data-iduser]').dataset.iduser;

        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',  // Set the locale to French
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: async function(info, successCallback, failureCallback) {
                try {
                    const response = await fetch(`/api/etu/${user_id}/sessions`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    successCallback(data);
                } catch (error) {
                    console.error('Error fetching events:', error);
                    failureCallback(error);
                }
            },
            eventDidMount: function(info) {
                const today = new Date();
                const startDate = new Date(info.event.start);
                const endDate = new Date(info.event.end);

                let classNames;
                if (today >= startDate && today <= endDate) {
                    classNames = 'bg-green-500 text-white'; // Green for current date within the interval
                } else if (endDate > today) {
                    classNames = 'bg-yellow-500 text-white'; // Yellow for future dates
                } else {
                    classNames = 'bg-red-500 text-white'; // Red for past dates
                }

                info.el.classList.add(...classNames.split(' '));

                // Add tooltip
                const presence = info.event.extendedProps.etat_presence;
                tippy(info.el, {
                    content: `Présence: ${presence}`,
                    placement: 'top',
                    theme: 'light'
                });
            },
            selectable: true,
            eventClick: function(info) {
                const today = new Date().getTime();
                const startDate = new Date(info.event.start).getTime();
                const endDate = new Date(info.event.end).getTime();
                const presenceStatus = info.event.extendedProps.etat_presence;

                if (presenceStatus === 'absent' && today >= startDate && today <= endDate) {
                    const modal = document.getElementById('cancelModal');
                    const modalText = document.getElementById('modalText');
                    const closeButton = document.getElementById('closeButton');
                    const confirmButton = document.getElementById('confirmButton');

                    modalText.textContent = `Marquer ma présence pour le cours "${info.event.title}" ?`;
                    modal.classList.remove('hidden');
                    modal.style.display = 'flex';
                    modal.style.zIndex = '2000';

                    closeButton.onclick = () => {
                        modal.classList.add('hidden');
                        modal.style.display = 'none';
                    };

                    confirmButton.onclick = async () => {
                        try {
                            const response = await fetch(`/api/etu/${user_id}/sessions`, {
                                method: "POST",
                                headers: { "Content-Type": "application/json" },
                                body: JSON.stringify({ request_type: 'togglePresence', event_id: info.event.id })
                            });

                            const data = await response.json();
                            console.log(data);
                            exit();
                            if (data.status === 1) {
                                alert('Présence marquée avec succès!');
                                calendar.refetchEvents();
                            } else {
                                console.error('Server responded with an error:', data.error);
                                alert(data.error || 'An error occurred');
                            }
                        } catch (error) {
                            console.error('Error handling event cancellation:', error);
                            alert('An error occurred while handling the event cancellation.');
                        } finally {
                            modal.classList.add('hidden');
                            modal.style.display = 'none';
                        }
                    };
                }
            }
        });

        calendar.render();
    });
</script>

Modal Background
<div id="cancelModal" class="hidden fixed inset-0 flex items-center justify-center backdrop-filter backdrop-blur-md bg-black bg-opacity-50">
    <div class="modal-container p-4 bg-white rounded-lg shadow-lg">
        <div class="modal-header text-xl font-bold mb-4">Marquer ma présence</div>
        <div class="modal-text mb-4" id="modalText"></div>
        <div class="modal-buttons flex justify-end space-x-2">
            <button id="closeButton" class="modal-button cancel bg-red-500 text-white py-2 px-4 rounded">Annuler</button>
            <button id="confirmButton" class="modal-button bg-green-500 text-white py-2 px-4 rounded">Confirmer</button>
        </div>
    </div>
</div>