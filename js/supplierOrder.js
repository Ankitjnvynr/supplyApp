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

function changeOrderStatus(target, id) {
    let status = target.checked ? 1 : 0;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../parts/_updateOrderStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.responseText);
        }
    };
    xhr.send("order_id=" + id + "&status=" + status);
}