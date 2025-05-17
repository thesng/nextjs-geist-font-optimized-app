<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            ?>
            <header class="page-header">
                <?php
                if (is_home() && !is_front_page()) :
                    ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                    <?php
                else :
                    ?>
                    <h1 class="page-title">Blog</h1>
                    <?php
                endif;
                ?>
            </header>

            <div class="posts-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                ?>

                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <?php if (has_category()) : ?>
                                        <span class="categories">
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </footer>
                        </div>
                    </article>
                <?php
                endwhile;
                ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '&larr; Previous',
                'next_text' => 'Next &rarr;',
            ));

        else :
            ?>
            <div class="no-posts">
                <h2>No Posts Found</h2>
                <p>It seems we can't find what you're looking for.</p>
                <?php get_search_form(); ?>
            </div>
            <?php
        endif;
        ?>

        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <aside id="secondary" class="widget-area">
                <?php dynamic_sidebar('sidebar-1'); ?>
            </aside>
        <?php endif; ?>
    </div>

    <?php if (is_home() && !is_paged()) : ?>
        <!-- Newsletter Section -->
        <section class="newsletter-section">
            <div class="container">
                <div class="newsletter-content">
                    <h2>Stay Updated</h2>
                    <p>Subscribe to our newsletter for hair care tips, product updates, and exclusive offers.</p>
                    <?php 
                    // Check if Contact Form 7 is active and the form exists
                    if (function_exists('wpcf7_contact_form')) {
                        $form_id = get_theme_mod('newsletter_form_id');
                        if ($form_id) {
                            echo do_shortcode('[contact-form-7 id="' . $form_id . '"]');
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <?php if (has_category()) : ?>
            <section class="featured-categories">
                <div class="container">
                    <h2>Popular Categories</h2>
                    <div class="categories-grid">
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => 4
                        ));

                        foreach ($categories as $category) :
                            ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-card">
                                <h3><?php echo esc_html($category->name); ?></h3>
                                <span class="post-count"><?php echo esc_html($category->count); ?> posts</span>
                            </a>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php
get_footer();
?>
