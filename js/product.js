let loadInfo = (target, page) => {
  $(target).load(page)
}
// function to load the product
loadProduct = () => {
  fltrs = {
    serachbox: $('#searchBox').val(),
    category: $('#filterCat').val(),
    start: '0',
    limit: '12',
  }

  $.ajax({
    url: '../parts/_loadProducts.php',
    type: 'POST',
    data: fltrs,
    success: function (response) {
      // console.log(response)
      $('#porductBox').html(response)
    }
  })
}
loadProduct()

$(document).ready(function () {
  $("#searchBox").on("input", function () {

    loadProduct()

  });
  $('#filterCat').on('change', function () {
    loadProduct();
  })
});
// loadInfo('#porductBox', '../parts/_loadProducts.php');


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
runUpdate = (productID) => {
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

        // Send the AJAX request
        $.ajax({
          type: "POST",
          url: "../parts/_updateProduct.php", // Change this to the URL of your PHP script
          data: formData,
          success: function (response) {
            // document.getElementById('updateProductForm').id = 'productForm';
            // Handle successful response
            console.log(response); // Log the response to the console

            pairs = formData.split("&");
            key_values = {};
            pairs.forEach((pair) => {
              const [key, value] = pair.split("=");
              key_values[key] = decodeURIComponent(value);
            });
            $("#pname" + productID).html(key_values.product_name);
            $("#pcat" + productID).html(key_values.category);
            $("#pbrand" + productID).html(key_values.brand);
            $("#pprice" + productID).html(key_values.price);
            $("#pqty" + productID).html(key_values.qty);
            // console.table(key_values);
          },
          error: function (xhr, status, error) {
            // document.getElementById('updateProductForm').id = 'productForm';
            // Handle errors
            console.error(xhr.responseText); // Log the error response to the console
            // Optionally, display an error message to the user
          },
        });
      },
    });
  });
};

//getting the details to update the product
const updateProductModal = new bootstrap.Modal(
  document.getElementById("updateProductModal")
);

openUpdateModal = (e, productId) => {
  //   productForm.id = "updateProductForm"; // updaing the id of the form
  //   $('#productModalLabel').html('Update Product')
  //   $("#productFormBtn").html('Update');

  // getting the current data
  prodName =
    e.parentNode.parentNode.childNodes[1].childNodes[1].childNodes[1].innerHTML;

  prodBrand =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[1]
      .childNodes[3].innerHTML;
  prodPrice =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[3]
      .childNodes[3].innerHTML;
  prodQty =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[5]
      .childNodes[3].innerHTML;
  prodCat =
    e.parentNode.parentNode.childNodes[1].childNodes[3].childNodes[5]
      .childNodes[3].innerHTML;

  $("#productKeyU").val(productId);
  $("#product_nameU").val(prodName);
  $("#priceU").val(prodPrice);
  $("#qtyU").val(prodQty);
  $("#brandU").val(prodBrand);
  $("#productKey").val(productId);

  var categoryU = document.getElementById("categoryU");
  for (var i = 0; i < categoryU.options.length; i++) {
    if (categoryU.options[i] === prodCat) {
      categoryU.options[i].selected = true;
      console.log(categoryU);
    }
  }

  updateProductModal.show();
  runUpdate(productId);

  // productForm
};

//event on modal close resetting the form and identifier
$(document).ready(function () {
  $("#addProductModal").on("hidden.bs.modal", function (e) {
    // Your code to execute when the modal is closed
    console.log("Modal closed!");
    prductform = document.getElementById('updateProductForm')
    prductform.reset();
    // if (prductform) {
    //     prductform.id = 'productForm';
    // }
  });

  loadInfo('#category', '../parts/_loadCategory.php');
  loadInfo('#filterCat', '../parts/_loadCategory.php');
  loadInfo('#categoryU', '../parts/_loadCategory.php');
  loadInfo("#productCount", "../parts/_productCount.php");
});


// deleting the product
const deleteModal = new bootstrap.Modal('#deleteModal')
openDelModal = (pId, e) => {
  deleteModal.show()

  $('#deleteProductId').val(pId);
  deleteProduct = () => {
    console.log('deleting')
    $.ajax({
      url: '../parts/_delete_Product.php',
      type: 'POST',
      data: { product: $('#deleteProductId').val() },
      success: function (response) {
        if (response == "1") {
          deleteModal.hide()
          fullitem = e.parentNode.parentNode.parentNode;
          fullitem.style.display = 'none';
          loadInfo("#productCount", "../parts/_productCount.php");
        }
        console.log(response)
      }
    })
  }
}




//  initializing tooltip for add to order
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
