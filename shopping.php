<?php
session_start();
include 'includes/header.php';
include 'scripts/data.php';

// Set initial, increment, and minimum counts
$initial_display_count = 9; // Products to display initially
$products_per_load = 3; // Products to add or remove on each "Load More" or "Show Less"
$min_products_to_display = $initial_display_count; // Minimum number of products to show

// Get selected filters
$selected_categories = isset($_POST['categories']) ? $_POST['categories'] : [];

// Filter products based on selected categories
$filtered_products = [];
if (!empty($selected_categories)) {
    foreach ($products as $product) {
        // Check if the product has a category key and if it matches the selected filters
        if (isset($product['category']) && in_array($product['category'], $selected_categories)) {
            $filtered_products[] = $product;
        }
    }
} else {
    $filtered_products = $products; // No filter applied, show all products
}

// Create a larger product list by repeating the filtered data
$total_products = count($filtered_products) * 10; // Simulate 10x the filtered product list
$expanded_products = [];
for ($i = 0; $i < ceil($total_products / count($filtered_products)); $i++) {
    foreach ($filtered_products as $product) {
        $expanded_products[] = $product; // Repeat the products
    }
}

// Get the current count of products to display from POST (or set default)
$products_to_display = isset($_POST['products_to_display']) 
    ? (int)$_POST['products_to_display'] 
    : $initial_display_count;

// Ensure the products to display does not exceed the total simulated products
$products_to_display = min($products_to_display, $total_products);
$products_to_display = max($products_to_display, $min_products_to_display); // Prevent going below the minimum
?>

<section class="hero-shoping">
    <div class="hero-p">
        <h1>Shop Men's</h1>
        <p>
            Revamp your style with the latest designer trends in <br>men's clothing or
            achieve a perfectly curated wardrobe.
        </p>
    </div>
</section>

<div class="content">
    <aside class="filters">
        <h3>Filters</h3>
        <form method="POST">
            <div>
                <h4>Categories</h4>
                <ul>
                    <li>
                        <label>
                            <input type="checkbox" name="categories[]" value="Jackets" 
                                <?= in_array('Jackets', $selected_categories) ? 'checked' : ''; ?> />
                            Jackets
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="categories[]" value="Sweatshirts & Hoodies" 
                                <?= in_array('Sweatshirts & Hoodies', $selected_categories) ? 'checked' : ''; ?> />
                            Sweatshirts & Hoodies
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="categories[]" value="Shoes" 
                                <?= in_array('Shoes', $selected_categories) ? 'checked' : ''; ?> />
                            Shoes
                        </label>
                    </li>
                </ul>
            </div>
            <button type="submit">Apply Filters</button>
        </form>
        <div class="flt"><a href="shopping.php">Clear filters</a></div>
    </aside>

    <main class="products">
        <div class="products-header">
            <h2>Showing <?= $products_to_display; ?> of <?= $total_products; ?> Products</h2>
        </div>

        <div class="product-grid">
            <?php foreach (array_slice($expanded_products, 0, $products_to_display) as $id => $product) : ?>
                <div class="product">
                <a href="product.php?id=<?= htmlspecialchars($product['id']); ?>">

                        <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                        <h4><?= htmlspecialchars($product['name']); ?></h4>
                        <div class="product-price">$<?= htmlspecialchars($product['price']); ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="load-buttons">
            <div class="button1">
                <form method="POST" style="display: inline;">
                    <?php if ($products_to_display < $total_products) : ?>
                        <input type="hidden" name="products_to_display" value="<?= $products_to_display + $products_per_load; ?>">
                        <?php foreach ($selected_categories as $category) : ?>
                            <input type="hidden" name="categories[]" value="<?= htmlspecialchars($category); ?>">
                        <?php endforeach; ?>
                        <button type="submit">Load more products</button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="button2">
                <form method="POST" style="display: inline;">
                    <?php if ($products_to_display > $min_products_to_display) : ?>
                        <input type="hidden" name="products_to_display" value="<?= $products_to_display - $products_per_load; ?>">
                        <?php foreach ($selected_categories as $category) : ?>
                            <input type="hidden" name="categories[]" value="<?= htmlspecialchars($category); ?>">
                        <?php endforeach; ?>
                        <button type="submit">Show less products</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
