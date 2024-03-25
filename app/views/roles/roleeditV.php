<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Edit Role</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>roles">Role</a></li>
      <li>Edit Role</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <form id="edit_roles" name="edit_roles" novalidate autocomplete="off">
        <span id="edit_roles_msg" class="status" aria-live="polite"></span>

        <div class="row pb-3 pb-sm-3">
          <div class="col col-sm-6 pr-sm-3">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Role Id</label> -->
            <input class="" id="roles_rolid" name="roles_rolid" type="hidden" placeholder="" required value="<?php echo $data['roles']['role_code']; ?>" hidden>
            <!-- </div> -->
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Role Name</label>
              <input class="" id="roles_rname" name="roles_rname" type="text" placeholder="" required value="<?php echo $data['roles']['role_name']; ?>" autofocus>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Status</label>
              <select class="" id="roles_status" name="roles_status" required>
                <option value="active" <?php echo ($data['roles']['role_state'] == 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($data['roles']['role_state'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
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
            <?php foreach ($data['rolprm']['category'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Brand</label>
            </div>
            <?php foreach ($data['rolprm']['brand'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Attribute</label>
            </div>
            <?php foreach ($data['rolprm']['attribute'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Vendor</label>
            </div>
            <?php foreach ($data['rolprm']['vendor'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Location</label>
            </div>
            <?php foreach ($data['rolprm']['location'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>User</label>
            </div>
            <?php foreach ($data['rolprm']['user'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Product</label>
            </div>
            <?php foreach ($data['rolprm']['product'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Order</label>
            </div>
            <?php foreach ($data['rolprm']['order'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
                <label class="pl-3" for="roles_permi_<?php echo $row['perm_code']; ?>"><?php echo $row['perm_section'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="col col-sm-4 p-3">
            <div class="row mb-3">
              <label>Role</label>
            </div>
            <?php foreach ($data['rolprm']['role'] as $row) : ?>
              <div class="row mb-3 pl-4 center-v">
                <input id="roles_permi_<?php echo $row['perm_code']; ?>" name="roles_permi_<?php echo $row['perm_code']; ?>" type="checkbox" value="<?php echo $row['perm_code']; ?>" <?php echo empty($row['ropm_role_code']) ? '' : 'checked' ?>>
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

  function rolesEdited() {
    // console.log("edited");
    location.href = urlroot;
  }

  let editRoles = new FormHandler('edit_roles', 'edit_roles_msg', `${urlroot}editRole`);
  editRoles.setCallback(rolesEdited);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>