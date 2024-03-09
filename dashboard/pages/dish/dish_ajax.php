<?php
include('../db_connection/conn.php');

$source = $_REQUEST['source'];
if ($source == 'get_dish_section') {
    $search_input = $_POST['search_input'];
    $search = "";
    if ($search_input !== "") {
        $search = " WHERE A.dish_name LIKE '%" . $search_input   . "%'";
    }
    $start_page = $_POST['start_page'];
    $end = $_POST['result_per_page'];
    $start = ($start_page - 1) * $end;
    $get_dish_section = "SELECT A.sno,A.dish_image,A.dish_name,A.dish_description,C.menu_name AS dish_category,A.dish_price,B.checked_status FROM menus A JOIN checked_status B ON A.checked_status = B.sno JOIN menu_headings C ON A.dish_category = C.sno $search LIMIT $start,$end";
    $run_dish_section = mysqli_query($conn, $get_dish_section);
    $count = 1;
    $row_count = mysqli_num_rows($run_dish_section);
    $table_details = "";
    if ($row_count > 0) {
        while ($getting_dish_section = mysqli_fetch_array($run_dish_section)) {
            $primary_id = $getting_dish_section['sno'];
            $dish_name = $getting_dish_section['dish_name'];
            $dish_image = $getting_dish_section['dish_image'];
            $dish_description = $getting_dish_section['dish_description'];
            $dish_category = $getting_dish_section['dish_category'];
            $dish_price = $getting_dish_section['dish_price'];
            $checked_status = $getting_dish_section['checked_status'];
            $table_details .= "<tr>
            <td>$count</td>
            <td>$dish_name</td>
            <td>$dish_description</td>
            <td><img src='$dish_image' width='80' height='80'></td>
            <td>$dish_category</td>
            <td>$dish_price</td>
            <td><button type='button' class='edit_button' data-bs-toggle='modal' data-bs-target='#update' onclick=dish_section_details($primary_id)>
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
        <th style='text-align:center; color:red;' colspan='8'>No Record Found</th>
    </tr>";
    }
    echo json_encode($table_details);
}
if ($source == 'ondish') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE  menus set status = 1,checked_status = 1 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The dish is live!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'offdish') {
    $id = $_POST['id'];
    $update_query = mysqli_query($conn, "UPDATE  menus set status = 0,checked_status = 2 WHERE sno='$id'");
    if ($update_query) {
        $update_response = "The dish is offed!";
    } else {
        $update_response = "Something Went Wrong...";
    }
    echo json_encode($update_response);
}
if ($source == 'dishdetails') {
    $id = $_POST['id'];
    $get_dish_details = "SELECT * FROM  menus WHERE sno=$id";
    $run_dish_details = mysqli_query($conn, $get_dish_details);
    $modal_details = "";
    while ($getting_dish_details = mysqli_fetch_array($run_dish_details)) {
        $id = $getting_dish_details['sno'];
        $dish_name = $getting_dish_details['dish_name'];
        $dish_image = $getting_dish_details['dish_image'];
        $dish_description = $getting_dish_details['dish_description'];
        $dish_category = $getting_dish_details['dish_category'];
        $dish_price = $getting_dish_details['dish_price'];
        $modal_details .= " 
        <div class='mb-3'>
        <img src='$dish_image' width='120' height='120'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Upload Image</label>
            <input type='file'  class='form-control' id='imageinput_$id'  accept='image/*'>
        </div>
        <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Name</label>
        <input type='text' class='form-control' id='dish_name_$id' value='$dish_name'  placeholder='Enter Dish Name'>
        </div>
        <div class='mb-3'>
            <label for='exampleFormControlInput1' class='form-label'>Description</label>
            <input type='text' class='form-control' id='dish_description_$id' value='$dish_description' placeholder='Enter Description'>
        </div>";
        $get_dish_category = "SELECT * FROM menu_headings WHERE status = 1";
        $run_dish_category = mysqli_query($conn, $get_dish_category);
        $modal_details .= "<div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Choose Category</label>
        <select class='form-select' id='dish_category_update'>";
        while ($getting_dish_category = mysqli_fetch_array($run_dish_category)) {
            $catogory = $getting_dish_category['menu_name'];
            $menu_id = $getting_dish_category['sno'];
            if ($dish_category ==  $menu_id) {
                $modal_details .= "<option value='$menu_id' selected>$catogory</option>";
            } else {
                $modal_details .= "<option value='$menu_id'>$catogory</option>";
            }
        }
        $modal_details .= "
        </select>
        </div>
       <div class='mb-3'>
        <label for='exampleFormControlInput1' class='form-label'>Price</label>
        <input type='text' class='form-control' id='dish_price_$id' value='$dish_price' placeholder='Enter Price'>
       </div>
        ";
        $modal_details .= "<div align='right'>
       <button type='button' class='btn btn-primary' data-bs-dismiss='modal' onclick='updatedish($id)'>update</button>
       </div>
    ";
    }
    echo json_encode($modal_details);
}
if ($source == 'updatedish') {
    $id = $_POST['id'];
    $image = $_POST['image'];
    $dish_name = $_POST['dish_name'];
    $dish_description = $_POST['dish_description'];
    $dish_price = $_POST['dish_price'];
    $category = $_POST['category'];
    if (!empty($_POST['dish_description']) && !empty($_POST['image'] && !empty($_POST['dish_name'])) && !empty($_POST['dish_price']) && !empty($_POST['category'])) {
        $update_query = mysqli_query($conn, "UPDATE menus set dish_image = '$image',dish_description='$dish_description',dish_name = '$dish_name',dish_category = '$category',dish_price = '$dish_price ' WHERE sno='$id'");
        if ($update_query) {
            $update_response = "The Dish is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else if (!empty($_POST['dish_description'])  && !empty($_POST['dish_name']) && !empty($_POST['dish_price']) && !empty($_POST['category'])) {
        $update_query_1 = mysqli_query($conn, "UPDATE menus set dish_description='$dish_description',dish_name = '$dish_name',dish_category = '$category',dish_price = '$dish_price ' WHERE sno='$id'");
        if ($update_query_1) {
            $update_response = "The Dish is updated successfully!";
        } else {
            $update_response = "Something Went Wrong...";
        }
    } else {
        $update_response = "Kindly Enter All The Details...";
    }
    echo json_encode($update_response);
}
if ($source == 'adddish') {
    $image = $_POST['image'];
    $dish_description = $_POST['dish_description'];
    $dish_name = $_POST['dish_name'];
    $dish_price = $_POST['dish_price'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $checked_status = $_POST['checked_status'];
    if (!empty($_POST['dish_description']) && !empty($_POST['image'] && !empty($_POST['dish_name'])) && !empty($_POST['dish_price']) && !empty($_POST['category'])) {
        $insert_query = mysqli_query($conn, "INSERT INTO menus(dish_image,dish_name,dish_description,dish_category,dish_price,status,checked_status)VALUE('$image','$dish_name','$dish_description','$category',' $dish_price','$status','$checked_status')");
        if ($insert_query) {
            $insert_response = "The dish is inserted successfully!";
        } else {
            $insert_response = "Something Went Wrong...";
        }
    } else {
        $insert_response = "Kindly Enter All The Details...";
    }
    echo json_encode($insert_response);
}


if ($source == 'addselect') {
    $get_dish_category = "SELECT * FROM menu_headings WHERE status = 1";
    $run_dish_category = mysqli_query($conn, $get_dish_category);
    $category_div =  "<option selected disabled>select Dish Category</option>";
    while ($getting_dish_category = mysqli_fetch_array($run_dish_category)) {
        $category_id = $getting_dish_category['sno'];
        $catogory = $getting_dish_category['menu_name'];
        $category_div .= "<option value='$category_id'>$catogory</option>";
    };
    $category_div .=  "</select>";
    echo json_encode($category_div);
}

if ($source == 'pagination') {
    $search_input = $_POST['search_input'];
    $search = "";
    if ($search_input !== "") {
        $search = " WHERE dish_name LIKE '%" . $search_input   . "%'";
    }

    $result_per_page = $_POST['result_per_page'];
    $query = "SELECT * FROM menus $search";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);
    $number_of_page = ceil($number_of_result / $result_per_page);
    $pagination = "  <a href='#!-1' class='cdp_i'>prev</a>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        $pagination .= " <a href='#!$page' class='cdp_i' onclick ='loadtable($page)'>$page</a>";
    }
    $pagination .= "<a href='#!+1' class='cdp_i'>next</a>";
    echo json_encode($pagination);
}
