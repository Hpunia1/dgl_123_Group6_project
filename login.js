// Get elements
const loginLink = document.querySelector('.login-link');
const overlay = document.getElementById('popup-overlay');
const closeBtn = document.getElementById('close-btn');

// Show popup when login link is clicked
loginLink.addEventListener('click', (e) => {
  e.preventDefault(); // Prevent default link behavior
  overlay.style.display = 'flex'; // Show overlay and popup
});

// Hide popup when close button is clicked
closeBtn.addEventListener('click', () => {
  overlay.style.display = 'none';
});

// Hide popup when clicking outside the popup
overlay.addEventListener('click', (e) => {
  if (e.target === overlay) {
    overlay.style.display = 'none';
  }
});