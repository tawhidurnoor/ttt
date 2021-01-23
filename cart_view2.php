<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="category.php" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <!--
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                        -->
                    </div>
                </div>
            </div>

            <?php include_once 'cart_details_total.php'; ?>

        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->

<?php include 'includes/footer.php'; ?>

<?php include 'includes/scripts.php'; ?>

<script>
    var total = 0;

    'use strict';
    
    (function($) {

        /*-------------------
            Quantity change
        --------------------- */
        var proQty = $('.pro-qty');
        //proQty.prepend('<span class="dec qtybtn" >-</span>');
        //proQty.append('<span class="inc qtybtn" >+</span>');
        proQty.on('click', '.qtybtn', function() {
            var $button = $(this);
            var oldValue = $button.parent().find('input').val();
            alert(oldValue);
            if ($button.hasClass('inc')) {
                var newVal = parseFloat(oldValue) + 1;

                var id = $(this).data('id');
                //var qty = $('#qty_' + id).val();
                var qty = newVal;

                $.ajax({
                    type: 'POST',
                    url: 'cart_update.php',
                    data: {
                        id: id,
                        qty: qty,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (!response.error) {
                            console.log("Error");
                            getDetails();
                            getCart();
                            getTotal();
                        }
                    }
                });

            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;

                    var id = $(this).data('id');
                    //var qty = $('#qty_' + id).val();
                    var qty = newVal;

                    $.ajax({
                        type: 'POST',
                        url: 'cart_update.php',
                        data: {
                            id: id,
                            qty: qty,
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (!response.error) {
                                getDetails();
                                getCart();
                                getTotal();
                            }
                        }
                    });

                } else {
                    newVal = 0;

                    var id = $(this).data('id');
                    //var qty = $('#qty_' + id).val();
                    var qty = newVal;

                    $.ajax({
                        type: 'POST',
                        url: 'cart_update.php',
                        data: {
                            id: id,
                            qty: qty,
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (!response.error) {
                                getDetails();
                                getCart();
                                getTotal();
                            }
                        }
                    });

                }
            }
            $button.parent().find('input').val(newVal);
        });

    })(jQuery);


    $(function() {
        $(document).on('click', '.cart_delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: 'cart_delete.php',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        /*
        $(document).on('click', '.minus', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var qty = $('#qty_' + id).val();
            if (qty > 1) {
                qty--;
            }
            $('#qty_' + id).val(qty);
            $.ajax({
                type: 'POST',
                url: 'cart_update.php',
                data: {
                    id: id,
                    qty: qty,
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        $(document).on('click', '.add', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var qty = $('#qty_' + id).val();
            qty++;
            $('#qty_' + id).val(qty);
            $.ajax({
                type: 'POST',
                url: 'cart_update.php',
                data: {
                    id: id,
                    qty: qty,
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        */

        getDetails();
        getTotal();

    });

    function getDetails() {
        $.ajax({
            type: 'POST',
            url: 'cart_details2.php',
            dataType: 'json',
            success: function(response) {
                $('#tbody').html(response);
                getCart();
            }
        });
    }

    function getTotal() {
        $.ajax({
            type: 'POST',
            url: 'cart_total.php',
            dataType: 'json',
            success: function(response) {
                total = response;
                setTotal(total);
            }
        });
    }

    function setTotal(total) {
        $('#t1').html("&#2547; " + total);
        $('#t2').html("&#2547; " + total);
    }
</script>
<!-- Paypal Express -->
<script>
    /*
    paypal.Button.render({
        env: 'sandbox', // change for production if app is live,

        client: {
            sandbox: 'ASb1ZbVxG5ZFzCWLdYLi_d1-k5rmSjvBZhxP2etCxBKXaJHxPba13JJD_D3dTNriRbAv3Kp_72cgDvaZ',
            //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
        },

        commit: true, // Show a 'Pay Now' button

        style: {
            color: 'gold',
            size: 'small'
        },

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [{
                        //total purchase
                        amount: {
                            total: total,
                            currency: 'USD'
                        }
                    }]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {
                window.location = 'sales.php?pay=' + payment.id;
            });
        },

    }, '#paypal-button');
    */
</script>
</body>

</html>