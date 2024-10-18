// Initial variables
let selectedSize = '';
let quantity = 1;
let basePrice = 99;

// Update price on Add to Cart button
function updatePrice() {
    const totalPrice = basePrice * quantity;
    document.getElementById('add-to-cart').textContent = `Add to Cart - $${totalPrice}`;
}

// Event listener for size buttons
document.querySelectorAll('.size-btn').forEach(button => {
    button.addEventListener('click', function() {
        selectedSize = this.dataset.size;
        document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
        this.classList.add('selected');
    });
});

// Event listeners for quantity buttons
document.getElementById('increase').addEventListener('click', function() {
    quantity++;
    document.getElementById('quantity').value = quantity;
    updatePrice();
});

document.getElementById('decrease').addEventListener('click', function() {
    if (quantity > 1) {
        quantity--;
        document.getElementById('quantity').value = quantity;
        updatePrice();
    }
});

// Event listener for Add to Cart button
document.getElementById('add-to-cart').addEventListener('click', function() {
    if (selectedSize === '') {
        alert('Please select a size');
        return;
    }
    const product = {
        name: "Men's Winter Jacket",
        price: basePrice,
        quantity: quantity,
        size: selectedSize,
        totalPrice: basePrice * quantity
    };

    // Store the product in localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product);
    localStorage.setItem('cart', JSON.stringify(cart));

    // Redirect to cart page
    window.location.href = 'cart.html';
});