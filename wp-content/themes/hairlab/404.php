<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container">
            <div class="error-content">
                <h1 class="page-title">404</h1>
                <h2>Page Not Found</h2>
                
                <div class="error-description">
                    <p>The page you're looking for doesn't exist or has been moved.</p>
                </div>

                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary">
                        Return Home
                    </a>
                    
                    <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button button-secondary">
                            Shop Products
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Popular Products Section -->
                <?php if (class_exists('WooCommerce')) :
                    $popular_products = wc_get_products(array(
                        'limit' => 4,
                        'orderby' => 'popularity'
                    ));

                    if (!empty($popular_products)) : ?>
                        <div class="popular-products">
                            <h3>Popular Products</h3>
                            <div class="products-grid">
                                <?php foreach ($popular_products as $product) : ?>
                                    <div class="product-card">
                                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                                            <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                                            <h4><?php echo esc_html($product->get_name()); ?></h4>
                                            <div class="price"><?php echo $product->get_price_html(); ?></div>
                                        </a>
                                        <?php if ($product->is_type('simple')) : ?>
                                            <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                                Quick Add
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Hair Quiz CTA -->
                <div class="error-cta">
                    <h3>Not sure where to start?</h3>
                    <p>Take our 2-minute hair quiz to get personalized product recommendations.</p>
                    <a href="<?php echo esc_url(home_url('/hair-quiz')); ?>" class="button button-primary">
                        Take the Hair Quiz
                    </a>
                </div>

                <!-- Search Form -->
                <div class="error-search">
                    <h3>Search Our Site</h3>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>
