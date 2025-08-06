//Description Show on Table-------------<td><button title='Delete' class='btn btn-outline-danger btn-sm' onclick=''><span class='fas fa-trash-alt'></span></button></td>
$(document).ready(function () {
    $.ajax({
        url: 'view-item-description-tbl.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var rows = '';
            data.forEach(function (item_description) {
                rows += `<tr>
                    <td>${item_description.item_desc}</td>
                    <td style="text-align: right;">
                        <button title="Delete Model" class="btn btn-outline-danger btn-sm delete-item-description-btn" data-id="${item_description.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#itemDescTBL tbody').html(rows);
        },
        error: function () {
            alert("Failed to fetch Brand data.");
        }
    });
});


document.getElementById('setupAddDescriptionBTN').addEventListener('click', function () {var setupAddDescriptionBTN = new bootstrap.Modal(document.getElementById('setupAddDescription'));setupAddDescriptionBTN.show();});

//Description Add on database-----------------------------------------------------------------------------------------------------------------------
function addDescriptionBTN() {

    var item_desc_add = $('#item_desc_add').val();

    var wordObj = {
        item_desc_add :item_desc_add
    };
    if (item_desc_add === '') {
        $("#addItemdDescMSG").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Empty Field Reqired!</strong>");
    } else {
        $.ajax({
            type: "POST",
            url: "setup-add-description.php",
            data: wordObj,
            success: function(response){
                $('#response').html(response);
                $("#addItemdDescMSG").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Added Successfully!</strong> You added New Harware Description to Equpments Reference.");
                $("input[name='item_desc_add']").val("");
            },
            error: function() {
                $('#response').html('<p> AN error occured while saving the data');

            }
        });
    }
}

//Brand show on table-----------------------------------------------------------------------------------------------------------------------------------
$(document).ready(function () {
    $.ajax({
        url: 'view-item-brand-tbl.php',
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $('#itemBrandTBL tbody').html(response);
        },
        error: function () {
            alert("Failed to fetch item Brands.");
        }
    });
});

// Delete data from table
$(document).on('click', '.delete-brand-btn', function () {
    const id = $(this).data('id');

    if (confirm("Are you sure you want to delete this brand?")) {
        $.ajax({
            url: 'delete-item-brand.php',
            method: 'POST',
            data: { id: id },
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Deleted successfully.");
                    loadItemBrandTBL();
                } else {
                    alert("Failed to delete.");
                }
            },
            error: function () {
                alert("AJAX error occurred.");
            }
        });
    }
});

//Open add brand modal ---------------------------------------------------------------------------------------------------------------------------------
document.getElementById('setupAddBrandBTN').addEventListener('click', function () {
    var setupAddBrandBTN = new bootstrap.Modal(document.getElementById('setupAddBrand'));
    setupAddBrandBTN.show();
});

//Brand Add on database-----------------------------------------------------------------------------------------------------------------------
function addBrandBTN() {

    var itemSelect2 = $('#itemSelect2').val();
    var item_brand_add = $('#item_brand_add').val();

    var wordObj = {
        itemSelect2: itemSelect2,
        item_brand_add: item_brand_add
    };
    if (itemSelect2 === '' || item_brand_add === '') {
        $("#addItemBrandMSG").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Empty Field Reqired!</strong>");
    } else {
        $.ajax({
            type: "POST",
            url: "setup-add-brand.php",
            data: wordObj,
            success: function(response){
                $('#response').html(response);
                $("#addItemBrandMSG").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Added Successfully!</strong> You added New Harware Description to Equpments Reference.");
                $("select[name='itemSelect2']").val("");
                $("input[name='item_brand_add']").val("");
            },
        });
    }
}

//Model show on table-----------------------------------------------------------------------------------------------------------------------------------
$(document).ready(function () {
    $.ajax({
        url: 'view-item-model-tbl.php',
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $('#itemModelTBL tbody').html(response);
        },
        error: function () {
            alert("Failed to fetch item models.");
        }
    });
});

function editItemModel(id) {
    $.ajax({
        url: 'item-model-get-by-id.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            $('#editModelID').val(data.id);
            $('#editItemDescriptionText').text(data.item_desc);
            $('#editItemBrand').val(data.brand);
            $('#editItemModel').val(data.model);
            $('#setupEditModel').modal('show');
        },
        error: function() {
            alert("Failed to fetch model details.");
        }
    });
}

function updateModelBTN() {
    const id = $('#editModelID').val();
    const model = $('#editItemModel').val().trim();

    if (model === "") {
        $('#editItemModelMSG').html('<div class="alert alert-danger">Model name is required.</div>');
        return;
    }

    $.ajax({
        url: 'update-item-model.php',
        type: 'POST',
        data: {
            editModelID: id,
            editItemModel: model
        },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                $('#editItemModelMSG').html('<div class="alert alert-success">' + res.message + '</div>');
                setTimeout(() => {
                    $('#setupEditModel').modal('hide');

                    // Wait for modal to close, then reload page
                    $('#setupEditModel').on('hidden.bs.modal', function () {
                        location.reload();
                    });

                }, 1000);
            } else {
                $('#editItemModelMSG').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function() {
            $('#editItemModelMSG').html('<div class="alert alert-danger">AJAX error occurred.</div>');
        }
    });
}

$(document).on('click', '.delete-model-btn', function () {
    const id = $(this).data('id');

    if (confirm("Are you sure you want to delete this model?")) {
        $.ajax({
            url: 'delete-item-model.php',
            type: 'POST',
            data: { modelID: id },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    location.reload(); // or refresh table dynamically
                } else {
                    alert("Error: " + res.message);
                }
            },
            error: function () {
                alert("AJAX error occurred while deleting.");
            }
        });
    }
});



//Model Add on database-----------------------------------------------------------------------------------------------------------------------
function addModelBTN() {

    var itemSelect3 = $('#itemSelect3').val();
    var itemBrand2 = $('#itemBrand2').val();
    var item_model_add = $('#item_model_add').val();

    var wordObj = {
        itemSelect3: itemSelect3,
        itemBrand2: itemBrand2,
        item_model_add: item_model_add
    };
    if (itemSelect3 === '' || itemBrand2 === '' || item_model_add === '') {
        $("#addItemModelMSG").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Empty Field Reqired!</strong>");
    } else {
        $.ajax({
            type: "POST",
            url: "setup-add-model.php",
            data: wordObj,
            success: function(response){
                $('#response').html(response);
                $("#addItemModelMSG").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Added Successfully!</strong> You added New Harware Description to Equpments Reference.");
                $("select[name='itemSelect3']").val("");
                $("select[name='itemBrand2']").val("");
                $("input[name='item_model_add']").val("");
            },
        });
    }
}

document.getElementById('setupAddModelBTN').addEventListener('click', function () {
    var setupAddModel = new bootstrap.Modal(document.getElementById('setupAddModel'));
    setupAddModel.show();
});

//Show Item Description on add Brand-------------------------------------

$.ajax({
    type: "POST",
    url: "hardware-item-description-modal2.php",
    success: function(data){
        $("#itemDescription2").html(data);
    },
    error: function(){s
        alert(data);
    }
});

$.ajax({
    type: "POST",
    url: "hardware-item-description-modal3.php",
    success: function(data){
        $("#itemDescription3").html(data);
    },
    error: function(){
        alert(data);
    }
});

// function for dependent hardware brand of description of add model
function hardware_brand_option2() {
    var item_name2 = $("select[name='itemSelect3']").val();
    document.getElementById('itemBrand2').disabled = false;

    var wordObj = {"item_name2": item_name2};

    $.ajax({
        type: "POST",
        url: "hardware-brand-modal2.php",
        data: wordObj,
        success: function (data) {
            $("#itemBrand2").html(data);
        },
        error: function (data) {
            alert(data);
        }
    });

}