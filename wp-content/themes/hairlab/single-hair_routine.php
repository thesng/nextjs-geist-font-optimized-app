<?php get_header(); ?>

<main id="primary" class="site-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class('hair-routine-single'); ?>>
        <div class="container">
            <div class="routine-header">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="routine-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <div class="routine-intro">
                    <h1 class="routine-title"><?php the_title(); ?></h1>
                    <div class="routine-description">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

            <?php
            // Get products used in this routine
            $products = get_field('routine_products');
            if ($products) : ?>
                <section class="routine-products">
                    <h2>Products Used</h2>
                    <div class="products-grid">
                        <?php foreach ($products as $product) :
                            $product_obj = wc_get_product($product->ID);
                            if ($product_obj) :
                        ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <?php echo get_the_post_thumbnail($product->ID, 'woocommerce_thumbnail'); ?>
                                </div>
                                <h3><?php echo esc_html($product->post_title); ?></h3>
                                <div class="product-price">
                                    <?php echo $product_obj->get_price_html(); ?>
                                </div>
                                <button class="quick-add-btn" data-product-id="<?php echo esc_attr($product->ID); ?>">
                                    Quick Add
                                </button>
                            </div>
                        <?php 
                            endif;
                        endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php
            // Get routine steps
            if (have_rows('routine_steps')) : ?>
                <section class="routine-steps">
                    <h2>How to Use</h2>
                    <div class="steps-list">
                        <?php 
                        $step_count = 1;
                        while (have_rows('routine_steps')) : the_row(); 
                        ?>
                            <div class="step-item" data-aos="fade-up" data-aos-delay="<?php echo $step_count * 100; ?>">
                                <div class="step-number"><?php echo $step_count; ?></div>
                                <div class="step-content">
                                    <?php echo wp_kses_post(get_sub_field('step_description')); ?>
                                </div>
                            </div>
                        <?php 
                            $step_count++;
                        endwhile; 
                        ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Related Routines -->
            <?php
            $related_routines = new WP_Query(array(
                'post_type' => 'hair_routine',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            ));

            if ($related_routines->have_posts()) : ?>
                <section class="related-routines">
                    <h2>More Hair Routines</h2>
                    <div class="routines-grid">
                        <?php while ($related_routines->have_posts()) : $related_routines->the_post(); ?>
                            <div class="routine-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="routine-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

            <!-- Call to Action -->
            <section class="routine-cta">
                <h2>Find Your Perfect Hair Routine</h2>
                <p>Take our hair quiz to get personalized product recommendations based on your unique hair type and concerns.</p>
                <a href="<?php echo esc_url(home_url('/hair-quiz')); ?>" class="button button-primary">Take the Quiz</a>
            </section>
        </div>
    </article>
</main>

<?php get_footer(); ?>
