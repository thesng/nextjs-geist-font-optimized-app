<?php
/**
 * The template for displaying product content within loops
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>

<li <?php wc_product_class('product-card', $product); ?>>
    <div class="product-card-inner">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item.
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>

        <div class="product-image-wrapper">
            <a href="<?php echo esc_url(get_permalink()); ?>" class="product-image-link">
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop_item_title.
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action('woocommerce_before_shop_loop_item_title');

                // Display sale badge if product is on sale
                if ($product->is_on_sale()) : ?>
                    <span class="onsale">Sale</span>
                <?php endif; ?>
            </a>

            <?php
            // Quick view button
            if (function_exists('wc_get_template')) : ?>
                <button class="quick-view-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                    Quick View
                </button>
            <?php endif; ?>
        </div>

        <div class="product-details">
            <?php
            // Product Categories
            $categories = wc_get_product_category_list($product->get_id(), ', ');
            if ($categories) : ?>
                <div class="product-categories">
                    <?php echo $categories; ?>
                </div>
            <?php endif; ?>

            <h2 class="woocommerce-loop-product__title">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h2>

            <?php
            // Short description
            if ($product->get_short_description()) : ?>
                <div class="product-short-description">
                    <?php echo wp_trim_words($product->get_short_description(), 15); ?>
                </div>
            <?php endif; ?>

            <div class="product-price-rating">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item_title.
                 * @hooked woocommerce_template_loop_price - 10
                 * @hooked woocommerce_template_loop_rating - 5
                 */
                do_action('woocommerce_after_shop_loop_item_title');
                ?>
            </div>

            <div class="product-actions">
                <?php
                // Quick Add button for simple products
                if ($product->is_type('simple')) : ?>
                    <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                        Quick Add
                    </button>
                <?php else : ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="button view-product-btn">
                        View Options
                    </a>
                <?php endif; ?>

                <?php
                // Wishlist button if YITH Wishlist is active
                if (defined('YITH_WCWL') && YITH_WCWL) : ?>
                    <div class="wishlist-btn">
                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            // Product tags
            $tags = wc_get_product_tag_list($product->get_id(), ', ');
            if ($tags) : ?>
                <div class="product-tags">
                    <?php echo $tags; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item.
         */
        do_action('woocommerce_after_shop_loop_item');
        ?>
    </div>

    <!-- Quick View Modal Structure -->
    <div id="quick-view-modal-<?php echo esc_attr($product->get_id()); ?>" class="quick-view-modal">
        <div class="quick-view-content">
            <div class="quick-view-close">&times;</div>
            <div class="quick-view-inner">
                <div class="quick-view-images">
                    <?php
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ($attachment_ids) : ?>
                        <div class="product-gallery">
                            <?php
                            foreach ($attachment_ids as $attachment_id) {
                                echo wp_get_attachment_image($attachment_id, 'woocommerce_single');
                            }
                            ?>
                        </div>
                    <?php else :
                        echo $product->get_image('woocommerce_single');
                    endif;
                    ?>
                </div>
                <div class="quick-view-details">
                    <h2><?php echo esc_html($product->get_name()); ?></h2>
                    <div class="price"><?php echo $product->get_price_html(); ?></div>
                    <div class="description">
                        <?php echo wp_kses_post($product->get_short_description()); ?>
                    </div>
                    <?php
                    if ($product->is_type('simple')) {
                        woocommerce_template_single_add_to_cart();
                    } else {
                        echo '<a href="' . esc_url(get_permalink()) . '" class="button">View Full Details</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</li>
