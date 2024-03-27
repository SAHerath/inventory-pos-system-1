<!-- <pre>
<?php //var_dump($data['param']); 
?>
</pre> -->
<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2><?php echo (($data['title'] == 'vendor_add') ? 'Add Vendor' : 'Edit Vendor'); ?></h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>vendors">Vendor</a></li>
      <li><?php echo (($data['title'] == 'vendor_add') ? 'Add Vendor' : 'Edit Vendor'); ?></li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form id="vendr" name="vendr" novalidate>
        <span id="vendr_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Id</label> -->
          <?php if ($data['title'] == 'vendor_edit') : ?>
            <input class="" id="vendr_id" name="vendr_id" data-name="Id" type="hidden" required hidden value="<?php echo $data['param']['vend_code']; ?>">
          <?php endif ?>
        </div>
        <div class="row">
          <div class="col col-md-6 pr-md-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Name</label>
              <input class="" id="vendr_name" name="vendr_name" data-name="Name" type="text" placeholder="Enter Vendor Name" required autocomplete="off" value="<?php echo $data['param']['vend_name']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Phone</label>
              <input class="" id="vendr_phone" name="vendr_phone" data-name="Phone" type="tel" placeholder="Enter Phone Number" required autocomplete="off" value="<?php echo $data['param']['vend_phone']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Email</label>
              <input class="" id="vendr_email" name="vendr_email" data-name="Email" type="email" placeholder="Enter Email" required autocomplete="off" value="<?php echo $data['param']['vend_email']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Website</label>
              <input class="" id="vendr_website" name="vendr_website" data-name="Website" type="text" placeholder="Enter Website (Optional)" required autocomplete="off" value="<?php echo $data['param']['vend_website']; ?>">
            </div>
          </div>
          <div class="col col-md-6 pl-md-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Address</label>
              <input class="" id="vendr_address" name="vendr_address" data-name="Address" type="text" placeholder="Enter Street Address" required autocomplete="off" value="<?php echo $data['param']['vend_address']; ?>">
              <!-- <textarea class="" id="txt_address" name="txt_address" type="text" placeholder="Enter Address" rows="2" required></textarea> -->
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">City</label>
              <input class="" id="vendr_city" name="vendr_city" data-name="City" type="text" placeholder="Enter City" required autocomplete="off" value="<?php echo $data['param']['vend_city']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Country</label>
              <input class="" id="vendr_country" name="vendr_country" data-name="Country" type="text" placeholder="Enter Country" required autocomplete="off" value="<?php echo $data['param']['vend_country']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">ZIP / Postal Code</label>
              <input class="" id="vendr_postal" name="vendr_postal" data-name="ZIP / Postal Code" type="number" placeholder="Enter Postal Code (Optional)" required autocomplete="off" value="<?php echo $data['param']['vend_zip']; ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-6 pr-md-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Remarks</label>
              <textarea class="" id="vendr_remarks" name="vendr_remarks" type="text" placeholder="Enter Additional Notes" rows="3" required><?php echo $data['param']['vend_notes']; ?></textarea>
            </div>
          </div>
          <div class="col col-md-6 pl-md-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Status</label>
              <select class="" id="vendr_state" name="vendr_state" data-name="Status" required>
                <option value="" <?php echo ($data['param']['vend_active'] == '') ? 'selected' : ''; ?>>Select Status</option>
                <option value="1" <?php echo ($data['param']['vend_active'] == '1') ? 'selected' : ''; ?>>Active</option>
                <option value="2" <?php echo ($data['param']['vend_active'] == '2') ? 'selected' : ''; ?>>Inactive</option>
              </select>
            </div>

          </div>

          <div class="row pt-3">
            <button class="btn green mr-3" type="submit">Save</button>
            <a class="btn blue" type="button" href="<?php echo URLROOT; ?>vendors">Cancel</a>
          </div>
      </form>
    </div>

  </div>
</main>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>vendors/";
  const method = "<?php echo (($data['title'] == 'vendor_add') ? 'addVendor' : 'editVendor'); ?>";
  /////////////////////////////////////////////////////////////////////

  function vendrCallback() {
    if (method == "addVendor") {
      vendr.resetForm();
    } else if (method == "editVendor") {
      location.href = urlroot;
    }
  }

  let vendr = new FormHandler('vendr', 'vendr_msg', urlroot + method);
  vendr.setCallback(vendrCallback);
  /////////////////////////////////////////////////////////////
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>