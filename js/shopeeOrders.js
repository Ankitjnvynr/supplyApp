loadOrders = () => {
    fltrs = {
        searchbox: $('#searchBox').val(),
        category: $('#filterCat').val(),
        start: '0',
        limit: '12',
    }
    $.ajax({
        url: '../parts/_loadorders.php',
        type: 'POST',
        data: fltrs,

        success: function (response) {
            $('#ordersContainer').html(response)
            console.log(fltrs)

        }
    })
}
loadOrders()

$(document).ready(function () {
    $("#searchBox").on("input", function () {  /// searchbox event for searching something
        loadOrders()

    });
});



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