<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <h2>View Purchase Order</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>purchases">Purchase Order</a></li>
      <li>View Purchase Order</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card p-sm-4 pt-md-4 pr-md-5 pl-md-5">

      <div class="row pb-4">
        <div class="col col-sm-6 o-sm-2 pl-sm-4 pl-md-8">
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Order No:</span>
            <span class="col-7 pl-2"><?php echo $data['pordr']['pordr_no']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Date:</span>
            <span class="col-7 pl-2"><?php echo $data['pordr']['prch_date']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Status:</span>
            <span class="col-7 pl-2"><?php echo $data['pordr']['prch_status']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Location:</span>
            <span class="col-7 pl-2"><?php echo $data['locat']['loca_name']; ?></span>
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

      <div class="row pb-2">Ordered Details:</div>
      <div class="row pb-2 mb-4 table-wrap">
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th" title="Stock Keeping Unit" style="width: 150px;">SKU</div>
              <div class="th" title="Vendor Part Number" style="width: 200px;">Vendor Part No</div>
              <div class="th" title="Quantity" style="width: 80px;">Qty</div>
              <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
              <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
            </div>
          </div>

          <div class="tbody stripes" id="dl_tbl_body">

            <?php foreach ($data['ordprd'] as $id => $row) : ?>
              <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                <div class="td">
                  <span><?php echo $row['prodt_sku']; ?></span>
                </div>
                <div class="td">
                  <span><?php echo $row['prod_vend_prtno']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_quantity']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_sub_amount']; ?></span>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="row pb-2">Received Details:</div>
      <div class="row pb-2 mb-4 table-wrap">
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th" title="Stock Keeping Unit" style="width: 150px;">SKU</div>
              <div class="th" title="Vendor Part Number" style="width: 200px;">Vendor Part No</div>
              <div class="th" title="Quantity" style="width: 80px;">Qty</div>
              <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
              <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
            </div>
          </div>

          <div class="tbody stripes" id="dl_tbl_body">

            <?php foreach ($data['ordprd'] as $id => $row) : ?>
              <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                <div class="td">
                  <span><?php echo $row['prodt_sku']; ?></span>
                </div>
                <div class="td">
                  <span><?php echo $row['prod_vend_prtno']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_qty_receiv']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_sub_amount']; ?></span>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="row pb-2">Return Details:</div>
      <div class="row pb-2 mb-4 table-wrap">
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th" title="Stock Keeping Unit" style="width: 150px;">SKU</div>
              <div class="th" title="Vendor Part Number" style="width: 200px;">Vendor Part No</div>
              <div class="th" title="Quantity" style="width: 80px;">Qty</div>
              <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
              <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
            </div>
          </div>

          <div class="tbody stripes" id="dl_tbl_body">

            <?php foreach ($data['ordprd'] as $id => $row) : ?>
              <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                <div class="td">
                  <span><?php echo $row['prodt_sku']; ?></span>
                </div>
                <div class="td">
                  <span><?php echo $row['prod_vend_prtno']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_qty_return']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_sub_amount']; ?></span>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col col-sm-6 pr-sm-4 pr-md-6">
          <!-- <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Payment Method:</span>
            <span class="col-6 pl-2"></span>
          </div> -->
        </div>
        <div class="col col-sm-6 pl-sm-4 pr-sm-4 pl-md-6">
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Sub Total:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['pordr']['prch_sub_total']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Other Charges:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['pordr']['prch_charges']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Total:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['pordr']['prch_total']; ?></b></span>
          </div>
          <div class="row pb-2 pb-sm-3 mt-3">
            <span class="col-6 pr-2">Paid:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['pordr']['prch_paid']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Balance:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['pordr']['prch_balance']; ?></b></span>
          </div>
        </div>
      </div>

      <div class="row">
        <a class="btn blue mr-3" href="<?php echo URLROOT; ?>purchases">Back</a>
        <a class="btn yellow mr-3" href="<?php echo URLROOT; ?>purchases/edit/<?php echo $data['pordr']['prch_code']; ?>">Edit</a>
        <a class="btn purple mr-3" href="<?php echo URLROOT; ?>purchases/print/po/<?php echo $data['pordr']['prch_code']; ?>">Print</a>
        <a class="btn purple mr-3" href="<?php echo URLROOT; ?>purchases/print/rn/<?php echo $data['pordr']['prch_code']; ?>">Print</a>
        <a class="btn purple mr-3" href="<?php echo URLROOT; ?>purchases/print/pr/<?php echo $data['pordr']['prch_code']; ?>">Print</a>
      </div>


    </div>
  </div>
</main>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>purchases/";
  /////////////////////////////////////////////////////////////////////////////
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>