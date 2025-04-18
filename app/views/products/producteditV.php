<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Edit Product</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>products">Product</a></li>
      <li>Edit Product</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card">
      <form id="edit_prodt" name="edit_prodt" novalidate autocomplete="off">
        <span id="edit_prodt_msg" class="status" aria-live="polite"></span>
        <div class="row pb-3">
          <b>Basic Information</b>
        </div>
        <section class="">
          <div class="row">
            <div class="col col-sm-5 pr-sm-3">
              <!-- <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Product Id</label> -->
              <input class="" id="prodt_id" name="prodt_id" type="hidden" placeholder="" required value="<?php echo $data['prodt']['prod_code']; ?>" hidden>
              <!-- </div> -->
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Product Name</label>
                <input class="" id="prodt_name" name="prodt_name" type="text" placeholder="" required value="<?php echo $data['prodt']['prod_name']; ?>">
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Brand</label>
                <select class="" id="prodt_brand" name="prodt_brand" required>
                  <?php foreach ($data['brand'] as $row) : ?>
                    <option value="<?php echo $row['brnd_code']; ?>" <?php echo ($data['prodt']['prod_brnd_code'] == $row['brnd_code']) ? 'selected' : ''; ?>>
                      <?php echo $row['brnd_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Category</label>
                <select class="" id="prodt_category" name="prodt_category" required>
                  <?php foreach ($data['categ'] as $row) : ?>
                    <option value="<?php echo $row['catg_code']; ?>" <?php echo ($data['prodt']['prod_catg_code'] == $row['catg_code']) ? 'selected' : ''; ?>>
                      <?php echo $row['catg_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col col-sm-7 pl-sm-3">
              <label class="mb-1">Image</label>
              <input onchange="previewFile(this, 'image_wrapper', 3)" class="" id="prodt_image" name="prodt_image[]" data-name="Image" type="file" accept="image/*" multiple hidden>
              <div class="border-wrap p-2" style="min-height: 10.5rem;">
                <a class="btn blue mb-1 mr-2" tabindex="0">
                  <label for="prodt_image" style="width: max-content; height: max-content; cursor: pointer">Choose</label>
                </a>
                <a class="btn blue mb-1" onclick="resetFile('prodt_image', 'image_wrapper')" tabindex="0">Remove</a>
                <div class="dynamic-wrap image-wrap" id="image_wrapper">
                  <?php foreach ($data['prdimg'] as $row) : ?>
                    <img src="<?php echo URLROOT; ?>img/uploads/product/<?php echo $row['impr_img_name']; ?>" alt="Product_Image">
                  <?php endforeach; ?>
                </div>
                <span class="empty">No Image Added</span>
              </div>
            </div>
          </div>
        </section>

        <div class="row pt-3">
          <div class="col col-sm-6 pr-sm-4">

            <div class="row pb-3">
              <b>Stock Information</b>
            </div>
            <section class="">
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Reorder Level</label>
                <input class="" id="prodt_rorderlvl" name="prodt_rorderlvl" type="number" placeholder="" required value="<?php echo $data['prodt']['prod_reod_level']; ?>">
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Reorder Quantity</label>
                <input class="" id="prodt_rorderqty" name="prodt_rorderqty" type="number" placeholder="" required value="<?php echo $data['prodt']['prod_reod_quant']; ?>">
              </div>

              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Total Stock</label>
                <div class="border-wrap p-2" id="prodt_totstock" style="min-height: 13.75rem;">
                  <a class="btn blue mb-1 mr-2" onclick="showHide('mod_addlocat')" tabindex="0">Add Store Location</a>
                  <a class="btn blue mb-1" onclick="showHide('mod_deltlocat')" tabindex="0">Remove</a>
                  <fieldset id="stock_wrapper" required>
                    <?php foreach ($data['prdstk'] as $row) : ?>
                      <label>Quantity At: <?php echo $row['loca_name']; ?>
                        <input id="dynm_locat_stock_<?php echo $row['stok_loca_code']; ?>" type="text" required value="<?php echo $row['stok_quantity']; ?>">
                      </label>
                    <?php endforeach; ?>
                  </fieldset>
                  <!-- <div class="dynamic-wrap" id="stock_wrapper"></div> -->
                  <span class="empty">No Stock & Location Info Added</span>
                </div>
              </div>
            </section>
          </div>
          <div class="col col-sm-6 pl-sm-4">
            <div class="row pb-3">
              <b>Sales Information</b>
            </div>
            <section class="">
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Retail Price</label>
                <input class="" id="prodt_rtlprice" name="prodt_rtlprice" type="text" placeholder="" required value="<?php echo $data['prodt']['prod_retl_price']; ?>">
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Wholesale Price</label>
                <input class="" id="prodt_wslprice" name="prodt_wslprice" type="text" placeholder="" required value="<?php echo $data['prodt']['prod_whsa_price']; ?>">
              </div>
            </section>
            <div class="row pt-3 pb-3">
              <b>Vendor Information</b>
            </div>
            <section class="">
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Vendor Name</label>
                <select class="" id="prodt_vendor" name="prodt_vendor" required>
                  <?php foreach ($data['vendr'] as $row) : ?>
                    <option value="<?php echo $row['vend_code']; ?>" <?php echo ($data['prodt']['prod_vend_code'] == $row['vend_code']) ? 'selected' : ''; ?>>
                      <?php echo $row['vend_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Vendor's Part No.</label>
                <input class="" id="prodt_vendprtno" name="prodt_vendprtno" type="text" placeholder="" required value="<?php echo $data['prodt']['prod_vend_prtno']; ?>">
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Vendor's Price</label>
                <input class="" id="prodt_vendprice" name="prodt_vendprice" type="text" placeholder="" required value="<?php echo $data['prodt']['prod_vend_price']; ?>">
              </div>
            </section>
          </div>
        </div>


        <div class="row pt-3 pb-3">
          <b>Additional Information</b>
        </div>
        <section class="">
          <div class="row">
            <div class="col col-sm-6 pr-sm-3">
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Attributes</label>
                <div class="border-wrap p-2" id="prodt_attributes" style="min-height: 10.25rem;">
                  <a class="btn blue mb-1 mr-2" onclick="showHide('mod_addattrb')" tabindex="0">Add Attributes</a>
                  <a class="btn blue mb-1" onclick="showHide('mod_deltattrb')" tabindex="0">Remove</a>
                  <fieldset id="attribute_wrapper">
                    <?php foreach ($data['prdatv'] as $row) : ?>
                      <label>Attribute: <?php echo $row['attp_name']; ?>
                        <select id="dynm_attrb_atval_<?php echo $row['attp_code'] ?>" required>
                          <?php foreach ($row['atval_list'] as $row2) : ?>
                            <option value="<?php echo $row2['atvl_code']; ?>" <?php echo ($row['atvl_code'] == $row2['atvl_code']) ? 'selected' : ''; ?>>
                              <?php echo $row2['atvl_value']; ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </label>
                    <?php endforeach; ?>
                  </fieldset>
                  <!-- <div class="dynamic-wrap" id="attribute_wrapper"></div> -->
                  <span class="empty">No Additional Attributes Added</span>
                </div>
              </div>
            </div>
            <div class="col col-sm-6 pl-sm-3">
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Product Description</label>
                <textarea class="" id="prodt_descrip" name="prodt_descrip" type="text" placeholder="" rows="4" required><?php echo $data['prodt']['prod_descrip']; ?></textarea>
                <span aria-live="polite"></span>
              </div>
              <div class="row pb-2 pb-sm-3">
                <label class="mb-1">Status</label>
                <select class="" id="prodt_state" name="prodt_state" required>
                  <option value="1" <?php echo ($data['prodt']['prod_active'] == '1') ? 'selected' : ''; ?>>Active</option>
                  <option value="2" <?php echo ($data['prodt']['prod_active'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                </select>
              </div>
            </div>
          </div>
        </section>

        <div class="row pt-3">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset" onclick="goBack();">Cancel</button>
        </div>

      </form>
      <!-- <a class="btn orange" onclick="myFunc()">Go To Top</a> -->
    </div>
  </div>
</main>

<div id="mod_addlocat" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addlocat')">&times;</span>
    <div class="modal-header">
      <h4>Add Store Location</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-3">
        <p>Select Location you wanted to add.</p>
      </div>
      <div class="row pb-2 pb-sm-3">
        <label class="mb-1">Location</label>
        <select class="" id="selt_locat_stock" name="selt_locat_stock" data-name-text="Quantity At: " required autocomplete="off">
          <option value="" selected></option>
          <?php foreach ($data['locat'] as $row) : ?>
            <option value="<?php echo $row['loca_code']; ?>" <?php echo ($row['selected']) ? 'disabled' : ''; ?>>
              <?php echo $row['loca_name']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row pt-3">
        <button class="btn green mr-3" onclick="stockField.addFields(); showHide('mod_addlocat');">Add</button>
        <button class="btn blue" type="button" onclick="showHide('mod_addlocat')">Cancel</button>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>
<div id="mod_deltlocat" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltlocat')">&times;</span>
    <div class="modal-header">
      <h4>Remove Store Location</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-3">
        <p>Select Location you wanted to remove.</p>
      </div>
      <div class="row pb-2 pb-sm-3">
        <label class="mb-1">Location</label>
        <select class="" id="delt_locat_stock" name="delt_locat_stock" required autocomplete="off">
          <option value="" selected></option>
          <?php foreach ($data['locat'] as $row) : ?>
            <option value="<?php echo $row['loca_code']; ?>" <?php echo ($row['selected']) ? '' : 'disabled'; ?>>
              <?php echo $row['loca_name']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row right pt-3">
        <button class="btn blue" type="button" onclick="showHide('mod_deltlocat')">Cancel</button>
        <button class="btn red ml-3" onclick="stockField.rmvFields(); showHide('mod_deltlocat');">Remove</button>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_addattrb" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addattrb')">&times;</span>
    <div class="modal-header">
      <h4>Add Attribute</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-3">
        <p>Select Attribute you wanted to add.</p>
      </div>
      <div class="row pb-2 pb-sm-3">
        <label class="mb-1">Attribute Name</label>
        <select class="" id="selt_attrb_atval" name="selt_attrb_atval" data-name-text="Attribute: " required autocomplete="off">
          <option value="" selected></option>
          <?php foreach ($data['attrb'] as $row) : ?>
            <option value="<?php echo $row['attp_code']; ?>" <?php echo ($row['selected']) ? 'disabled' : ''; ?>>
              <?php echo $row['attp_name']; ?>
            </option>
          <?php endforeach; ?>
        </select>

      </div>
      <div class="row pt-3">
        <button class="btn green mr-3" onclick="attrbField.addFields(); showHide('mod_addattrb');">Add</button>
        <button class="btn blue" type="button" onclick="showHide('mod_addattrb')">Cancel</button>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>
<div id="mod_deltattrb" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltattrb')">&times;</span>
    <div class="modal-header">
      <h4>Remove Attribute</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-3">
        <p>Select Attribute you wanted to remove.</p>
      </div>
      <div class="row pb-2 pb-sm-3">
        <label class="mb-1">Attribute Name</label>
        <select class="" id="delt_attrb_atval" name="delt_attrb_atval" required autocomplete="off">
          <option value="" selected></option>
          <?php foreach ($data['attrb'] as $row) : ?>
            <option value="<?php echo $row['attp_code']; ?>" <?php echo ($row['selected']) ? '' : 'disabled'; ?>>
              <?php echo $row['attp_name']; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="row right pt-3">
        <button class="btn blue" type="button" onclick="showHide('mod_deltattrb')">Cancel</button>
        <button class="btn red ml-3" onclick="attrbField.rmvFields(); showHide('mod_deltattrb');">Remove</button>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>products/";
  /////////////////////////////////////////////////////////////////////////////

  let stockField = new DynamicFields('stock_wrapper', 'selt_locat_stock', 'delt_locat_stock');
  stockField.setCustomField("input", {
    type: "text",
    required: "" // no need attribute value for boolean attributes
  });

  /////////////////////////////////////////////////////////////////////////////

  let attrbField = new DynamicFields('attribute_wrapper', 'selt_attrb_atval', 'delt_attrb_atval');
  attrbField.setCustomField("select", {
    required: ""
  });
  attrbField.setChildCallback(getChildren);
  attrbField.addFields();

  async function getChildren(parentId, elementId) {
    // console.log(parentId, elementId);
    let serverCall = new ServerCall(`${urlroot}getAttributVal/${parentId}`);
    serverCall.setMethod = "GET";
    const resp = await serverCall.fetchServer();
    let htmlStr = `<option value="" selected></option>`;
    for (const key in resp['atval']) {
      htmlStr += `<option value="${resp['atval'][key]['atval_id']}">${resp['atval'][key]['atval_name']}</option>`;
    }
    document.getElementById(elementId).innerHTML = htmlStr;
  }
  /////////////////////////////////////////////////////////////////////////////

  function prodtEdited() {
    resetFile('prodt_image', 'image_wrapper');
    console.log("prodtEdited");
    location.href = urlroot;
  }

  let editProdt = new FormHandler('edit_prodt', 'edit_prodt_msg', `${urlroot}editProduct`);
  editProdt.setCallback(prodtEdited);
  editProdt.setMaxFileLimit(3);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>