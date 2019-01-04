$(document).ready(function(){
    $("#myModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);  // Button that triggered the modal
        let visitId = button.data('visit-id'); // Extract value from data-* attributes
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete this visit to ${customerName}?</p>`);
        let path = `delete/${visitId}`;
        $('#confirm-delete').attr('href', path);
    });

    $("#byCustomerModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let visitId = button.data('visit-id');
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete this visit to ${customerName}?</p>`);
        let path = `/visit/delete/${visitId}`;
        $('#confirm-delete').attr('href', path);
    });
});