<?php
/*
Template Name: Home
*/
get_header();
 ?>


    <!-- banner section -->
    <div class="main_wrapper newHome">
        <div class="banner_main_wraper">
            <div class="banner_slider swiper-wrapper">
            <?php
                if( have_rows('banner_slider') ) {
                while( have_rows('banner_slider') ) { the_row();
                    $banner_image = get_sub_field('banner_image');
                    if($banner_image){
                    $banner_title = get_sub_field('banner_title');
                    $banner_description = get_sub_field('banner_description');
                    $banner_contact_us_link = get_sub_field('banner_contact_us_link');
                    $banner_shop_link = get_sub_field('banner_shop_link');
                    
            ?>
                <div class="swiper-slide ban_item">
                    <div class="ban_in_con">
                        <figure class="ban_slide_img">
                            <img src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_image['alt']; ?>">
                        </figure>
                        <div class="banner_outer">
                            <div class="container">
                                <div class="ban_contant">
                                    <h1 class="title_one"><?php echo $banner_title; ?></h1>
                                    <p class="ban_para">
                                        <?php echo $banner_description; ?>
                                    </p>
                                    <div class="ban_btn">
                                    <?php if($banner_contact_us_link){ ?>
                                        <a class="cmn_btn" href="<?php echo $banner_contact_us_link['url']; ?>"><?php echo $banner_contact_us_link['title']; ?></a>
                                    <?php }
                                        if($banner_shop_link){
                                    ?>
                                        <a class="cmn_btn" href="<?php echo $banner_shop_link['url']; ?>"><?php echo $banner_shop_link['title']; ?></a>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                    }
                }
            }
            ?>

            </div>
            <ul class="banner_arrow">
                <li class="prev_arrow slider_arrow "><i class="fas fa-chevron-left"></i></li>
                <li class="next_arrow slider_arrow"><i class="fas fa-chevron-right"></i></li>
            </ul>
        </div>
        <div class="swiper-pagination"></div>
    </div>


    <!-- our product section -->
    <div class="our_product_wraper cmn_gap pb-0">
        <div class="container">
            <div class="sec_head">
                <h2>Our Products</h2>
            </div>
            <div class="row product_row home_product_slider">
            <?php
                $src = '';
                $args = array(
                    'post_type'  => 'product',
                    'posts_per_page'  => 3,
                    'order' => 'ASC',
                    'post_status' => 'publish'
                );
                $query = new WP_Query( $args );
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post(); 
                        $post_id = get_the_ID();
                        $src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large', false, '' );
                        $img_id = get_post_thumbnail_id($post_id);
                        $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
            ?>
                <div class="col-lg-4 col-md-6 product_column">
                    <div class="product_card">
                        <div class="product_slider">
                            <div class="product_item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if($src){ ?>
                                    <figure>
                                        <img src="<?php echo $src[0]; ?>" alt="<?php echo $alt_text; ?>">
                                    </figure>
                                    <?php } ?>
                                </a>
                            </div>
                            <?php
                                global $product;
                                $attachment_ids = $product->get_gallery_image_ids();
                                $src = '';
                                foreach( $attachment_ids as $attachment_id ) {
                                    $src = wp_get_attachment_image_src( $attachment_id, 'large', false, '' );
                                    $img_id = get_post_thumbnail_id($attachment_id);
                                    $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
                                    if($src){
                                        ?>
                                        <div class="product_item">
                                            <figure>
                                                <img src="<?php echo $src[0]; ?>" alt="<?php echo $alt_text; ?>">
                                            </figure>                            
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                        <div class="product_bt_con">
                            <a href="<?php the_permalink(); ?>"><p class="product_title"><?php the_title(); ?></p></a>
                            <div class="priceWrap">
                                <?php echo $product->get_price_html(); ?>
                            </div>
                            <div class="prduct_cart_wrap">
                                <div class="product_quantity qty-container">
                                    <button type="button" class="qty-btn-minus" data-id="<?php echo get_the_ID(  );?>">-</button>
                                    <input type="number" value="1" data-id="<?php echo get_the_ID();?>" class="Pcount input-qty_<?php echo get_the_ID(); ?> qty_item_<?php echo get_the_ID(); ?>">
                                    <button type="button" class="qty-btn-plus" data-id="<?php echo get_the_ID();?>">+</button>
                                </div>
                                <!-- <a class="cmn_btn" href="#url">ADD To Cart</a> -->
                                <div>
                                    <?php  
                                        echo sprintf( '<a href="%s" data-quantity="1" class="%s" %s>Add to Cart</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( implode( ' ', array_filter( array(
                                                'add-btn', 'cmn_btn','home_prod_add_cart_' . $product->get_ID(),'product_type_' . $product->get_type(),
                                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                            ) ) ) ),
                                            wc_implode_html_attributes( array(
                                                'data-product_id'  => $product->get_id(),
                                                'data-product_sku' => $product->get_sku(),
                                                'aria-label'       => $product->add_to_cart_description(),
                                                'rel'              => 'nofollow',
                                            ) ),
                                            esc_html( $product->add_to_cart_text() )
                                        ); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } } wp_reset_query(); ?>

            </div>

            <div class="slide-number"> 1<span> of </span>3 </div>

        </div>
    </div>


    <!-- benefits section start -->
    <div class="benefit_sec cmn_gap pt-0">
        <div class="why_main">
            <div class="container">
                <div class="why_hdr_wrap">
                    <div class="sec_head">
                        <div class="subTitle_wrap">
                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/bar.svg" alt=""></span>
                            <h5 class="extra_style_smllHdr"><?php the_field('benefits_title'); ?></h5>
                        </div>
                        <h2><?php the_field('benefits_heading'); ?></h2>
                    </div>
                    <div class="why_hdr_txt">
                        <p><?php the_field('benefits_description'); ?></p>
                    </div>
                </div>

                <div class="why_item_wrap">
                    <div class="why_rw">
                    <?php
                        if( have_rows('benefits_list') ) {
                        while( have_rows('benefits_list') ) { the_row();
                            $image = get_sub_field('image');
                            if($image){
                            $title = get_sub_field('title');
                            $description = get_sub_field('description');
                    ?>
                        <div class="why_item_col">
                            <div class="why_item">
                                <span class="item_icon"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></span>
                                <h4><?php echo $title; ?></h4>
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>
                    <?php } } } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mission_main">
            <div class="container">
                <div class="mission_wrap">
                    <div class="mission_content">
                        <div class="sec_head">
                            <h2><?php the_field('mission_statement_title'); ?></h2>
                        </div>
                        <?php the_field('mission_statement_description'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- benefits section end -->



    <!-- about section start -->
    <div class="about_sec cmn_gap">
        <div class="container">
            <div class="row pallets_rw cntr_algn">
                <div class="col-lg-6 pallets_img_col">
                <?php
                    $about_us_main_image = get_field('about_us_main_image');
                    if($about_us_main_image){
                    $about_us_image = get_field('about_us_image');
                ?>
                    <div class="pallets_img_wrap">
                        <figure><img src="<?php echo $about_us_main_image['url']; ?>" alt="<?php echo $about_us_main_image['alt']; ?>"></figure>
                        <div class="pallets_img_smll">
                            <img src="<?php echo $about_us_image['url']; ?>" alt="<?php echo $about_us_image['alt']; ?>">
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="col-lg-6 pallets_txt_col">
                    <div class="pallets_content">
                        <div class="sec_head">
                            <div class="subTitle_wrap">
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/bar.svg" alt=""></span>
                                <h5 class="extra_style_smllHdr"><?php the_field('about_us_title'); ?></h5>
                            </div>
                            <h2><?php the_field('about_us_heading'); ?></h2>
                        </div>
                        <?php the_field('about_us_description'); ?>
                        <?php 
                            $shop_link = get_field('about_us_shop_link'); 
                            if($shop_link){
                        ?>
                        <a href="<?php echo $shop_link['url']; ?>" class="cmn_btn"><?php echo $shop_link['title']; ?></a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about section end -->


    <!-- our clint section -->
    <div class="our_clint_wrap cmn_gap pt-0">
        <div class="container">
            <div class="sec_head">
                <h5 class="extra_style_smllHdr">OUR CLIENTS</h5>
            </div>
            <div class="our_clint_slider">
            <?php
                if( have_rows('our_client_list') ) {
                while( have_rows('our_client_list') ) { the_row();
                    $our_client_image = get_sub_field('our_client_image');
                    if($our_client_image){
            ?>
                <div class="our_clint_item">
                    <figure>
                        <img src="<?php echo $our_client_image['url']; ?>" alt="<?php echo $our_client_image['alt']; ?>">
                    </figure>
                </div>
            <?php } } } ?>

            </div>
        </div>
    </div>


    <!-- track section start -->
    <div class="track_sec">
        <span class="teck_dots"><img src="<?php echo get_template_directory_uri(); ?>/images/dot3.svg" alt=""></span>
    <?php
        $imag = get_field('track_mats_&_sheets_image');
        if($imag){
    ?>
        <div class="track_main_img">
            <figure><img src="<?php echo $imag['url']; ?>" alt="<?php echo $imag['alt']; ?>"></figure>
        </div>
    <?php } ?>
        <div class="track_txt_main">
            <div class="container">
                <div class="track_content">
                    <div class="sec_head">
                        <div class="subTitle_wrap">
                            <span><img src="<?php echo get_template_directory_uri(); ?>/images/bar.svg" alt=""></span>
                            <h5 class="extra_style_smllHdr"><?php the_field('track_mats_&_sheets_title'); ?></h5>
                        </div>
                        <h2><?php the_field('track_mats_&_sheets_heading'); ?></h2>
                    </div>
                    <p><?php the_field('track_mats_&_sheets_details'); ?></p>
                <?php
                    $shop_link = get_field('track_mats_&_sheets_shop_link');
                    if($shop_link){
                ?>
                    <a href="<?php echo $shop_link['url']; ?>" class="cmn_btn"><?php echo $shop_link['title']; ?></a>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- track section end -->


    <!-- pallets section start -->
    <div class="pallets_sec">
        <div class="container">
            <div class="row pallets_rw cntr_algn">
                <div class="col-lg-6 pallets_img_col">
                    <?php
                        $plastic_pallets_img = get_field('plastic_pallets_main_image');
                        if($plastic_pallets_img){
                        $plastic_pallets_image = get_field('plastic_pallets_image');
                    ?>
                    <div class="pallets_img_wrap">
                        <figure><img src="<?php echo $plastic_pallets_img['url']; ?>" alt="<?php echo $plastic_pallets_img['alt']; ?>"></figure>
                        <div class="pallets_img_smll">
                            <img src="<?php echo $plastic_pallets_image['url']; ?>" alt="<?php echo $plastic_pallets_image['alt']; ?>">
                        </div>
                    </div>
                <?php } ?>
                </div>
                <div class="col-lg-6 pallets_txt_col">
                    <div class="pallets_content">
                        <div class="sec_head">
                            <div class="subTitle_wrap">
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/bar.svg" alt=""></span>
                                <h5 class="extra_style_smllHdr"><?php the_field('plastic_pallets_title'); ?></h5>
                            </div>
                            <h2><?php the_field('plastic_pallets_heading'); ?></h2>
                        </div>
                        <p><?php the_field('plastic_pallets_description'); ?> </p>
                    <?php
                        $shopNow_link = get_field('plastic_pallets_shop_link');
                        if($shopNow_link){
                    ?>
                        <a href="<?php echo $shopNow_link['url']; ?>" class="cmn_btn"><?php echo $shopNow_link['title']; ?></a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pallets section end -->




    
    <!-- contact section start -->
    <div class="contact_sec cmn_gap">
        <div class="container">
            <div class="row contct_rw">
                <div class="col-lg-6 contct_col">
                    <div class="contct_txt_wrap">
                        <div class="sec_head">
                            <div class="subTitle_wrap">
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/bar.svg" alt=""></span>
                                <h5 class="extra_style_smllHdr"><?php the_field('contact_us_title'); ?></h5>
                            </div>
                            <h2><?php the_field('contact_us_heading'); ?></h2>
                        </div>
                        <ul>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/msg.svg" alt=""></span>
                                <a href="mailto:<?php the_field('contact_us_email'); ?>"><?php the_field('contact_us_email'); ?></a>
                            </li>
                            <li>
                                <?php $phone = preg_replace("/[^0-9]/", "",  get_field('contact_us_number')); ?>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/call.svg" alt=""></span>
                                <a href="tel:+1<?php echo $phone; ?>"><?php the_field('contact_us_number'); ?></a>
                            </li>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/location.svg" alt=""></span>
                                <p><?php the_field('contact_us_address'); ?></p>
                            </li>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/location.svg" alt=""></span>
                                <p><?php the_field('contact_another_address'); ?></p>
                            </li>
                            <li>
                                <span><img src="<?php echo get_template_directory_uri(); ?>/images/clock.svg" alt=""></span>
                                <p><?php the_field('contact_us_weekly_open'); ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 contct_col">
                    <div class="contct_frm_main">
                        <div class="contct_frm_wrap">
                            <h4><?php the_field('contact_us_form_title'); ?></h4>
                            <?php
                                echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact section end -->


<?php get_footer(); ?>