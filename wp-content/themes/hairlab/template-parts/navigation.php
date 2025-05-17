<?php
/**
 * Template part for displaying the main navigation
 */
?>

<nav id="site-navigation" class="main-navigation">
    <div class="nav-wrapper">
        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="screen-reader-text">Menu</span>
        </button>

        <!-- Main Menu -->
        <div class="menu-container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id' => 'primary-menu',
                'menu_class' => 'nav-menu',
                'container' => false,
                'fallback_cb' => function() {
                    echo '<ul class="nav-menu">';
                    echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">Create a menu</a></li>';
                    echo '</ul>';
                },
            ));
            ?>
        </div>

        <!-- Shop Categories Mega Menu -->
        <div class="mega-menu-wrapper">
            <div class="mega-menu-content">
                <div class="categories-grid">
                    <?php
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0
                    ));

                    if (!empty($product_categories)) :
                        foreach ($product_categories as $category) :
                            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_url($thumbnail_id);
                    ?>
                        <div class="category-item">
                            <?php if ($image) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                            <?php endif; ?>
                            <h3><?php echo esc_html($category->name); ?></h3>
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-link">
                                Shop <?php echo esc_html($category->name); ?>
                            </a>
                            <?php
                            // Get subcategories
                            $subcategories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => $category->term_id
                            ));

                            if (!empty($subcategories)) : ?>
                                <ul class="subcategories-list">
                                    <?php foreach ($subcategories as $subcategory) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($subcategory)); ?>">
                                                <?php echo esc_html($subcategory->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Featured Products -->
                <div class="featured-products">
                    <h3>Featured Products</h3>
                    <?php
                    $featured_products = wc_get_products(array(
                        'featured' => true,
                        'limit' => 3
                    ));

                    if (!empty($featured_products)) :
                        foreach ($featured_products as $product) : ?>
                            <div class="featured-product">
                                <?php if ($product->get_image_id()) : ?>
                                    <img src="<?php echo wp_get_attachment_image_url($product->get_image_id(), 'thumbnail'); ?>"
                                         alt="<?php echo esc_attr($product->get_name()); ?>">
                                <?php endif; ?>
                                <h4><?php echo esc_html($product->get_name()); ?></h4>
                                <span class="price"><?php echo $product->get_price_html(); ?></span>
                                <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                    Quick Add
                                </button>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-form-wrapper">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <label>
                    <span class="screen-reader-text">Search for:</span>
                    <input type="search" class="search-field" 
                           placeholder="Search products..." 
                           value="<?php echo get_search_query(); ?>" 
                           name="s" />
                    <input type="hidden" name="post_type" value="product" />
                </label>
                <button type="submit" class="search-submit">
                    <span class="screen-reader-text">Search</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Cart Icon -->
        <?php if (class_exists('WooCommerce')) : ?>
            <div class="cart-icon">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-contents">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<!-- Mini Cart Dropdown -->
<?php if (class_exists('WooCommerce')) : ?>
    <div class="mini-cart-dropdown">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
<?php endif; ?>
