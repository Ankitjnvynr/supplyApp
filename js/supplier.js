let loadInfo = (target, page) => {
  $(target).load(page);
};
loadInfo("#latestOrders", "_loadorders.php");
loadInfo("#totalShopkeeper", "../parts/_shopKeeperCount.php");
