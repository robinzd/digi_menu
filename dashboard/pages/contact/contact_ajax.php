<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];

if ($source == 'get_contact') {
    $get_contact = "SELECT A.sno,B.sno as contact_count_id,B.name,D.checked_status,A.mobile,A.email FROM contact_us A JOIN footer_menu_counts B ON A.footer_menu_counts = B.sno JOIN footer_access_control C ON B.footer_access_control = C.sno JOIN checked_status D ON D.sno = A.checked_status WHERE B.footer_access_control=2";
    $run_contact = mysqli_query($conn, $get_contact);
    $count = 1;
    $row_count = mysqli_num_rows($run_contact);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_contact = mysqli_fetch_array($run_contact)) {
            $primary_id = $getting_contact['sno'];
            $primary_id_contact_count = $getting_contact['contact_count_id'];
            $contact_name = $getting_contact['name'];
            $mobile = $getting_contact['mobile'];
            $email = $getting_contact['email'];
            $checked_status = $getting_contact['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$contact_name</td>
            <td>$mobile</td>
            <td>$email</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=contact_details($primary_id,$primary_id_contact_count)>
           <i class='material-icons'>&#xE254;</i>
             </button></td>
            <td>";
            if ($checked_status == 'checked') {
                $table_details .= "<div class='form-check form-switch'>
            <input class='form-check-input checkbox_$primary_id' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id)' value= $primary_id $checked_status>
           </div>";
            } else {
                $table_details .= "<div class='form-check form-switch'>
                <input class='form-check-input checkbox_$primary_id' type='checkbox' role='switch' id='checkbox' onclick='switch_on_off($primary_id)' value= $primary_id>
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
if ($source == 'oncontact') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE contact_us set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The contact is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offcontact') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE contact_us set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The contact is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'contactdetails') {
    $id = $_POST['id'];
    $id_count = $_POST['id_count'];
    $get_contact_details = "SELECT A.mobile,A.email,B.name FROM contact_us A JOIN footer_menu_counts B ON A.footer_menu_counts = B.sno WHERE A.sno = $id AND B.sno =  $id_count";
    $run_contact_details = mysqli_query($conn, $get_contact_details);
    while ($getting_contact_details = mysqli_fetch_array($run_contact_details)) {
        $mobile = $getting_contact_details['mobile'];
        $email = $getting_contact_details['email'];
        $name = $getting_contact_details['name'];
        $contact_details = " <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Contact Name</label>
        <input type='text' class='form-control' id='name_$id' value='$name' placeholder='Enter Contact Name'>
    </div>
        <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Mobile No</label>
        <input type='text' class='form-control' id='mobile_$id' value='$mobile' placeholder='Enter Mobile No'>
    </div>
    <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Email</label>
        <input type='text' class='form-control' id='email_$id' value= '$email' placeholder='Enter Email'>
    </div>
    <div align='right'>
   <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick=update_contact($id,$id_count)>update</button>
   </div>";
    }
    echo json_encode($contact_details);
}
if ($source == 'updatecontact') {
    $id = $_POST['id'];
    $id_count = $_POST['id_count'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    if (!empty($mobile) && !empty($email) && !empty($name)) {
        $update_query_1 = mysqli_query($conn, "UPDATE footer_menu_counts set name = '$name' WHERE sno=$id_count");
        if ($update_query_1) {
            $update_query_2 = mysqli_query($conn, "UPDATE contact_us set mobile = '$mobile',email='$email' WHERE sno='$id'");
            $update_response = "Contact updated Successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == "addcontact") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $checked_status = $_POST['checked_status'];
    $status = $_POST['status'];
    $last_inserted_id = $_POST['last_inserted_id'];
    $footer_access_control = $_POST['footer_access_control'];
    $update_lastinserted_query = mysqli_query($conn, "UPDATE footer_menu_counts set last_inserted_id = 0 WHERE last_inserted_id = $last_inserted_id AND footer_access_control = $footer_access_control");
    if (!empty($name) && !empty($mobile) && !empty($email)) {
        $insert_query = mysqli_query($conn, "INSERT INTO footer_menu_counts(name,footer_access_control,status,last_inserted_id) VALUES('$name','$footer_access_control','$status','$last_inserted_id')");
        if ($insert_query) {
            $last_inserted_id = mysqli_query($conn, "SELECT sno FROM footer_menu_counts where last_inserted_id=$last_inserted_id ");
            $last_id = mysqli_fetch_array($last_inserted_id);
            $footer_access_counts = $last_id['sno'];
            $insert_query_1 = mysqli_query($conn, "INSERT INTO contact_us(mobile,footer_menu_counts,email,status,checked_status) VALUES('$mobile','$footer_access_counts','$email','$status','$checked_status')");
            if ($insert_query_1) {
                $insert_response = "Contact Added Successfully!";
            } else {
                $insert_response = "Something Went Wrong...";
            }
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}
