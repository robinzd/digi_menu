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
if ($source == 'header_menu') {
   $get_header_menu = "SELECT * FROM header_menu WHERE status = 1";
   $run_header_menu = mysqli_query($conn, $get_header_menu);
   $header_menu = '';
   while ($getting_header_menu = mysqli_fetch_array($run_header_menu)) {
      $href = $getting_header_menu['href'];
      $menu_name = $getting_header_menu['menu_name'];
      $header_menu .= "<li><a href='$href'>$menu_name</a></li>";
   }
   echo json_encode($header_menu);
}
if ($source == 'about_section') {
   $get_about_section = "SELECT * FROM about_section WHERE status = 1";
   $run_about_section =  mysqli_query($conn, $get_about_section);
   $about_section = "";
   while ($getting_about_section = mysqli_fetch_array($run_about_section)) {
      $about_image = $getting_about_section['image'];
      $description = $getting_about_section['description'];
      $about_section .= "<div class='col-lg-7 position-relative about-img' style='background-image: url(assets/img/$about_image) ;' data-aos='fade-up' data-aos-delay='150'>
      </div>
      <div class='col-lg-5 d-flex align-items-start' data-aos='fade-up' data-aos-delay='300'>
        <div class='content ps-0 ps-lg-5'>
          <p class='fst-italic'>
          $description
          </p>
        </div>
      </div>";
   }
   echo json_encode($about_section);
}
if ($source == 'footer_section') {
   $get_footer_section = "SELECT * FROM footer_access_control WHERE status = 1";
   $run_footer_section =  mysqli_query($conn, $get_footer_section);
   $footer_section = "";
   $count = 0;
   while ($getting_footer_section = mysqli_fetch_array($run_footer_section)) {
      $footer_access_control_id = $getting_footer_section['sno'];
      $footer_menu = $getting_footer_section['footer_menu'];
      $icon = $getting_footer_section['icon'];
      if ($count == 0) {
         $footer_section .= "<div class='col-lg-3 col-md-6 d-flex'>
      <i class='$icon'></i>
      <div>
        <h4>$footer_menu</h4>";
         $get_footer_counts = "SELECT A.sno FROM footer_menu_counts A JOIN footer_access_control B ON A.footer_access_control = B.sno WHERE A.status = 1 AND B.sno = $footer_access_control_id AND A.status = 1";
         $run_footer_counts =  mysqli_query($conn, $get_footer_counts);
         while ($getting_footer_counts = mysqli_fetch_array($run_footer_counts)) {
            $footer_counts_id = $getting_footer_counts['sno'];
            $footer_section .= "<p>";
            $get_address = "SELECT * FROM address WHERE status = 1 AND footer_menu_counts = $footer_counts_id";
            $run_address = mysqli_query($conn, $get_address);
            while ($getting_address = mysqli_fetch_array($run_address)) {
               $address = $getting_address['address'];
               $implode_address = array($address);
               $explode_address = explode(".", $address);
               $final_imploded_address = implode("<br>", $explode_address);
               $footer_section .= $final_imploded_address;
            }
            $footer_section .= "</p>";
         };
         $footer_section .= "</div>
    </div>";
         $count++;
      } else if ($count > 3) {
         $footer_section .= "<div class='col-lg-3 col-md-6 footer-links'>
          <h4>$footer_menu</h4>
          <div class='social-links d-flex'>";
         $get_follow_us = "SELECT * FROM follow_us WHERE status = 1";
         $run_follow_us = mysqli_query($conn, $get_follow_us);
         while ($getting_follow_us = mysqli_fetch_array($run_follow_us)) {
            $platform = $getting_follow_us['platform'];
            $href = $getting_follow_us['href'];
            $icon = $getting_follow_us['icon'];
            $footer_section .= "<a href='$href' class='$platform'><i class='$icon'></i></a>";
         }
         $footer_section .= "</div>
        </div>";
         $count++;
      } else {
         $footer_section .= "<div class='col-lg-3 col-md-6 footer-links d-flex'>
      <i class='$icon'></i>
      <div>
        <h4>$footer_menu</h4>";
         if ($footer_menu == "Contact Us") {
            $get_footer_counts = "SELECT A.sno FROM footer_menu_counts A JOIN footer_access_control B ON A.footer_access_control = B.sno WHERE A.status = 1 AND B.sno = $footer_access_control_id AND A.status = 1";
            $run_footer_counts =  mysqli_query($conn, $get_footer_counts);
            while ($getting_footer_counts = mysqli_fetch_array($run_footer_counts)) {
               $footer_counts_id = $getting_footer_counts['sno'];
               $footer_section .= "<p>";
               $get_contact = "SELECT * FROM contact_us WHERE status=1 AND footer_menu_counts = $footer_counts_id";
               $run_contact =  mysqli_query($conn, $get_contact);
               while ($getting_contact = mysqli_fetch_array($run_contact)) {
                  $mobile = $getting_contact['mobile'];
                  $email = $getting_contact['email'];
                  $footer_section .= "<strong>Phone:</strong> +91 $mobile<br>
              <strong>Email:</strong>$email<br>";
               }
               $footer_section .= "</p>";
            }
            $count++;
         } else if ($footer_menu == "Opening Hours") {
            $footer_section .= "<p>";
            $get_openeing_hours = "SELECT * FROM openeing_hours WHERE status=1";
            $run_openeing_hours =  mysqli_query($conn, $get_openeing_hours);
            while ($getting_openeing_hours = mysqli_fetch_array($run_openeing_hours)) {
               $day = $getting_openeing_hours['day'];
               $start_time = $getting_openeing_hours['start_time'];
               $end_time = $getting_openeing_hours['end_time'];
               $footer_section .= "<strong>$day : </strong>$start_time - $end_time<br>";
            }
            $footer_section .= "</p>";
            $count++;
         }
         $footer_section .= "</div>
    </div>";
         $count++;
      }
   }
   echo json_encode($footer_section);
}
