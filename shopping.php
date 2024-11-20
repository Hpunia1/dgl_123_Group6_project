<?php
session_start();
include 'includes/header.php';
include 'scripts/data.php';

// Set initial, increment, and minimum counts
$initial_display_count = 9; // Products to display initially
$products_per_load = 15; // Products to add or remove on each "Load More" or "Show Less"
$min_products_to_display = $initial_display_count; // Minimum number of products to show

// Get the current count of products to display from POST (or set default)
$products_to_display = isset($_POST['products_to_display']) 
    ? (int)$_POST['products_to_display'] 
    : $initial_display_count;

// Create a larger product list by repeating the original data
$total_products = count($products) * 10; // Simulate 10x the original product list
$expanded_products = [];
for ($i = 0; $i < ceil($total_products / count($products)); $i++) {
    foreach ($products as $key => $product) {
        $expanded_products[] = $product; // Repeat the products
    }
}

// Ensure the products to display does not exceed the total simulated products
$products_to_display = min($products_to_display, $total_products);
$products_to_display = max($products_to_display, $min_products_to_display); // Prevent going below the minimum
?>

<section class="hero-shoping">
    <div class="hero-p">
        <h1>Shop Men's</h1>
        <p>
            Revamp your style with the latest designer trends </br> in men's clothing or
            achieve a perfectly curated wardrobe.
        </p>
    </div>
</section>

<div class="content">
    <aside class="filters">
        <h3>Filters</h3>
        <div>
            <h4>Categories</h4>
            <ul>
                <li><input type="checkbox" checked /> Jackets</li>
                <li><input type="checkbox" /> Fleece</li>
                <li><input type="checkbox" /> Sweatshirts & Hoodies</li>
                <li><input type="checkbox" /> Sweaters</li>
                <li><input type="checkbox" /> Shirts</li>
                <li><input type="checkbox" /> T-shirts</li>
                <li><input type="checkbox" /> Pants & Jeans</li>
            </ul>
        </div>
        <div>
            <h4>Color</h4>
            <div class="colors">
                <div class="color-box color-orange"></div>
                <div class="color-box color-purple"></div>
                <div class="color-box color-blue"></div>
                <div class="color-box color-green"></div>
                <div class="color-box color-red"></div>
                <div class="color-box color-yellow"></div>
            </div>
        </div>
        <div class="flt"><a href="#">Clear filters</a></div>
    </aside>

    <main class="products">
        <div class="products-header">
            <h2>Showing <?= $products_to_display; ?> of <?= $total_products; ?> Products</h2>
        </div>

        <div class="product-grid">
            <?php foreach (array_slice($expanded_products, 0, $products_to_display) as $id => $product) : ?>
                <div class="product">
                    <a href="product.php?id=<?= htmlspecialchars($id); ?>">
                        <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                        <h4><?= htmlspecialchars($product['name']); ?></h4>
                        <div class="product-price">$<?= htmlspecialchars($product['price']); ?></div>
                    </a>
                    <button 
                        class="add-to-cart" 
                        data-id="<?= htmlspecialchars($id); ?>" 
                        data-name="<?= htmlspecialchars($product['name']); ?>" 
                        data-price="<?= htmlspecialchars($product['price']); ?>" 
                        data-image="<?= htmlspecialchars($product['image']); ?>">
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="load-buttons">
            <form method="POST" style="display: inline;">
                <?php if ($products_to_display < $total_products) : ?>
                    <input type="hidden" name="products_to_display" value="<?= $products_to_display + $products_per_load; ?>">
                    <button type="submit">Load more products</button>
                <?php endif; ?>
            </form>

            <form method="POST" style="display: inline;">
                <?php if ($products_to_display > $min_products_to_display) : ?>
                    <input type="hidden" name="products_to_display" value="<?= $products_to_display - $products_per_load; ?>">
                    <button type="submit">Show less products</button>
                <?php endif; ?>
            </form>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>