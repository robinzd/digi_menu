<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];


if ($source == "get_followus") {
    $get_follow_us = "SELECT A.sno,A.platform,A.href,B.checked_status FROM follow_us A JOIN checked_status B ON A.checked_status = B.sno";
    $run_follow_us = mysqli_query($conn, $get_follow_us);
    $count = 1;
    $row_count = mysqli_num_rows($run_follow_us);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_follow_us = mysqli_fetch_array($run_follow_us)) {
            $primary_id = $getting_follow_us['sno'];
            $link = $getting_follow_us['href'];
            $platform = $getting_follow_us['platform'];
            $checked_status = $getting_follow_us['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$link</td>
            <td>$platform</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=followus_details($primary_id)>
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
if ($source == 'onfollowus') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE follow_us set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The Social link is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offfollowus') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE follow_us set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The Social link is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'followusdetails') {
    $id = $_POST['id'];
    $get_followus_details = "SELECT * FROM follow_us WHERE sno=$id";
    $run_followus_details = mysqli_query($conn, $get_followus_details);
    $modal_details = "";
    while ($getting_followus_details = mysqli_fetch_array($run_followus_details)) {
        $id = $getting_followus_details['sno'];
        $link = $getting_followus_details['href'];
        $platform = $getting_followus_details['platform'];
        $checked_status = $getting_followus_details['checked_status'];
        $modal_details = " 
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Platform</label>
            <input type='text' class='form-control' value = '$platform' disabled >
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Link</label>
            <input type='text' class='form-control' id='link_$id' value='$link' placeholder='Enter Your Social Link'>
        </div>
       <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick=update_follow_us($id)>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updatefollowus') {
    $id = $_POST['id'];
    $link = $_POST['link'];
    if (!empty($_POST['link'])) {
        $update_query = mysqli_query($conn, "UPDATE follow_us set href = '$link' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "Social Link is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Please Enter All The Details...";
    }
    echo json_encode($update_response);
}
