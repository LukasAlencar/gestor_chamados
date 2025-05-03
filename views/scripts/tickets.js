function toggleDetails(id) {
    var el = document.getElementById(id);
    if (el.style.display == "none") {
        el.style.display = "block";
    } else {
        el.style.display = "none";
    }
}

function deleteTicket(ticket_id, e){
    e.preventDefault();

    $('#formDelete'+ticket_id).submit();
}