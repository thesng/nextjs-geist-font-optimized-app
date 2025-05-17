<?php
/**
 * The Template for displaying all single products
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content
 */
do_action('woocommerce_before_main_content');
?>

<div class="single-product-wrapper">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <div class="product-main">
            <div class="container">
                <div class="product-content-wrapper">
                    <?php 
                    global $product;
                    
                    // Breadcrumb
                    woocommerce_breadcrumb();
                    ?>

                    <div class="product-gallery-summary">
                        <div class="product-gallery">
                            <?php
                            /**
                             * Hook: woocommerce_before_single_product_summary.
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action('woocommerce_before_single_product_summary');
                            ?>
                        </div>

                        <div class="product-summary">
                            <?php
                            /**
                             * Hook: woocommerce_single_product_summary.
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             */
                            do_action('woocommerce_single_product_summary');
                            ?>

                            <!-- Custom Benefits Section -->
                            <?php if (get_field('product_benefits')) : ?>
                                <div class="product-benefits">
                                    <h3>Benefits</h3>
                                    <div class="benefits-list">
                                        <?php
                                        while (have_rows('product_benefits')) : the_row();
                                            $benefit = get_sub_field('benefit');
                                        ?>
                                            <div class="benefit-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                    <path d="M20 6L9 17l-5-5"></path>
                                                </svg>
                                                <span><?php echo esc_html($benefit); ?></span>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Custom Ingredients Section -->
                            <?php if (get_field('product_ingredients')) : ?>
                                <div class="product-ingredients">
                                    <h3>Key Ingredients</h3>
                                    <div class="ingredients-list">
                                        <?php echo wp_kses_post(get_field('product_ingredients')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- How to Use Section -->
                            <?php if (get_field('how_to_use')) : ?>
                                <div class="how-to-use">
                                    <h3>How to Use</h3>
                                    <div class="usage-steps">
                                        <?php echo wp_kses_post(get_field('how_to_use')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-tabs-section">
            <div class="container">
                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary.
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action('woocommerce_after_single_product_summary');
                ?>
            </div>
        </div>

        <!-- Before & After Results -->
        <?php if (have_rows('before_after_results')) : ?>
            <section class="before-after-section">
                <div class="container">
                    <h2>Real Results</h2>
                    <div class="results-slider">
                        <?php while (have_rows('before_after_results')) : the_row();
                            $before_image = get_sub_field('before_image');
                            $after_image = get_sub_field('after_image');
                            $testimonial = get_sub_field('testimonial');
                        ?>
                            <div class="result-slide">
                                <div class="before-after-images">
                                    <div class="before-image">
                                        <img src="<?php echo esc_url($before_image['url']); ?>" alt="Before">
                                        <span class="label">Before</span>
                                    </div>
                                    <div class="after-image">
                                        <img src="<?php echo esc_url($after_image['url']); ?>" alt="After">
                                        <span class="label">After</span>
                                    </div>
                                </div>
                                <?php if ($testimonial) : ?>
                                    <div class="testimonial">
                                        <?php echo wp_kses_post($testimonial); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Recommended Products -->
        <?php
        $recommended_products = get_field('recommended_products');
        if ($recommended_products) : ?>
            <section class="recommended-products">
                <div class="container">
                    <h2>Complete Your Routine</h2>
                    <div class="products-grid">
                        <?php foreach ($recommended_products as $recommended_product) :
                            $product = wc_get_product($recommended_product->ID);
                            if ($product) : ?>
                                <div class="product-card">
                                    <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                                        <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                                        <h3><?php echo esc_html($product->get_name()); ?></h3>
                                        <div class="price"><?php echo $product->get_price_html(); ?></div>
                                    </a>
                                    <?php if ($product->is_type('simple')) : ?>
                                        <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                            Quick Add
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
