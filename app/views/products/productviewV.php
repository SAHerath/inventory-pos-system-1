<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>View Product</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>products">Product</a></li>
      <li>View Product</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card p-sm-4 pt-md-5 pr-md-6 pl-md-6">

      <div class="row mb-5 gallery" id="image_gallery">
        <?php foreach ($data['image'] as $row) : ?>
          <div class="col col-sm-4 pr-sm-1">
            <img src="<?php echo URLROOT; ?>img/uploads/product/<?php echo $row['impr_img_name']; ?>" alt="Product Image">
          </div>
        <?php endforeach; ?>
      </div>

      <div>
        <div class="row pb-3 ">
          <b>Product Details</b>
        </div>
        <div class="row pb-5">
          <div class="col col-sm-6 pr-sm-4 pr-md-5">
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">SKU:</span>
              <span class="col-6 pl-2"><?php echo $data['prodt']['prod_sku']; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Name:</span>
              <span class="col-6 pl-2"><?php echo $data['prodt']['prod_name']; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Category:</span>
              <span class="col-6 pl-2"><?php echo $data['categ']['categ_name']; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Brand:</span>
              <span class="col-6 pl-2"><?php echo $data['brand']['brand_name']; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Status:</span>
              <span class="col-6 pl-2"><?php echo ($data['prodt']['prod_active'] == 1) ? 'Active' : 'Inactive'; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <div>
                <span class="row pb-2">Description</span>
                <div class="row pb-2">
                  <?php echo $data['prodt']['prod_descrip']; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-4 pl-md-5">
            <span class="row pb-2">Barcode</span>
            <div class="row pb-2 pb-sm-3">
              <?php echo $data['bcode']; ?>
            </div>
            <div>
              <span class="row pb-2">Attributes</span>
              <?php foreach ($data['attrb'] as $row) : ?>
                <div class="row pb-2 pb-sm-3">
                  <span class="col-6 pr-2"><?php echo $row['attp_name']; ?>:</span>
                  <span class="col-6 pl-2"><?php echo $row['atvl_value']; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="row pb-5 ">
        <div class="col col-sm-6 pr-sm-4 pr-md-5">
          <div class="row pb-3">
            <b>Sales Details</b>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Retail Price:</span>
            <span class="col-6 pl-2"><?php echo $data['prodt']['prod_retl_price']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Wholesale Price:</span>
            <span class="col-6 pl-2"><?php echo $data['prodt']['prod_whsa_price']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Tax Rule:</span>
            <span class="col-6 pl-2">Number</span>
          </div>
        </div>
        <div class="col col-sm-6 pl-sm-4 pl-md-5">
          <div class="row pb-3">
            <b>Vendor Details</b>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Vendor Name:</span>
            <span class="col-6 pl-2"><?php echo $data['vendr']['vendr_name']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Vendor Part No.:</span>
            <span class="col-6 pl-2"><?php echo $data['prodt']['prod_vend_prtno']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Vendor Price:</span>
            <span class="col-6 pl-2"><?php echo $data['prodt']['prod_vend_price']; ?></span>
          </div>
        </div>
      </div>

      <div>
        <div class="row pb-3 ">
          <b>Stock Details</b>
        </div>
        <div class="row pb-5">
          <div class="col col-sm-6 pr-sm-4 pr-md-5">
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Reorder Level:</span>
              <span class="col-6 pl-2"><?php echo $data['prodt']['prod_reod_level']; ?></span>
            </div>
            <div class="row pb-2 pb-sm-3">
              <span class="col-6 pr-2">Reorder Quantity:</span>
              <span class="col-6 pl-2"><?php echo $data['prodt']['prod_reod_quant']; ?></span>
            </div>
          </div>
          <!-- <div class="col-auto col-md-2"></div> -->
          <div class="col col-sm-6 pl-sm-4 pl-md-5">
            <div>
              <span class="row pb-2">Quantity</span>
              <?php foreach ($data['stock'] as $row) : ?>
                <div class="row pb-2 pb-sm-3">
                  <span class="col-6 pr-2"><?php echo $row['loca_name']; ?>:</span>
                  <span class="col-6 pl-2"><?php echo $row['stok_quantity']; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <a class="btn blue mr-3" href="<?php echo URLROOT; ?>products">Back</a>
        <a class="btn yellow" href="<?php echo URLROOT; ?>products/edit/<?php echo $data['prodt']['prod_code']; ?>">Edit</a>
      </div>

    </div>
  </div>
</main>

<div id="mod_showgallery" class="modal">
  <div class="modal-content max-width">
    <span class="modal-close" onclick="showHide('mod_showgallery')">&times;</span>
    <div class="modal-header"></div>
    <div class="modal-body center">
      <img class="" id="preview_image" style="max-height: 30rem;">
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>products/";
  /////////////////////////////////////////////////////////////////////////////

  const galleryImgs = document.getElementById("image_gallery").getElementsByTagName("IMG");
  console.log(galleryImgs);
  let imgLen = galleryImgs.length;
  if (imgLen) {
    for (let i = 0; i < imgLen; i++) {
      galleryImgs.item(i).addEventListener("click", viewImage);
    }
  }

  function viewImage() {
    console.log(this);
    const modalImage = document.getElementById("preview_image");
    modalImage.src = this.src;
    modalImage.alt = this.alt;
    showHide('mod_showgallery');
  }
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>