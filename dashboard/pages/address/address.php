<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Address Management</title>
    <link rel="icon" type="image/png" href="../favicon/icons8-admin-settings-male-48.png" />
    <link rel="stylesheet" href="../assets/fonts/fonts.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/icons/material.icon.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- update modal box started -->
    <div class=" modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body' id="update_address">
                </div>
            </div>
        </div>
    </div>
    <!-- update modal box ended -->
    <!-- add modal box start -->
    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Shop Address</label>
                        <input type='text' class='form-control' id='name' placeholder='Enter Shop Address'>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Address</label>
                        <input type='text' class='form-control' id='address' placeholder='Enter Address'>
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addaddress()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add modal box end -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-text">
                <a onclick="history.back()">
                    <div class="icon"><i class="fa-solid fa-arrow-left"></i></div>
                    <div class="text">Go Back</div>
                </a>
            </div>

        </div>
    </nav>

    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Address Management</h2>
                        </div>
                    </div>
                    <div class="col-sm-11" align="right">
                        <button type="button" data-bs-toggle="modal" data-bs-target='#add' id="add_button" onclick="add()"><a class="btn btn btn-circle btn-xl"><i class="material-icons">&#xE147;</i></a></button>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shop Address</th>
                            <th>Address</th>
                            <th>Action</th>
                            <th id="status_id">Switch</th>
                        </tr>
                    </thead>
                    <tbody id="address_table">
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color:#f5f5f5;">
            © 2024 Copyright:
            <a class="text1" href="/index.php`">Digi Menu Dashboard</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- link script tag -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/fontawesome.js"></script>
    <script>
        $(document).ready(function() {
            loadtable()
        });

        function loadtable() {
            var url = 'address_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'get_address',
                },
                success: function(result) {
                    $("#address_table").html(result);
                },
            });
        }

        function switch_on_off(count) {
            var url = 'address_ajax.php'
            let value = $('.checkbox_' + count).val();
            if ($('.checkbox_' + count).is(":checked")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: {
                        source: 'onaddress',
                        id: value,
                    },
                    success: function(result) {
                        alert(result)
                    },
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: {
                        source: 'offaddress',
                        id: value,
                    },
                    success: function(result) {
                        alert(result)
                    },
                });

            }
        }

        function address_details(id, id_count) {
            var url = 'address_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'addressdetails',
                    id: id,
                    id_count: id_count
                },
                success: function(result) {
                    $('#update_address').html(result);
                },
            });
        }

        function update_address(id, id_count) {
            var url = 'address_ajax.php'
            let name = $('#name_' + id).val();
            let address = $('#address_' + id).val();
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'updateaddress',
                    id: id,
                    id_count: id_count,
                    name: name,
                    address: address
                },
                success: function(result) {
                    alert(result)
                    loadtable()
                },
            });
        }

        function addaddress() {
            var url = 'address_ajax.php'
            let name = $('#name').val();
            let address = $('#address').val();
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'addaddress',
                    name: name,
                    address: address,
                    checked_status: 1,
                    status: 1,
                    footer_access_control: 1,
                    last_inserted_id: 1
                },
                success: function(result) {
                    alert(result)
                    loadtable()
                },
            });
        }
    </script>
</body>

</html>