<?php
/**
 * The Template for displaying product archives, including the main shop page
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');
?>

<header class="woocommerce-products-header">
    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_archive_description.
     */
    do_action('woocommerce_archive_description');
    ?>
</header>

<div class="shop-container">
    <div class="shop-sidebar">
        <?php
        /**
         * Custom Category Menu
         */
        $categories = get_terms('product_cat', array(
            'hide_empty' => true,
            'parent' => 0
        ));

        if (!empty($categories)) : ?>
            <div class="product-categories-menu">
                <h3>Categories</h3>
                <ul>
                    <?php foreach ($categories as $category) : 
                        $category_thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $category_image = wp_get_attachment_url($category_thumbnail_id);
                    ?>
                        <li class="category-item">
                            <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                <?php if ($category_image) : ?>
                                    <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                <?php endif; ?>
                                <span><?php echo esc_html($category->name); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
        /**
         * Custom Filter Widget Area
         */
        if (is_active_sidebar('shop-filters')) : ?>
            <div class="shop-filters">
                <?php dynamic_sidebar('shop-filters'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="shop-content">
        <?php
        if (woocommerce_product_loop()) {
            /**
             * Hook: woocommerce_before_shop_loop.
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            ?>
            <div class="shop-controls">
                <?php do_action('woocommerce_before_shop_loop'); ?>
            </div>

            <div class="products-wrapper">
                <?php
                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();
                ?>
            </div>

            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
        }
        ?>
    </div>
</div>

<?php
/**
 * Featured Products Section
 */
$featured_products = wc_get_products(array(
    'featured' => true,
    'limit' => 4
));

if (!empty($featured_products)) : ?>
    <section class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="products-grid">
                <?php foreach ($featured_products as $featured_product) : ?>
                    <div class="featured-product-card">
                        <a href="<?php echo esc_url(get_permalink($featured_product->get_id())); ?>">
                            <?php echo $featured_product->get_image('woocommerce_thumbnail'); ?>
                            <h3><?php echo esc_html($featured_product->get_name()); ?></h3>
                            <div class="price"><?php echo $featured_product->get_price_html(); ?></div>
                        </a>
                        <?php if ($featured_product->is_type('simple')) : ?>
                            <button class="quick-add-btn" data-product-id="<?php echo esc_attr($featured_product->get_id()); ?>">
                                Quick Add
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
/**
 * Shop CTA Section
 */
?>
<section class="shop-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Not sure which products are right for you?</h2>
            <p>Take our 2-minute hair quiz to get personalized recommendations based on your unique hair biology.</p>
            <a href="<?php echo esc_url(home_url('/hair-quiz')); ?>" class="button button-primary">Take the Hair Quiz</a>
        </div>
    </div>
</section>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
