import Form from '../libs/form.js';
import Table from '../libs/table.js';

// order form
var orderForm = new Form('order-form');
var orderFormItemsTable = new Table('table-order-items');
orderForm.submitPostSuccess = function(response) {
    var form = this.getForm();
    // redirect to home page
    var redirectUrl = form.attr('data-redirect');
    
    const editMode = form.attr('data-edit-mode');
    if (editMode === '0') {
        // redirect to add item form
        redirectUrl = form.attr('data-item-form-url').replace('0', response.data.orderPk); 
    }

    window.location.href = redirectUrl;
};
orderForm.manageOrderStatus = function(nextStatusPk) {
    const formModel = this;
    const btn = $('#order-form-set-status-btn');

    $.ajax({
        url: btn.attr('href'),
        method: 'POST',
        data: {
            orderPk: formModel.getFormInput('pk').val(),
            // nextStatus: btn.attr('data-next-status')
            nextStatusPk: nextStatusPk
        },
        success: function(response) {
            // reload
            window.location.reload();
        },
        error: function(response) {
            alert('Pri ukladaní došlo k chybe. Skúste to prosím znova.');
        }
    });
};

// orderForm.validation['title'] = function() {
//     orderForm.clearInputErrors('title');
//     let input = orderForm.getFormInput('title');
//     let value = input.val();
//     let valid = true;

//     if (value.length === 0) {
//         valid = false;
//         orderForm.addInputError('title', 'Názov musí byť vyplený.');
//     }
//     if (value.length > 100) {
//         valid = false;
//         orderForm.addInputError('title', 'Názov musí byť kratší ako 100 znakov.');    
//     }

//     return valid;
// }
global.orderForm = orderForm;

// orders table 
var ordersTable = new Table('table-orders');

// order item form
var orderItemForm = new Form('order-item-form');
orderItemForm.validation['quantity'] = function() {
    orderItemForm.clearInputErrors('quantity');
    let input = orderItemForm.getFormInput('quantity');
    let value = input.val();
    let valid = true;

    if (value === 0 || isNaN(value)) {
        valid = false;
        orderItemForm.addInputError('quantity', 'Množstvo musí byť vyplené.');
    }
    if (value < 0) {
        valid = false;
        orderItemForm.addInputError('quantity', 'Množstvo nemôže byť záporné.');    
    }

    return valid;
}


global.orderItemForm = orderItemForm;