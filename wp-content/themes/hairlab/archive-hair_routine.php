<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">Hair Routines</h1>
            <div class="archive-description">
                <p>Discover personalized hair care routines tailored to different hair types and concerns. Each routine is scientifically formulated to deliver optimal results for your unique hair biology.</p>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="routines-filter">
                <div class="filter-wrapper">
                    <?php
                    // Get all unique hair types from ACF field
                    $hair_types = get_field_object('hair_type')['choices'];
                    if ($hair_types) : ?>
                        <div class="filter-group">
                            <label for="hair-type-filter">Hair Type:</label>
                            <select id="hair-type-filter" class="filter-select">
                                <option value="">All Types</option>
                                <?php foreach ($hair_types as $value => $label) : ?>
                                    <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Get all unique concerns from ACF field
                    $hair_concerns = get_field_object('hair_concerns')['choices'];
                    if ($hair_concerns) : ?>
                        <div class="filter-group">
                            <label for="concern-filter">Hair Concern:</label>
                            <select id="concern-filter" class="filter-select">
                                <option value="">All Concerns</option>
                                <?php foreach ($hair_concerns as $value => $label) : ?>
                                    <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="routines-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    $hair_type = get_field('hair_type');
                    $concerns = get_field('hair_concerns');
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('routine-card'); ?> 
                             data-hair-type="<?php echo esc_attr($hair_type); ?>"
                             data-concerns="<?php echo esc_attr(implode(' ', (array)$concerns)); ?>">
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="routine-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="routine-content">
                            <h2 class="routine-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <?php if ($hair_type || $concerns) : ?>
                                <div class="routine-meta">
                                    <?php if ($hair_type) : ?>
                                        <span class="hair-type"><?php echo esc_html($hair_types[$hair_type]); ?></span>
                                    <?php endif; ?>

                                    <?php if ($concerns) : ?>
                                        <div class="concerns-list">
                                            <?php foreach ((array)$concerns as $concern) : ?>
                                                <span class="concern-tag"><?php echo esc_html($hair_concerns[$concern]); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="routine-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <?php
                            // Display products used in this routine
                            $products = get_field('routine_products');
                            if ($products) : ?>
                                <div class="routine-products">
                                    <?php foreach ($products as $product) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($product->ID, 'thumbnail'); ?>" 
                                             alt="<?php echo esc_attr($product->post_title); ?>"
                                             title="<?php echo esc_attr($product->post_title); ?>">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <a href="<?php the_permalink(); ?>" class="button">View Routine</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('Previous', 'hairlab'),
                'next_text' => __('Next', 'hairlab'),
            ));
            ?>

        <?php else : ?>
            <div class="no-routines-found">
                <p>No hair routines found. Please check back later or try different filters.</p>
            </div>
        <?php endif; ?>

        <!-- Call to Action -->
        <section class="routines-cta">
            <div class="cta-content">
                <h2>Not sure which routine is right for you?</h2>
                <p>Take our 2-minute hair quiz to get personalized recommendations based on your unique hair biology.</p>
                <a href="<?php echo esc_url(home_url('/hair-quiz')); ?>" class="button button-primary">Take the Hair Quiz</a>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
