// const buttons = document.querySelectorAll(".cancel, .confirm")
//
// buttons.forEach(button => {
//     button.addEventListener('click', (event) => {
//         let clickedButton = event.target
//         let reservationWrapper = clickedButton.closest('.carCard')
//         let reservationId = reservationWrapper.getAttribute('id');
//         let action = clickedButton.getAttribute('data-action')
//         handleAction(action,reservationId);
//         reservationWrapper.remove();
//     })
// })
//
// async function handleAction(decision, reservation_id){
//     const data = {
//         action: decision,
//         reservation_id: reservation_id
//     }
//
//     const response = await fetch("/handleReservation", {
//         method: "POST",
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify(data)
//     });
// }