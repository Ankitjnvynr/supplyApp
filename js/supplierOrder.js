loadOrders = () => {
    $.ajax({
        url: '_loadorders.php',
        type: 'POST',
        fltr: {},
        success: function (response) {
            $('#ordersContainer').html(response)

        }
    })
}
loadOrders()

deleteOrder = (e, orderID) => {
    if (confirm('Are you sure ?')) {
        $.ajax({
            url: '../parts/_deleteOrder.php',
            type: 'POST',
            data: { product: orderID },
            success: function (response) {
                console.log(response)
                element = e.parentNode.parentNode;
                console.log(element)
                $(element).addClass('deleted');
                setTimeout(() => {
                    element.style.display = "none"
                }, 1000);
            }
        })

    }
}