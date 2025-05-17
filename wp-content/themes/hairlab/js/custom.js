jQuery(document).ready(function($) {
    // Mobile Menu Toggle
    $('.mobile-menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.nav-menu').slideToggle();
    });

    // Hero Slider
    if ($('.hero-slider').length) {
        $('.hero-slider').slick({
            dots: true,
            arrows: false,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 5000,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        adaptiveHeight: true
                    }
                }
            ]
        });
    }

    // Product Categories Slider
    if ($('.product-categories-slider').length) {
        $('.product-categories-slider').slick({
            dots: false,
            arrows: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    // Quick Add to Cart
    $('.quick-add-btn').on('click', function(e) {
        e.preventDefault();
        var $button = $(this);
        var productId = $button.data('product-id');
        var quantity = 1;

        $button.addClass('loading');

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $button.removeClass('loading').addClass('added');
                    $(document.body).trigger('wc_fragment_refresh');
                    
                    // Show success message
                    if ($('.cart-notification').length === 0) {
                        $('body').append('<div class="cart-notification">Product added to cart!</div>');
                    }
                    $('.cart-notification').fadeIn().delay(2000).fadeOut();
                }
            },
            error: function() {
                $button.removeClass('loading');
                // Show error message
                if ($('.cart-notification').length === 0) {
                    $('body').append('<div class="cart-notification error">Failed to add product.</div>');
                }
                $('.cart-notification').fadeIn().delay(2000).fadeOut();
            }
        });
    });

    // Sticky Header
    var header = $('.site-header');
    var headerOffset = header.offset().top;

    $(window).scroll(function() {
        if ($(window).scrollTop() > headerOffset) {
            header.addClass('sticky');
        } else {
            header.removeClass('sticky');
        }
    });

    // Smooth Scroll for Anchor Links
    $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (
            location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
            && 
            location.hostname == this.hostname
        ) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - header.outerHeight()
                }, 1000);
            }
        }
    });

    // Press Logos Slider
    if ($('.press-logos').length) {
        $('.press-logos').slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });
    }

    // Initialize AOS (Animate on Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }

    // Handle Window Resize
    var resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Reset mobile menu on larger screens
            if ($(window).width() > 768) {
                $('.nav-menu').removeAttr('style');
                $('.mobile-menu-toggle').removeClass('active');
            }
        }, 250);
    });
});
