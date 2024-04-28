let loadInfo = (target, page) => {
    $(target).load(page)
}
loadInfo('#porductBox', '../parts/_loadProducts.php');

const ToastBody = document.getElementById('ToastBody')
const toastType = document.getElementById('toastType')
const toastIcon = document.getElementById('toastIcon')

const errorToast = document.getElementById('ErrorToast');

showNoti = (iconClass,msgType,msgBody) => {
    toastIcon.classList.add(iconClass);
    toastType.innerHTML = msgType;
    ToastBody.innerHTML = msgBody;
    errorToastCreate = bootstrap.Toast.getOrCreateInstance(errorToast);
    errorToastCreate.show()
}