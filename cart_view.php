<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <style>
        .shopping-cart {
            width: auto;
            height: auto;
            margin: 80px auto;
            background: #ffffff;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            border-radius: 6px;
            margin-bottom: 50px;
            padding-bottom: 10px;
            display: flex;
            flex-direction: column;
        }

        .title {
            height: 60px;
            border-bottom: 1px solid #E1E8EE;
            padding: 20px 30px;
            color: #5E6977;
            font-size: 18px;
            font-weight: 400;
        }
        </style>

        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row shopping-cart">
                        <div class="col-sm-12">
                            <div class="title">YOUR CART</div>
                            <div class="box box-solid">
                                <div class="box-body">
                                    <table class="table table-borderless table-responsive">
                                        <thead>
                                            <th></th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th width="20%">Quantity</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo "
	        					<div id='paypal-button'></div>
	        				";
                            } else {
                                echo "
	        					<strong>You need to <a href='login.php'>Login</a> to checkout.</strong><br>
	        				";
                            }
                            ?>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <?php $pdo->close(); ?>
        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script>
    var total = 0;
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

        getDetails();
        getTotal();

    });

    function getDetails() {
        $.ajax({
            type: 'POST',
            url: 'cart_details.php',
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
            }
        });
    }
    </script>
    <!-- Paypal Express -->
    <script>
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
    </script>
</body>

</html>