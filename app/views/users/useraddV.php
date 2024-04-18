<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Add User</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>users">User</a></li>
      <li>Add User</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form id="add_users" name="add_users" novalidate autocomplete="off">
        <span id="add_users_msg" class="status" aria-live="polite"></span>

        <div class="row pb-3">
          <b>Personal Information</b>
        </div>
        <div class="row">
          <div class="col col-sm-4 pb-2 pr-sm-3">
            <label class="mb-1">Image</label>
            <input onchange="previewFile(this, 'image_wrapper', 1)" class="" id="users_image" name="users_image[]" data-name="Image" type="file" accept="image/*" hidden>
            <div class="border-wrap p-2" style="min-height: 20.5rem;">
              <a class="btn blue mb-1 mr-2" tabindex="0">
                <label for="users_image">Choose</label>
              </a>
              <a class="btn blue mb-1" onclick="resetFile('users_image', 'image_wrapper')" tabindex="0">Remove</a>
              <div class="dynamic-wrap image-wrap" id="image_wrapper"></div>
              <span class="empty">No Image Added</span>
            </div>
          </div>
          <div class="col col-sm-8 pl-sm-3">
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">First Name</label>
                <input class="" id="users_fname" name="users_fname" data-name="First Name" type="text" placeholder="" required autofocus>
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Last Name</label>
                <input class="" id="users_lname" name="users_lname" data-name="Last Name" type="text" placeholder="">
              </div>
            </div>
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">Date of Birth</label>
                <input class="" id="users_birthday" name="users_birthday" data-name="Date of Birth" type="date" placeholder="" required>
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Gender</label>
                <select class="" id="users_gender" name="users_gender" data-name="Gender" required>
                  <option value="" selected></option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Phone</label>
              <input class="" id="users_phone" name="users_phone" data-name="Phone" type="tel" placeholder="" required>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Email</label>
              <input class="" id="users_email" name="users_email" data-name="Email" type="email" placeholder="" required>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Address</label>
              <!-- <input class="" id="users_address" name="users_address" data-name="Address" type="text" placeholder="" required> -->
              <textarea class="" id="users_address" name="users_address" data-name="Address" type="text" placeholder="" rows="2" required></textarea>
            </div>
          </div>
        </div>

        <div class="row pt-3 pb-3">
          <b>Account Information</b>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Role</label>
            <select class="" id="users_role" name="users_role" data-name="Role" required>
              <option value="" selected></option>
              <?php foreach ($data['roles'] as $row) : ?>
                <option value="<?php echo $row['role_code']; ?>">
                  <?php echo $row['role_name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Username</label>
            <input class="" id="users_username" name="users_username" data-name="Username" type="text" placeholder="" required>
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Password</label>
            <input class="" id="users_password" name="users_password" data-name="Password" type="password" placeholder="" required autocomplete="new-password">
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Confirm Password</label>
            <input class="" id="users_confpass" name="users_confpass" data-name="Confirm Password" type="password" placeholder="" required>
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Account Status</label>
            <select class="" id="users_acstatus" name="users_acstatus" data-name="Account Status" required>
              <option value="" selected></option>
              <option value="active">Active</option>
              <option value="blocked">Blocked</option>
            </select>
          </div>

        </div>

        <div class="row pt-3">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset" onclick="goBack();">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</main>


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>users/";

  function goBack() {
    location.href = urlroot;
  }
  /////////////////////////////////////////////////////////////////////////////

  function usersAdded() {
    resetFile('users_image', 'image_wrapper');
    console.log("submitted and cleard");
  }

  let addUsers = new FormHandler('add_users', 'add_users_msg', `${urlroot}addUser`);
  addUsers.setCallback(usersAdded);
  addUsers.setMaxFileLimit(1);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>