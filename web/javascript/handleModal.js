$(document).ready(function(){
    //Delete confirmation
    $("#myModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);  // Button that triggered the modal
        let id = button.data('id'); // Extract value from data-* attributes
        let name = button.data('name');
        let type = button.data('type');
        $('.modal-body').html(`<p>Do you really want to delete ${name} ${type}?</p>`);
        let path = `delete/${id}`;
        $('#confirm-delete').attr('href', path);
    });

    //Delete visit by customer
    $("#byCustomerModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let visitId = button.data('visit-id');
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete ${customerName} visit?</p>`);
        let path = `/visit/delete/${visitId}`;
        $('#confirm-delete').attr('href', path);
    });

    //Delete contact
    $("#contactModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let name = button.data('name');
        $('.modal-body').html(`<p>Do you really want to delete ${name} contact?</p>`);
        let path = `/contact/delete/${id}`;
        $('#confirm-delete').attr('href', path);
    });
});