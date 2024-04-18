<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>View User</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>users">User</a></li>
      <li>View User</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card pt-md-5">
      <div class="row">
        <div class="col col-sm-4 mb-3 pr-sm-3 pr-md-4">
          <div class="image-wrap">
            <img src="<?php echo URLROOT; ?>img/uploads/user/<?php echo $data['users']['user_photo']; ?>" alt="User Photo" style="max-height: 16rem;">
          </div>
          <div class="row mb-3 center-h h-4">
            <span class="col-auto pr-2"><?php echo $data['users']['user_first_name']; ?></span>
            <span class="col-auto"><?php echo $data['users']['user_last_name']; ?></span>
          </div>
          <div class="row center-h h-6">
            <span class="col-auto"><?php echo $data['roles']['role_name']; ?></span>
          </div>
          <div class="row center-h" style="text-transform: capitalize;">
            <span class="col-auto"><?php echo $data['users']['user_status']; ?> user</span>
          </div>
        </div>
        <div class="col col-sm-8 pl-sm-3 pl-md-4">
          <div class="row mb-4 h-5">
            <b>User Information</b>
          </div>
          <div class="row">
            <div class="col col-md-6 pr-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">First Name:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_first_name']; ?></span>
              </div>
            </div>
            <div class="col col-md-6 pl-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Last Name:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_last_name']; ?></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col col-md-6 pr-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Username:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_username']; ?></span>
              </div>
            </div>
            <div class="col col-md-6 pl-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Role:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['roles']['role_name']; ?></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col col-md-6 pr-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Gender:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_gender']; ?></span>
              </div>
            </div>
            <div class="col col-md-6 pl-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Birthday:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_birthday']; ?></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col col-md-6 pr-md-3">
              <div class="row mb-2 mb-sm-3">
                <span class="col-4 col-md-6 pr-2">Phone:</span>
                <span class="col-8 col-md-6 pl-2"><?php echo $data['users']['user_phone']; ?></span>
              </div>
            </div>
            <div class="col col-md-6 pl-md-3"></div>
          </div>
          <div class="row mb-2 mb-sm-3">
            <span class="col-4 col-sm-3 col-md-3 pr-2">Email:</span>
            <span class="col-auto col-sm-auto col-md-9 pl-2 pl-md-0"><?php echo $data['users']['user_email']; ?></span>
          </div>
          <div class="row mb-2 mb-sm-3">
            <span class="col-4 col-sm-3 col-md-3 pr-2">Address:</span>
            <span class="col-8 col-sm-auto col-md-9 pl-2 pl-md-0"><?php echo $data['users']['user_address']; ?></span>
          </div>

        </div>
      </div>
      <div class="row mb-4 h-5">
        <b>User Activity</b>
      </div>
    </div>
  </div>
</main>


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>users/";
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>