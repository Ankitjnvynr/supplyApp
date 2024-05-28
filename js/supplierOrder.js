
loadOrders = (start_date, end_date, start, limit) => {
    fltrs = {
        searchbox: $('#searchBox').val(),
        category: $('#filterCat').val(),
        start: start,
        limit: limit,
        start_date: start_date,
        end_date: end_date,
    }
    $.ajax({
        url: '_loadorders.php',
        type: 'POST',
        data: fltrs,
        success: function (response) {
            $('#ordersContainer').html(response);
        }
    })
    $.ajax({
        url: '../parts/_filterOrderCount.php',
        type: 'POST',
        data: fltrs,

        success: function (response) {
            $('#OrderCount1').html(response.filtered_orders)
            $('#OrderCount2').html(response.total_orders)
            console.log("the response is:", response)
        }

    })
}

// date filter with onlick
const dateFilter = (startDate, days) => {
    let end_date = new Date();
    end_date.setDate(end_date.getDate() + 1); // Increment today's date by 1
    end_date = end_date.toISOString().split('T')[0]; // Convert to ISO string and get the date part 

    let start_date;

    if (startDate) {
        start_date = startDate;
    } else if (days) {
        let date = new Date();
        date.setDate(date.getDate() - days);
        start_date = date.toISOString().split('T')[0];
    }

    loadOrders(start_date, end_date, 0, 10);
};
// Attach event listeners for the date inputs
$('#startDate, #endDate').change(function () {
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    if (startDate && endDate) {
        loadOrders(startDate, endDate, 0, 10);
    }
});




loadOrders(null, null, 0, 5)

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