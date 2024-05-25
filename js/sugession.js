
$(document).ready(function () {
    // Function to fetch suggestions from the database
    function fetchSuggestions(column, filterProductName, filterBrandName, filterPrice, callback) {
        $.ajax({
            url: '../parts/suggestions.php',
            method: 'GET',
            data: {
                column: column,
                filterProductName: filterProductName,
                filterBrandName: filterBrandName,
                filterPrice: filterPrice,
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                callback(data);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching suggestions: ' + error);
            }
        });
    }

    // Initialize autocomplete for all editable cells
    $('#editableTable').on('focus', '.editable', function () {
        var cell = $(this);
        var column = cell.data('column');
        var filterProductName = this.parentNode.childNodes[1].innerText;
        var filterBrandName = this.parentNode.childNodes[2].innerText;
        var filterPrice = this.parentNode.childNodes[3].innerText;

        fetchSuggestions(column, filterProductName, filterBrandName, filterPrice, function (suggestions) {
            cell.autocomplete({
                source: suggestions,
                minLength: 0,
                appendTo: '#editableTable',
                position: {
                    my: 'left top',
                    at: 'left bottom'
                },
                select: function (event, ui) {
                    // When an item is selected, set the cell's text to the selected value
                    cell.text(ui.item.value);
                    // Destroy the autocomplete to hide the suggestions list
                    $(this).autocomplete("destroy");
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                var formattedItem = $("<li class='suges'>")
                    .append(item.label)
                    .appendTo(ul);
                return formattedItem;
            };

            // Trigger search to display suggestions immediately
            cell.autocomplete("search", cell.text());
        });
    });

    // Trigger search when typing in the cell
    $('#editableTable').on('input', '.editable', function () {
        $(this).autocomplete("search", $(this).text());
    });
});

