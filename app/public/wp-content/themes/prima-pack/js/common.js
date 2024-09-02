jQuery(document).ready(function($){
// document start
jQuery('body').on('change', '#shipping_state', function(){

jQuery('body').trigger('update_checkout');
})

 // Navbar
 $( "<span class='clickD'></span>" ).insertAfter(".navbar-nav li.menu-item-has-children > a");
 $('.navbar-nav li .clickD').click(function(e) {
     e.preventDefault();
     var $this = $(this);
     if ($this.next().hasClass('show'))
        {
            $this.next().removeClass('show');
            $this.removeClass('toggled');
        }
        else
        {
            $this.parent().parent().find('.sub-menu').removeClass('show');
            $this.parent().parent().find('.toggled').removeClass('toggled');
            $this.next().toggleClass('show');
            $this.toggleClass('toggled');
        }
 });

 $(window).on('resize', function(){
     if ($(this).width() < 1025) {
         $('html').click(function(){
             $('.navbar-nav li .clickD').removeClass('toggled');
             $('.toggled').removeClass('toggled');
             $('.sub-menu').removeClass('show');
         });
         $(document).click(function(){
             $('.navbar-nav li .clickD').removeClass('toggled');
             $('.toggled').removeClass('toggled');
             $('.sub-menu').removeClass('show');
         });
         $('.navbar-nav').click(function(e){
            e.stopPropagation();
         });
     }
 });
 // Navbar end



/* ===== For menu animation === */
$(".navbar-toggler").click(function(){
    $(".navbar-toggler").toggleClass("open");
    $(".navbar-toggler .stick").toggleClass("open");
    $('body,html' ).toggleClass("open-nav");
});

// Navbar end





// to make sticky nav bar
// $(window).scroll(function() {
//     var scroll = $(window).scrollTop();
//     if (scroll > 200) {
//         $(".main-head").addClass("fixed");
//     }
//     else {
//       $(".main-head").removeClass("fixed");
//     }
// })


// smooth scroll to any section
// if($('a.scroll').length){
//     $("a.scroll").on('click', function(event) {
//       if (this.hash !== "") {
//         event.preventDefault();
//         var target = this.hash, $target = $(target);
//         $('html, body').animate({
//           scrollTop: $target.offset().top - 60
//         }, 800, function(){
//           window.location.href.substr(0, window.location.href.indexOf('#'));
//         });
//       }
//     });

//   }


// back to top
if($("#scroll").length){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 200) {
            $('#scroll').fadeIn(200);
        } else {
            $('#scroll').fadeOut(200);
        }
    });
    $('#scroll').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 500);
        return false;
    });
}




// one page scroll menu link
// $('a[href*="#"]').on('click', function (e) {
//     e.preventDefault();
//     $(document).off("scroll");
//     $('.navbar-nav > li > a').each(function () {
//         $(this).parent('li').removeClass('current-menu-item');
//     });
//     $(this).parent('li').addClass('current-menu-item');
//     var target = this.hash, $target = $(target);
//     $('html, body').stop().animate({
//         'scrollTop': $target.offset().top
//     }, 500, 'swing', function () {
//         window.location.href.substr(0, window.location.href.indexOf('#'));
//         $(document).on("scroll", onScroll);
//     });
// });
//  $(document).on("scroll", onScroll);
// function onScroll(event){
//     var scrollPos = $(document).scrollTop() + 100;
//     $('.navbar-nav > li > a').each(function () {
//         var currLink = $(this);
//         var refElement = $(currLink.attr("href"));
//         if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
//             $('.navbar-nav > li').removeClass("current-menu-item");
//             currLink.parent('li').addClass("current-menu-item");
//         }
//         else{
//             currLink.parent('li').removeClass("current-menu-item");
//         }
//     });
// }


// product slider

// $('.product_column').each(function(index){
    $('.product_slider').slick({
        dots: false,
        arrows: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<button class="prev-arrow"><i class="fas fa-chevron-left"></i></button>',
        nextArrow: '<button class="next-arrow"><i class="fas fa-chevron-right"></i></button>'
    });

// });
//   if($('.product_slider').length){

//   }


$('.our_clint_slider').slick({
    dots: false,
    arrows: true,
    infinite: true,
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: true,
    speed: 1000,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]
});

