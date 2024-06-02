<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>View Purchase Order</span>
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
            <span class="col-7 pl-2"><?php echo $data['purch']['prch_no']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Status:</span>
            <span class="col-7 pl-2"><?php echo $data['purch']['prch_status']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-4 pr-2">Location:</span>
            <span class="col-7 pl-2"><?php echo $data['locat']['loca_name']; ?></span>
          </div>
        </div>
        <div class="col col-sm-6 o-sm-1 pr-sm-4 pr-md-6">
          <div class="row pb-2 pb-sm-3">
            <span class="row"><b>Vendor Details:</b></span>
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

      <!-- Order Details -->
      <div class="row pb-2 pb-sm-1"><b>Order Details:</b></div>
      <div class="row pb-2 pb-sm-1">
        <div class="col col-sm-6 pr-sm-3">

        </div>
        <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
          <div class="row pb-2">
            <span class="col-4 ">Date:</span>
            <span class="col-7 pl-2"><?php echo $data['purch']['prch_order_date']; ?></span>
          </div>
        </div>
      </div>

      <div class="row pb-2 table-wrap">
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
                  <span class="txt-right"><?php echo $row['pcpd_order_qty']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                </div>
                <div class="td">
                  <span class="txt-right"><?php echo ($row['pcpd_unit_price'] * $row['pcpd_order_qty']); ?></span>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <div class="row pb-2 pb-sm-3">
        <div class="col col-sm-6 pr-sm-3">
          <div class="row pb-2">
            <span class="col-4 ">Ordered By:</span>
            <span class="col-7 pl-2"><?php echo $data['users']['order']['user_username']; ?></span>
          </div>
        </div>
        <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
          <div class="row pb-2 end-h">
            <a class="btn purple" href="<?php echo URLROOT; ?>purchases/print/po/<?php echo $data['purch']['prch_code']; ?>">Print</a>
          </div>
        </div>
      </div>

      <!-- Receive Details -->
      <div class="row pb-2 pb-sm-1"><b>Receive Details:</b></div>
      <?php if ($data['users']['recev']) : ?>

        <div class="row pb-2 pb-sm-1">
          <div class="col col-sm-6 pr-sm-3">

          </div>
          <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
            <div class="row pb-2">
              <span class="col-4 ">Date:</span>
              <span class="col-7 pl-2"><?php echo $data['purch']['prch_recev_date']; ?></span>
            </div>
          </div>
        </div>

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
                    <span class="txt-right"><?php echo $row['pcpd_recev_qty']; ?></span>
                  </div>
                  <div class="td">
                    <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                  </div>
                  <div class="td">
                    <span class="txt-right"><?php echo ($row['pcpd_unit_price'] * $row['pcpd_recev_qty']); ?></span>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>

        <div class="row pb-2 pb-sm-3">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2">
              <span class="col-4 ">Received By:</span>
              <span class="col-7 pl-2"><?php echo $data['users']['recev']['user_username']; ?></span>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
            <div class="row pb-2 end-h">
              <a class="btn purple" href="<?php echo URLROOT; ?>purchases/print/rn/<?php echo $data['purch']['prch_code']; ?>">Print</a>
            </div>
          </div>
        </div>
      <?php else : ?>
        <div class="row pt-2 pb-2 pb-sm-4">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2">
              <span class="">Received information not available.</span>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <div class="row pb-2 end-h">
              <a class="btn orange" href="<?php echo URLROOT; ?>purchases/grn/<?php echo $data['purch']['prch_code']; ?>">Receive</a>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Return Details -->
      <div class="row pb-2 pb-sm-1"><b>Return Details:</b></div>
      <?php if ($data['users']['retrn']) : ?>

        <div class="row pb-2 pb-sm-1">
          <div class="col col-sm-6 pr-sm-3">

          </div>
          <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
            <div class="row pb-2">
              <span class="col-4 ">Date:</span>
              <span class="col-7 pl-2"><?php echo $data['purch']['prch_retrn_date']; ?></span>
            </div>
          </div>
        </div>
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
                    <span class="txt-right"><?php echo $row['pcpd_retrn_qty']; ?></span>
                  </div>
                  <div class="td">
                    <span class="txt-right"><?php echo $row['pcpd_unit_price']; ?></span>
                  </div>
                  <div class="td">
                    <span class="txt-right"><?php echo ($row['pcpd_unit_price'] * $row['pcpd_retrn_qty']); ?></span>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>

        <div class="row pb-2 pb-sm-3">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2">
              <span class="col-4 ">Returned By:</span>
              <span class="col-7 pl-2"><?php echo $data['users']['retrn']['user_username']; ?></span>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3 pl-sm-4 pl-md-8">
            <div class="row pb-2 end-h">
              <a class="btn purple" href="<?php echo URLROOT; ?>purchases/print/rn/<?php echo $data['purch']['prch_code']; ?>">Print</a>
            </div>
          </div>
        </div>
      <?php else : ?>
        <div class="row pt-2 pb-2 pb-sm-4">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2">
              <span class="">Returned information not available.</span>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <div class="row pb-2 end-h">
              <a class="btn orange" href="<?php echo URLROOT; ?>purchases/return/<?php echo $data['purch']['prch_code']; ?>">Return</a>
            </div>
          </div>
        </div>
      <?php endif; ?>

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
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['purch']['prch_sub_total']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Other Charges:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['purch']['prch_charges']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Total:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['purch']['prch_total']; ?></b></span>
          </div>
          <div class="row pb-2 pb-sm-3 mt-3">
            <span class="col-6 pr-2">Paid:</span>
            <span class="col-6 pl-2 txt-right-sm"><?php echo $data['purch']['prch_paid']; ?></span>
          </div>
          <div class="row pb-2 pb-sm-3">
            <span class="col-6 pr-2">Balance:</span>
            <span class="col-6 pl-2 txt-right-sm"><b><?php echo $data['purch']['prch_balance']; ?></b></span>
          </div>
        </div>
      </div>

      <div class="row">
        <a class="btn blue mr-3" href="<?php echo URLROOT; ?>purchases">Back</a>
        <?php if (!$data['users']['recev']) : ?>
          <a class="btn yellow mr-3" href="<?php echo URLROOT; ?>purchases/edit/<?php echo $data['purch']['prch_code']; ?>">Edit</a>
        <?php endif; ?>
      </div>


    </div>
  </div>
</main>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>purchases/";
  /////////////////////////////////////////////////////////////////////////////
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>