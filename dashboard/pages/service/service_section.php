<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Service Section Management</title>
    <link rel="icon" type="image/png" href="../favicon/icons8-admin-settings-male-48.png" />
    <link rel="stylesheet" href="../assets/fonts/fonts.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/icons/material.icon.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- update modal box started -->
    <div class="modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Service Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body' id="update_service_section">
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
                    <h5 class="modal-title" id="staticBackdropLabel">Add Service Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
                        <input type='file' class='form-control' id='imageinput' accept='image/*'>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Heading</label>
                        <input type='text' class='form-control' id='heading' placeholder="Enter Heading">
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Description</label>
                        <input type='text' class='form-control' id='description' placeholder="Enter Description">
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addservicesection()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <h2>Service Section Management</h2>
                        </div>
                    </div>
                    <div class="col-sm-11" align="right">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#add" id="add_button"><a class="btn btn btn-circle btn-xl"><i class="material-icons">&#xE147;</i></a></button>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Action</th>
                            <th id="status_id">Switch</th>
                        </tr>
                    </thead>
                    <tbody id="service_section_table">
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
            var url = 'service_section_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'get_service_section',
                },
                success: function(result) {
                    $("#service_section_table").html(result);
                },
            });
        }

        function switch_on_off(count) {
            var url = 'service_section_ajax.php'
            let value = $('.checkbox_' + count).val();
            if ($('.checkbox_' + count).is(":checked")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: {
                        source: 'onservicesection',
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
                        source: 'offservicesection',
                        id: value,
                    },
                    success: function(result) {
                        alert(result)
                    },
                });

            }
        }

        function service_section_details(id) {
            var url = 'service_section_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'servicesectiondetails',
                    id: id,
                },
                success: function(result) {
                    $('#update_service_section').html(result);
                },
            });
        }

        function updateservicessection(id) {
            let input = document.getElementById('imageinput_' + id);
            let description = $("#description_" + id).val();
            let heading = $("#service_heading_" + id).val();
            let upload_url = "service_section_ajax.php";
            var file = input.files[0];
            if (file) {
                const fileSizeInMegabytes = file.size / (1024 * 1024);
                const maxSizeInMegabytes = 2;
                if (fileSizeInMegabytes > maxSizeInMegabytes) {
                    alert("Max file size " + maxSizeInMegabytes + "MB allowed" + " Current Image size is " + fileSizeInMegabytes.toFixed(2) + "MB");
                    input.value = "";
                    return false;
                } else if (fileSizeInMegabytes <= maxSizeInMegabytes) {
                    var resize_width = 300;
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = new Image();
                        img.src = e.target.result;
                        img.onload = function(el) {
                            var canvas = document.createElement('canvas');
                            var scaleFactor = resize_width / el.target.width;
                            canvas.width = resize_width;
                            canvas.height = el.target.height * scaleFactor;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                            canvas.toBlob(function(blob) {
                                url = URL.createObjectURL(blob);
                                var reader = new FileReader();
                                reader.readAsDataURL(blob);
                                reader.onloadend = function() {
                                    var base64data = reader.result;
                                    $.ajax({
                                        url: upload_url,
                                        method: "POST",
                                        data: {
                                            source: 'updateservicesection',
                                            heading: heading,
                                            id: id,
                                            image: base64data,
                                            description: description,
                                        },
                                        success: function(result) {
                                            let getted_result = result.replace(/['"]+/g, '')
                                            alert(getted_result);
                                            loadtable()
                                        },
                                    });
                                };
                            });
                        };
                    };
                    reader.readAsDataURL(file);
                }
            } else if (description !== "" || heading !== "") {
                $.ajax({
                    url: upload_url,
                    method: "POST",
                    data: {
                        source: 'updateservicesection',
                        id: id,
                        description: description,
                        heading: heading,
                    },
                    success: function(result) {
                        let getted_result = result.replace(/['"]+/g, '')
                        alert(getted_result);
                        loadtable()
                    },
                });
            } else {
                alert("Kindly Enter All The Details...");
            }
        }

        function addservicesection() {
            let input = document.getElementById('imageinput');
            var file = input.files[0];
            if (file) {
                const fileSizeInMegabytes = file.size / (1024 * 1024);
                const maxSizeInMegabytes = 2;
                if (fileSizeInMegabytes > maxSizeInMegabytes) {
                    alert("Max file size " + maxSizeInMegabytes + "MB allowed" + " Current Image size is " + fileSizeInMegabytes.toFixed(2) + "MB");
                    input.value = "";
                    return false;
                } else if (fileSizeInMegabytes <= maxSizeInMegabytes) {
                    var resize_width = 300;
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = new Image();
                        img.src = e.target.result;
                        img.onload = function(el) {
                            var canvas = document.createElement('canvas');
                            var scaleFactor = resize_width / el.target.width;
                            canvas.width = resize_width;
                            canvas.height = el.target.height * scaleFactor;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                            canvas.toBlob(function(blob) {
                                url = URL.createObjectURL(blob);
                                var reader = new FileReader();
                                reader.readAsDataURL(blob);
                                reader.onloadend = function() {
                                    var base64data = reader.result;
                                    ajax_call(base64data)
                                };
                            });
                        };
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                alert("Kindly Enter All The Details...");
            }
        }

        function ajax_call(base64data) {
            let description = $("#description").val();
            let heading = $("#heading").val();
            let url = "service_section_ajax.php";
            if (description !== "" || heading !== "") {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        source: 'addservicesection',
                        image: base64data,
                        description: description,
                        heading: heading,
                        status: 1,
                        checked_status: 1
                    },
                    success: function(result) {
                        let getted_result = result.replace(/['"]+/g, '')
                        alert(getted_result);
                        loadtable()
                    },
                });
            } else {
                alert("Kindly Enter All The Details...");
            }
        }
    </script>
</body>

</html>