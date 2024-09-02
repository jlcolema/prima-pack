<?php

function prima_pack(){
    wp_enqueue_style( 'all.min', get_template_directory_uri() . '/css/all.min.css' );
    wp_enqueue_style( 'brands.min', get_template_directory_uri() . '/css/brands.min.css' );
    wp_enqueue_style( 'fontawesome.min', get_template_directory_uri() . '/css/fontawesome.min.css' );
    wp_enqueue_style( 'regular.min', get_template_directory_uri() . '/css/regular.min.css' );
    wp_enqueue_style( 'solid.min', get_template_directory_uri() . '/css/solid.min.css' );
    wp_enqueue_style( 'slick.min', get_template_directory_uri() . '/css/slick.min.css' );
    wp_enqueue_style( 'bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'swiper', '//cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css?v=19' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-bundle-min', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'swiper-bundle', '//cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'commonjs', get_template_directory_uri() . '/js/common.js', array(), '2.0.0', true );

    wp_enqueue_script('currency-switcher-js', get_template_directory_uri() . '/js/currency-switcher.js', array('jquery'), null, true);
    wp_localize_script('currency-switcher-js', 'currencySwitcher', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('currency_switcher_nonce')
    ));

    if(!isset($_COOKIE['user_country'])) {
        wp_enqueue_script( 'sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), '1.0.0', true );
        wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, true);
        wp_localize_script( 'custom', 'frontendajax', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce('ajax-nonce')
        ));
    }
}
add_action( 'wp_enqueue_scripts', 'prima_pack');



if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(
        array(
            'page_title'    => 'Theme General Option',
            'menu_title'    => 'Theme Option',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => '',
            'redirect'      => false
        )
    );

    acf_add_options_sub_page(
        array(
            'page_title'    => 'Theme Header Option',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        )
    );

    acf_add_options_sub_page(
      array(
        'page_title'    => 'Bulk Orders',
        'menu_title'    => 'Bulk Orders',
        'parent_slug'   => 'theme-general-settings',
      )
    );

    acf_add_options_sub_page(
        array(
            'page_title'    => 'Theme Footer Option',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        )
    );
}

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

register_nav_menu('header-menu', 'Header menu');
register_nav_menu('footer-menu', 'Footer menu');


//woocommerce
add_theme_support( 'woocommerce' );

// add to cart
add_filter( 'woocommerce_add_to_cart_fragments', function($fragments) {
    global $woocommerce;
    ob_start();
?>
    <a id='mini-cart-count' href="<?php echo wc_get_cart_url(); ?>" class="carticon">
      <span><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></span>
    </a>
<?php
    $fragments['#mini-cart-count'] = ob_get_clean();
    return $fragments;
} );


//sale_flash remove
add_filter('woocommerce_sale_flash', 'avada_hide_sale_flash');
function avada_hide_sale_flash()
{
return false;
}

//add more info button
add_action('woocommerce_after_shop_loop_item', 'add_a_custom_button', 10 );
function add_a_custom_button() { ?>

<a href="<?php the_permalink(); ?>" class="product__view-details">View Details</a>
<?php
}

add_action('woocommerce_after_shop_loop_item', 'add_a_custom_button_after', 10 );
function add_a_custom_button_after(){ ?>
</div>
<?php
}

//remove sidebar
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

//product-gallery-zoom
add_action( 'after_setup_theme', 'yourtheme_setup' );
function yourtheme_setup(){
    add_theme_support( 'wc-product-gallery-slider' );
    //add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
}


//add price text
// add_action('woocommerce_single_product_summary','add_after_price',9);
function add_after_price(){ ?>
<h5>Price:</h5>
<?php
}


remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',20);
//add Description,Features,Comparison
add_action('woocommerce_single_product_summary','add_after_content',11);
function add_after_content(){
  session_start();
    $product_id = get_the_ID();
    ?>
<div class="accordion faq-detail-sec" id="accordionExample">
  <?php
  $i = 0;
  if( have_rows('products_details',$product_id) ) {
    while( have_rows('products_details',$product_id) ) { the_row();
        $title = get_sub_field('title',$product_id);
        $description = get_sub_field('description',$product_id);
  ?>
    <div class="accordion-item">
        <h3 class="accordion-header" id="heading<?php echo $i; ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                <?php echo $title; ?>
            </button>
        </h3>
        <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 0){ echo 'show';} ?>"
            aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?php echo $description; ?>
                <?php
                 // $getcountry = 'USA';
                if(IPtoLocation() == 'Canada'){
                  echo '<p><strong style="font-weight: 800;">'. get_field('canada_description_point',$product_id).'</strong></p>';
                }else {
                  echo '<p><strong style="font-weight: 800;">'. get_field('usa_description_point',$product_id).'</strong></p>';
                }
                ?>
            </div>
        </div>
    </div>
  <?php
  $i++;
      }
  }
  ?>
</div>




<?php
}


remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
//add Shipping Information
add_action('woocommerce_single_product_summary','add_shipping_info',31);
function add_shipping_info(){
    $product_id = get_the_ID();
    ?>
<h5><?php the_field('shipping_information_title',$product_id); ?></h5>


    <div class="accordion faq-detail-sec shipping_faq" id="accordionExampletwo">
      <?php
        $j = 5;
        if( have_rows('shipping_information',$product_id) ) {
          while( have_rows('shipping_information',$product_id) ) { the_row();
              $title = get_sub_field('shipping_information_heading',$product_id);
              $description = get_sub_field('shipping_information_description',$product_id);
      ?>
        <div class="accordion-item">
            <h3 class="accordion-header" id="heading<?php echo $j; ?>">
                <button class="accordion-button <?php if($j>5){echo 'collapsed';} ?>" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse<?php echo $j; ?>" aria-expanded="<?php ($j==5)? false:true; ?>" aria-controls="collapse<?php echo $j; ?>">
                    <?php echo $title; ?>
                </button>
            </h3>
            <div id="collapse<?php echo $j; ?>" class="accordion-collapse collapse <?php if($j==5){echo 'show';} ?>"
                aria-labelledby="heading<?php echo $j; ?>" data-bs-parent="#accordionExampletwo">
                <div class="accordion-body">
                    <?php echo $description; ?>
                </div>

            </div>
        </div>
      <?php $j++; } } ?>
    </div>

<?php
}






/* Show Buttons */
add_action( 'woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus' );

function bbloomer_display_quantity_plus() {
   echo '<button type="button" class="plus">+</button>';
}

add_action( 'woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus' );

function bbloomer_display_quantity_minus() {
   echo '<button type="button" class="minus">-</button>';
}

// 2. Trigger update quantity script

add_action( 'wp_footer', 'bbloomer_add_cart_quantity_plus_minus' );

function bbloomer_add_cart_quantity_plus_minus() {

   if ( ! is_product() && ! is_cart() ) return;

   wc_enqueue_js( "

      $(document).on( 'click', 'button.plus, button.minus', function() {

         var qty = $( this ).parent( '.quantity' ).find( '.qty' );
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr( 'max' ));
         var min = parseFloat(qty.attr( 'min' ));
         var step = parseFloat(qty.attr( 'step' ));

         if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
               qty.val( max ).change();
            } else {
               qty.val( val + step ).change();
            }
         } else {
            if ( min && ( min >= val ) ) {
               qty.val( min ).change();
            } else if ( val > 1 ) {
               qty.val( val - step ).change();
            }
         }

      });

   " );
}


add_action( 'init', 'IPtoLocation' );
function IPtoLocation(){
    // session_start();
    // // // session_destroy();
    // if(empty($_SESSION['country'])){
    //     // $curl_handle=curl_init();
    //     // curl_setopt($curl_handle,CURLOPT_URL,'http://www.geoplugin.net/php.gp?ip=185.80.221.235');
    //     // curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
    //     // curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
    //     // $buffer = curl_exec($curl_handle);
    //     // curl_close($curl_handle);
    //     // if (empty($buffer)){
    //     //     print "Nothing returned from url.<p>";
    //     // }
    //     // else{
    //     //     print $buffer;
    //     //     $country = $buffer;
    //     //     $_SESSION['country'] = $country;
    //     // }
    //     $ip = $_SERVER['REMOTE_ADDR'];
    //     $access_key = 'a58b496f7fc6cb0eaf42eeec635edc92';
    //     $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $json = curl_exec($ch);
    //     curl_close($ch);
    //     $api_result = json_decode($json, true);
    //     $_SESSION['country']= $api_result['country_name'];
    //     $country = $_SESSION['country'];
    // }else{
    //     $country = $_SESSION['country'];
    // }
    // print_r($country);
    if(isset($_COOKIE['user_country'])) {
        $country = $_COOKIE['user_country'];
    }
    return $country;
}


