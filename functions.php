<?php
// Add custom Theme Functions here
// Add custom Theme Functions here
update_option( 'flatsome_wup_purchase_code', 'GWrxBEss-VqSg-cJbs-dVvg-QzLEDfLzzExZ' );
update_option( 'flatsome_wup_supported_until', '14.07.2027' );
update_option( 'flatsome_wup_buyer', 'Licensed' );
update_option( 'flatsome_wup_sold_at', time() );
delete_option( 'flatsome_wup_errors', '' );
delete_option( 'flatsome_wupdates', '');


function devvn_ux_builder_element(){
    add_ux_builder_shortcode('devvn_viewnumber', array(
        'name'      => __('element giỏ hàng'),
        'category'  => __('Content'),
        'priority'  => 1,
        // 'options' => array(
        //     'number'    =>  array(
        //         'type' => 'scrubfield',
        //         'heading' => 'Numbers',
        //         // 'default' => '1',
        //         // 'step' => '1',
        //         // 'unit' => '',
        //         // 'min'   =>  1,
        //         // //'max'   => 2
        //     ),
        // ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element');function devvn_viewnumber_func($atts) {
    ob_start();
    ?>
    <section class="cartContainer">
        <section class="container">
            <section class="cartWrapper">
                <h4>Giỏ hàng của bạn</h4>
                <div class="cartContent">
                    <?php
                    // Lặp qua các sản phẩm trong giỏ hàng của WooCommerce
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        // Lấy thông tin sản phẩm
                        $product = $cart_item['data'];

                        // Lấy URL hình ảnh sản phẩm
                        $thumbnail_url = get_the_post_thumbnail_url($product->get_id(), 'thumbnail');
                        ?>

                        <div class="cartItem flex" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                            <div class="imgProductCart">
                                <?php if ($thumbnail_url) : ?>
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/placeholder.jpg" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="centerProductCart flex" >
                                <div class="titleProductCart"><h5><?php echo $product->get_name(); ?></h5></div>
                                <div class="descriptProductCart">
                                    <div class="priceProductCart flex">
                                        <span class="titleDsProductCart">Đơn giá:</span>
                                        <span class="lastPriceProductCart"><?php echo wc_price($cart_item['data']->get_price()); ?></span>
                                    </div>
                                    <div class="amountProductCart flex">
                                        <span class="titleDsProductCart">Số lượng:</span>
                                        <div class="inputAmoutProductCart">
                                            <button class="cart-quantity-button minus" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                                                <i class=" fas fa-minus "></i>
                                            </button>
                                            <input class="cart-quantity-input" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" value="<?php echo esc_attr($cart_item['quantity']); ?>" type="number" min="1">
                                            <button class="cart-quantity-button plus" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                                                <i class=" fas fa-plus "></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="totalProductCart flex">
                                        <span class="titleDsProductCart">Tổng:</span>
                                        <span class="lastPriceProductCart"><?php echo wc_price($cart_item['line_total']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="deleteProcuctCart">
                                <a href="<?php echo esc_url(WC()->cart->get_remove_url($cart_item_key)); ?>">
                                    <i class="cart-delete-icon fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
                <div class="cartTotalCart">
                    <div class="cartItemCart">
                        <div class="totalProductCart flex">
                            <span class="titleDsProductCart">Tổng tiền:</span>
                            <span class="lastPriceProductCarts"><?php wc_cart_totals_subtotal_html(); ?></span>
                        </div>
                        <div class="payProductCart">
                            <a class="" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="Xem thêm sản phẩm">
                                <span class="">Xem thêm sản phẩm</span>
                            </a>
                            <a class="" href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="Thanh toán">
                                <span class="">Thanh toán</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber', 'devvn_viewnumber_func');


// Bỏ các trường không cần thiết trong trang thanh toán
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	// unset($fields['billing']['billing_last_name']);		 
	unset($fields['billing']['billing_address_2']);		
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_country']);	
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_postcode']); 
	unset($fields['billing']['billing_address_2']); 
 	return $fields;
}
// thêm chú thích vào ô nhập thông tin
add_filter( 'woocommerce_checkout_fields' , 'override_billing_checkout_fields', 20, 1 );
function override_billing_checkout_fields( $fields ) {
    $fields['billing']['billing_first_name']['placeholder'] = 'Họ và tên';
    $fields['billing']['billing_last_name']['placeholder'] = 'Họ và tên';
    $fields['billing']['billing_email']['placeholder'] = 'Email';
    $fields['billing']['billing_address_1']['placeholder'] = 'Địa chỉ giao hàng';
    $fields['billing']['billing_phone']['placeholder'] = 'Số điện thoại';
    return $fields;
}

// WooCommerce Checkout Fields Hook
add_filter('woocommerce_checkout_fields','custom_wc_checkout_fields_no_label');

// Action: remove label from $fields
function custom_wc_checkout_fields_no_label($fields) {
    // loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($value as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
     return $fields;
}
add_filter('woocommerce_billing_fields', 'remove_phone_number_required_field', 10, 1);

function remove_phone_number_required_field($fields) {
    $fields['billing_phone']['required'] = false;

    return $fields;
}





function change_woocommerce_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'VND':
            $currency_symbol = ' đ';
            break;
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'change_woocommerce_currency_symbol', 10, 2);


function custom_price_html($price, $product) {
    // Kiểm tra nếu giá sản phẩm bằng 0 hoặc sản phẩm hết hàng
    if ($product->get_price() == 0 || !$product->is_in_stock()) {
        $price = '<span class="box-text" style="color: red;font-weight: bold;font-size: 16px;">Liên hệ</span>';
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'custom_price_html', 10, 2);
function custom_woocommerce_archive_shortcode($atts) {
    ob_start(); // Bắt đầu bộ đệm đầu ra

    woocommerce_content(); // Lấy nội dung trang archive sản phẩm

    $output = ob_get_clean(); // Lấy nội dung từ bộ đệm đầu ra và kết thúc bộ đệm

    return $output;
}
add_shortcode('woocommerce_archive', 'custom_woocommerce_archive_shortcode');


function enqueue_custom_script() {
    // Đăng ký và nạp tệp JavaScript tùy chỉnh
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/custom-js.js', array('jquery'), '1.0', true);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.3', 'all');

}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');


// add_action( 'woocommerce_checkout_after_customer_details','woocommerce_checkout_payment',20 );
//thêm ảnh cho checkout page
add_filter( 'woocommerce_cart_item_name', 'sgd_product_image_review_order_checkout', 9999, 3 );
  
function sgd_product_image_review_order_checkout( $name, $cart_item, $cart_item_key ) {
    if ( ! is_checkout() ) return $name;
    $product = $cart_item['data'];
    $thumbnail = $product->get_image( array( '50', '50' ), array( 'class' => 'alignleft' ) );
    return $thumbnail . $name;
}

//đổi chữ quick view 
function my_custom_translations( $strings ) {
	$text = array('Quick View' => '<i class="fa fa-eye"></i>');
	$strings = str_ireplace( array_keys( $text ), $text, $strings );
	return $strings;
}
add_filter( 'gettext', 'my_custom_translations', 20 );