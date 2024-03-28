<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h1><?php echo $data['title']; ?></h1>
    </div>

    <ul class="breadcrumb">
      <li>Home Dashboard</li>
    </ul>

  </div>

  <div class="main-overview">
    <div class="overviewcard">
      <div class="row pt-2 center-h">
        <span>Total Products</span>
      </div>
      <div class="row">
        <div class="col-4 p-3 txt-center">
          <i class="fas fa-box"></i>
        </div>
        <div class="col-7 p-4 txt-right">
          <!-- <span><b>18</b></span> -->
          <span><b><?php echo $data['tot_prodt']; ?></b></span>
        </div>
      </div>
    </div>
    <div class="overviewcard">
      <div class="row pt-2 center-h">
        <span>Total Orders</span>
      </div>
      <div class="row">
        <div class="col-4 p-3 txt-center">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="col-7 p-4 txt-right">
          <!-- <span><b>12</b></span> -->
          <span><b><?php echo $data['tot_order']; ?></b></span>
        </div>
      </div>
    </div>
    <div class="overviewcard">
      <div class="row pt-2 center-h">
        <span>Total Users</span>
      </div>
      <div class="row">
        <div class="col-4 p-3 txt-center">
          <i class="fas fa-users"></i>
        </div>
        <div class="col-7 p-4 txt-right">
          <!-- <span><b>6</b></span> -->
          <span><b><?php echo $data['tot_users']; ?></b></span>
        </div>
      </div>
    </div>
    <div class="overviewcard">
      <div class="row pt-2 center-h">
        <span>Total Locations</span>
      </div>
      <div class="row">
        <div class="col-4 p-3 txt-center">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="col-7 p-4 txt-right">
          <!-- <span><b>2</b></span> -->
          <span><b><?php echo $data['tot_locat']; ?></b></span>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="main-cards">
    <h1>Hello There!</h1>
    <pre>
      <?php var_dump($_SESSION); ?>
    </pre>
  </div> -->

</main>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>