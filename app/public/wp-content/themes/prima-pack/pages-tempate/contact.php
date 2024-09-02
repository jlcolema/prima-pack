<?php
/*
Template Name: Contact Us
*/
get_header();
?>

    <!-- contact form section start -->
    <div class="contact_form_sec cmn_gap">
        <div class="container">
            <div class="row contact_rw">
                <div class="col-lg-7 contct_frm_col">
                    <div class="main_contct_frm">
                        <div class="contct_frm_hdr">
                            <div class="sec_head">
                                <h2><?php the_field('get_in_touch_title'); ?></h2>
                                <p><?php the_field('get_in_touch_details'); ?></p>
                            </div>
                        </div>
                        <div class="main_contct_frm_wrap">
                            <?php
                            $form_shortcode = get_field('form_shortcode');
                                echo do_shortcode($form_shortcode);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 contct_info_col">
                    <div class="contct_info_wrap">
                        <h3><?php the_field('contact_us_title'); ?></h3>
                        <ul>
                            <li>
                                <div class="contct_icon"><i><img src="<?php echo get_template_directory_uri(); ?>/images/loca.svg" alt=""></i></div>
                                <div class="contct_txt">
                                    <h5><?php the_field('address_title'); ?></h5>
                                    <p><?php the_field('contact_us_address'); ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="contct_icon"><i><img src="<?php echo get_template_directory_uri(); ?>/images/loca.svg" alt=""></i></div>
                                <div class="contct_txt">
                                    <h5><?php the_field('another_address_title'); ?></h5>
                                    <p><?php the_field('contact_another_add'); ?></p>
                                </div>
                            </li>
                            <li>
                                <div class="contct_icon"><i><img src="<?php echo get_template_directory_uri(); ?>/images/call1.svg" alt=""></i></div>
                                <div class="contct_txt">
                                    <h5><?php the_field('phone_title'); ?></h5>
                                    <?php $contact_phone = preg_replace("/[^0-9]/", "",  get_field('contact_us_phone'));?>
                                    <a href="tel:+1<?php echo $contact_phone; ?>"><?php the_field('contact_us_phone'); ?></a>
                                </div>
                            </li>
                            <li>
                                <div class="contct_icon"><i><img src="<?php echo get_template_directory_uri(); ?>/images/mail.svg" alt=""></i></div>
                                <div class="contct_txt">
                                    <h5><?php the_field('email_title'); ?></h5>
                                    <a href="mailto:<?php the_field('contact_us_email'); ?>"><?php the_field('contact_us_email'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact form section end -->

<?php get_footer(); ?>