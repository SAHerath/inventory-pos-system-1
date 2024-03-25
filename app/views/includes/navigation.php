<header class="header">
  <nav>
    <!-- left navigation -->
    <a class="toggle-lg" role="button" onclick="dashbC.toggleMenu()">
      <i class="fas fa-bars"></i>
    </a>
    <a class="active" href="#">Home</a>
    <a class="" href="#">Menu1</a>
  </nav>
  <!-- center navigation -->
  <!-- <nav> 
        Search..
      </nav>   -->
  <nav>
    <!-- right navigation -->
    <a class="" href="#">Notifications</a>
    <div class="drop">
      <a class="" onclick="showDrop(this);">
        <img src="<?php echo URLROOT; ?>img/uploads/user/avatar_m.png" alt="User Photo">
        <!-- <img src="< echo URLROOT; ?>img/uploads/user/< echo $_SESSION['userphoto']; ?>" alt="User Photo">
        < echo $_SESSION['userfname']; ?> -->
        User_Name
      </a>
      <div class="drop-content">
        <a href="#">Profile</a>
        <a href="<?php echo URLROOT; ?>users/logout">Logout</a>
      </div>
    </div>
  </nav>
</header>

<div class="aside-overlay"></div>

<aside class="aside">
  <div>
    <a class="aside-logo" href="#">
      <!-- link to the website -->
      <img class="" src="<?php echo URLROOT; ?>img/nawalanka-logo-2.png" alt="Company Logo">
      <span>
        <p><b>NAWA LANKA</b></p>
        <p><small>ENTERPRISES</small></p>
      </span>
    </a>
    <a class="toggle-sm" role="button" onclick="dashbC.toggleMenu()">
      <i class="fas fa-bars"></i>
    </a>
  </div>
  <div class="aside-menu-wrap" id="aside_menu_wrap">
    <nav class="aside-menu">
      <a class="<?php echo (($data['title'] == 'dashboard') ? 'active' : ''); ?>" href="dashboard.php">
        <i class="fas fa-home"></i> <!-- fa-th -->
        <span>Dashboard</span>
      </a>
      <a class="<?php echo (($data['title'] == 'category') ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>categories">
        <i class=" fas fa-sitemap"></i> <!-- fa-list-alt -->
        <span>Category</span>
      </a>
      <a class="<?php echo (($data['title'] == 'brand') ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>brands">
        <i class="fas fa-tags"></i>
        <span>Brand</span>
      </a>
      <a class="<?php echo (($data['title'] == 'attributes') ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>attributes">
        <i class="fas fa-list"></i> <!-- fa-layer-plus -->
        <span>Attributes</span>
      </a>
      <a class="<?php echo ((strpos($data['title'], 'vendor') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>vendors">
        <i class="fas fa-truck fa-flip-horizontal"></i> <!-- fa-layer-plus -->
        <span>Vendor</span>
      </a>
      <a class="<?php echo ((strpos($data['title'], 'location') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>locations">
        <i class="fas fa-map-marker-alt"></i>
        <span>Location</span>
      </a>
      <a class="<?php echo ((strpos($data['title'], 'product') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>products">
        <i class="fas fa-box"></i>
        <span>Product</span>
      </a>

      <div class="drop">
        <a class="" onclick="showDrop(this);">
          <i class="fas fa-box"></i> <!-- fa-cubes-->
          <span>Product</span>
        </a>
        <div class="drop-content">
          <a class="<?php echo (($data['title'] == 'product_add') ? 'active' : ''); ?>" href="#">
            Add Product
          </a>
          <a class="<?php echo (($data['title'] == 'product_list') ? 'active' : ''); ?>" href="#">
            Product List
          </a>
        </div>
      </div>

      <a class="<?php echo ((strpos($data['title'], 'order') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>orders">
        <i class="fas fa-shopping-cart"></i>
        <span>Order</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-chart-area"></i> <!-- fa-analytics -->
        <span>Report</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-building"></i>
        <span>Company</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-users"></i>
        <span>User</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
      <a class="" href="#">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </nav>
    <div class="scroll-menu hide">
      <a class="" onclick="scrollH.scrollMax();">
        <i class="fas fa-caret-up"></i>
        <!-- <span>Top</span> -->
      </a>
      <a class="" onclick="scrollH.scrollMin();">
        <i class="fas fa-caret-down"></i>
      </a>
    </div>
  </div>

</aside>