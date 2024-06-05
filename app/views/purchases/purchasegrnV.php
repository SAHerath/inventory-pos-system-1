<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>Good Received Note</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>purchases">Purchase Order</a></li>
      <li>Good Received Note</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card">
      <form id="grn_purch" name="grn_purch" novalidate autocomplete="off">
        <span id="grn_purch_msg" class="status" aria-live="polite"></span>

        <div class="row pb-sm-1">
          <div class="col col-sm-6 pr-sm-3">
            <div class="row pb-2 pb-sm-3">
              <span class="col-4 pr-2">Order No:</span>
              <span class="col-7 pl-2"><?php echo $data['purch']['prch_no']; ?></span>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <div class="row pb-2 pb-sm-3">
              <span class="col-4 pr-2">Vendor Name:</span>
              <span class="col-7 pl-2"><?php echo $data['vendr']['vend_name']; ?></span>
            </div>
          </div>
        </div>

        <div class="row pb-2 pb-sm-2">
          <div class="col col-sm-6 pr-sm-3">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Order Id</label> -->
            <input class="" id="purch_id" name="purch_id" type="hidden" placeholder="" required value="<?php echo $data['purch']['prch_code']; ?>" hidden>
            <!-- </div> -->
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Location</label> -->
            <input class="" id="purch_locat" name="purch_locat" type="hidden" placeholder="" required value="<?php echo $data['purch']['prch_loca_code']; ?>" hidden>
            <!-- </div> -->
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Date</label>
              <input class="" id="purch_recev_date" name="purch_recev_date" type="date" placeholder="" required value="<?php echo $data['date']; ?>">
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-3">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Location</label>

            </div> -->
          </div>
        </div>

        <div class="row pb-2 mb-4 table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" title="Stock Keeping Unit" style="width: 150px;">SKU</div>
                <div class="th" title="Vendor Part Number">Vendor Part No</div>
                <div class="th" title="Ordered Quantity" style="width: 100px;">Ord. Qty</div>
                <div class="th" title="Received Quantity" style="width: 100px;">Rec. Qty</div>
                <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
                <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
                <!-- <div class="th" style="width: 80px;">Action</div> -->
              </div>
            </div>

            <div class="tbody stripes" id="dl_tbl_body">

              <?php foreach ($data['ordprd'] as $id => $row) : ?>
                <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_purch_sku" type="text" disabled value="<?php echo $row['prodt_sku']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_purch_prt" type="text" disabled value="<?php echo $row['prod_vend_prtno']; ?>">
                  </div>
                  <div class="td">
                    <!-- ordered qty -->
                    <input id="tblr_<?php echo $id + 1; ?>_purch_ord" type="number" disabled value="<?php echo $row['pcpd_order_qty']; ?>">
                  </div>
                  <div class="td">
                    <!-- received qty -->
                    <input id="tblr_<?php echo $id + 1; ?>_purch_rec" type="number" value="<?php echo $row['pcpd_order_qty']; ?>" max="<?php echo $row['pcpd_order_qty']; ?>" min="0">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_purch_rat" class="txt-right" type="text" disabled value="<?php echo $row['pcpd_unit_price']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_purch_amt" class="txt-right" type="text" disabled>
                  </div>
                  <!-- <div class="td txt-center">
                    <button class="btn-sm red" type="button" title="Remove Product">
                      <i class="fas fa-times"></i>
                    </button>
                  </div> -->
                </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>


        <div class="row pb-3">
          <div class="col col-sm-6 pr-sm-4 pr-md-6">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Payment Method</label>
              <select class="" id="order_paymeth" name="order_paymeth" required>
                <option value="" selected></option>
                <option value="Cash">Cash</option>
                <option value="Credit">Credit</option>
                <option value="Cheque">Cheque</option>
              </select>
            </div> -->
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Remarks</label>
              <textarea class="" id="purch_remarks" name="purch_remarks" type="text" placeholder="" rows="3"><?php echo $data['purch']['prch_remark']; ?></textarea>
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-4 pl-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Sub Total</label>
              <input class="txt-right" id="purch_subtotal" name="purch_subtotal" type="text" placeholder="" required disabled>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Additinal Charges</label>
              <input onchange="calculatePay();" class="txt-right" id="purch_addcharg" name="purch_addcharg" type="text" placeholder="" required value="<?php echo $data['purch']['prch_charges']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Total</b></label>
              <input class="txt-right" id="purch_totalamt" name="purch_totalamt" type="text" placeholder="" required disabled>
            </div>
            <!-- <div class="row pb-2 pb-sm-3 mt-3">
              <label class="mb-1">Paid</label>
              <input onchange="calculatePay();" class="txt-right" id="purch_paidamt" name="purch_paidamt" type="text" placeholder="" required value="0.00">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Balance</b></label>
              <input class="txt-right" id="purch_balance" name="purch_balance" type="text" placeholder="" required disabled>
            </div> -->
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

  function updateRowTbl(rowId) {
    let inpQtyVal = document.getElementById(rowId + "_purch_rec").value;
    let inpRatVal = document.getElementById(rowId + "_purch_rat").value;
    document.getElementById(rowId + "_purch_amt").value = (inpRatVal * inpQtyVal).toFixed(2);
  }

  function removeRowTbl() {
    let tblRow = this.parentElement.parentElement;
    // console.log("remove row", tblRow.id);
    tblRow.remove();
    calculatePay();
  }

  function calculateAll() {
    let tblRowId = this.parentElement.parentElement.id;
    updateRowTbl(tblRowId);
    calculatePay();
  }

  function calculatePay() {
    var subTotal = 0;
    for (let ind = 1; ind < tblRowCount; ind++) {
      let inpAmt = document.getElementById("tblr_" + ind + "_purch_amt");
      if (inpAmt) {
        subTotal = subTotal + (+inpAmt.value); // unary operator makes it number
      }
    }
    // console.log("Total", subTotal);
    document.getElementById("purch_subtotal").value = subTotal.toFixed(2);
    let inpOther = document.getElementById("purch_addcharg");
    inpOther.value = (+inpOther.value).toFixed(2);
    let totalAmt = (subTotal + (+inpOther.value));
    document.getElementById("purch_totalamt").value = totalAmt.toFixed(2);
    // let inpPaid = document.getElementById("purch_paidamt");
    // inpPaid.value = (+inpPaid.value).toFixed(2);
    // let balance = (+inpPaid.value) - totalAmt;
    // document.getElementById("purch_balance").value = balance.toFixed(2);
  }



  function addEvents() {
    for (let ind = 1; ind < tblRowCount; ind++) {
      console.log('addEvents', ind);
      // let inpSku = document.getElementById("tblr_" + ind + "_order_sku");
      let inpQty = document.getElementById("tblr_" + ind + "_purch_rec");
      // let btnDel = document.getElementById("tblr_" + ind).getElementsByTagName("button")[0];
      // inpSku.addEventListener('keyup', checkInput);
      inpQty.addEventListener('input', calculateAll);
      // btnDel.addEventListener('click', removeRowTbl);
      updateRowTbl("tblr_" + ind);
    }
  }

  const tblBody = document.getElementById("dl_tbl_body");
  var tblRowCount = <?php echo $data['prdcon'] + 1; ?>;
  addEvents();
  calculatePay();

  // var tblRowCount = 1;
  // tblBody.appendChild(createTblRow(tblRowCount++));

  function purchaseReceived() {
    console.log("purchaseOrderReceived");
    location.href = urlroot;
  }

  let grnOrder = new FormHandler('grn_purch', 'grn_purch_msg', `${urlroot}receivePurchase`);
  grnOrder.setCallback(purchaseReceived);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>