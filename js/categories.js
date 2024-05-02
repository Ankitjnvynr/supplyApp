editCat = (e, id) => {
    const updateCatModal = new bootstrap.Modal(document.getElementById('updateCatModal'))
    updateCatModal.show();
    $('#updateCatid').val(id);
    $('#updateCatName').val(e.parentNode.parentNode.childNodes[3].innerHTML)
    console.log(e.parentNode.parentNode.childNodes[3].innerHTML)
}

let loadInfo = (target, page) => {
    $(target).load(page)
}
loadInfo('#porductBox', '../parts/_loadProducts.php');