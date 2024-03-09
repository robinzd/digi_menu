<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Logo And Name Management</title>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Update Logo Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body' id="update_logo_section">
                </div>
            </div>
        </div>
    </div>
    <!-- update modal box ended -->
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
                            <h2>Logo And Name Management</h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Shop Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="logo_table">

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
            load_table()
        });

        function load_table() {
            var url = 'logo_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'get_logo_name',
                },
                success: function(result) {
                    $("#logo_table").html(result);
                },
            });
        }

        function logo_details(id) {
            var url = 'logo_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'logosectiondetails',
                    id: id,
                },
                success: function(result) {
                    $('#update_logo_section').html(result);
                },
            });
        }


        function updatelogosection(id) {
            let input = document.getElementById('imageinput_' + id);
            let shop_name = $("#shop_name_" + id).val();
            let upload_url = "logo_ajax.php";
            var file = input.files[0];
            if (file) {
                const fileSizeInMegabytes = file.size / (1024 * 1024);
                const maxSizeInMegabytes = 1;
                if (fileSizeInMegabytes > maxSizeInMegabytes) {
                    alert("Max file size " + maxSizeInMegabytes + "MB allowed" + " Current Image size is " + fileSizeInMegabytes.toFixed(2) + "MB");
                    input.value = "";
                    return false;
                } else if (fileSizeInMegabytes <= maxSizeInMegabytes) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = new Image();
                        img.src = e.target.result;
                        img.onload = function() {
                            var canvas = document.createElement('canvas');
                            var ctx = canvas.getContext('2d');
                            canvas.width = img.width;
                            canvas.height = img.height;
                            ctx.drawImage(img, 0, 0, img.width, img.height);
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
                                            source: 'updatelogosection',
                                            id: id,
                                            image: base64data,
                                            shop_name: shop_name,
                                        },
                                        success: function(result) {
                                            let getted_result = result.replace(/['"]+/g, '')
                                            alert(getted_result);
                                            load_table()
                                        },
                                    });
                                };
                            });
                        };
                    };
                    reader.readAsDataURL(file);
                }
            } else if (shop_name !== "") {
                $.ajax({
                    url: upload_url,
                    method: "POST",
                    data: {
                        source: 'updatelogosection',
                        id: id,
                        shop_name: shop_name,
                    },
                    success: function(result) {
                        let getted_result = result.replace(/['"]+/g, '')
                        alert(getted_result);
                        load_table()
                    },
                });
            } else {
                alert("Kindly Enter All The Details...")
            }
        }
    </script>
</body>

</html>