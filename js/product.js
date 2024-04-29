let loadInfo = (target, page) => {
    $(target).load(page)
}
loadInfo('#porductBox', '../parts/_loadProducts.php');

const ToastBody = document.getElementById('ToastBody')
const toastType = document.getElementById('toastType')
const toastIcon = document.getElementById('toastIcon')

const errorToast = document.getElementById('ErrorToast');

showNoti = (iconClass, msgType, msgBody) => {
    toastIcon.classList.add(iconClass);
    toastType.innerHTML = msgType;
    ToastBody.innerHTML = msgBody;
    errorToastCreate = bootstrap.Toast.getOrCreateInstance(errorToast);
    errorToastCreate.show()
}

// function to update the form data to db
$(document).ready(function () {
    $('#updateProductForm').submit(function (event) {
        event.preventDefault();  // Prevent default form submission

        var formData = $(this).serialize();// Serialize form data

        // Send the AJAX request
        $.ajax({
            type: 'POST',
            url: 'update_product.php', // Change this to the URL of your PHP script
            data: formData,
            success: function (response) {
                document.getElementById('updateProductForm').id = productForm;
                // Handle successful response
                console.log(response); // Log the response to the console
                // Optionally, display a success message to the user
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText); // Log the error response to the console
                // Optionally, display an error message to the user
            }
        });
    });
});

//getting the details to update the product
const updateProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));

openUpdateModal = (e, productId) => {
    prodName = e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[1].innerHTML
    prodCat = e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[5].innerHTML

    prodBrand = e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[1].childNodes[3].innerHTML
    prodPrice = e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[3].childNodes[3].innerHTML
    prodQty = e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[5].childNodes[3].innerHTML
    
    $('#productKey').val(productId);
    $('#product_name').val(prodName);
    $('#price').val(prodPrice);
    $('#qty').val(prodQty);
    $('#brand').val(prodBrand);
    $('#category').val(prodCat);


    console.log(prodName, prodCat, prodBrand, prodPrice, prodQty)
    updateProductModal.show()

    productForm.id = 'updateProductForm';

    // productForm
}





