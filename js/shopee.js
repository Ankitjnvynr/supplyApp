let loadInfo = (target, page) => {
    $(target).load(page)
}
loadInfo('#latestOrders','../parts/_loadorders.php')