//add Question
add_action( 'woocommerce_after_single_product_summary' , 'bbloomer_add_below_prod_gallery', 5 );
function bbloomer_add_below_prod_gallery() {
    $product_id = get_the_ID();
?>
  <div class="question-wrap">
    <h4><?php the_field('have_a_question_title',$product_id); ?></h4>
    <?php $call = get_field('give_us_a_call',$product_id);?>
    <a href="<?php echo $call['url']; ?>"><?php echo $call['title']; ?></a>
  </div>
<?php
}

//add shop page price
function wptips_custom_html_addon_to_price( $price, $product ) {
  $html_price_prefix = '<span class="price-prefix sr-only">Price:</span>';

  // $getcountry = 'USA';
  $product_id = $product->get_id();
  // print_r($product);

  if(IPtoLocation() == 'Canada'){
    $canada_price = get_field('can_price', $product_id);
    $price_html = '<span class="woocommerce-Price-amount amount 12"><bdi><span class="woocommerce-Price-currencySymbol">CA$</span>'.$canada_price.'</bdi></span>';
     $price = $html_price_prefix . ' ' . $price_html;

  }else{
    $usa_price = get_field('us_price', $product_id);
    $price_html = '<span class="woocommerce-Price-amount amount 11"><bdi><span class="woocommerce-Price-currencySymbol">$</span>'.$usa_price.'</bdi></span>';
     $price = $html_price_prefix . ' ' . $price_html;
  }

    return $price;
}
add_filter( 'woocommerce_get_price_html', 'wptips_custom_html_addon_to_price', 999, 2 );

//remove default sotting and show in result
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//remove breadcrumb
add_action('woocommerce_before_main_content', 'remove_page_breadcrumbs' );
function remove_page_breadcrumbs(){
    if (is_shop('24'))
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}



add_action( 'woocommerce_product_options_pricing', 'quadlayers_add_country_price_box' );

function quadlayers_add_country_price_box() {

    woocommerce_wp_text_input(
        array('id' => 'can_price',
            'class' => 'wc_input_price_extra_info short',
           'label' => __( 'Price in Canada(CA$)', 'woocommerce' ),
        )
    );
     woocommerce_wp_text_input(
        array('id' => 'can_discount_price',
            'class' => 'wc_input_price_extra_info short',
           'label' => __( 'Discount Price in Canada(CA$)', 'woocommerce' ),
        )
    );
    woocommerce_wp_text_input(
        array('id' => 'max_quantity',
            'class' => 'wc_input_price_extra_info short',
           'label' => __( 'Maximum Quantity', 'woocommerce' ),
        )
    );

    woocommerce_wp_text_input(
        array('id' => 'us_price',
            'class' => 'wc_input_price_extra_info short',
            'label' => __( 'Price in USA($)', 'woocommerce' ),
        )
    );

    woocommerce_wp_text_input(
        array('id' => 'max_quantity_us',
            'class' => 'wc_input_price_extra_info short',
            'label' => __( 'Max Quantity For Free Shipping In US', 'woocommerce' ),
        )
    );
}

add_action( 'woocommerce_process_product_meta', 'quadlayers_save_country_price', 2, 2 );
function quadlayers_save_country_price( $post_id, $post ) {
  if ( ! empty( $_POST['can_price'] ) ) {
    update_post_meta( $post_id, 'can_price', stripslashes( $_POST ['can_price'] ) );
  }
 if ( ! empty( $_POST['can_discount_price'] ) ) {
    update_post_meta( $post_id, 'can_discount_price', stripslashes( $_POST ['can_discount_price'] ) );
  }
  if ( ! empty( $_POST['max_quantity'] ) ) {
    update_post_meta( $post_id, 'max_quantity', stripslashes( $_POST ['max_quantity'] ) );
  }


  if ( ! empty( $_POST['us_price'] ) ) {
    update_post_meta( $post_id, 'us_price', stripslashes( $_POST ['us_price'] ) );
  }
  if ( ! empty( $_POST['max_quantity_us'] ) ) {
    update_post_meta( $post_id, 'max_quantity_us', stripslashes( $_POST ['max_quantity_us'] ) );
  }
}

