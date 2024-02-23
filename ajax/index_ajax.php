<?php
include('../db_connection/conn.php');
$source = $_REQUEST['source'];
if ($source == 'menu_headings') {
   $get_menus = "SELECT * FROM menu_headings WHERE status = 1";
   $run_get_menus = mysqli_query($conn, $get_menus);
   $ul_menu_headings = '';
   $count = 0;
   while ($getted_headings = mysqli_fetch_array($run_get_menus)) {
      $menu_name = $getted_headings['menu_name'];
      if ($count == 0) {
         $ul_menu_headings .= "<li class='nav-item'>
                       <a class='nav-link active show' data-bs-toggle='tab' data-bs-target='#menu-$menu_name'>
                       <h4>$menu_name</h4>
                       </a>
                       </li>";
         $count++;
      } else {
         $ul_menu_headings .= "<li class='nav-item'>
                       <a class='nav-link' data-bs-toggle='tab' data-bs-target='#menu-$menu_name'>
                       <h4>$menu_name</h4>
                       </a>
                       </li>";
      }
   }
   echo json_encode($ul_menu_headings);
}
if ($source == 'menu_div') {
   $get_menu_div = "SELECT * FROM menu_headings WHERE status = 1";
   $run_menu_div = mysqli_query($conn, $get_menu_div);
   $menu_divs = '';
   $count = 0;
   while ($getting_menu_div = mysqli_fetch_array($run_menu_div)) {
      $menu_heading_id = $getting_menu_div['sno'];
      $menu_name = $getting_menu_div['menu_name'];
      if ($count == 0) {
         $menu_divs .= "<div class='tab-pane fade active show' id='menu-$menu_name'>
         <div class='tab-header text-center'>
           <p>Menu</p>
           <h3>$menu_name</h3>
         </div>
         <div class='row gy-5' id='item-$menu_name'>";
         $get_final_menu = "SELECT A.dish_name,A.dish_description,A.dish_image,A.dish_price FROM menus A JOIN menu_headings B ON A.dish_category = B.sno WHERE A.dish_category='$menu_heading_id' AND A.status = 1";
         $run_final_menu = mysqli_query($conn, $get_final_menu);
         while ($getting_final_menu = mysqli_fetch_array($run_final_menu)) {
            $dish_name = $getting_final_menu['dish_name'];
            $dish_description = $getting_final_menu['dish_description'];
            $dish_image = $getting_final_menu['dish_image'];
            $dish_price = $getting_final_menu['dish_price'];
            $menu_divs .= "<div class='col-lg-4 menu-item'>
                         <a href='assets/img/menu/menu-item-1.png' class='glightbox'><img src='assets/img/menu/$dish_image' class='menu-img img-fluid' alt=''></a>
                         <h4>$dish_name</h4>
                         <p class='ingredients'>
                          $dish_description
                        </p>
                        <p class='price'>
                         $dish_price
                        </p>
                       </div>";
         }
         $menu_divs .= "</div>
       </div>";
         $count++;
      } else if ($count > 0) {
         $menu_divs .= "<div class='tab-pane fade' id='menu-$menu_name'>
         <div class='tab-header text-center'>
           <p>Menu</p>
           <h3>$menu_name</h3>
         </div>
         <div class='row gy-5' id='item-$menu_name'>";
         $get_final_menu = "SELECT A.dish_name,A.dish_description,A.dish_image,A.dish_price FROM menus A JOIN menu_headings B ON A.dish_category = B.sno WHERE A.dish_category='$menu_heading_id' AND A.status = 1";
         $run_final_menu = mysqli_query($conn, $get_final_menu);
         while ($getting_final_menu = mysqli_fetch_array($run_final_menu)) {
            $dish_name = $getting_final_menu['dish_name'];
            $dish_description = $getting_final_menu['dish_description'];
            $dish_image = $getting_final_menu['dish_image'];
            $dish_price = $getting_final_menu['dish_price'];
            $menu_divs .= "<div class='col-lg-4 menu-item'>
                         <a href='assets/img/menu/menu-item-1.png' class='glightbox'><img src='assets/img/menu/$dish_image' class='menu-img img-fluid' alt=''></a>
                         <h4>$dish_name</h4>
                         <p class='ingredients'>
                          $dish_description
                        </p>
                        <p class='price'>
                         $dish_price
                        </p>
                       </div>";
         }
         $menu_divs .= "</div>
       </div>";
      }
   }
   echo json_encode($menu_divs);
}
