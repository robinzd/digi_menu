<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];
if ($source == 'get_about_section') {
    $get_about_section = "SELECT A.sno,A.image,A.description,B.checked_status FROM about_section A JOIN checked_status B ON A.checked_status = B.sno";
    $run_about_section = mysqli_query($conn, $get_about_section);
    $count = 1;
    $row_count = mysqli_num_rows($run_about_section);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_about_section = mysqli_fetch_array($run_about_section)) {
            $primary_id = $getting_about_section['sno'];
            $about_image = $getting_about_section['image'];
            $description = $getting_about_section['description'];
            $checked_status = $getting_about_section['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td><img src='$about_image' width='80' height='80'></td>
            <td>$description</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=about_section_details($primary_id)>
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
if ($source == 'onaboutsection') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE about_section set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The about section is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offaboutsection') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE about_section set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The about section is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'aboutsectiondetails') {
    $id = $_POST['id'];
    $get_about_details = "SELECT * FROM about_section WHERE sno=$id";
    $run_about_details = mysqli_query($conn, $get_about_details);
    $modal_details = "";
    while ($getting_about_details = mysqli_fetch_array($run_about_details)) {
        $id = $getting_about_details['sno'];
        $image = $getting_about_details['image'];
        $description = $getting_about_details['description'];
        $modal_details = " 
        <div class='mb-3'>
        <img src='$image' width='120' height='120'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
            <input type='file'  class='form-control' id='imageinput_$id'  accept='image/*'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Description</label>
            <input type='text' class='form-control' id='description_$id' value='$description' placeholder='Enter Description'>
        </div>
        <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='updateaboutsection($id)'>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updateaboutsection') {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    if (!empty($_POST['description']) && !empty($_POST['image'])) {
        $update_query = mysqli_query($conn, "UPDATE about_section set image = '$image',description='$description' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The about section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else if (!empty($_POST['description'])) {
        $update_query_1 = mysqli_query($conn, "UPDATE about_section set description='$description' WHERE sno='$id'");
        if ($update_query_1) {
            $update_response = "The about section is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == 'addaboutsection') {
    $image = $_POST['image'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $checked_status = $_POST['checked_status'];
    if (!empty($description) && !empty($image)) {
        $insert_query = mysqli_query($conn, "INSERT INTO about_section(image,description,status,checked_status)VALUE('$image','$description',' $status','$checked_status')");
        if ($insert_query) {
            $insert_response = "The about section is inserted successfully!";
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}