// if ( ! is_admin() ) {
//   add_filter( 'woocommerce_product_get_price', 'quadlayers_change_price', 10, 2 );
//   function quadlayers_change_price( $price, $product ) {
//     session_start();
//     global $woocommerce;
//     // $customer_country = $woocommerce->customer->get_billing_country();
//     if($_SESSION["curusercuntry"]=='United States'){
//       return get_post_meta( $product->id, 'us_price', true );
//     }else if($_SESSION["curusercuntry"]=='Canada'){
//       $can_price = $product->get_meta( 'can_price', true );
//       return $can_price;
//     }
//     return $price;
//   }
// }

// function set_currency_programmatically($selected_currency) {
//   session_start();
//   // Use the usercountry api here to find the currency.
//   global $woocommerce;
//   $selected_currency = 'USD';
//   // $customer_country = $woocommerce->customer->get_billing_country();
//   if($_SESSION["curusercuntry"]=='United States'){
//     $selected_currency = 'USD';
//   }
//   if($_SESSION["curusercuntry"]=='Canada'){
//     $selected_currency = 'CAD';
//   }
//   return $selected_currency;
// }
// add_filter('wc_aelia_cs_selected_currency', 'set_currency_programmatically', 0);


// add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
// function change_existing_currency_symbol( $currency_symbol, $currency ) {
//   session_start();
//   global $woocommerce;
//   $selected_currency_code = '$';
//   // $customer_country = $woocommerce->customer->get_billing_country();
//   if($_SESSION["curusercuntry"]=='United States'){
//     $selected_currency_code = '$';
//   }
//   if($_SESSION["curusercuntry"]=='Canada'){
//     $selected_currency_code = 'CA$';
//   }
//   return $selected_currency_code;
// }



//price change
add_action( 'wp_footer', 'add_cart_quantity');

function add_cart_quantity() {
 $product_id = get_the_ID();
?>
<script type="text/javascript">
  var product_id = '<?php echo $product_id; ?>';
   // var get_country = 'USA';
  // console.log(product_id);

  var max_quantity = '<?php echo get_field('max_quantity', $product_id); ?>';
  // console.log(max_quantity);
    let IPtoLocation = '<?php echo IPtoLocation(); ?>';

    jQuery(document).on('click', 'button.plus', function() {
        var qty = jQuery('.input-text').val();
        var qty_vall = parseInt(qty)+1;


        if(IPtoLocation == 'Canada'){
            var can_discount_price = '<?php echo get_field('can_discount_price', $product_id); ?>';
            var currency = 'CA$';
        }else{
            var can_discount_price = '<?php echo get_post_meta( $product_id, '_price', true);?>'
            var currency = '$';
        }
        if(qty_vall >= parseInt(max_quantity)){
          // console.log(can_discount_price);
          jQuery('.amount').html('');
          jQuery('.amount').html('<bdi><span class="woocommerce-Price-currencySymbol">'+currency+'</span>'+can_discount_price+'</bdi>');
        }
    });



    jQuery(document).on('click','button.minus', function() {
        var qty_pro = jQuery('.input-text').val();
        var qty_val = parseInt(qty_pro)-1;

        if(IPtoLocation == 'Canada'){
            var can_price = '<?php echo get_field('can_price', $product_id); ?>';
            var currency = 'CA$';
        }else{
            var can_price = '<?php echo get_post_meta( $product_id, '_price', true);?>'
            var currency = '$';
        }

        if( qty_val < parseInt(max_quantity)) {
          jQuery('.amount').html('');
          jQuery('.amount').html('<bdi><span class="woocommerce-Price-currencySymbol">'+currency+'</span>'+can_price+'</bdi>');
        }
    });


    jQuery(document).on('change','woocommerce-cart.input-text', function() {
        var qtyv = jQuery('.input-text').val();
        var qty_valp = parseInt(qtyv)+1;

        if(IPtoLocation == 'Canada'){
          var can_price = '<?php echo get_field('can_price', $product_id); ?>';
          var can_discount_price = '<?php echo get_field('can_discount_price', $product_id); ?>';
          var currency = 'CA$';

          if( qty_valp >= parseInt(max_quantity)) {
            jQuery('.amount').html('');
            jQuery('.amount').html('<bdi><span class="woocommerce-Price-currencySymbol">'+currency+'</span>'+can_discount_price+'</bdi>');
          }else{
            jQuery('.amount').html('');
            jQuery('.amount').html('<bdi><span class="woocommerce-Price-currencySymbol">'+currency+'</span>'+can_price+'</bdi>');
          }

        }else{
          var can_pricer = '<?php echo get_post_meta( $product_id, '_price', true);?>';
          var currency = '$';
          jQuery('.amount').html('');
          jQuery('.amount').html('<bdi><span class="woocommerce-Price-currencySymbol">'+currency+'</span>'+can_pricer+'</bdi>');
        }
    });
</script>

<?php
}


