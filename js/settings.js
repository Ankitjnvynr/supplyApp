// js code for settings of shopee
let shopeeinfo = document.getElementById('shopeeinfo');
let loadInfo = () => {
    $(shopeeinfo).load('../parts/_loadSetting.php')
    // $.ajax({
    //     url: '../parts/_loadSetting.php',

    // })
}
loadInfo();