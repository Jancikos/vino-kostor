
// forms setup
export default class Form {
    constructor(id) {
        this.id = id;
        this.inputs = this.getInputsNames();
        this.validation = {};
    }
    getForm() {
        return $(`#${this.id}`);
    }
    getFormInput(name) {
        return this.getForm().find(`[name="${name}"]`);
    }
    getInputsNames() {
        return this.getForm().find('input, select, textarea').map(function() {
            return $(this).attr('name');
        }).get();
    }
    
    submit() {
        if (!productForm.validate()) {
            return;
        }
    
        var form = productForm.getForm();
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // redirect to home page
                    window.location.href = form.attr('data-redirect');
                } else {
                    // show error messages to inputs
                    for (var key in response.errors) {
                        productForm.addInputError(key, response.errors[key]);
                    }
                }
            },
            error: function(response) {
                alert('Pri ukladaní došlo k chybe. Skúste to prosím znova.');
            }
        });
    }   
    validate() {
        let valid = true;
        this.inputs.forEach((inputName) => {
            if (this.validation[inputName] !== undefined) {
                let inputValid = this.validation[inputName]();
                if (!inputValid) {
                    valid = false;
                }
            }
        });

        return valid;
    }
    addInputError(inputName, message) {
        let input = this.getFormInput(inputName);
        input.addClass('invalid');
        input.after(`<span class="error-msg">${message}</span>`);
    }
    clearInputErrors(inputName) {
        let input = this.getFormInput(inputName);
        input.removeClass('invalid');
        input.nextAll('.error-msg').remove();
    }
}