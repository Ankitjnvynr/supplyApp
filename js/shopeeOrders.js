
// Function to update GET parameter and update display
function updateParam(paramName, newValue) {
    const url = new URL(window.location.href);
    url.searchParams.set(paramName, newValue);
    history.pushState({}, "", url.toString());

    // Update displayed parameters
    // showCurrentParams();
}

function resetFilter() {
    const baseUrl = window.location.origin + window.location.pathname;
    history.pushState({}, "", baseUrl);
    $('#searchBox').val('');
    loadOrders({}, null)
}
function getUrlParams() {
    const queryString = window.location.search;
    // if (!queryString) {
    //     return {};
    // }

    const params = {};
    const pairs = queryString.slice(1).split('&'); // Remove leading '?'

    for (const pair of pairs) {
        const [key, value] = pair.split('=');
        params[decodeURIComponent(key)] = decodeURIComponent(value);
    }

    return params;
}




let start = 0;
let limit = 10;
let responseEnd = false;
let start_date;
let end_date

let fltrs = {
    searchbox: $('#searchBox').val(),
    category: $('#filterCat').val(),
    start: start,
    limit: limit,
    start_date: start_date ? start_date : '',
    end_date: end_date ? end_date : '',
};

function loadOrders(fltrs, append = false) {
    
    if ($('#ordersContainer').children().last().text() === 'No order found') {
        return;
    }
    $('#loadingAnimation').show();
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
            
            $('#loadingAnimation').hide();
        },
        error: function (xhr, status, error) {
            
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



function getNumberOfItems(containerId) {
    var container = document.getElementById(containerId);
    if (container) {
        return container.childElementCount;
    } else {
        console.error('Container with id ' + containerId + ' not found.');
        return 0;
    }
}



$(document).ready(
    $('#loadMoreBtn').on('click',function (){
        $('#loadMoreBtn').text = "loading..."
        // Usage
        var numberOfItems = getNumberOfItems('ordersContainer');
        console.log('Number of items in the container:', numberOfItems);
        updateParam('start', numberOfItems)
    
        if (responseEnd) {
            console.table(fltrs)
            return;
        } else {
            let filter = getUrlParams();
            loadOrders(filter, true)
    
        }
    })
)

// Initial load
$(document).ready(function () {
    resetFilter();
    let filter = getUrlParams();
    loadOrders(filter, null);
});

// Date filter functionality
const dateFilter = (startDate, days) => {
    let end_date = new Date();
    end_date.setDate(end_date.getDate() + 1);
    end_date = end_date.toISOString().split('T')[0];
    updateParam('end_date', end_date)
    updateParam('start', 0)

    let start_date;

    if (startDate) {
        start_date = startDate;
        updateParam('start_date', start_date)
    } else if (days) {
        let date = new Date();
        date.setDate(date.getDate() - days);
        start_date = date.toISOString().split('T')[0];
        updateParam('start_date', start_date)
    }

    start = 0;

    let filter = getUrlParams();
    loadOrders(filter, null)
};

$('#startDate, #endDate').change(function () {
    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();
    updateParam('start_date', startDate);
    updateParam('end_date', endDate)
    if (startDate && endDate) {
        start = 0;
        let filter = getUrlParams();
        loadOrders(filter, null)
    }
});

// Loading animation HTML
// $('body').append('<div id="loadingAnimation" style="display:none; position:fixed; bottom:10px; right:10px;"><img style="width:20px" src="../pics/loading.gif" alt="Loading..."></div>');

$(document).ready(function () {
    $("#searchBox").attr("placeholder", "Search orders by order id....");
    $("#searchBox").on("input", function () {
        updateParam('searchbox', this.value)

        let filter = getUrlParams();
        loadOrders(filter, null)
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
