import Form from '../libs/form.js';
import Table from '../libs/table.js';

// product form
var productForm = new Form('product-form');
productForm.validation['title'] = function() {
    productForm.clearInputErrors('title');
    let input = productForm.getFormInput('title');
    let value = input.val();
    let valid = true;

    if (value.length === 0) {
        valid = false;
        productForm.addInputError('title', 'Nadpis musí byť vyplený.');
    }
    if (value.length > 100) {
        valid = false;
        productForm.addInputError('title', 'Nadpis musí byť kratší ako 100 znakov.');    
    }

    return valid;
}
productForm.validation['subtitle'] = function() {
    productForm.clearInputErrors('subtitle');
    let input = productForm.getFormInput('subtitle');
    let value = input.val();
    let valid = true;

    if (value.length > 50) {
        valid = false;
        productForm.addInputError('subtitle', 'Podnadpis musí byť kratší ako 50 znakov.');    
    }

    return valid;
};
productForm.validation['price'] = function() {
    productForm.clearInputErrors('price');
    let input = productForm.getFormInput('price');
    let value = parseFloat(input.val());
    let valid = true;

    if (value === 0 || isNaN(value)) {
        valid = false;
        productForm.addInputError('price', 'Cena musí byť vyplená.');
    }
    if (value < 0) {
        valid = false;
        productForm.addInputError('price', 'Cena nemôže byť záporná.');    
    }

    return valid;
}
productForm.validation['image'] = function() {
    productForm.clearInputErrors('image');
    let input = productForm.getFormInput('image');
    let value = input.val();
    let valid = true;

    if (input.attr('required') === undefined) {
        return true;
    }

    if (value.length === 0) {
        valid = false;
        productForm.addInputError('image', 'Obrázok musí byť nahraný.');
    }

    return valid;
}
global.productForm = productForm;

// products table actions
var productsTable = new Table('table-products');