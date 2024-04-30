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
runUpdate = (a, b, c, d, e) => {
  $("#updateProductForm").submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    console.log("this is update form run");
    var formData = $(this).serialize(); // Serialize form data
    // Send the AJAX request
    $.ajax({
      type: "POST",
      url: "../parts/_updateProduct.php", // Change this to the URL of your PHP script
      data: formData,
      success: function (response) {
        updateProductModal.hide();

        var queryParams = formData.split("&");
        var parcedformData = {};
        for (var i = 0; i < queryParams.length; i++) {
          // Splitting each pair into key and value
          var pair = queryParams[i].split("=");
          // Check if key is not "productKey" and store key-value pairs in the formData object
          if (pair[0] !== "productKey") {
            parcedformData[decodeURIComponent(pair[0])] = decodeURIComponent(
              pair[1]
            );
          }
        }

        var index = 0;
        for (var key in formData) {
          // Assign values to variables a, b, c, d, and e based on the order of properties
          switch (index) {
            case 0:
              a.innerHTML = formData[key];
              console.log(formData[key])
              break;
            case 1:
              b = formData[key];
              break;
            case 2:
              c = formData[key];
              break;
            case 3:
              d = formData[key];
              break;
            case 4:
              e = formData[key];
              break;
            default:
              break;
          }
          index++;
        }
        // Handle successful response
        console.log(parcedformData); // Log the response to the console
        // Optionally, display a success message to the user
      },
      error: function (xhr, status, error) {
        document.getElementById("updateProductForm").id = "productForm";
        // Handle errors
        console.error(xhr.responseText); // Log the error response to the console
        // Optionally, display an error message to the user
      },
    });
  });
};

//getting the details to update the product
const updateProductModal = new bootstrap.Modal(
  document.getElementById("addProductModal")
);

openUpdateModal = (e, productId) => {
  productForm.id = "updateProductForm"; // updaing the id of the form

  // getting the current data
  prodName =
    e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[1].innerHTML;
  prodNameE = e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[1];

  prodCat =
    e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[5].innerHTML;

  prodBrand =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[1]
      .childNodes[3].innerHTML;
  prodPrice =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[3]
      .childNodes[3].innerHTML;
  prodQty =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[5]
      .childNodes[3].innerHTML;

  $("#productKey").val(productId);
  $("#product_name").val(prodName);
  $("#price").val(prodPrice);
  $("#qty").val(prodQty);
  $("#brand").val(prodBrand);
  $("#category").val(prodCat);

  $("#productFormBtn").attr("name", "UpdateProductForm");

  // console.log(prodName, prodCat, prodBrand, prodPrice, prodQty)
  updateProductModal.show();
  runUpdate(prodNameE, prodCat, prodBrand, prodPrice, prodQty);

  // productForm
};

//event on modal close resetting the form and identifier
$(document).ready(function () {
  $("#addProductModal").on("hidden.bs.modal", function (e) {
    // Your code to execute when the modal is closed
    console.log("Modal closed!");
    prductform = document.getElementById("updateProductForm");
    if (prductform) {
      prductform.id = "productForm";
      $("#productFormBtn").attr("name", "addProduct");
      prductform.reset();
    }
  });
});