//updated in cart price
add_action('woocommerce_before_calculate_totals', 'change_cart_item_quantities', 20, 1 );
function change_cart_item_quantities ( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // $getcountry = 'USA';
    // Checking cart items
    foreach( $cart->get_cart() as $cart_item_key => $cart_item ) {

        $product = $cart_item['data'];
        $product_id = $product->get_id();

        if (IPtoLocation() == 'Canada') {
          $currency = 'CA$';
          // print_r($product_id);
            $quantity = $cart_item['quantity'];
            $max_quantity = get_field('max_quantity', $product_id);

            if($quantity >= $max_quantity){
            $price = get_field('can_discount_price', $product_id);
            } else{
            $price = get_field('can_price', $product_id);
            }

            $cart_item['data']->set_price( $price );
            // $cart->set_currency( $cart_item_key, $currency );
            $cart->set_quantity( $cart_item_key, $quantity );
        }else{
          $currency = '$';
        }
    }
}


add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // $getcountry = 'USA';
    if(IPtoLocation() == 'Canada'){
        $currency_symbol = 'CA$';

    }else{
        $currency_symbol = '$';
    }
    return $currency_symbol;
}


// related_products
add_filter( 'woocommerce_related_products', 'bbloomer_related_products_by_same_title', 9999, 3 );
function bbloomer_related_products_by_same_title( $related_posts, $product_id, $args ) {
   // $product = wc_get_product( $product_id );
   // $title = $product->get_name();
   $related_posts = get_posts( array(
      'post_type' => 'product',
      'post_status' => 'publish',
      'posts_per_page' => 3,
      'orderby' => 'rand'
      // 'exclude' => array( $product_id ),
   ));
   return $related_posts;
}

add_filter( 'woocommerce_package_rates', 'disable_shipping_method_based_on_postcode', 10, 2 );
function disable_shipping_method_based_on_postcode( $rates, $package ) {
    foreach( $package['contents'] as $cart_item ) {
        $max_quantity += get_post_meta( $cart_item['product_id'], 'max_quantity_us', true );
        $quantity += $cart_item['quantity'];
    }
    $country = array( 'US' );
    if( in_array( $package['destination']['country'], $country ) ){
        if ( $quantity >= 33 ) {
            $free = array();
            foreach ( $rates as $rate_id => $rate ) {
                if ( 'free_shipping' === $rate->method_id ) {
                    $free[ $rate_id ] = $rate;
                    break;
                }
            }
            return !empty( $free ) ? $free : $rates;
        }else{
            unset($rates['free_shipping:10']);
            return $rates;
        }
    }
}



