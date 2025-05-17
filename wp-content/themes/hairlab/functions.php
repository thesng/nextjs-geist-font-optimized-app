<?php
if (!defined('ABSPATH')) exit;

// Theme Setup
function hairlab_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'hairlab'),
        'footer' => __('Footer Menu', 'hairlab')
    ));
}
add_action('after_setup_theme', 'hairlab_setup');

// Enqueue Scripts and Styles
function hairlab_scripts() {
    // Styles
    wp_enqueue_style('hairlab-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Helvetica+Neue:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    
    // Scripts
    wp_enqueue_script('hairlab-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('hairlab-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'hairlab_scripts');

// Custom Post Types
function hairlab_register_post_types() {
    // Hair Routine CPT
    register_post_type('hair_routine', array(
        'labels' => array(
            'name' => __('Hair Routines', 'hairlab'),
            'singular_name' => __('Hair Routine', 'hairlab')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-customizer'
    ));

    // Testimonials CPT
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => __('Testimonials', 'hairlab'),
            'singular_name' => __('Testimonial', 'hairlab')
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote'
    ));
}
add_action('init', 'hairlab_register_post_types');

// Register ACF Fields
if(function_exists('acf_add_local_field_group')) {
    // Hair Routine Fields
    acf_add_local_field_group(array(
        'key' => 'group_hair_routine',
        'title' => 'Hair Routine Details',
        'fields' => array(
            array(
                'key' => 'field_routine_products',
                'label' => 'Products Used',
                'name' => 'routine_products',
                'type' => 'relationship',
                'post_type' => array('product'),
                'multiple' => true,
            ),
            array(
                'key' => 'field_routine_steps',
                'label' => 'Routine Steps',
                'name' => 'routine_steps',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_step_description',
                        'label' => 'Step Description',
                        'name' => 'step_description',
                        'type' => 'textarea'
                    )
                )
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'hair_routine',
                )
            )
        )
    ));
}

// Customizer Settings
function hairlab_customize_register($wp_customize) {
    // Social Media Section
    $wp_customize->add_section('hairlab_social_media', array(
        'title' => __('Social Media Links', 'hairlab'),
        'priority' => 30,
    ));

    // Facebook URL
    $wp_customize->add_setting('facebook_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('facebook_url', array(
        'label' => __('Facebook URL', 'hairlab'),
        'section' => 'hairlab_social_media',
        'type' => 'url'
    ));

    // Instagram URL
    $wp_customize->add_setting('instagram_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('instagram_url', array(
        'label' => __('Instagram URL', 'hairlab'),
        'section' => 'hairlab_social_media',
        'type' => 'url'
    ));

    // TikTok URL
    $wp_customize->add_setting('tiktok_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('tiktok_url', array(
        'label' => __('TikTok URL', 'hairlab'),
        'section' => 'hairlab_social_media',
        'type' => 'url'
    ));
}
add_action('customize_register', 'hairlab_customize_register');

// WooCommerce Support
function hairlab_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'hairlab_woocommerce_support');

// Custom Image Sizes
add_image_size('hairlab-product-thumb', 300, 300, true);
add_image_size('hairlab-hero', 1920, 800, true);

// Disable Gutenberg editor for certain post types
function hairlab_disable_gutenberg($is_enabled, $post_type) {
    if ($post_type === 'hair_routine' || $post_type === 'testimonial') {
        return false;
    }
    return $is_enabled;
}
add_filter('use_block_editor_for_post_type', 'hairlab_disable_gutenberg', 10, 2);

// Add custom body classes
function hairlab_body_classes($classes) {
    if (is_singular('hair_routine')) {
        $classes[] = 'hair-routine-template';
    }
    return $classes;
}
add_filter('body_class', 'hairlab_body_classes');
