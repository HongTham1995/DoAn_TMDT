<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */
update_option( get_template() . '_wup_purchase_code', '*******' );
update_option( get_template() . '_wup_supported_until', '01.01.2050' );
update_option( get_template() . '_wup_buyer', 'Licensed' );
require get_template_directory() . '/inc/init.php';

flatsome()->init();

/**
 * It's not recommended to add any custom code here. Please use a child theme
 * so that your customizations aren't lost during updates.
 *
 * Learn more here: https://developer.wordpress.org/themes/advanced-topics/child-themes/
 */



# HIỂN THỊ MÃ ƯU ĐÃI
add_action( 'woocommerce_before_cart', function() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        var $couponDiv = $('.coupon'); // div chứa "Mã ưu đãi"

        // Chèn coupon nhưng chỉ nếu chưa có class 'inserted'
        function insertCoupons() {
            $('.wt_sc_single_coupon').each(function(){
                if (!$(this).hasClass('inserted')) {
                    $(this).insertAfter($couponDiv.find('h3.widget-title'));
                    $(this).addClass('inserted'); // đánh dấu đã chèn
                }
            });
        }

        // Chạy ngay khi load page
        insertCoupons();

        // Quan sát các node mới được thêm vào DOM
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                $(mutation.addedNodes).find('.wt_sc_single_coupon').each(function(){
                    insertCoupons();
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    });
    </script>
    <?php
});




# ẨN 1 SỐ MENU
function jnn_admin_menus() {
    // Ẩn các menu mặc định
    remove_menu_page( 'index.php' );
    remove_menu_page( 'upload.php' );
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'wpcf7' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'options-general.php' );

    // ====== Ẩn các menu bạn yêu cầu ======

    // Ẩn Portfolio
    remove_menu_page( 'edit.php?post_type=portfolio' );

    // Ẩn Marketing (WooCommerce)
    remove_menu_page( 'woocommerce-marketing' );
    remove_menu_page( 'marketing' ); // fallback

    // Ẩn Elementor
    remove_menu_page( 'elementor' );

    // Ẩn Templates (Mẫu Elementor)
    remove_menu_page( 'edit.php?post_type=elementor_library' );

    // Ẩn Essential Addons for Elementor
    remove_menu_page( 'eael-settings' ); // trang chính
    remove_menu_page( 'eael' );          // fallback
}
add_action( 'admin_menu', 'jnn_admin_menus', 999 );


# SỬA GIỎ Hàng


// Hiển thị dropdown Size + Màu trong giỏ hàng
add_action('woocommerce_after_cart_item_name', 'custom_show_cart_variation_select', 20, 2);
function custom_show_cart_variation_select($cart_item, $cart_item_key){
    $product = wc_get_product($cart_item['product_id']);
    if(!$product->is_type('variable')) return;

    $attributes = $product->get_variation_attributes();
    $current_variation = isset($cart_item['variation']) ? $cart_item['variation'] : array();

    foreach($attributes as $attribute_name => $options){
        $label = wc_attribute_label($attribute_name);
        echo '<p><label>'.$label.':</label>';
        echo '<select class="cart-variation-select" data-cart_item_key="'.$cart_item_key.'" name="'.$attribute_name.'">';
        echo '<option value="">Chọn '.$label.'</option>';
        foreach($options as $option){
            $selected = (isset($current_variation[$attribute_name]) && $current_variation[$attribute_name]==$option)?'selected':'';
            echo '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
        }
        echo '</select></p>';
    }
}

// Enqueue JS cho cart page
add_action('wp_enqueue_scripts', 'custom_enqueue_cart_variation_js');
function custom_enqueue_cart_variation_js(){
    if(is_cart()){
        wp_enqueue_script(
            'custom-cart-variation-js',
            get_stylesheet_directory_uri() . '/js/cart-variation.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_localize_script('custom-cart-variation-js', 'cart_variation_params', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}

// AJAX xử lý update biến thể
add_action('wp_ajax_update_cart_variation', 'custom_update_cart_variation');
add_action('wp_ajax_nopriv_update_cart_variation', 'custom_update_cart_variation');
function custom_update_cart_variation(){
    $cart_item_key   = sanitize_text_field($_POST['cart_item_key']);
    $attribute_name  = sanitize_text_field($_POST['attribute_name']);
    $value           = sanitize_text_field($_POST['value']);

    $cart = WC()->cart->get_cart();
    if(isset($cart[$cart_item_key])){
        $cart_item = $cart[$cart_item_key];
        $product   = wc_get_product($cart_item['product_id']);
        if(!$product->is_type('variable')) wp_send_json_error('Not a variable product');

        $new_attributes = $cart_item['variation'];
        $new_attributes[$attribute_name] = $value;

        // Tìm variation_id mới
        $available_variations = $product->get_available_variations();
        $new_variation_id = 0;

        foreach($available_variations as $variation){
            $match = true;
            foreach($variation['attributes'] as $attr_name => $attr_value){
                if(!isset($new_attributes[$attr_name]) || $new_attributes[$attr_name] != $attr_value){
                    $match = false;
                    break;
                }
            }
            if($match){
                $new_variation_id = $variation['variation_id'];
                break;
            }
        }

        if($new_variation_id > 0){
            WC()->cart->cart_contents[$cart_item_key]['variation']    = $new_attributes;
            WC()->cart->cart_contents[$cart_item_key]['variation_id'] = $new_variation_id;
            WC()->cart->set_session();
            wp_send_json_success('Variation updated');
        } else {
            wp_send_json_error('Variation không tồn tại');
        }
    }
    wp_die();
}

add_filter('woocommerce_get_item_data', 'custom_remove_duplicate_variation', 10, 2);
function custom_remove_duplicate_variation($item_data, $cart_item){
    $unique = array();
    foreach($item_data as $data){
        $unique[$data['key']] = $data;
    }
    return array_values($unique);
}