$('.intra_slider_sec').slick({
    dots: false,
    arrows: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    centerMode: true,
    adaptiveHeight: true,
    centerPadding: '12%',
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

// quantity js

var buttonPlus  = $(".qty-btn-plus");
var buttonMinus = $(".qty-btn-minus");

var incrementPlus = buttonPlus.click(function() {
  var id = $(this).attr('data-id');
  // console.log(id);
  var $n = $(this)
  .parent(".qty-container")
  .find(".input-qty_"+id);
  $n.val(Number($n.val())+1 );
  // console.log($(".qty_item").val());
  $('.home_prod_add_cart_'+id).attr("data-quantity",$(".qty_item_"+id).val());
});

var incrementMinus = buttonMinus.click(function() {
  var id = $(this).attr('data-id');
  // console.log(id);
  var $n = $(this)
  .parent(".qty-container")
  .find(".input-qty_"+id);
  var amount = Number($n.val());
  if (amount > 0) {
    $n.val(amount-1);
    // console.log($(".qty_item").val());
    $('.home_prod_add_cart_'+id).attr("data-quantity",$(".qty_item_"+id).val());
  }
});

///////// equal height ////////
// function equal_height() {
//     $('.career_imp .item_inner').matchHeight({ property: 'min-height' });
//   }
//   equal_height();
//   $(window).on('load', function (event) {
//     equal_height();
//   });
//   $(window).resize(function (event) {
//     equal_height();
//   });


//// accordion item active js ////
// $(".faq_sec hr").first().addClass("hidee");
// $('.faq_sec .accordion-collapse').on('show.bs.collapse', function () {
//   $(this).parents(".accordion-item").addClass('activelink');
//   $(this).parents(".accordion-item").next("hr").addClass("hidee");
// });
// $('.faq_sec .accordion-collapse').on('hide.bs.collapse', function () {
// $(this).parents(".accordion-item").removeClass('activelink');
// $(this).parents(".accordion-item").next("hr").removeClass("hidee");
// });






$('.search_icon a').on('click', function(e){
  e.preventDefault();
  $('.search-sec').toggleClass('search-open');
});

$('.search-close').on('click', function(e){
  e.preventDefault();
  $('.search-sec').removeClass('search-open');
});

$('.Pcount').change(function(){
  var id = $(this).attr('data-id');
  var prCount =  $(".qty_item_"+id).val();
  $('.home_prod_add_cart_'+id).attr("data-quantity",prCount);
});







// document end

})


var swiper = new Swiper(".banner_main_wraper", {
  pagination: {
    el: ".swiper-pagination",
    type: "progressbar",
  },
  loop: true,
  speed: 1000,
  autoplay: {
    delay: 5000,
  },
  navigation: {
    nextEl: ".next_arrow",
    prevEl: ".prev_arrow",
  },
});

jQuery(document).ready(function($) {
  $('body').on('click', '.ajax_add_to_cart', function(e) {
      e.preventDefault();

      var $thisbutton = $(this),
          product_qty = $thisbutton.closest('.product').find('.quantity .qty').val() || 1,
          product_id = $thisbutton.data('product_id'),
          product_sku = $thisbutton.data('product_sku');

      var data = {
          action: 'woocommerce_ajax_add_to_cart',
          product_id: product_id,
          product_sku: product_sku,
          quantity: product_qty,
      };

      $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

      $.ajax({
          type: 'post',
          url: wc_add_to_cart_params.ajax_url,
          data: data,
          beforeSend: function (response) {
              $thisbutton.removeClass('added').addClass('loading');
          },
          complete: function (response) {
              $thisbutton.addClass('added').removeClass('loading');
          },
          success: function (response) {
              if (response.error && response.product_url) {
                  window.location = response.product_url;
                  return;
              } else {
                  $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
              }
          },
      });

      return false;
  });
});

/* Shop page product quantity buttons */
// Add quantity buttons and then carry over
// the value from the input field to the to cart
// when added to cart.
document.addEventListener('DOMContentLoaded', function () {
  const products = document.querySelectorAll('.woocommerce .product');

  products.forEach(function(product) {
    const minusButton = product.querySelector('.product-quantity--minus');
    const plusButton = product.querySelector('.product-quantity--plus');
    const quantityInput = product.querySelector('.quantity input[type="number"]');
    const addToCartButton = product.querySelector('.add_to_cart_button');

    function updateQuantity() {
      addToCartButton.setAttribute('data-quantity', quantityInput.value);
    }

    minusButton.addEventListener('click', function() {
      if (quantityInput.value > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        updateQuantity();
      }
    });

    plusButton.addEventListener('click', function() {
      quantityInput.value = parseInt(quantityInput.value) + 1;
      updateQuantity();
    });
  });
});

// Display "Add to Cart" notification when product is added to cart
document.addEventListener('DOMContentLoaded', function () {
  const products = document.querySelectorAll('.product.type-product');

  products.forEach(function(product) {
    // Create an observer instance
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
          Array.from(mutation.addedNodes).forEach(function(node) {
              if (node.classList.contains('added_to_cart')) {
                // Add class to the product
                product.classList.add('product--added-to-cart');

                const imageLinkWrapper = product.querySelector('.woocommerce-LoopProduct-link');
                const img = imageLinkWrapper.querySelector('img');

                // Create new div and set its content to "Added to Cart"
                const viewCartDiv = document.createElement('div');
                viewCartDiv.innerHTML = "Added to Cart";
                viewCartDiv.className = node.className;

                // Create wrapper div and insert it before the image
                const wrapperDiv = document.createElement('div');
                wrapperDiv.className = 'product__added-to-cart-wrapper';
                imageLinkWrapper.insertBefore(wrapperDiv, img);

                // Append the viewCartDiv and the image to the wrapperDiv
                wrapperDiv.appendChild(viewCartDiv);
                wrapperDiv.appendChild(img);

                node.remove();

                // Set a timeout to remove the wrapperDiv and the class
                setTimeout(function() {
                    imageLinkWrapper.insertBefore(img, wrapperDiv);
                    imageLinkWrapper.removeChild(wrapperDiv);
                    product.classList.remove('product--added-to-cart');
                }, 3000);
              }
          });
        }
      });
    });

    // Configuration of the observer
    const config = { childList: true, subtree: true };

    // Pass in the target node and the observer options
    observer.observe(product, config);
  });
});
