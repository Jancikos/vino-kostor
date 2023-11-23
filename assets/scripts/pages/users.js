import Form from '../libs/form.js';

// user form
var userForm = new Form('user-form');
// userForm.validation['title'] = function() {
//     userForm.clearInputErrors('title');
//     let input = userForm.getFormInput('title');
//     let value = input.val();
//     let valid = true;

//     if (value.length === 0) {
//         valid = false;
//         userForm.addInputError('title', 'Názov musí byť vyplený.');
//     }
//     if (value.length > 100) {
//         valid = false;
//         userForm.addInputError('title', 'Názov musí byť kratší ako 100 znakov.');    
//     }

//     return valid;
// }
global.userForm = userForm;

// users table actions
global.userDelete = function (itemPk) {
    if (!confirm('Naozaj chcete vymazať tohto používateľa?')) {
        return;
    }

    $.ajax({
        url: $("#table-users").attr('data-delete-url'),
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
global.userEdit = function (itemPk) {
    window.location.href = $("#table-users").attr('data-form-url') + '/' + itemPk;
}