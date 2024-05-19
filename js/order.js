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

