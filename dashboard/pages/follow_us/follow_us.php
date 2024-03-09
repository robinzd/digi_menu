<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Social Link Management</title>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Update Socail Link</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class='modal-body'>
                </div>
            </div>
        </div>
    </div>
    <!-- update modal box ended -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-text">
                <a onclick="history.back()">
                    <div class="icon"><i class="fa fa-angle-left"></i></div>
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
                            <h2>Social Link Management</h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Platform</th>
                            <th>Link</th>
                            <th>Action</th>
                            <th id="status_id">Switch</th>
                        </tr>
                    </thead>
                    <tbody id="followus_table">
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
            var url = 'follow_us_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'get_followus',
                },
                success: function(result) {
                    $("#followus_table").html(result);
                },
            });
        }

        function switch_on_off(count) {
            var url = 'follow_us_ajax.php'
            let value = $('.checkbox_' + count).val();
            if ($('.checkbox_' + count).is(":checked")) {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: {
                        source: 'onfollowus',
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
                        source: 'offfollowus',
                        id: value,
                    },
                    success: function(result) {
                        alert(result)
                    },
                });

            }
        }

        function followus_details(id) {
            var url = 'follow_us_ajax.php'
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'followusdetails',
                    id: id,
                },
                success: function(result) {
                    $('.modal-body').html(result);
                },
            });
        }

        function update_follow_us(id) {
            var url = 'follow_us_ajax.php'
            let link = $('#link_' + id).val();
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                delay: 250,
                data: {
                    source: 'updatefollowus',
                    id: id,
                    link: link,
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