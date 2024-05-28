let isLoading = false;
let start = 0;
let limit = 20;
let responseEnd = false;

function loadOrders(start_date, end_date, start, limit, append = false) {
    if (isLoading) return;

    $('#loadingAnimation').show();

    const fltrs = {
        searchbox: $('#searchBox').val(),
        category: $('#filterCat').val(),
        start: start,
        limit: limit,
        start_date: start_date,
        end_date: end_date,
    };

    $.ajax({
        url: '../parts/_loadorders.php',
        type: 'POST',
        data: fltrs,
        success: function (response) {
            if (response == 'No order found') {
                responseEnd = true;
            }
            if (append) {
                $('#ordersContainer').append(response);
            } else {
                $('#ordersContainer').html(response);
            }
            isLoading = false;
            $('#loadingAnimation').hide();
        },
        error: function (xhr, status, error) {
            isLoading = false;
            $('#loadingAnimation').hide();
        }
    });

    $.ajax({
        url: '../parts/_filterOrderCount.php',
        type: 'POST',
        data: fltrs,
        success: function (response) {
            $('#OrderCount1').html(response.filtered_orders);
            $('#OrderCount2').html(response.total_orders);
        },
        error: function (xhr, status, error) {
        }
    });
}

$(window).on('scroll', function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !isLoading) {
        start += limit;
        if (responseEnd) {
            return;
        } else {
            loadOrders(null, null, start, limit, true);
        }
    }
});

// Initial load
$(document).ready(function () {
    loadOrders(null, null, start, limit);
});

// Date filter functionality
const dateFilter = (startDate, days) => {
    let end_date = new Date();
    end_date.setDate(end_date.getDate() + 1);
    end_date = end_date.toISOString().split('T')[0];

    let start_date;

    if (startDate) {
        start_date = startDate;
    } else if (days) {
        let date = new Date();
        date.setDate(date.getDate() - days);
        start_date = date.toISOString().split('T')[0];
    }

    start = 0;
    loadOrders(start_date, end_date, start, limit);
};

$('#startDate, #endDate').change(function () {
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    if (startDate && endDate) {
        start = 0;
        loadOrders(startDate, endDate, start, limit);
    }
});

// Loading animation HTML
$('body').append('<div id="loadingAnimation" style="display:none;position:fixed;bottom:10px;right:10px;"><img src="../pics/loading.gif" alt="Loading..."></div>');

$(document).ready(function () {
    $("#searchBox").attr("placeholder", "Search orders by order id....");
    $("#searchBox").on("input", function () {
        loadOrders(null, null, 0, limit);
    });

    $(".filter-btn").on('click', function () {
        $(".filter-btn").removeClass('active');
        $(this).addClass('active');
    });
});

function deleteOrder(e, orderID) {
    if (confirm('Are you sure ?')) {
        $.ajax({
            url: '../parts/_deleteOrder.php',
            type: 'POST',
            data: { product: orderID },
            success: function (response) {
                const element = e.parentNode.parentNode;
                $(element).addClass('deleted');
                setTimeout(() => {
                    element.style.display = "none";
                }, 1000);
            }
        });
    }
}
