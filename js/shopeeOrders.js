loadOrders = () => {
    $.ajax({
        url: '../parts/_loadorders.php',
        type: 'POST',
        fltr: {},
        success: function (response) {
            $('#ordersContainer').html(response)
            
        }
    })
}
loadOrders()