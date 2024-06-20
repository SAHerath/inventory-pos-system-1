<header class="header">
  <nav>
    <!-- left navigation -->
    <a class="toggle-lg" role="button" onclick="dashbCon.toggleMenu()">
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
    <!-- <a class="" href="#">Notifications</a> -->
    <div class="drop">
      <a class="" onclick="showDrop(this);">
        <?php if (isset($_SESSION['usercode'])) : ?>
          <img src="<?php echo URLROOT; ?>img/uploads/user/<?php echo $_SESSION['userphoto']; ?>" alt="User_Photo">
          <?php echo $_SESSION['userfname']; ?>
        <?php else : ?>
          <img src="<?php echo URLROOT; ?>img/uploads/user/avatar_m.png" alt="User Photo">
          User_Name
        <?php endif ?>
      </a>
      <div class="drop-content">
        <a href="<?php echo URLROOT; ?>users/show/<?php echo (isset($_SESSION['usercode']) ? $_SESSION['usercode'] : ''); ?>">Profile</a>
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
    <a class="toggle-sm" role="button" onclick="dashbCon.toggleMenu()">
      <i class="fas fa-bars"></i>
    </a>
  </div>
  <div class="aside-menu-wrap" id="aside_menu_wrap">
    <nav class="aside-menu">
      <a class="menu-item <?php echo ((strpos($data['title'], 'dashboard') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>home">
        <i class="menu-icon fas fa-home"></i> <!-- fa-th -->
        <span>Dashboard</span>
      </a>
      <?php if (isEnabled('catg')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'category') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>categories">
          <i class="menu-icon fas fa-sitemap"></i> <!-- fa-list-alt -->
          <span>Category</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('brnd')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'brand') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>brands">
          <i class="menu-icon fas fa-tags"></i>
          <span>Brand</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('atrb')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'attribute') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>attributes">
          <i class="menu-icon fas fa-list"></i> <!-- fa-layer-plus -->
          <span>Attributes</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('vend')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'vendor') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>vendors">
          <i class="menu-icon fas fa-truck fa-flip-horizontal"></i> <!-- fa-layer-plus -->
          <span>Vendor</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('loca')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'location') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>locations">
          <i class="menu-icon fas fa-map-marker-alt"></i>
          <span>Location</span>
        </a>
      <?php endif ?>


      <?php if (isEnabled('prod')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'product') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>products">
          <i class="menu-icon fas fa-box"></i> <!-- fa-cubes-->
          <span>Product</span>
        </a>
      <?php endif ?>


      <!-- <div class="menu-drop">
        <a class="menu-item">
          <i class="menu-icon fas fa-cash-register"></i>
          <span>Sales</span>
          <i class="drop-icon fas fa-caret-down"></i>
        </a>
        <div class="drop-content">
          <a class="<?php echo ((strpos($data['title'], 'porder') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>purchases">
            Purchase Order
          </a>
          <a class="<?php echo ((strpos($data['title'], 'sorder') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>orders">
            Sales Order
          </a>
        </div>
      </div> -->

      <!-- <div class="menu-drop">
        <a class="menu-item">
          <i class="menu-icon fas fa-cart-plus"></i>
          <span>Purchase</span>
          <i class="drop-icon fas fa-caret-down"></i>
        </a>
        <div class="drop-content">
          <a class="<?php echo ((strpos($data['title'], 'purchord') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>purchases/add">
            Add Purchase Order
          </a>
          <a class="<?php echo ((strpos($data['title'], 'purchord') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>purchases/grn">
            Grn Purchase Order
          </a>
          <a class="<?php echo ((strpos($data['title'], 'purchord') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>purchases">
            Manage Purchase Order
          </a>
        </div>
      </div> -->


      <?php if (isEnabled('ordr')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'order') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>orders">
          <i class="menu-icon fas fa-cash-register"></i> <!-- fa-cubes-->
          <span>Sales</span>
        </a>
      <?php endif ?>

      <?php if (isEnabled('ordr')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'sale') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>sales">
          <i class="menu-icon fas fa-cash-register"></i> <!-- fa-cubes-->
          <span>Sales2</span>
        </a>
      <?php endif ?>


      <?php if (isEnabled('ordr')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'purchord') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>purchases">
          <i class="menu-icon fas fa-cart-plus"></i> <!-- fa-cubes-->
          <span>Purchase</span>
        </a>
      <?php endif ?>

      <?php if (isEnabled('repo')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'report') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>reports">
          <i class="menu-icon fas fa-chart-area"></i> <!-- fa-analytics -->
          <span>Report</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('comp')) : ?>
        <a class="menu-item" href="#">
          <i class="menu-icon fas fa-building"></i>
          <span>Company</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('user')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'user') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>users">
          <i class="menu-icon fas fa-users"></i>
          <span>User</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('role')) : ?>
        <a class="menu-item <?php echo ((strpos($data['title'], 'role') !== false) ? 'active' : ''); ?>" href="<?php echo URLROOT; ?>roles">
          <i class="menu-icon fas fa-user-shield"></i> <!--  fa-shield-alt -->
          <span>Role</span>
        </a>
      <?php endif ?>
      <?php if (isEnabled('setn')) : ?>
        <a class="menu-item" href="#">
          <i class="menu-icon fas fa-cog"></i>
          <span>Settings</span>
        </a>
      <?php endif ?>
      <!-- <div class="menu-drop">
        <a class="menu-item">
          <i class="menu-icon fas fa-cubes"></i>
          <span>MyMenu</span>
          <i class="drop-icon fas fa-caret-down"></i>
        </a>
        <div class="drop-content">
          <a class="" href="#">sub_menu_1</a>
          <a class="" href="#">sub_2</a>
          <a class="" href="#">menu_hi</a>
        </div>
      </div> -->
    </nav>
    <div class="scroll-menu hide">
      <a class="" onclick="dashbCon.scrollUp();">
        <i class="fas fa-caret-up"></i>
        <!-- <span>Top</span> -->
      </a>
      <a class="" onclick="dashbCon.scrollDown();">
        <i class="fas fa-caret-down"></i>
      </a>
    </div>
  </div>

</aside>