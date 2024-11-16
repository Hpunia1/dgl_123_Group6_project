// product.js
document.addEventListener('DOMContentLoaded', () => {
    const productId = localStorage.getItem('selectedProductId');
    const product = products.find(p => p.id == productId);

    if (product) {
        document.querySelector('.product-image img').src = product.image;
        document.querySelector('.product-details h1').innerText = product.name;
        document.querySelector('.product-details .price').innerText = `$${product.price}`;
        document.querySelector('.product-details p').innerText = product.description;

        document.getElementById('add-to-cart').dataset.id = product.id;
        document.getElementById('add-to-cart').dataset.price = product.price;
    }
});