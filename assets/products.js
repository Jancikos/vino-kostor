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

productForm.submit = function() {
    if (!productForm.validate()) {
        return;
    }

    alert("Produkt bol úspešne zvalidovany.");

    // $.ajax({
    //     url: '/admin/products',
    //     method: 'POST',
    //     data: productForm.getForm().serialize(),
    //     success: function(response) {
    //         console.log(response);
    //         if (response.success) {
    //             alert('Produkt bol úspešne pridaný.');
    //             productForm.getForm()[0].reset();

    //             // redirect to home page
    //             window.location.href = '/admin';
    //         } else {
    //             alert('Pri ukladaní produktu došlo k chybe.');
    //         }
    //     },
    //     error: function() {
    //         alert('Pri ukladaní produktu došlo k chybe.');
    //     }
    // });
}



global.productForm = productForm;