add_filter( 'woocommerce_available_payment_gateways', 'bbloomer_payment_gateway_disable_country' );
function bbloomer_payment_gateway_disable_country( $payment_gateways ) {

    if ( is_admin() ) return $payment_gateways;
    if ( is_checkout() ) {
        // Get country
        $customer_country = WC()->customer->get_shipping_country() ? WC()->customer->get_shipping_country() : WC()->customer->get_billing_country();

        // Country = US
        if ( in_array( $customer_country, array( 'US' ) ) ) {
            // Cod
            if ( isset( $payment_gateways['cod'] ) ) {
                unset( $payment_gateways['cod'] );
            }
        }

        $minimum = 100;
        if ( WC()->cart->total < $minimum ) {
            unset( $payment_gateways['stripe_cc'] );
        }
    }
    return $payment_gateways;
}

add_action('wp_ajax_nopriv_set_country', 'set_country');
add_action('wp_ajax_set_country', 'set_country');
function set_country() {
    if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        die ( 'Busted!');
    }
    $country = $_POST['country'];
    if($country){
        setcookie('user_country', $country, time() + (86400 * 30), "/");
        echo json_encode(array('status' => 'success'));
	    exit;
    }
}

// New home script
function new_home_script_footer() {
    ?>
    <script>
        function initProductSlider() {
            var $product_slider = jQuery('.home_product_slider');
            $product_slider.slick({
                dots: false,
                arrows: true,
                infinite: true,
                variableWidth: false,
                slidesToShow: 1,
                accessibility: false,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style="">Previous</button>',
                nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button" style="">Next</button>'
            });
            $product_slider.on('init afterChange', function (event, slick, currentSlide) {
                var currentSlideNumber = currentSlide + 1;
                var totalSlides = slick.slideCount;
                if (!isNaN(currentSlideNumber) && !isNaN(totalSlides)) {
                    var numberingText = currentSlideNumber + ' of ' + totalSlides;
                    jQuery('.slide-number').text(numberingText);
                }
            });
        }
        if (window.matchMedia('(max-width: 768px)').matches) {
            initProductSlider();
        }
    </script>
    <?php
}
add_action('wp_footer', 'new_home_script_footer', 9999);


// Add Meta Pixel code to the header
function add_meta_pixel_code() {
    ?>
    <!-- Meta Pixel Code -->
        <script>

        !function(f,b,e,v,n,t,s)

        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?

        n.callMethod.apply(n,arguments):n.queue.push(arguments)};

        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

        n.queue=[];t=b.createElement(e);t.async=!0;

        t.src=v;s=b.getElementsByTagName(e)[0];

        s.parentNode.insertBefore(t,s)}(window, document,'script',

        'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '995533745068186');

        fbq('track', 'PageView');

        </script>

        <noscript><img height="1" width="1" style="display:none"

        src="https://www.facebook.com/tr?id=995533745068186&ev=PageView&noscript=1"

        /></noscript>

        <!-- End Meta Pixel Code -->
    <?php
}
add_action('wp_head', 'add_meta_pixel_code');

//currency switcher
function currency_switcher() {
    check_ajax_referer('currency_switcher_nonce', 'nonce');
    $currency = isset($_POST['currency']) ? sanitize_text_field($_POST['currency']) : '';
    if($currency){
        setcookie('user_country', $currency, time() + (86400 * 30), "/");
        echo json_encode(array('status' => 'success'));
	    exit;
    }
}
add_action('wp_ajax_currency_switcher', 'currency_switcher');
add_action('wp_ajax_nopriv_currency_switcher', 'currency_switcher');

// PACK-A-PLP-Redesign-Dec2023
function add_quantity_shop_page_products() {
  global $product;
  if (is_shop()) {
    echo '<div class="product__meta"><div class="quantity"><button type="button" class="product-quantity--minus">-</button><input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="input-text qty" size="4" /><button type="button" class="product-quantity--plus">+</button></div>';
  }
}
add_action('woocommerce_after_shop_loop_item', 'add_quantity_shop_page_products', 5);

// Use full-sized images for products on the Shop page
function custom_woocommerce_template_loop_product_thumbnail() {
  echo woocommerce_get_product_thumbnail('full');  // Retrieve and display the full-size image
}

// Remove the default WooCommerce thumbnail function
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

// Add custom thumbnail function
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_woocommerce_template_loop_product_thumbnail', 10 );

// End PACK-A-PLP-Redesign-Dec2023
