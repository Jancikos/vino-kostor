import Form from './admin_libs.js';

var productForm = new Form('product-form');

productForm.validation['title'] = function() {
    productForm.clearInputErrors('title');
    let input = productForm.getFormInput('title');
    let value = input.val();
    let valid = true;

    if (value.length === 0) {
        valid = false;
        productForm.addInputError('title', 'Názov musí byť vyplený.');
    }
    if (value.length > 100) {
        valid = false;
        productForm.addInputError('title', 'Názov musí byť kratší ako 100 znakov.');    
    }

    return valid;
}
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

global.productForm = productForm;