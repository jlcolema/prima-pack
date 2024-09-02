 <!-- instragram feed section start -->
<?php if(!is_cart() && !is_checkout() && !is_account_page()){ ?>
    <div class="intra_slider_sec">
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i1.jpg" alt=""></figure>
        </div>
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i2.jpg" alt=""></figure>
        </div>
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i3.jpg" alt=""></figure>
        </div>
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i4.jpg" alt=""></figure>
        </div>
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i5.jpg" alt=""></figure>
        </div>
        <div class="intra_slide">
            <figure><img src="<?php echo get_template_directory_uri(); ?>/images/i6.jpg" alt=""></figure>
        </div>
    </div>
<?php } ?>
    <!-- instragram feed section end -->

    <!-- footer-section -->
    <footer class="main-footer">
        <div class="fttr_main_top">
            <div class="container">
                <div class="footer-aminRw">
                    <div class="footer-MainClm footer-mn-clmTw">
                        <p class="footer-tittle-txt"><?php the_field('links_title','option'); ?></p>
                        <?php
                            wp_nav_menu( 
                                array(
                                  'theme_location'  => 'footer-menu',
                                  'container'       => '',
                                  'menu_class'      => ''
                                ) 
                            );
                        ?>
                    </div>
                    <div class="footer-MainClm footer-mn-clmThree">
                        <p class="footer-tittle-txt"><?php the_field('get_in_touch','option'); ?></p>
                        <ul>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/msg.svg" alt=""></span>
                                <a href="mailto:<?php the_field('get_in_touch_email','option'); ?>"><?php the_field('get_in_touch_email','option'); ?></a>
                            </li>
                            <?php $phone_no = preg_replace("/[^0-9]/", "",  get_field('get_in_touch_phone','option')); ?>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/call.svg" alt=""></span>
                                <a href="tel:+1<?php echo $phone_no; ?>"><?php the_field('get_in_touch_phone','option'); ?></a>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="footer-MainClm footer-mn-clmAddrs">
                        <p class="footer-tittle-txt">Address</p>
                        <ul>
                            <li>
                                <p>Office</p>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/location.svg" alt=""></span>
                                <p><?php the_field('get_in_touch_address','option'); ?></p>
                            </li>
                            
                            <li>
                                <p>Warehouse</p>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/location.svg" alt=""></span>
                                <p><?php the_field('another_address','option'); ?></p>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-MainClm footer-mn-clmFour">
                        <p class="footer-tittle-txt"><?php the_field('opening_hours_title','option'); ?></p>
                        <ul>
                            <li><?php the_field('weekly_open','option'); ?></li>
                            <li><?php the_field('weekly_closed','option'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy_right_part">
        <?php
            $footer_img = get_field('footer_logo','option');
            if($footer_img){
        ?>
            <div class="cpy_logo_wrap">
                <a href="<?php echo home_url(); ?>"><img src="<?php echo $footer_img['url']; ?>" alt="<?php echo $footer_img['alt']; ?>"></a>
            </div>
        <?php } ?>
            <p>© <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>"><?php the_field('site_name','option'); ?></a><?php the_field('text','option'); ?></p>
            <ul>
                <li><a target="_blank" href="<?php the_field('twitter_link','option'); ?>"><i class="fab fa-twitter"></i></a></li>
                <li><a target="_blank" href="<?php the_field('instagram_link','option'); ?>"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </footer>   
    <!-- footer-section -->

    <?php wp_footer(); ?>

</body>

</html>