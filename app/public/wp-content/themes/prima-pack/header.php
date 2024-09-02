<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- navigation -->
    <header class="main-head">
        <!-- Header top value prop message -->
        <div class="header-top">
            <div class="top-prop-message">
                <div class="container">
                    <div class="value-prop-content">
                        <div class="top-icon">
                            <img style="height: 18px;" src="<?php echo get_template_directory_uri(); ?>/images/eco-friendly-new.svg" alt="Free Shipping">
                            <p><span>Eco Friendly:</span></p>
                        </div>
                       <div class="top-message">
                            <p><span>Eco Friendly:</span> Focused on using 100% recycled materials</p>
                       </div>
                    </div>
                </div>
            </div>
            <div class="utility-nav">
                <?php $email = get_field('email_us','option'); ?>
                <div class="container">
                    <div class="utility-content">
                        <div class="col">
                            <?php if($email){
                                echo '<a href="mailto:'. $email. '">'. $email. '</a>';
                            } ?>
                        </div>
                        <div class="col">
                            <div class="currency-dropdown">
                                <select id="mobile-currency" class="select-currency" style="background: transparent url('<?php echo get_template_directory_uri(); ?>/images/Caret-Down.svg') no-repeat !important;background-position: right 0px top 50% !important;">
                                    <option value="US">USD</option>
                                    <option value="Canada">CA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
 
        
 

        <div class="header_in">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                <?php
                    $logo_img = get_field('header_logo','option');
                    if($logo_img){
                ?>
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <img src="<?php echo $logo_img['url']; ?>" alt="<?php echo $logo_img['alt']; ?>">
                    </a>
                <?php } ?>
                    <button class="navbar-toggler navbar-toggler-main" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="stick"></span>
                    </button>

                    <div class="search_icon">
                        <a href="#url"><img src="<?php echo get_template_directory_uri(); ?>/images/Icon-search.svg" alt=""></a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <button class="navbar-toggler navbar-toggler-main" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="stick"></span>
                        </button>
                        <?php
                            wp_nav_menu( 
                                array(
                                  'theme_location'  => 'header-menu',
                                  'container'       => '',
                                  'menu_class'      => 'navbar-nav ms-auto'
                                ) 
                            );
                        ?>
                        <div class="mobile-nav-bottom">
                            <div class="item">
                                <div class="call">
                                    <div class="icon">
                                        <img src="<?php echo get_template_directory_uri(); ?>//images/Contact-support.svg" alt="">
                                    </div>
                                    <div class="call-number">
                                        <?php $phone = preg_replace("/[^0-9]/", "",  get_field('call_us','option'));?>
                                        <a href="tel:+1<?php echo $phone;?>"><span>Give us a call</span>(647) 726-1290</a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="currency-dropdown">
                                    <select id="currency" class="select-currency" style="background: transparent url('<?php echo get_template_directory_uri(); ?>/images/Caret-Down.svg') no-repeat !important;background-position: right 0px top 50% !important;">
                                        <option value="US">USD</option>
                                        <option value="Canada">CA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="call">
                        <div class="icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/Contact-support.svg" alt="">
                        </div>
                        <div class="call-number">
                            <?php $phone = preg_replace("/[^0-9]/", "",  get_field('call_us','option'));?>
                            <a href="tel:+1<?php echo $phone;?>"><span>Give us a call</span>(647) 726-1290</a>
                        </div>
                    </div>
                
                    <a id="mini-cart-count" class="carticon" href="<?php echo wc_get_cart_url(); ?>" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/Icon-cart.svg);">
                        <span><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span>
                    </a>
                </nav>
            </div>
        </div>

        <button class="navbar-toggler" id="navoverlay" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation"></button>
            <div class="search-sec">
                <div class="search-wpr">
                    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" id="search" name="s" value="<?php echo get_search_query() ?>">
                        <button type="submit"><img src="<?php echo get_template_directory_uri(); ?>/images/Icon-search.svg" alt=""></button>
                    </form>
                    <span class="search-close"><img src="<?php echo get_template_directory_uri(); ?>/images/close.svg" alt=""></span>
                </div>
            </div>
    </header>
