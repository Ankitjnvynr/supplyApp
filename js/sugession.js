

function getFocusedElementPosition() {
    var focusedElement = document.activeElement;
    if (focusedElement) {
        var rect = focusedElement.getBoundingClientRect();
        return {
            top: rect.top + window.pageYOffset, // Adjust for scrolling
            left: rect.left , // Adjust for scrolling
            width: rect.width,
            height: rect.height
        };
    }
    return null; // Return null if no element is focused
}



$(document).ready(function () {
    $('.editable').on('input', function () {
        
        
        // Example usage:
        var focusedElementPosition = getFocusedElementPosition();
        positonLeft = focusedElementPosition.left/2 + (focusedElementPosition.width) / 2;
        console.log(focusedElementPosition.left);
        console.log(focusedElementPosition.width);
        console.log(positonLeft)

        var value = $(this).text();
        console.log(value)
        sugessionBox = document.createElement('ul')
        $(sugessionBox).addClass('sugession-box')
        sugessionBox.id = "sugessionArea";
        sugessionBox.innerHTML = value
        $(sugessionBox).css('left', positonLeft);

        this.parentNode.appendChild(sugessionBox)
        console.log(sugessionBox)
        console.log(this)
    })
})
