
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
        if (!this.validate()) {
            return;
        }
    
        var form = this.getForm();
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
                    for (const [column, messages] of Object.entries(response.errorMessages)) {
                        for (const message of messages) {
                            this.addInputError(column, message);
                        }
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