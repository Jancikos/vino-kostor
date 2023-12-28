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
        var formModel = this;
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: (new FormData(form[0])),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    formModel.submitPostSuccess(response);
                } else {
                    // show error messages to inputs
                    for (const [column, messages] of Object.entries(response.errorMessages)) {
                        for (const message of messages) {
                            formModel.addInputError(column, message);
                        }
                    }
                }
            },
            error: function(response) {
                alert('Pri ukladaní došlo k chybe. Skúste to prosím znova.');
            }
        });
    }
    submitPostSuccess(response) {
        var form = this.getForm();
        // redirect to home page
        window.location.href = form.attr('data-redirect');
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