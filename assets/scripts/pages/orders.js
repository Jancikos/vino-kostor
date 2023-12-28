import Form from '../libs/form.js';

// order form
var orderForm = new Form('order-form');
orderForm.submitPostSuccess = function(response) {
    var form = this.getForm();
    var redirectUrl = form.attr('data-redirect');
    
    const editMode = form.attr('data-edit-mode');
    if (editMode === '0') {
        // redirect to add item form

        return;
    }
    
    // redirect to home page
    window.location.href = redirectUrl;    
}

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

// orders table actions
global.orderDelete = function (itemPk) {
    if (!confirm('Naozaj chcete vymazať túto objednávku?')) {
        return;
    }

    $.ajax({
        url: $("#table-orders").attr('data-delete-url'),
        method: 'POST',
        data: {
            pk_: itemPk
        },
        success: function(response) {
            if (!response.success) {
                alert(response.title);
                return;
            }

            window.location.reload();
        },
        error: function(response) {
            alert('Pri vymazávaní došlo k chybe. Skúste to prosím znova.');
        }
    });
}
global.orderEdit = function (itemPk) {
    window.location.href = $("#table-orders").attr('data-form-url') + '/' + itemPk;
}

// order item form
var orderItemForm = new Form('order-item-form');
global.orderItemForm = orderItemForm;