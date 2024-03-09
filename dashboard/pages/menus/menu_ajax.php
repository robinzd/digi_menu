<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];

if ($source == 'get_menus_headings') {
    $get_menu_headings = "SELECT A.sno,A.menu_name,B.checked_status FROM menu_headings A JOIN checked_status B ON A.checked_status = B.sno";
    $run_menu_headings = mysqli_query($conn, $get_menu_headings);
    $count = 1;
    $row_count = mysqli_num_rows($run_menu_headings);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_menu_headings = mysqli_fetch_array($run_menu_headings)) {
            $primary_id = $getting_menu_headings['sno'];
            $menu_name = $getting_menu_headings['menu_name'];
            $checked_status = $getting_menu_headings['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$menu_name</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=modaldetails($primary_id)>
           <i class='material-icons'>&#xE254;</i>
             </button></td>
            <td>";
            if ($checked_status == 'checked') {
                $table_details .= "<div class='form-check form-switch'>
            <input class='form-check-input checkbox_$primary_id' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id)' value=$primary_id $checked_status>
           </div>";
            } else {
                $table_details .= "<div class='form-check form-switch'>
                <input class='form-check-input checkbox_$primary_id' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id)' value=$primary_id>
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
if ($source == 'onmenuheading') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE menu_headings set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The menu is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offmenuheading') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE menu_headings set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The menu is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'menudetails') {
    $id = $_POST['id'];
    $get_menu_details = "SELECT * FROM menu_headings WHERE sno=$id";
    $run_menu_details = mysqli_query($conn, $get_menu_details);
    $modal_details = "";
    while ($getting_menu_details = mysqli_fetch_array($run_menu_details)) {
        $id = $getting_menu_details['sno'];
        $menu_name = $getting_menu_details['menu_name'];
        $modal_details = " 
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>S.No</label>
            <input type='text' class='form-control' id='sno_$id' value='$id' disabled>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Enter Menu Name</label>
            <input type='text' class='form-control' id='menu_$id' value= '$menu_name' placeholder='Enter Menu Name'>
        </div>
        <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick=updatemenus($id)>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updatemenus') {
    $id = $_POST['id'];
    $menu_name = $_POST['menu_name'];
    if (!empty($_POST['menu_name'])) {
        $update_query = mysqli_query($conn, "UPDATE menu_headings set menu_name = '$menu_name' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The menu is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == 'addmenus') {
    $checked_status = $_POST['checked_status'];
    $menu_name = $_POST['menu_name'];
    $status = $_POST['status'];
    if (!empty($menu_name)) {
        $insert_query = mysqli_query($conn, "INSERT INTO menu_headings(menu_name,checked_status,status)VALUE('$menu_name',' $checked_status',' $status')");
        if ($insert_query) {
            $insert_response = "The menu is inserted successfully!";
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}
