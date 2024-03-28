<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <h2>Add PO Receive Info</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>purchases">Purchase Order</a></li>
      <li><a href="<?php echo URLROOT; ?>purchases">Purchase Order View</a></li>
      <li>Add PO Receive Info</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card">
      <form id="recev_pordr" name="recev_pordr" novalidate autocomplete="off">
        <span id="recev_pordr_msg" class="status" aria-live="polite"></span>

        <div class="row pb-4">
          <div class="col col-sm-6 o-sm-2 pl-sm-4 pl-md-8">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Order Id</label> -->
            <input class="" id="pordr_id" name="pordr_id" type="hidden" placeholder="" required value="<?php echo $data['pordr']['prch_code']; ?>" hidden>
            <!-- </div> -->
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Received Date</label>
              <input class="" id="pordr_date" name="pordr_date" type="date" placeholder="" required value="<?php echo $data['date']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Received Location</label>
              <select class="" id="pordr_locat" name="pordr_locat" required>
                <?php foreach ($data['locat'] as $row) : ?>
                  <option value="<?php echo $row['loca_code']; ?>" <?php echo ($data['pordr']['prch_loca_code'] == $row['loca_code']) ? 'selected' : ''; ?>>
                    <?php echo $row['loca_name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col col-sm-6 o-sm-1 pr-sm-4 pr-md-6">
            <div class="row pb-2">
              <span class="row">Vendor Details:</span>
            </div>
            <div class="row pb-2 ml-3">
              <span class="col-4 pr-2">Name:</span>
              <span class="col-7 pl-2"><?php echo $data['vendr']['vend_name']; ?></span>
            </div>
            <div class="row pb-2 ml-3">
              <span class="col-4 pr-2">Contact:</span>
              <span class="col-7 pl-2"><?php echo $data['vendr']['vend_phone']; ?></span>
            </div>
            <div class="row pb-2 ml-3">
              <span class="col-4 pr-2">Address:</span>
              <div class="col-7 pl-2">
                <span class="row"><?php echo $data['vendr']['vend_address']; ?></span>
                <span class="row"><?php echo $data['vendr']['vend_city']; ?></span>
                <span class="row"><?php echo $data['vendr']['vend_country']; ?></span>
              </div>
            </div>
            <div class="row pb-2 ml-3">
              <span class="col-4 pr-2">Email:</span>
              <span class="col-7 pl-2"><?php echo $data['vendr']['vend_email']; ?></span>
            </div>
          </div>
        </div>

        <div class="row pb-2 mb-4 table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" title="Stock Keeping Unit">SKU</div>
                <div class="th" title="Vendor Part Number">Vendor Part No</div>
                <div class="th" title="Quantity" style="width: 120px;">Received Qty</div>
                <div class="th" style="width: 120px;">Action</div>
              </div>
            </div>

            <div class="tbody stripes" id="dl_tbl_body">

              <?php foreach ($data['ordprd'] as $id => $row) : ?>
                <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_pordr_sku" type="text" placeholder="Enter Barcode" disabled value="<?php echo $row['prodt_sku']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_pordr_prt" type="text" disabled value="<?php echo $row['prod_vend_prtno']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_pordr_qty" type="number" value="<?php echo $row['pcpd_qty_receiv']; ?>">
                  </div>
                  <div class="td txt-center">
                    <button class="btn-sm red" type="button" title="Remove Product">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>

        <div class="row">
          <button class="btn green mr-2" type="submit">Save</button>
          <button class="btn blue ml-2" type="reset" onclick="goBack();">Cancel</button>
        </div>

      </form>
    </div>
  </div>
</main>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>purchases/";
  /////////////////////////////////////////////////////////////////////////////


  function removeRowTbl() {
    let tblRow = this.parentElement.parentElement;
    // console.log("remove row", tblRow.id);
    tblRow.remove();
  }

  function addEvents() {
    for (let ind = 1; ind < tblRowCount; ind++) {
      let btnDel = document.getElementById("tblr_" + ind).getElementsByTagName("button")[0];
      btnDel.addEventListener('click', removeRowTbl);
    }
  }

  const tblBody = document.getElementById("dl_tbl_body");
  var tblRowCount = <?php echo $data['prdcon'] + 1; ?>;
  addEvents();

  function pordrEdited() {
    console.log("pordrEdited");
    location.href = urlroot;
  }

  let editOrder = new FormHandler('recev_pordr', 'recev_pordr_msg', `${urlroot}recevOrder`);
  editOrder.setCallback(pordrEdited);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>