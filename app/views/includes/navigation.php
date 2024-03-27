<header class="header">
  <nav>
    <!-- left navigation -->
    <a class="toggle-lg" role="button" onclick="dashbC.toggleMenu()">
      <i class="fas fa-bars"></i>
    </a>
    <a class="" href="<?php echo URLROOT; ?>home">Home</a>
    <!-- <a class="" href="#">Menu1</a> -->
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
        <!-- <img src="<?php echo URLROOT; ?>img/uploads/user/avatar_m.png" alt="User Photo"> -->
        <img src="<?php echo URLROOT; ?>img/uploads/user/<?php echo $_SESSION['userphoto']; ?>" alt="User_Photo">
        <?php echo $_SESSION['userfname']; ?>
        <!-- User_Name -->
      </a>
      <div class="drop-content">
        <a href="#">Profile</a>
        <a href="<?php echo URLROOT; ?>auth/logout">Logout</a>
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
      <a class="<?php echo ((strpos($data['title'], 'dashboard') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>home">
        <i class="fas fa-home"></i> <!-- fa-th -->
        <span>Dashboard</span>
      </a>
      <?php if (isEnabled('catg')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'category') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>categories">
          <i class=" fas fa-sitemap"></i> <!-- fa-list-alt -->
          <span>Category</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('brnd')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'brand') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>brands">
          <i class="fas fa-tags"></i>
          <span>Brand</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('atrb')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'attribute') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>attributes">
          <i class="fas fa-list"></i> <!-- fa-layer-plus -->
          <span>Attributes</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('vend')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'vendor') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>vendors">
          <i class="fas fa-truck fa-flip-horizontal"></i> <!-- fa-layer-plus -->
          <span>Vendor</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('loca')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'location') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>locations">
          <i class="fas fa-map-marker-alt"></i>
          <span>Location</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('prod')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'product') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>products">
          <i class="fas fa-box"></i> <!-- fa-cubes-->
          <span>Product</span>
        </a>
      <?php endif ?>

      <!-- <div class="drop">
        <a class="" onclick="showDrop(this);">
          <i class="fas fa-box"></i>
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
      </div> -->
      <?php if (isEnabled('ordr')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'order') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>orders">
          <i class="fas fa-shopping-cart"></i>
          <span>Order</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('repo')) : ?>
        <a class="" href="#">
          <i class="fas fa-chart-area"></i> <!-- fa-analytics -->
          <span>Report</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('comp')) : ?>
        <a class="" href="#">
          <i class="fas fa-building"></i>
          <span>Company</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('user')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'user') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>users">
          <i class="fas fa-users"></i>
          <span>User</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('role')) : ?>
        <a class="<?php echo ((strpos($data['title'], 'role') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>roles">
          <i class="fas fa-user-shield"></i> <!--  fa-shield-alt -->
          <span>Role</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('setn')) : ?>
        <a class="" href="#">
          <i class="fas fa-cog"></i>
          <span>Settings</span>
        </a>
      <?php endif ?>
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