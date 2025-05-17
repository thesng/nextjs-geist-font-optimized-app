</div><!-- #content -->

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-column">
                <h4><?php echo get_bloginfo('name'); ?></h4>
                <p>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. All rights reserved.</p>
            </div>
            
            <div class="footer-column">
                <h4>Quick Links</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                ));
                ?>
            </div>
            
            <div class="footer-column">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <?php if (get_theme_mod('facebook_url')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-facebook"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('instagram_url')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (get_theme_mod('tiktok_url')) : ?>
                        <a href="<?php echo esc_url(get_theme_mod('tiktok_url')); ?>" target="_blank" rel="noopener">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-column">
                <h4>Press Highlights</h4>
                <div class="press-logos">
                    <img src="<?php echo get_theme_file_uri('assets/images/good-housekeeping-logo.png'); ?>" alt="Good Housekeeping">
                    <img src="<?php echo get_theme_file_uri('assets/images/cew-logo.png'); ?>" alt="CEW">
                    <img src="<?php echo get_theme_file_uri('assets/images/glossy-logo.png'); ?>" alt="Glossy">
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
