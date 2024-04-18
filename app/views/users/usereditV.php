<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Edit User</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>users">User</a></li>
      <li>Edit User</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form id="edit_users" name="edit_users" novalidate autocomplete="off">
        <span id="edit_users_msg" class="status" aria-live="polite"></span>

        <div class="row pb-3">
          <b>Personal Information</b>
        </div>
        <div class="row">
          <div class="col col-sm-4 pb-2 pr-sm-3">
            <label class="mb-1">Image</label>
            <input onchange="previewFile(this, 'image_wrapper', 1)" class="" id="users_image" name="users_image[]" data-name="Image" type="file" accept="image/*" hidden>
            <div class="border-wrap p-2" style="min-height: 14.75rem;">
              <a class="btn blue mb-1 mr-2" tabindex="0">
                <label for="users_image">Choose</label>
              </a>
              <a class="btn blue mb-1" onclick="resetFile('users_image', 'image_wrapper')" tabindex="0">Remove</a>
              <div class="dynamic-wrap image-wrap" id="image_wrapper">
                <?php if (!empty($data['users']['user_photo'])) : ?>
                  <img src="<?php echo URLROOT; ?>img/uploads/user/<?php echo $data['users']['user_photo']; ?>" alt="User_Image">
                <?php endif; ?>
              </div>
              <span class="empty">Image Added. Click Choose to change</span>
            </div>
          </div>
          <div class="col col-sm-8 pl-sm-3">
            <!-- <div class="row pb-2 pb-sm-3"> -->
            <!-- <label class="mb-1">User Id</label> -->
            <input class="" id="users_id" name="users_id" type="hidden" placeholder="" required value="<?php echo $data['users']['user_code']; ?>" hidden>
            <!-- </div> -->
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">First Name</label>
                <input class="" id="users_fname" name="users_fname" data-name="First Name" type="text" placeholder="" required value="<?php echo $data['users']['user_first_name']; ?>" autofocus>
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Last Name</label>
                <input class="" id="users_lname" name="users_lname" data-name="Last Name" type="text" placeholder="" value="<?php echo $data['users']['user_last_name']; ?>">
              </div>
            </div>
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">Date of Birth</label>
                <input class="" id="users_birthday" name="users_birthday" data-name="Date of Birth" type="date" placeholder="" required value="<?php echo $data['users']['user_birthday']; ?>">
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Gender</label>
                <select class="" id="users_gender" name="users_gender" data-name="Gender" required>
                  <option value="" selected></option>
                  <option value="male" <?php echo ($data['users']['user_gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                  <option value="female" <?php echo ($data['users']['user_gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
              </div>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Phone</label>
              <input class="" id="users_phone" name="users_phone" data-name="Phone" type="tel" placeholder="" required value="<?php echo $data['users']['user_phone']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Email</label>
              <input class="" id="users_email" name="users_email" data-name="Email" type="email" placeholder="" required value="<?php echo $data['users']['user_email']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Address</label>
              <textarea class="" id="users_address" name="users_address" data-name="Address" type="text" placeholder="" rows="2" required><?php echo $data['users']['user_address']; ?></textarea>
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
                <option value="<?php echo $row['role_code']; ?>" <?php echo ($data['users']['user_role_code'] == $row['role_code']) ? 'selected' : ''; ?>>
                  <?php echo $row['role_name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Username</label>
            <input class="" id="users_username" name="users_username" data-name="Username" type="text" placeholder="" required value="<?php echo $data['users']['user_username']; ?>">
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Password</label>
            <input class="" id="users_password" name="users_password" data-name="Password" type="password" placeholder="" required value="" autocomplete="new-password">
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Confirm Password</label>
            <input class="" id="users_confpass" name="users_confpass" data-name="Confirm Password" type="password" placeholder="" required value="">
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Account Status</label>
            <select class="" id="users_acstatus" name="users_acstatus" data-name="Account Status" required>
              <option value="" selected></option>
              <option value="active" <?php echo ($data['users']['user_status'] == 'active') ? 'selected' : ''; ?>>Active</option>
              <option value="blocked" <?php echo ($data['users']['user_status'] == 'blocked') ? 'selected' : ''; ?>>Blocked</option>
            </select>
          </div>

        </div>

        <div class="row pt-3">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset" onclick="location.href = urlroot;">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</main>


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>users/";
  /////////////////////////////////////////////////////////////////////////////

  function usersEdited() {
    resetFile('users_image', 'image_wrapper');
    console.log("userEdited");
    location.href = urlroot;
  }

  let editUsers = new FormHandler('edit_users', 'edit_users_msg', `${urlroot}editUser`);
  editUsers.setCallback(usersEdited);
  editUsers.setMaxFileLimit(1);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>