<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
$(document).ready(function() {
    // Datatable
    $('#example1').DataTable()
} );

</script>
<!-- Custom Scripts -->
<script>
$(function() {
    $('#navbar-search-input').focus(function() {
        $('#searchBtn').show();
    });

    $('#navbar-search-input').focusout(function() {
        $('#searchBtn').hide();
    });

    getCart();

    $('#productForm').submit(function(e) {
        e.preventDefault();
        var product = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'cart_add.php',
            data: product,
            dataType: 'json',
            success: function(response) {
                $('#callout').show();
                $('.message').html(response.message);
                if (response.error) {
                    //$('#callout').removeClass('callout-success').addClass('callout-danger');
                } else {
                    //$('#callout').removeClass('callout-danger').addClass('callout-success');
                    //sweet alert starts
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Product added to the cart.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    //sweet alert ends
                    getCart();
                }
            }
        });
    });

    $(document).on('click', '.close', function() {
        $('#callout').hide();
    });

});

function getCart() {
    $.ajax({
        type: 'POST',
        url: 'cart_fetch.php',
        dataType: 'json',
        success: function(response) {
            $('#cart_menu').html(response.list);
            $('.cart_count').html(response.count);
        }
    });
}
</script>