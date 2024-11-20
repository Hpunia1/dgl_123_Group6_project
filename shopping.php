<?php
include 'includes/header.php';

// Include the products data
include 'scripts/data.php';
?>
      </section>
      </section>
    </header>


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
            <h2>Showing <?= count($products); ?> Products</h2>
        </div>

        <div class="product-grid">
            <?php foreach ($products as $id => $product) : ?>
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

        <div class="load-more">
            <button>Load more products</button>
          </div>
        </main>
      </div>
      
    </main>
</div>

<?php include 'includes/footer.php'; ?>
