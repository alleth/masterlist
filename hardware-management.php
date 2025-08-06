<?php 
include("includes/header.php");
?>

<main>
        <div class="container-fluid px-4">
            <div class="container-fluid mt-4">
                <div class="row">
<!--Item Description Table ------------------------------------------------------------------>
                    <div class="col-lg-3 mb-4">
                        <div class="card border border-dark-subtle shadow-sm fixed-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-7">
                                <h6 class="card-title mt-2">Item Description</h6>
                                <button type="button" class="btn btn-primary" id="setupAddDescriptionBTN" >Add Item</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="itemDescTBL" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Description</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

<!--Item Brand Table --------------------------------------------------------------------------->
                    <div class="col-lg-4 mb-4">
                        <div class="card border border-dark-subtle shadow-sm fixed-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center mb-7">
                                <h6 class="card-title mt-2">Item Brand</h6>
                                <button type="button" class="btn btn-primary" id="setupAddBrandBTN">Add Brand</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="itemBrandTBL" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Description</th>
                                            <th>Brand</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
<!--Item Model Table --------------------------------------------------------------------------->
                <div class="col-lg-5 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mt-2">Item Model</h6>
                            <button type="button" class="btn btn-primary" id="setupAddModelBTN">Add Model</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table id="itemModelTBL" class="table  mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Description</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Edit Modal -->
                <div class="modal fade" id="editItemModelModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="editItemModelForm">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Edit Item Model</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_id" name="id">
                            <div class="mb-3">
                                <label for="edit_item_desc" class="form-label">Item Description</label>
                                <input type="text" class="form-control" id="edit_item_desc" name="item_desc" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="edit_brand" name="brand" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="edit_model" name="model" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
      

<!-- Add Hardware Description Modal --------------------------------------------------------------------------------------->
<div class="modal fade" id="setupAddDescription" tabindex="-1" aria-labelledby="modalOneLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOneLabel">Add hardware Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dd class="col-sm-12">
                    <div id="addItemdDescMSG"></div>
                    </dd>
                <dd class="col-sm-12">
                    <label>Item Description</label>
                    <input type="text" class="form-control" name="item_desc_add" id="item_desc_add" required>
                </dd>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="addDescriptionBTN()" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Add Brand Modal -------------------------------------------------------------------------------------->
<div class="modal fade" id="setupAddBrand" tabindex="-1" aria-labelledby="modalTwoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTwoLabel">Add Hardware Brands</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dd class="col-sm-12">
                        <div id="addItemBrandMSG"></div>
                    </dd>
                    <dd class="col-sm-12">
                        <div class="">Item Description</div>
                        <div>
                            <div id="itemDescription2"></div>
                        </div>
                    </dd>
                    <dd class="col-sm-12">
                        <label>Brand</label>
                        <input type="text" class="form-control" name="item_brand_add" id="item_brand_add" required>
                    </dd>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addBrandBTN()" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Model Modal -------------------------------------------------------------------------------------->
<div class="modal fade" id="setupAddModel" tabindex="-1" aria-labelledby="setupAddModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTwoLabel">Add Hardware Model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dd class="col-sm-12">
                        <div id="addItemModelMSG"></div>
                    </dd>
                    <dd class="col-sm-12">
                        <div class="">Item Description</div>
                        <div>
                            <div id="itemDescription3"></div>
                        </div>
                    </dd>
                    <dd class="col-sm-12">
                        <div class="">Brand</div>
                            <select class="form-select" name="itemBrand2" id="itemBrand2" disabled>
                                <option value="" selected></option>
                            </select>
                    </dd>
                    <dd class="col-sm-12">
                        <label>Model</label>
                        <input type="text" class="form-control" name="item_model_add" id="item_model_add" required>
                    </dd>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addModelBTN()" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="setupEditModel" tabindex="-1" aria-labelledby="setupEditModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hardware Model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Hidden input for the model ID -->
                    <input type="hidden" id="editModelID" name="editModelID">

                    <dd class="col-sm-12 mb-2">
                        <div id="editItemModelMSG"></div>
                    </dd>

                    <dd class="col-sm-12 mb-2">
                        <label>Item Description</label>
                        <div type="text" class="form-control" id="editItemDescriptionText" class="form-control bg-light" readonly></div>
                    </dd>

                    <dd class="col-sm-12 mb-2">
                        <label>Brand</label>
                        <input type="text" class="form-control" name="editItemBrand" id="editItemBrand" readonly>
                    </dd>

                    <dd class="col-sm-12 mb-2">
                        <label>Model</label>
                        <input type="text" class="form-control" name="editItemModel" id="editItemModel" required>
                    </dd>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="updateModelBTN()" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------->

</main>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Masterfile | Hardware Inventory System &copy; 2024 &dash; <?php echo date("Y");?> </div>
        </div>
    </div>
</footer>
</div>
</div>


<script src="js/jquery.main.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
<script src="js/cdn.jsdelivr.js" type="text/javascript"></script>
<script src="js/chart.min.js"></script>>
<script src="js/user-tab.js" type="text/javascript"></script>
<script src="js/datepicker.min.js" type="text/javascript"></script>
<!-- <script src="js/hardware.js" type="text/javascript"></script> -->
<!-- <script src="js/cpu-pc-software.js" type="text/javascript"></script> -->
<script src="js/hardware-management.js" type="text/javascript"></script>
<!-- <script src="js/spinner/bootstrap.bundle.min.js" type="text/javascript"></script> -->
</body>
</html>