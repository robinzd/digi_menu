<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dish Section Management</title>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Update Dish Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body' id="update_dish">
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
                    <h5 class="modal-title" id="staticBackdropLabel">Add Dish Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
                        <input type='file' class='form-control' id='imageinput' accept='image/*'>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Name</label>
                        <input type='text' class='form-control' id='dish_name' placeholder='Enter Dish Name'>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Description</label>
                        <input type='text' class='form-control' id='dish_description' placeholder='Enter Description'>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>Select Category</label>
                        <select class="form-select" id="select_category">

                        </select>
                    </div>
                    <div class='mb-3'>
                        <label for='exampleFormControlInput1' class='form-label'>price</label>
                        <input type='text' class='form-control' id='dish_price' placeholder='Enter Price'>
                    </div>
                    <div align="right">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="adddish()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-text">
                <a href="http://digi-menu.infinityfreeapp.com/dashboard/?i=" onclick="history.back()">
                    <div class="icon"><i class="fa-solid fa-arrow-left"></i></div>
                    <div class="text">Go Back</div>
                </a>
            </div>

        </div>
    </nav>

    <div class="container-xl">
        <div class="d-flex justify-content-center h-100">
            <div class="search">
                <input type="text" class="search-input" placeholder="search..." id="search_input">
                <a class="search-icon" id="search_buttons">
                    <div class="search_button">
                        <i class="fa fa-search"></i>
                    </div>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Dish Section Management</h2>
                        </div>
                    </div>
                    <div class="col-sm-11" align="right">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#add" id="add_button" onclick=add_select_div()><a class="btn btn btn-circle btn-xl"><i class="material-icons">&#xE147;</i></a></button>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Dish Catogory</th>
                            <th>Price</th>
                            <th>Action</th>
                            <th id="status_id">Switch</th>
                        </tr>
                    </thead>
                    <tbody id="dish_section_table">
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="content_detail__pagination cdp" actpage="1" align="centre" id="pagination_div">

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
            pagination()

        });
        window.onload = function() {
            var paginationPage = parseInt($('.cdp').attr('actpage'), 10);
            $('.cdp_i').on('click', function() {
                var go = $(this).attr('href').replace('#!', '');
                if (go === '+1') {
                    paginationPage++;
                } else if (go === '-1') {
                    paginationPage--;
                } else {
                    paginationPage = parseInt(go, 10);
                }
                $('.cdp').attr('actpage', paginationPage);
            });
        };

        $("#search_input").keyup(function(event) {
            let search_input = $('#search_input').val()
            loadtable()
            pagination(search_input)
        });


        function loadtable(page) {
            let search_input = $('#search_input').val()
            let start_page = "";
            let result_per_page = 10;
            if (page == undefined) {
                start_page = 1
            } else {
                start_page = page
            }
            var url = 'dish_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'get_dish_section',
                    start_page: start_page,
                    result_per_page: result_per_page,
                    search_input: search_input
                },
                success: function(result) {
                    $("#dish_section_table").html(result);
                    var paginationPage = parseInt($('.cdp').attr('actpage'), 10);
                    $('.cdp_i').on('click', function() {
                        var go = $(this).attr('href').replace('#!', '');
                        if (go === '+1') {
                            paginationPage++;
                        } else if (go === '-1') {
                            paginationPage--;
                        } else {
                            paginationPage = parseInt(go, 10);
                        }
                        $('.cdp').attr('actpage', paginationPage);
                    });

                },
            });
        }

        function pagination(search_input) {
            var url = 'dish_ajax.php'
            let result_per_page = 10
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'pagination',
                    result_per_page: result_per_page,
                    search_input: search_input
                },
                success: function(result) {
                    $("#pagination_div").html(result);
                    var paginationPage = parseInt($('.cdp').attr('actpage'), 10);
                    $('.cdp_i').on('click', function() {
                        var go = $(this).attr('href').replace('#!', '');
                        if (go === '+1') {
                            paginationPage++;
                        } else if (go === '-1') {
                            paginationPage--;
                        } else {
                            paginationPage = parseInt(go, 10);
                        }
                        $('.cdp').attr('actpage', paginationPage);
                    });

                },
            });
        }


        function add_select_div() {
            var url = 'dish_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'addselect',
                },
                success: function(result) {
                    $("#select_category").html(result);
                },
            });

        }

        function switch_on_off(count) {
            var url = 'dish_ajax.php'
            let value = $('.checkbox_' + count).val();
            if ($('.checkbox_' + count).is(":checked")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: {
                        source: 'ondish',
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
                        source: 'offdish',
                        id: value,
                    },
                    success: function(result) {
                        alert(result)
                    },
                });

            }
        }

        function dish_section_details(id) {
            var url = 'dish_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'dishdetails',
                    id: id,
                },
                success: function(result) {
                    $('#update_dish').html(result);
                },
            });
        }

        function updatedish(id) {
            let input = document.getElementById('imageinput_' + id);
            let dish_name = $("#dish_name_" + id).val();
            let dish_description = $("#dish_description_" + id).val();
            let dish_price = $("#dish_price_" + id).val();
            let category = $('#dish_category_update option:selected').val();
            let upload_url = "dish_ajax.php";
            var file = input.files[0];
            if (file) {
                const fileSizeInMegabytes = file.size / (1024 * 1024);
                const maxSizeInMegabytes = 5;
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
                                    console.log(base64data);
                                    $.ajax({
                                        url: upload_url,
                                        method: "POST",
                                        data: {
                                            source: 'updatedish',
                                            id: id,
                                            image: base64data,
                                            dish_name: dish_name,
                                            dish_description: dish_description,
                                            dish_price: dish_price,
                                            category: category
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
            } else if (dish_name !== "" || dish_description !== "" || dish_price !== "" || category !== "") {
                $.ajax({
                    url: upload_url,
                    method: "POST",
                    data: {
                        source: 'updatedish',
                        id: id,
                        dish_name: dish_name,
                        dish_description: dish_description,
                        dish_price: dish_price,
                        category: category
                    },
                    success: function(result) {
                        let getted_result = result.replace(/['"]+/g, '')
                        alert(getted_result);
                        loadtable()
                    },
                });
            } else {
                alert("Kindly Enter All The Details...")
            }
        }


        function adddish() {
            let input = document.getElementById('imageinput');
            var file = input.files[0];
            if (file) {
                const fileSizeInMegabytes = file.size / (1024 * 1024);
                const maxSizeInMegabytes = 5;
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
                alert("Kindly Enter All The Details...")
            }
        }

        function ajax_call(base64data) {
            let dish_name = $("#dish_name").val();
            let dish_description = $("#dish_description").val();
            let dish_price = $("#dish_price").val();
            var category = $('#select_category option:selected').val();
            let url = "dish_ajax.php";
            if (dish_name !== "" || dish_description !== "" || dish_price !== "" || category !== "") {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        source: 'adddish',
                        image: base64data,
                        dish_name: dish_name,
                        dish_description: dish_description,
                        dish_price: dish_price,
                        category: category,
                        status: 1,
                        checked_status: 1
                    },
                    success: function(result) {
                        let getted_result = result.replace(/['"]+/g, '')
                        alert(getted_result);
                        loadtable()
                        pagination()
                        let dish_name = $("#dish_name").val('');
                        let dish_description = $("#dish_description").val('');
                        let dish_price = $("#dish_price").val('');
                        var category = $('#select_category option:selected').val('');
                        document.getElementById('imageinput').value = ''
                    },
                });
            } else {
                alert("Kindly Enter All The Details...")
            }
        }
    </script>
</body>

</html>