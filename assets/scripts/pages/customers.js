import Form from '../libs/form.js';
import Table from '../libs/table.js';

// customer form
var customerForm = new Form('customer-form');
customerForm.validateFullname = function() {
    const firstname = customerForm.getFormInput('firstname').val();
    const lastname = customerForm.getFormInput('lastname').val();

    if (firstname.length === 0 && lastname.length === 0) {
        customerForm.addInputError('firstname', 'Meno alebo priezvisko musí byť vyplené.');
        customerForm.addInputError('lastname', 'Meno alebo priezvisko musí byť vyplené.');
        return false;
    }

    return true;
};
customerForm.validation['firstname'] = function() {
    customerForm.clearInputErrors('firstname');
    return customerForm.validateFullname();
}
customerForm.validation['lastname'] = function() {
    customerForm.clearInputErrors('lastname');
    return customerForm.validateFullname();
}

customerForm.validation['price'] = function() {
    customerForm.clearInputErrors('price');
    let input = customerForm.getFormInput('price');
    let value = parseFloat(input.val());
    let valid = true;

    if (value === 0 || isNaN(value)) {
        valid = false;
        customerForm.addInputError('price', 'Cena musí byť vyplená.');
    }
    if (value < 0) {
        valid = false;
        customerForm.addInputError('price', 'Cena nemôže byť záporná.');    
    }

    return valid;
}
customerForm.validation['image'] = function() {
    customerForm.clearInputErrors('image');
    let input = customerForm.getFormInput('image');
    let value = input.val();
    let valid = true;

    if (input.attr('required') === undefined) {
        return true;
    }

    if (value.length === 0) {
        valid = false;
        customerForm.addInputError('image', 'Obrázok musí byť nahraný.');
    }

    return valid;
}
global.customerForm = customerForm;

// customers table actions
var customersTable = new Table('table-customers');