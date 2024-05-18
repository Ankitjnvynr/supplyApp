addNewItem = (orderID) => {
    // console.log(orderID)
    $.ajax({
        URL: 'parts/_addOrderItem.php',
        type: 'POST',
        data: { orderID: orderID },
        success: function (response) {
            console.log(response)
        }
    })

}