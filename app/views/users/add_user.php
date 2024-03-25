<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>User Account</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li>User Account</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form onsubmit="frmHand.submitForm(event);" novalidate>
        <span id="frm_status" class="status" aria-live="polite"></span>

        <div class="row pb-3">
          <b>Personal Information</b>
        </div>
        <div class="row">
          <div class="col col-sm-4 pr-sm-3">
            <label class="mb-1">Image</label>
            <input onchange="previewFile(this, 'preview_box')" class="" id="fil_image" name="fil_image[]" data-name="Image" type="file" accept="image/*" hidden>
            <div class="border-wrap p-3">
              <a class="btn blue mb-2 mr-3" tabindex="0">
                <label for="fil_image">Choose</label>
              </a>
              <a class="btn blue mb-2" onclick="resetFile('fil_image', 'preview_box')" tabindex="0">Remove</a>
              <div class="dynamic-wrap image-wrap" id="preview_box"></div>
              <span class="empty">No Image Added</span>
            </div>
          </div>
          <div class="col col-sm-8 pl-sm-3">
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">First Name</label>
                <input class="" id="txt_fname" name="txt_fname" data-name="First Name" type="text" placeholder="Enter First Name" required autofocus autocomplete="off">
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Last Name</label>
                <input class="" id="txt_lname" name="txt_lname" data-name="Last Name" type="text" placeholder="Enter Last Name" autocomplete="off">
              </div>
            </div>
            <div class="row">
              <div class="col pb-2 pb-sm-3 col-md-6 pr-md-3">
                <label class="mb-1">Date of Birth</label>
                <input class="" id="dte_birthday" name="dte_birthday" data-name="Date of Birth" type="date" placeholder="Enter Birthday" required autocomplete="off">
              </div>
              <div class="col pb-2 pb-sm-3 col-md-6 pl-md-3">
                <label class="mb-1">Gender</label>
                <select class="" id="opt_gender" name="opt_gender" data-name="Gender" required>
                  <option value="" selected>Select Gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                </select>
              </div>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Address</label>
              <input class="" id="txt_address" name="txt_address" data-name="Address" type="text" placeholder="Enter Address" required autocomplete="off">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Phone</label>
              <input class="" id="tel_phone" name="tel_phone" data-name="Phone" type="tel" placeholder="Enter Phone No." required autocomplete="off">
            </div>
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Email</label>
              <input class="" type="text" placeholder="Enter Email Address" id="txt_email" name="txt_email" required autocomplete="off">
            </div> -->
          </div>
        </div>

        <div class="row pt-3 pb-3">
          <b>Account Information</b>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Role</label>
            <select class="" id="opt_role" name="opt_role" data-name="Role" required>
              <option value="" selected>Select Role</option>
              <option value="1">Admin</option>
              <option value="2">Manager</option>
              <option value="3">Sales Rep</option>
            </select>
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Username</label>
            <input class="" id="txt_username" name="txt_username" data-name="Username" type="text" placeholder="Enter Username/Email" required autocomplete="off">
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Password</label>
            <input class="" id="pas_password" name="pas_password" data-name="Password" type="password" placeholder="Enter New Password" required autocomplete="new-password">
          </div>
          <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3">
            <label class="mb-1">Confirm Password</label>
            <input class="" id="pas_confpass" name="pas_confpass" data-name="Confirm Password" type="password" placeholder="Enter Password Again" required autocomplete="off">
          </div>
        </div>

        <div class="row">
          <div class="col pb-2 col-sm-6 pr-sm-3 pb-sm-3">
            <label class="mb-1">Account Status</label>
            <select class="" id="opt_accstat" name="opt_accstat" data-name="Account Status" required>
              <option value="" selected>Select</option>
              <option value="1">Active</option>
              <option value="2">Blocked</option>
            </select>
          </div>
          <!-- <div class="col pb-2 col-sm-6 pl-sm-3 pb-sm-3"> -->
          <!-- <label class="mb-1">User Status</label>
            <select class="" id="opt_usrstat" name="User Status" required>
              <option value="" disabled selected>Select</option>
              <option value="1">Active</option>
              <option value="2">Blocked</option>
            </select> -->
          <!-- <input class="" type="text" placeholder="Enter User Status" id="txt_usrstat" name="User Status" required autocomplete="off"> -->

          <!-- <div class="elem-wrap">
              <label class="" for="chk_active">
                <input class="" type="checkbox" id="chk_active" name="Active" required autocomplete="off">
                User Active
              </label>
            </div> -->
          <!-- </div> -->
        </div>

        <div class="row pt-3">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</main>
<script type="text/javascript">
  function previewFile(fileInput, previewboxId) {
    console.log(fileInput.files);
    var previewBox = document.getElementById(previewboxId);
    previewBox.textContent = "";

    // let i = 0;
    for (let i = 0; i < fileInput.files.length; i++) {
      const file = fileInput.files[i];

      const image = document.createElement("img");
      image.src = URL.createObjectURL(file);
      image.onload = function() {
        URL.revokeObjectURL(this.src);
      }
      previewBox.appendChild(image);
    }
    // if (!i) {
    //   previewBox.textContent = "No Image Selected";
    // }
  }

  function resetFile(fileinputId, previewboxId) {
    var fileInput = document.getElementById(fileinputId);
    var previewBox = document.getElementById(previewboxId);
    previewBox.textContent = "";
    fileInput.value = "";
  }
</script>
<script type="text/javascript">
  let frmHand = new FormHandler('saveUser', 'frm_status');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>