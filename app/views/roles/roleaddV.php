<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Add Role</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>roles">Role</a></li>
      <li>Add Role</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form id="add_roles" name="add_roles" novalidate autocomplete="off">
        <span id="add_roles_msg" class="status" aria-live="polite"></span>

        <div class="row pb-3 pb-sm-3">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Role Name</label>
              <input class="" id="roles_rname" name="roles_rname" type="text" placeholder="" required autofocus>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Status</label>
              <select class="" id="roles_status" name="roles_status" required>
                <option value="" selected></option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
        </div>


        <div class="row">
          <label class="mb-1">Permissions</label>
        </div>
        <div class="row mb-3 border-wrap">
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Category</label>
            </div>
            <?php foreach ($data['permi']['category'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Brand</label>
            </div>
            <?php foreach ($data['permi']['brand'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Attribute</label>
            </div>
            <?php foreach ($data['permi']['attribute'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Vendor</label>
            </div>
            <?php foreach ($data['permi']['vendor'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Location</label>
            </div>
            <?php foreach ($data['permi']['location'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>User</label>
            </div>
            <?php foreach ($data['permi']['user'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Product</label>
            </div>
            <?php foreach ($data['permi']['product'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Order</label>
            </div>
            <?php foreach ($data['permi']['order'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Role</label>
            </div>
            <?php foreach ($data['permi']['role'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>

        </div>

        <!-- <div class="row mb-3 border-wrap">
          <?php foreach ($data['permi'] as $key => $value) : ?>
            <div class="col col-sm-6 p-3">
              <div class="row mb-3">
                <label><?php echo $key; ?></label>
              </div>
              <?php foreach ($value as $row) : ?>
                <div class="row mb-3 pl-4 center-v">
                  <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>">
                  <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div> -->

        <div class="row pt-3">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset" onclick="location.href = urlroot;">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</main>


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>roles/";
  /////////////////////////////////////////////////////////////////////////////

  function rolesAdded() {
    console.log("added and cleard");
  }

  let addRoles = new FormHandler('add_roles', 'add_roles_msg', `${urlroot}addRole`);
  addRoles.setCallback(rolesAdded);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>