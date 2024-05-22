addNewItem = async (orderID) => {
    // console.log(orderID)
    const response = await $.ajax({
        url: '../parts/_addOrderItem.php',
        type: 'POST',
        data: { orderID: orderID },
    })
    location.reload();
}

deleteProductItem = async (orderID) => {
    if (confirm("Are you sure to delete ?")) {
        const response = await $.ajax({
            url: '../parts/_delOrderItem.php',
            type: 'POST',
            data: { orderID: orderID },
        })
        location.reload();
    }
}

$(document).ready(function () {
    function validateNumberInput(event) {
        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
        }
    }

    $('.price, .qty').on('keypress', validateNumberInput);


    $('.editable').blur(function () {
        var id = $(this).data('id');
        var column = $(this).data('column');
        var value = $(this).text();

        // If the column is price or qty, update subtotal
        if (column === 'price' || column === 'qty') {
            var row = $(this).closest('tr');
            // var price = row.find("[data-column='price']").text();
            var price = parseInt(row.find("[data-column='type']").text());
            var qty = parseInt(row.find("[data-column='qty']").text());
            var subtotal = price * qty;
            row.find(".subtotal").text(subtotal);

            // Update the subtotal in the database
            $.ajax({
                url: '../parts/update_order.php',
                type: 'POST',
                data: {
                    id: id,
                    column: 'subtotal',
                    value: subtotal
                },
                success: function (response) {
                    console.log(response);
                    if (response != 'success') {
                        alert('Update failed');
                    }
                }
            });
        }

        // Update the changed column in the database
        $.ajax({
            url: '../parts/update_order.php',
            type: 'POST',
            data: {
                id: id,
                column: column,
                value: value
            },
            success: function (response) {
                console.log(response);
                if (response != 'success') {
                    alert('Update failed');
                }
            }
        });
    });
});




