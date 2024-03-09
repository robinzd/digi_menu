<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];


if ($source == "get_menu_headings") {
    $get_menu_heading = "SELECT A.sno,A.href,A.menu_name,B.checked_status FROM header_menu A JOIN checked_status B ON A.checked_status = B.sno";
    $run_menu_heading = mysqli_query($conn, $get_menu_heading);
    $count = 1;
    $row_count = mysqli_num_rows($run_menu_heading);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_menu_heading = mysqli_fetch_array($run_menu_heading)) {
            $primary_id = $getting_menu_heading['sno'];
            $menu_link = $getting_menu_heading['href'];
            $menu_name = $getting_menu_heading['menu_name'];
            $checked_status = $getting_menu_heading['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$menu_link</td>
            <td>$menu_name</td>
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
    $update_query = mysqli_query($conn, "UPDATE header_menu set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The menu is on!";
    } else {
        $update_response = "Something Went Wrong......";
    }
    echo json_encode($update_response);
}
if ($source == 'offmenuheading') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE header_menu set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The menu is offed!";
    } else {
        $update_response = "Something Went Wrong......";
    }
    echo json_encode($update_response);
}
