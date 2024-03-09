<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];


if ($source == "get_logo_name") {
    $get_logo = "SELECT * FROM logos";
    $run_logo = mysqli_query($conn, $get_logo);
    $count = 1;
    $row_count = mysqli_num_rows($run_logo);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_logo = mysqli_fetch_array($run_logo)) {
            $primary_id = $getting_logo['sno'];
            $logo = $getting_logo['logo'];
            $shop_name = $getting_logo['name'];
            $table_details .= "<tr>
            <td>$count</td>
            <td><img src='$logo' width='80' height='80'></td>
            <td>$shop_name</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=logo_details($primary_id)>
           <i class='material-icons'>&#xE254;</i>
             </button></td>;
           </tr>";
            $count++;
        }
    } else {
        $table_details  .= " <tr>
    <th style='text-align:center; color:red;' colspan='6'>No Record Found</th>
</tr>";
    }
    echo json_encode($table_details);
}

if ($source == 'logosectiondetails') {
    $id = $_POST['id'];
    $get_logo_details = "SELECT * FROM logos WHERE sno=$id";
    $run_logo_details = mysqli_query($conn, $get_logo_details);
    $modal_details = "";
    while ($getting_logo_details = mysqli_fetch_array($run_logo_details)) {
        $id = $getting_logo_details['sno'];
        $image = $getting_logo_details['logo'];
        $shop_name = $getting_logo_details['name'];
        $modal_details = " 
        <div class='mb-3'>
        <img src='$image' width='120' height='120'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
            <input type='file'  class='form-control' id='imageinput_$id'  accept='image/*'>
        </div>
        <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Shop Name</label>
        <input type='text' class='form-control' id='shop_name_$id' value='$shop_name'  placeholder='Enter Heading'>
        </div>
       <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='updatelogosection($id)'>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}


if ($source == 'updatelogosection') {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $shop_name = $_POST['shop_name'];
    if (!empty($_POST['shop_name']) && !empty($_POST['image'])) {
        $update_query = mysqli_query($conn, "UPDATE logos set logo = '$image',name='$shop_name' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The logo section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else if (!empty($_POST['shop_name'])) {
        $update_query_1 = mysqli_query($conn, "UPDATE logos set name='$shop_name' WHERE sno='$id'");
        if ($update_query_1) {
            $update_response = "The logo section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
