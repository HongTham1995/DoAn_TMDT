jQuery(document).ready(function($){
    $('.cart-variation-select').change(function(){
        var cart_item_key = $(this).data('cart_item_key');
        var attribute_name = $(this).attr('name');
        var value = $(this).val();

        $.ajax({
            url: cart_variation_params.ajax_url,
            type: 'POST',
            data: {
                action: 'update_cart_variation',
                cart_item_key: cart_item_key,
                attribute_name: attribute_name,
                value: value
            },
            success: function(response){
                if(response.success){
                    location.reload(); // Reload cart để cập nhật giá / hình ảnh
                } else {
                    alert(response.data);
                }
            }
        });
    });
});
