let loadInfo = (target, page) => {
  $(target).load(page)
}
// function to load the product
loadProduct = (start, append = false) => {
  if (append == true) {
    if ($("#porductBox").children().last().text() === " No Products Found") {
      return;
    }
  }
  fltrs = {
    serachbox: $('#searchBox').val(),
    category: $('#filterCat').val(),
    start: start,
    limit: '10',
  }

  $.ajax({
    url: '../parts/_loadProducts.php',
    type: 'POST',
    data: fltrs,
    success: function (response) {
      if (!append) {
        $('#porductBox').html(response)
      } else {
        $('#porductBox').append(response)
      }
    }
  })
}
loadProduct(1)

$(document).ready(function () {
  $("#searchBox").on("input", function () {

    loadProduct(1)

  });
  $('#filterCat').on('change', function () {
    loadProduct(1);
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

function closeCartQty() {  // Remove existing cart divs if any
  document.querySelectorAll('.cart-div').forEach(div => div.remove());
}



// for shopkeeper add to cart handle
function addToCart(e, pId) {

  // Remove existing cart divs if any
  document.querySelectorAll('.cart-div').forEach(div => div.remove());

  // Get button position
  const rect = e.getBoundingClientRect();

  // Create the cart div
  const cartDiv = document.createElement('div');
  cartDiv.classList.add('cart-div');
  cartDiv.style.top = `${rect.top}px`;
  cartDiv.style.left = `${rect.left - 150}px`; // Adjust the left position

  // Add content to the cart div
  const productId = pId;
  cartDiv.innerHTML = `
                    <button onclick=closeCartQty() style="right:9px;" type="button" class="btn-close float-end  position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
                    <label for="quantity">Quantity:</label>
                    <input class="form-control p-0 m-0 px-2" type="number" id="quantity" name="quantity" min="1" value="1">
                    <button class="btn btn-success m-0 p-0" id="saveQuantity"><i class="fa-solid fa-cart-plus"></i> Save</button>
                `;

  // Append the cart div to the body
  document.body.appendChild(cartDiv);

  // Add event listener to the save button
  cartDiv.querySelector('#saveQuantity').addEventListener('click', function () {
    const quantity = cartDiv.querySelector('#quantity').value;

    $.ajax({
      url: '../parts/_addFromCart.php',
      method: 'POST',
      data: {
        pId: pId,
        qty: quantity
      },
      success: function (response) {
        console.log(response)
        console.log("res", response == "added");
        cartDiv.remove();
        if (response == 0 || response == "added") {
          // Create and display the popup
          if (response == 0) {
            popMessage = "No active order found. Please create a new order.";
          }
          else {
            popMessage = "Item added to your Order";
          }

          const popup = document.createElement('div');
          popup.classList.add('popup');
          popup.innerHTML = `
                    <div class="popup-content">
                        <p>${popMessage}</p>
                        <button class="btn btn-secondary" id="closePopup">OK</button>
                    </div>
                `;

          // Style the popup
          popup.style.position = 'fixed';
          popup.style.top = '50%';
          popup.style.left = '50%';
          popup.style.transform = 'translate(-50%, -50%)';
          popup.style.backgroundColor = 'transparent';
          popup.style.padding = '20px';
          popup.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.1)';
          popup.style.zIndex = '1000';
          popup.style.width = '300px';
          popup.style.border = '2 px solid green';
          popup.style.textAlign = 'center';
          popup.style.backdropFilter = 'blur(5px)';
          popup.classList.add('shadow', 'rounded', 'border', 'border-success')


          // Append the popup to the body
          document.body.appendChild(popup);

          // Add event listener to the close button
          popup.querySelector('#closePopup').addEventListener('click', function () {
            popup.remove();
          });
        } else {
          // If the response is not "no active order", remove the cart div
          cartDiv.remove();
        }
      }
    })


  });
}

// counts the numbers of items contains the div of products
function getNumberOfItems(containerId) {
  var container = document.getElementById(containerId);
  if (container) {
    return container.childElementCount;
  } else {
    console.error("Container with id " + containerId + " not found.");
    return 0;
  }
}


$(document).ready(function () {
  $('#loadMoreBtn').on('click', function () {
    let start = getNumberOfItems('porductBox');

    loadProduct(start, true)
  })
})