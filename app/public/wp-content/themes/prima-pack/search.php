<?php

get_header();
?>

<div class="pro-page-inner-sec common-gap">
	<div class="container">
        <div class="ptit"><h3>Our Products</h3></div>
		<div class="row pro-page-inner-rw">
		<?php
		$args = array(
		'post_type'        => 'product',
		'posts_per_page'   => -1,
         's'      =>     $_GET['s'],
		'post_status'      => 'publish',
		);
		$query = new WP_Query( $args ); 
		if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
				$query->the_post();

				$imageSrc = get_the_post_thumbnail_url();
                $image_id = get_post_thumbnail_id();
                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);  
		?>
			<div class="col-lg-4 col-md-6 product_column">
                    <div class="product_card">
                        <div class="product_slider">
                        	<a href="<?php the_permalink(); ?>">
	                            <div class="product_item">
	                                <figure>
	                                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $image_alt; ?>">
	                                </figure>
	                            </div>
                        	</a>
                            <?php
                                global $product;
                                $attachment_ids = $product->get_gallery_image_ids();

                                foreach( $attachment_ids as $attachment_id ) {
                                    $image_link = wp_get_attachment_url( $attachment_id );
                            ?>
                            <div class="product_item">
                                <figure>
                                    <img src="<?php echo $image_link; ?>" alt="">
                                </figure>                            
                            </div>
                            <?php } ?>
                        </div>
                        <div class="product_bt_con">
                            <a href="<?php the_permalink(); ?>"><p class="product_title"><?php the_title(); ?></p></a>
                            <div class="prduct_cart_wrap">
                                <div class="product_quantity qty-container">
                                    <button type="button" class="qty-btn-minus" data-id="<?php echo get_the_ID(  );?>">-</button>
                                    <input type="number" value="1" data-id="<?php echo get_the_ID();?>" class="Pcount input-qty_<?php echo get_the_ID(  ); ?> qty_item_<?php echo get_the_ID(); ?>">
                                    <button type="button" class="qty-btn-plus" data-id="<?php echo get_the_ID(  );?>">+</button>
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
		<?php
			}
		}else{
		?>
		<div class="error-not-found">
			<h5 class="no-found">Nothing Found!</h5>
			<p class="sorr-error">Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
		</div>
		<?php
		}
		wp_reset_query();
		?>      
		</div>
	</div>
</div>

<?php
get_footer();