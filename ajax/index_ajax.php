<?php
include ('../db_connection/conn.php');
$source = $_REQUEST['source'];
if($source == 'menu_headings'){
   $get_menus = "SELECT * FROM menu_headings WHERE status = 1";
   $run_get_menus = mysqli_query($conn, $get_menus);
   $ul_menu_headings = ""; 
   $count = 0;
   while ($getted_headings = mysqli_fetch_array($run_get_menus)) {
      $menu_name = $getted_headings['menu_name'];
      if($count == 0){
      $ul_menu_headings .= "<li class='nav-item'>
                       <a class='nav-link active show' data-bs-toggle='tab' data-bs-target='#menu-$menu_name'>
                       <h4>$menu_name</h4>
                       </a>
                       </li>";
                       $count++;
      }
      else {
         $ul_menu_headings .= "<li class='nav-item'>
                       <a class='nav-link' data-bs-toggle='tab' data-bs-target='#menu-$menu_name'>
                       <h4>$menu_name</h4>
                       </a>
                       </li>";
      }
     
   }
   echo json_encode($ul_menu_headings); 
}

?>