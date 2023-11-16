
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