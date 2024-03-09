<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];

if ($source == 'get_workinghours') {
    $get_working_hours = "SELECT A.sno,A.day,A.start_time,A.end_time,B.checked_status FROM openeing_hours A JOIN checked_status B ON A.checked_status = B.sno";
    $run_working_hours = mysqli_query($conn, $get_working_hours);
    $count = 1;
    $row_count = mysqli_num_rows($run_working_hours);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_working_hours = mysqli_fetch_array($run_working_hours)) {
            $primary_id = $getting_working_hours['sno'];
            $day = $getting_working_hours['day'];
            $start_time = $getting_working_hours['start_time'];
            $end_time = $getting_working_hours['end_time'];
            $checked_status = $getting_working_hours['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$day</td>
            <td>$start_time</td>
            <td>$end_time</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=working_details($primary_id)>
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
if ($source == 'onworkinghours') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE openeing_hours set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The Hours is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offworkinghours') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE openeing_hours set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The Hours is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'workingdetails') {
    $id = $_POST['id'];
    $get_working_details = "SELECT * FROM openeing_hours WHERE sno=$id";
    $run_working_details = mysqli_query($conn, $get_working_details);
    $modal_details = "";
    while ($getting_working_details = mysqli_fetch_array($run_working_details)) {
        $id = $getting_working_details['sno'];
        $day = $getting_working_details['day'];
        $start_time = $getting_working_details['start_time'];
        $end_time = $getting_working_details['end_time'];
        $modal_details = " 
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Day</label>
            <input type='text' class='form-control' id='day_$id' value='$day' placeholder='Enter Day'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Start Time</label>
            <input type='text' class='form-control' id='start_time_$id' value='$start_time' placeholder='Enter Menu Name'>
        </div>
        <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>End Time</label>
        <input type='text' class='form-control' id='end_time_$id' value='$end_time' placeholder='Enter Menu Name'>
       </div>
        <div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick=update_working_hours($id)>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updateworkinghours') {
    $id = $_POST['id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    if (!empty($_POST['day']) && !empty($_POST['start_time'] && $_POST['end_time'])) {
        $update_query = mysqli_query($conn, "UPDATE openeing_hours set day = '$day',start_time = '$start_time',end_time = '$end_time' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The Working Hours is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == 'addworkinghours') {
    $checked_status = $_POST['checked_status'];
    $status = $_POST['status'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    if (!empty($_POST['day']) && !empty($_POST['start_time'] && $_POST['end_time'])) {
        $insert_query = mysqli_query($conn, "INSERT INTO openeing_hours(day,start_time,end_time,checked_status,status)VALUE('$day','$start_time','$start_time',' $checked_status',' $status')");
        if ($insert_query) {
            $insert_response = "The Working Hours inserted Successfully!";
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}
