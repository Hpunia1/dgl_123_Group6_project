// cart.js
const cart = JSON.parse(localStorage.getItem('cart')) || [];

document.getElementById('add-to-cart').addEventListener('click', () => {
    const productId = document.getElementById('add-to-cart').dataset.id;
    const quantity = parseInt(document.getElementById('quantity').value);
    const product = products.find(p => p.id == productId);

    const existingItem = cart.find(item => item.id == productId);
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({ ...product, quantity });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${product.name} added to cart!`);
});


// cart.js
document.addEventListener('DOMContentLoaded', () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartContainer = document.querySelector('.cart-items');

    if (cart.length === 0) {
        cartContainer.innerHTML = '<p>Your cart is empty. <a href="shopping.html">Continue Shopping</a></p>';
    } else {
        cart.forEach(item => {
            cartContainer.innerHTML += `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h3>${item.name}</h3>
                        <p>Quantity: ${item.quantity}</p>
                        <p class="price">$${item.price * item.quantity}</p>
                        <a href="#" class="remove-item" data-id="${item.id}">Remove</a>
                    </div>
                </div>
            `;
        });

        // Update Total Price
        const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        document.querySelector('.summary-details span').innerText = `$${total}`;
    }

    // Remove Item from Cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.id;
            const updatedCart = cart.filter(item => item.id != productId);
            localStorage.setItem('cart', JSON.stringify(updatedCart));
            location.reload();
        });
    });
});