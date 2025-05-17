<?php get_header(); ?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-slider">
            <?php
            if (have_rows('hero_slides')) :
                while (have_rows('hero_slides')) : the_row();
                    $desktop_image = get_sub_field('desktop_image');
                    $mobile_image = get_sub_field('mobile_image');
                    $heading = get_sub_field('heading');
                    $subheading = get_sub_field('subheading');
                    $button_text = get_sub_field('button_text');
                    $button_link = get_sub_field('button_link');
            ?>
                <div class="hero-slide">
                    <picture>
                        <source media="(min-width: 768px)" srcset="<?php echo esc_url($desktop_image['url']); ?>">
                        <img src="<?php echo esc_url($mobile_image['url']); ?>" alt="<?php echo esc_attr($heading); ?>" class="hero-image">
                    </picture>
                    <div class="hero-content">
                        <h1><?php echo esc_html($heading); ?></h1>
                        <p><?php echo esc_html($subheading); ?></p>
                        <?php if ($button_text && $button_link) : ?>
                            <a href="<?php echo esc_url($button_link); ?>" class="button"><?php echo esc_html($button_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </section>

    <!-- Build Your Routine Section -->
    <section class="build-routine">
        <div class="container">
            <h2>BUILD YOUR ROUTINE</h2>
            <p>Once we know your hair's unique biology, we build a customized routine to match. There's no guesswork, just great hair.</p>
            
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
            ));

            if (!empty($categories)) :
            ?>
            <div class="product-categories-slider">
                <?php foreach ($categories as $category) : ?>
                    <div class="category-slide">
                        <?php
                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                        ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                        <h3><?php echo esc_html($category->name); ?></h3>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="button">Shop All <?php echo esc_html($category->name); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <h2>HOW IT WORKS</h2>
            <div class="steps-grid">
                <?php
                if (have_rows('how_it_works_steps')) :
                    while (have_rows('how_it_works_steps')) : the_row();
                        $step_image = get_sub_field('step_image');
                        $step_title = get_sub_field('step_title');
                        $step_description = get_sub_field('step_description');
                ?>
                    <div class="step-item">
                        <img src="<?php echo esc_url($step_image['url']); ?>" alt="<?php echo esc_attr($step_title); ?>">
                        <h3><?php echo esc_html($step_title); ?></h3>
                        <p><?php echo esc_html($step_description); ?></p>
                    </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Hair Routines Section -->
    <section class="hair-routines">
        <div class="container">
            <h2>REMOVE THE GUESSWORK</h2>
            <p>Hair care is not one size fits all. Your hair's health is a function of many factors — explore some of our favorite routines.</p>
            
            <?php
            $routines = new WP_Query(array(
                'post_type' => 'hair_routine',
                'posts_per_page' => 4
            ));

            if ($routines->have_posts()) :
            ?>
            <div class="routines-grid">
                <?php
                while ($routines->have_posts()) : $routines->the_post();
                    $products = get_field('routine_products');
                ?>
                    <div class="routine-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <?php if ($products) : ?>
                            <div class="routine-products">
                                <?php foreach ($products as $product) : ?>
                                    <img src="<?php echo get_the_post_thumbnail_url($product->ID, 'thumbnail'); ?>" 
                                         alt="<?php echo esc_attr($product->post_title); ?>">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Press Section -->
    <section class="press-section">
        <div class="container">
            <h2>PRESS HIGHLIGHTS</h2>
            <div class="press-logos">
                <?php
                if (have_rows('press_logos', 'option')) :
                    while (have_rows('press_logos', 'option')) : the_row();
                        $logo = get_sub_field('logo');
                        $quote = get_sub_field('quote');
                ?>
                    <div class="press-item">
                        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
                        <?php if ($quote) : ?>
                            <p class="press-quote"><?php echo esc_html($quote); ?></p>
                        <?php endif; ?>
                    </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
