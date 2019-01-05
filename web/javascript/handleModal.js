$(document).ready(function(){
    //Delete visit
    $("#myModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);  // Button that triggered the modal
        let visitId = button.data('visit-id'); // Extract value from data-* attributes
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete this visit to ${customerName}?</p>`);
        let path = `delete/${visitId}`;
        $('#confirm-delete').attr('href', path);
    });

    //Delete visit by customer
    $("#byCustomerModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let visitId = button.data('visit-id');
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete this visit to ${customerName}?</p>`);
        let path = `/visit/delete/${visitId}`;
        $('#confirm-delete').attr('href', path);
    });

    //Delete customer
    $("#customerModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let customerId = button.data('customer-id');
        let customerName = button.data('customer-name');
        $('.modal-body').html(`<p>Do you really want to delete ${customerName}?</p>`);
        let path = `delete/${customerId}`;
        $('#confirm-delete').attr('href', path);
    });

    //Delete expense
    $("#expenseModal").on('show.bs.modal', function(event){
        let button = $(event.relatedTarget);
        let expenseId = button.data('expense-id');
        let expenseName = button.data('expense-name');
        $('.modal-body').html(`<p>Do you really want to delete this expense for ${expenseName}?</p>`);
        let path = `delete/${expenseId}`;
        $('#confirm-delete').attr('href', path);
    });
});