<!-- Add -->
<div class="modal fade bd-example-modal-lg" id="addfeatured" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Product to Featured Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table id="example1" class="table table-borderless table-hover productstablemodal">
                    <thead>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        $conn = $pdo->open();

                        try {
                            $stmt = $conn->prepare("SELECT * FROM products");
                            $stmt->execute();
                            foreach ($stmt as $row) {
                                $image = (!empty($row['photo'])) ? '../images/' . $row['photo'] : '../images/noimage.jpg';
                                echo "<tr>
                                        <td>" . $row['name'] . "</td>
                                        <td>
                                            <a href='" . $image . "' target='_blank'> <img src='" . $image . "' height='30px' width='30px'> </a>
                                        </td>
                                        <td>
                                            <form action='add_featured_products.php' method='POST'>
                                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                <button type='submit' class='mb-2 mr-2 btn btn-info'><i class='fa fa-plus'></i> Add</button>
                                            </form>
                                        </td>
                                      </tr>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                        $pdo->close();
                        ?>
                    </tbody>
                </table>

                <script src="datatable/jquery-3.5.1.js"></script>
                <script src="datatable/jquery.dataTables.min.js"></script>
                <script src="datatable/dataTables.bootstrap4.min.js"></script>
                <script>
                    $('.productstablemodal').DataTable();
                </script>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Remove -->
<div class="modal fade" id="removefeatured" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Removing...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure remove this product from Featured Products?</p>
                <p class="mb-0">This won't delete the product from record. It will only remove the product from Featured Products</p>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>