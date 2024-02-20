jQuery(document).ready(function($) {
    $('.quick-view').each(function() {
        $(this).html('<i class="fa fa-eye"></i>');
    });
    $('.cart-icon').each(function() {
      $(this).html('<i class="fa fa-shopping-basket" aria-hidden="true"></i>');
    });
    
    $('.woosc-btn.woosc-btn-has-icon').addClass('show-on-hover');
    $('.grid-tools').removeClass('hover-slide-in');
    $('.add-to-cart-grid').addClass('show-on-hover');
    $('.quick-view').addClass('show-on-hover');
    
    $('.add-to-cart-grid').click(function() {
      $('.add-to-cart-grid').css('display', 'block');
    });
    $('#ship-to-different-address-checkbox').prop('checked', true);
    $('.shipping_address').show();
    $('.product-remove .remove').html('<i class="fa fa-trash" aria-hidden="true"></i>');
});


