<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];
if ($source == 'get_service_section') {
    $get_service_section = "SELECT A.sno,A.image,A.heading,A.description,B.checked_status FROM  service_access A JOIN checked_status B ON A.checked_status = B.sno";
    $run_service_section = mysqli_query($conn, $get_service_section);
    $count = 1;
    $row_count = mysqli_num_rows($run_service_section);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_service_section = mysqli_fetch_array($run_service_section)) {
            $primary_id = $getting_service_section['sno'];
            $image = $getting_service_section['image'];
            $heading = $getting_service_section['heading'];
            $description = $getting_service_section['description'];
            $checked_status = $getting_service_section['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td><img src='$image' width='80' height='80'></td>
            <td>$heading</td>
            <td>$description</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=service_section_details($primary_id)>
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
if ($source == 'onservicesection') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE  service_access set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The service section is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offservicesection') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE  service_access set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The service section is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'servicesectiondetails') {
    $id = $_POST['id'];
    $get_service_details = "SELECT * FROM  service_access WHERE sno=$id";
    $run_service_details = mysqli_query($conn, $get_service_details);
    $modal_details = "";
    while ($getting_service_details = mysqli_fetch_array($run_service_details)) {
        $id = $getting_service_details['sno'];
        $image = $getting_service_details['image'];
        $heading = $getting_service_details['heading'];
        $description = $getting_service_details['description'];
        $modal_details = " 
        <div class='mb-3'>
        <img src='$image' width='120' height='120'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
            <input type='file'  class='form-control' id='imageinput_$id'  accept='image/*'>
        </div>
        <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Heading</label>
        <input type='text' class='form-control' id='service_heading_$id' value='$heading'  placeholder='Enter Heading'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Description</label>
            <input type='text' class='form-control' id='description_$id' value='$description' placeholder='Enter Description'>
        </div>
        <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='updateservicessection($id)'>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updateservicesection') {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $heading = $_POST['heading'];
    $description = $_POST['description'];
    if (!empty($_POST['description']) && !empty($_POST['image'] && !empty($_POST['heading']))) {
        $update_query = mysqli_query($conn, "UPDATE service_access set image = '$image',description='$description',heading = '$heading' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The service section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else if (!empty($_POST['description']) && !empty($_POST['heading'])) {
        $update_query_1 = mysqli_query($conn, "UPDATE service_access set heading = '$heading',description='$description' WHERE sno='$id'");
        if ($update_query_1) {
            $update_response = "The service section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == 'addservicesection') {
    $image = $_POST['image'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $heading = $_POST['heading'];
    $checked_status = $_POST['checked_status'];
    if (!empty($_POST['description']) && !empty($_POST['image'] && !empty($_POST['heading']))) {
        $insert_query = mysqli_query($conn, "INSERT INTO service_access(image,heading,description,status,checked_status)VALUE('$image','$heading','$description',' $status','$checked_status')");
        if ($insert_query) {
            $insert_response = "The service section is inserted successfully!";
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}
