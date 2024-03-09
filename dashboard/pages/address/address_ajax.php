<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];

if ($source == 'get_address') {
    $get_address = "SELECT A.sno,B.sno as address_count_id,B.name,D.checked_status,A.address FROM address A JOIN footer_menu_counts B ON A.footer_menu_counts = B.sno JOIN footer_access_control C ON B.footer_access_control = C.sno JOIN checked_status D ON D.sno = A.checked_status  WHERE B.footer_access_control=1";
    $run_address = mysqli_query($conn, $get_address);
    $count = 1;
    $row_count = mysqli_num_rows($run_address);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_address = mysqli_fetch_array($run_address)) {
            $primary_id_address = $getting_address['sno'];
            $primary_id_address_count = $getting_address['address_count_id'];
            $address = $getting_address['address'];
            $shop_address = $getting_address['name'];
            $checked_status = $getting_address['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$shop_address</td>
            <td>$address</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=address_details($primary_id_address,$primary_id_address_count)>
           <i class='material-icons'>&#xE254;</i>
             </button></td>
            <td>";
            if ($checked_status == 'checked') {
                $table_details .= "<div class='form-check form-switch'>
            <input class='form-check-input checkbox_$primary_id_address' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id_address)' value= $primary_id_address $checked_status>
           </div>";
            } else {
                $table_details .= "<div class='form-check form-switch'>
                <input class='form-check-input checkbox_$primary_id_address' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id_address)' value= $primary_id_address>
               </div>";
            }
            $table_details .= "</td>
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
if ($source == 'onaddress') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE address set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The address is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offaddress') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE address set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The address is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'addressdetails') {
    $id = $_POST['id'];
    $id_count = $_POST['id_count'];
    $get_address_details = "SELECT A.address,B.name FROM address A JOIN footer_menu_counts B ON A.footer_menu_counts = B.sno WHERE A.sno = $id AND B.sno =  $id_count";
    $run_addres_details = mysqli_query($conn, $get_address_details);
    while ($getting_address_details = mysqli_fetch_array($run_addres_details)) {
        $address = $getting_address_details['address'];
        $shop_address = $getting_address_details['name'];
        $address_details = " <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Shop Address</label>
        <input type='text' class='form-control' id='name_$id' value='$shop_address' placeholder='Enter Shop Address'>
    </div>
    <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Address</label>
        <input type='text' class='form-control' id='address_$id' value= '$address' placeholder='Enter Menu Name' placeholder='Enter Address'>
    </div>
    <div align='right'>
   <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick=update_address($id,$id_count)>update</button>
   </div>";
    }
    echo json_encode($address_details);
}
if ($source == 'updateaddress') {
    $id = $_POST['id'];
    $id_count = $_POST['id_count'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    if (!empty($name) && !empty($address)) {
        $update_query_1 = mysqli_query($conn, "UPDATE footer_menu_counts set name = '$name' WHERE sno=$id_count");
        if ($update_query_1) {
            $update_query_2 = mysqli_query($conn, "UPDATE address set address = '$address' WHERE sno='$id'");
            $update_response = "Adress updated Successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Fill All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == "addaddress") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $checked_status = $_POST['checked_status'];
    $status = $_POST['status'];
    $last_inserted_id = $_POST['last_inserted_id'];
    $footer_access_control = $_POST['footer_access_control'];
    $update_lastinserted_query = mysqli_query($conn, "UPDATE footer_menu_counts set last_inserted_id = 0 WHERE last_inserted_id = $last_inserted_id AND footer_access_control = $footer_access_control");
    if (!empty($name) && !empty($address)) {
        $insert_query = mysqli_query($conn, "INSERT INTO footer_menu_counts(name,footer_access_control,status,last_inserted_id) VALUES('$name','$footer_access_control','$status','$last_inserted_id')");
        if ($insert_query) {
            $last_inserted_id = mysqli_query($conn, "SELECT sno FROM footer_menu_counts where last_inserted_id=$last_inserted_id ");
            $last_id = mysqli_fetch_array($last_inserted_id);
            $footer_access_counts = $last_id['sno'];
            $insert_query_1 = mysqli_query($conn, "INSERT INTO address(address,footer_menu_counts,status,checked_status) VALUES('$address','$footer_access_counts','$status','$checked_status')");
            if ($insert_query_1) {
                $insert_response = "Address Added Successfully!";
            } else {
                $insert_response = "Something Went Wrong...";
            }
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Fill All The Details...";
    }
    echo json_encode($insert_response);
}
