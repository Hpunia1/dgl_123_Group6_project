// shopping.js
document.querySelectorAll('.product a').forEach((productLink) => {
    productLink.addEventListener('click', function (event) {
        const productId = this.closest('.product').querySelector('.add-to-cart').dataset.id;
        localStorage.setItem('selectedProductId', productId);
    });
});