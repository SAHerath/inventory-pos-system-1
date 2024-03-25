<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <h2>View Order</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>orders">Order</a></li>
      <li>View Order</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card p-sm-4 pt-md-4 pr-md-5 pl-md-5">
      <div class="row pb-4">
        <div class="col col-sm-6 o-sm-2 pl-sm-4 pl-md-8">
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Order No:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['order_num']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Date:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['ordr_date']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Status:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['ordr_status']; ?></span>
          </div>
        </div>
        <div class="col col-sm-6 o-sm-1 pr-sm-4 pr-md-6">
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Customer Name:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['ordr_cust_name']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Phone:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['ordr_cust_phone']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <div>
              <span class="row pb-2">Billing Address</span>
              <div class="row pb-2">
                <?php echo $data['order']['ordr_cust_address']; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row pb-2 mb-4 table-wrap">
        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th" title="Stock Keeping Unit" style="width: 150px;">SKU</div>
              <div class="th" title="Product Name/Id" style="width: 200px;">Product</div>
              <div class="th" title="Quantity" style="width: 80px;">Qty</div>
              <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
              <div class="th" title="Discount" style="width: 100px;">Disc</div>
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
                  <span><?php echo $row['prod_name']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['odpd_quantity']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['odpd_unit_price']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['odpd_discount']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['odpd_sub_amount']; ?></span>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col col-sm-6 pr-sm-4 pr-md-6">
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Payment Method:</span>
            <span class="col-6 pl-2"><?php echo $data['order']['ordr_pay_method']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Tax %:</span>
            <span class="col-6 pl-2"><?php echo $data['taxp']; ?></span>
          </div>
        </div>
        <div class="col col-sm-6 pl-sm-4 pr-sm-4 pl-md-6">
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Sub Total:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['order']['ordr_sub_total']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Total Tax:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['order']['ordr_taxes']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Total:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['order']['ordr_total']; ?></b></span>
          </div>
          <div class="row pb-2 pb-sm-3 mt-3">
            <span class="col-6 pr-2">Paid:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['order']['ordr_paid']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Balance:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['order']['ordr_balance']; ?></b></span>
          </div>
        </div>
      </div>

      <div class="row">
        <a class="btn blue mr-3" href="<?php echo URLROOT; ?>orders">Back</a>
        <a class="btn yellow mr-3" href="<?php echo URLROOT; ?>orders/edit/<?php echo $data['order']['ordr_code']; ?>">Edit</a>
        <?php if ($data['order']['ordr_status']) : ?>
          <a class="btn green mr-3" href="<?php echo URLROOT; ?>orders/print/<?php echo $data['order']['ordr_code']; ?>">Print</a>
        <?php endif; ?>
      </div>


    </div>
  </div>
</main>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>orders/";
  /////////////////////////////////////////////////////////////////////////////
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>