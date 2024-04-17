<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>Edit Order</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>orders">Order</a></li>
      <li>Edit Order</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card">
      <form id="edit_order" name="edit_order" novalidate autocomplete="off">
        <span id="edit_order_msg" class="status" aria-live="polite"></span>

        <div class="row pb-4">
          <div class="col col-sm-6 o-sm-2 pl-sm-4 pl-md-8">
            <!-- <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Order Id</label> -->
            <input class="" id="order_id" name="order_id" type="hidden" placeholder="" required value="<?php echo $data['order']['ordr_code']; ?>" hidden>
            <!-- </div> -->
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Date</label>
              <input class="" id="order_date" name="order_date" type="date" placeholder="" required value="<?php echo $data['order']['ordr_date']; ?>">
            </div>
          </div>
          <div class="col col-sm-6 o-sm-1 pr-sm-4 pr-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Customer Name</label>
              <input class="" id="order_cusname" name="order_cusname" type="text" placeholder="" required value="<?php echo $data['order']['ordr_cust_name']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Phone</label>
              <input class="" id="order_cusphone" name="order_cusphone" type="text" placeholder="" required value="<?php echo $data['order']['ordr_cust_phone']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Billing Address</label>
              <textarea class="" id="order_cusaddress" name="order_cusaddress" type="text" placeholder="" rows="3" required><?php echo $data['order']['ordr_cust_address']; ?></textarea>
            </div>
          </div>
        </div>

        <div class="row pb-2 mb-4 table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" title="Stock Keeping Unit">SKU</div>
                <div class="th" title="Product Name/Id">Product</div>
                <div class="th" title="Quantity" style="width: 80px;">Qty</div>
                <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
                <div class="th" title="Discount Percentage" style="width: 100px;">Disc %</div>
                <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
                <div class="th">Action</div>
              </div>
            </div>

            <div class="tbody stripes" id="dl_tbl_body">

              <?php foreach ($data['ordprd'] as $id => $row) : ?>
                <div class="tr" id="tblr_<?php echo $id + 1; ?>">
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_order_sku" type="text" placeholder="Enter Barcode" disabled value="<?php echo $row['prodt_sku']; ?>">
                  </div>
                  <div class="td">
                    <input " id=" tblr_<?php echo $id + 1; ?>_order_prd"type="text value=" <?php echo $row['prod_name']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_order_qty" type="number" value="<?php echo $row['odpd_quantity']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_order_rat" class="txt-right" type="text" disabled value="<?php echo $row['odpd_unit_price']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_order_dis" class="txt-right" type="text" value="<?php echo $row['odpd_discount']; ?>">
                  </div>
                  <div class="td">
                    <input id="tblr_<?php echo $id + 1; ?>_order_amt" class="txt-right" type="text" disabled value="<?php echo $row['odpd_sub_amount']; ?>">
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

        <div class="row pb-3">
          <div class="col col-sm-6 pr-sm-4 pr-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Payment Method</label>
              <select class="" id="order_paymeth" name="order_paymeth" required>
                <!-- <option value="" selected></option> -->
                <option value="Cash" <?php echo ($data['order']['ordr_pay_method'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="Credit" <?php echo ($data['order']['ordr_pay_method'] == 'Credit') ? 'selected' : ''; ?>>Credit</option>
                <option value="Cheque" <?php echo ($data['order']['ordr_pay_method'] == 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
              </select>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Tax %</label>
              <input class="" id="order_taxrate" name="order_taxrate" type="text" placeholder="" required value="<?php echo $data['taxp']; ?>">
            </div>
          </div>
          <div class="col col-sm-6 pl-sm-4 pl-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Sub Total</label>
              <input class="txt-right" id="order_subtotal" name="order_subtotal" type="text" placeholder="" required disabled value="<?php echo $data['order']['ordr_sub_total']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Total Tax</label>
              <input class="txt-right" id="order_taxesall" name="order_taxesall" type="text" placeholder="" required disabled value="<?php echo $data['order']['ordr_taxes']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Total</b></label>
              <input class="txt-right" id="order_totalamt" name="order_totalamt" type="text" placeholder="" required disabled value="<?php echo $data['order']['ordr_total']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3 mt-3">
              <label class="mb-1">Paid</label>
              <input onchange="calculatePay();" class="txt-right" id="order_paidamt" name="order_paidamt" type="text" placeholder="" required value="<?php echo $data['order']['ordr_paid']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Balance</b></label>
              <input class="txt-right" id="order_balance" name="order_balance" type="text" placeholder="" required disabled value="<?php echo $data['order']['ordr_balance']; ?>">
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
  const urlroot = "<?php echo URLROOT; ?>orders/";
  /////////////////////////////////////////////////////////////////////////////

  async function addRowTbl(rowId, searchVal) {
    // console.log("addRowTbl", rowId, searchVal);
    let serverCall = new ServerCall(`${urlroot}getRowData`);
    serverCall.setData = new URLSearchParams({
      prodtSku: searchVal
    });
    const resp = await serverCall.fetchServer();
    // console.log(resp);
    if (resp['prodt']) {
      // parseFloat(this.value).toFixed(2);
      document.getElementById(rowId + "_order_sku").value = resp['prodt']['prodt_sku'];
      document.getElementById(rowId + "_order_prd").value = resp['prodt']['prodt_name'];
      document.getElementById(rowId + "_order_qty").value = 1;
      document.getElementById(rowId + "_order_rat").value = parseFloat(resp['prodt']['prodt_reprice']).toFixed(2);
      document.getElementById(rowId + "_order_dis").value = 0;
      document.getElementById(rowId + "_order_amt").value = parseFloat(resp['prodt']['prodt_reprice']).toFixed(2);
      document.getElementById(rowId).getElementsByTagName("button")[0].disabled = false;
      document.getElementById(rowId + "_order_sku").disabled = true;
      return true;
    } else {
      return false;
    }
  }
  /*
    function updateTbl() {
      for (let ind = 1; ind < tblRowCount - 1; ind++) {
        // console.log("updateTbl", ind);
        let tblRow = document.getElementById("tblr_" + ind);
        if (tblRow) {
          updateRowTbl("tblr_" + ind);
        }
      }
    }
  */
  function updateRowTbl(rowId) {
    // console.log(rowId);
    let inpQtyVal = document.getElementById(rowId + "_order_qty").value;
    let inpRatVal = document.getElementById(rowId + "_order_rat").value;
    let inpDisVal = document.getElementById(rowId + "_order_dis").value;
    document.getElementById(rowId + "_order_amt").value = ((inpRatVal * inpQtyVal) - (inpRatVal * inpQtyVal * inpDisVal * 0.01)).toFixed(2);
  }

  async function checkInput(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      let text = event.target.value.trim();

      if (text.length > 10) {
        let tblRowId = event.target.parentElement.parentElement.id;
        let found = false;

        for (let ind = 1; ind < tblRowCount; ind++) {
          if (("tblr_" + ind) == tblRowId) {
            continue;
          }
          // console.log("checkInput-loop", ind);
          let inpSku = document.getElementById("tblr_" + ind + "_order_sku");

          if (inpSku) {
            // console.log("checkInput-check", inpSku.value, text);
            /*  
              for (let index = 0; index < inpSku.value.length; index++) {
                console.log(inpSku.value.charCodeAt(index));
              }
              console.log("next");
              for (let index = 0; index < text.length; index++) {
                console.log(text.charCodeAt(index));
              }
            */
            if (text == inpSku.value) {
              document.getElementById("tblr_" + ind + "_order_qty").value++;
              found = true;
              updateRowTbl("tblr_" + ind);
              calculatePay();
              break;
            }
          }
        }
        // console.log(tblRowId, text, found);
        if (!found) {
          let result = await addRowTbl(tblRowId, text);
          if (result) {
            // console.log("data ok");

            tblBody.appendChild(createTblRow(tblRowCount++));
            document.getElementById("tblr_" + (tblRowCount - 1) + "_order_sku").focus();
            calculatePay();
          } else {
            // console.log("data not ok");
            document.getElementById("tblr_" + (tblRowCount - 1) + "_order_sku").value = "";
          }
          /* 
            addRowTbl(text, tblRowId).then(function(result) {
              if (result) {
                console.log("data ok");
                tblBody.appendChild(createTblRow(tblRowCount++));
                document.getElementById("tblr_" + (tblRowCount - 1) + "_order_sku").focus();
              } else {
                console.log("data not ok");
                document.getElementById("tblr_" + (tblRowCount - 1) + "_order_sku").value = "";
              }
            });
          */
        } else {
          document.getElementById("tblr_" + (tblRowCount - 1) + "_order_sku").value = "";
        }
      }
    }
  }

  function removeRowTbl() {
    let tblRow = this.parentElement.parentElement;
    // console.log("remove row", tblRow.id);
    tblRow.remove();
    calculatePay();
  }

  function calculateAll() {
    let tblRowId = this.parentElement.parentElement.id;
    // console.log("calculateAll", this);
    updateRowTbl(tblRowId);
    calculatePay();
  }

  function calculatePay() {
    var subTotal = 0;
    for (let ind = 1; ind < tblRowCount - 1; ind++) {
      let inpAmt = document.getElementById("tblr_" + ind + "_order_amt");
      if (inpAmt) {
        subTotal = subTotal + (+inpAmt.value); // unary operator makes it number
      }
    }
    // console.log("Total", subTotal);
    document.getElementById("order_subtotal").value = subTotal.toFixed(2);
    let inpTaxVal = document.getElementById("order_taxrate").value;
    let taxTotal = (subTotal * inpTaxVal / 100);
    document.getElementById("order_taxesall").value = taxTotal.toFixed(2);
    let totalAmt = subTotal + taxTotal;
    document.getElementById("order_totalamt").value = totalAmt.toFixed(2);
    let inpPaid = document.getElementById("order_paidamt");
    inpPaid.value = (+inpPaid.value).toFixed(2);
    let balance = (+inpPaid.value) - totalAmt;
    document.getElementById("order_balance").value = balance.toFixed(2);
  }

  function createTblRow(rowId) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.id = "tblr_" + rowId;

    // create SKU column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let input1 = document.createElement("input");
    input1.type = "text";
    input1.id = tblRow.id + "_order_sku";
    input1.placeholder = "Enter Barcode";
    // input1.onkeyup = checkInput;
    input1.addEventListener("keyup", checkInput);
    tblData1.appendChild(input1);

    // create Product Name column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let input2 = document.createElement("input");
    input2.type = "text";
    input2.id = tblRow.id + "_order_prd";
    tblData2.appendChild(input2);

    // create Qty column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let input3 = document.createElement("input");
    input3.type = "number";
    input3.id = tblRow.id + "_order_qty";
    // input3.oninput = calculateAll;
    input3.addEventListener("input", calculateAll);
    tblData3.appendChild(input3);

    // create Rate column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let input4 = document.createElement("input");
    input4.type = "text";
    input4.id = tblRow.id + "_order_rat";
    input4.className = "txt-right";
    input4.disabled = true;
    tblData4.appendChild(input4);

    // create Discount column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let input5 = document.createElement("input");
    input5.type = "text";
    input5.id = tblRow.id + "_order_dis";
    input5.className = "txt-right";
    // input5.oninput = calculateAll;
    input5.addEventListener("input", calculateAll);
    tblData5.appendChild(input5);

    // create Amount column
    let tblData6 = document.createElement("div");
    tblData6.className = "td";
    tblRow.appendChild(tblData6);
    let input6 = document.createElement("input");
    input6.type = "text";
    input6.id = tblRow.id + "_order_amt";
    input6.className = "txt-right";
    input6.disabled = true;
    tblData6.appendChild(input6);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    let btnDelt = document.createElement("button");
    btnDelt.type = "button";
    btnDelt.className = "btn-sm red";
    btnDelt.title = "Remove Product";
    btnDelt.disabled = true;
    // btnDelt.onclick = removeRowTbl;
    btnDelt.addEventListener("click", removeRowTbl);
    tblDataAct.appendChild(btnDelt);
    let icoDelt = document.createElement("i");
    icoDelt.className = "fas fa-times";
    btnDelt.appendChild(icoDelt);

    return tblRow;
  }

  function addEvents() {
    for (let ind = 1; ind < tblRowCount; ind++) {
      // console.log('addEvents', ind);
      // let inpSku = document.getElementById("tblr_" + ind + "_order_sku");
      let inpQty = document.getElementById("tblr_" + ind + "_order_qty");
      let inpDis = document.getElementById("tblr_" + ind + "_order_dis");
      let btnDel = document.getElementById("tblr_" + ind).getElementsByTagName("button")[0];
      // inpSku.addEventListener('keyup', checkInput);
      inpQty.addEventListener('input', calculateAll);
      inpDis.addEventListener('input', calculateAll);
      btnDel.addEventListener('click', removeRowTbl);
    }
  }

  const tblBody = document.getElementById("dl_tbl_body");
  var tblRowCount = <?php echo $data['prdcon'] + 1; ?>;
  addEvents();
  tblBody.appendChild(createTblRow(tblRowCount++));


  function orderEdited() {
    console.log("orderEdited");
    location.href = urlroot;
  }

  let editOrder = new FormHandler('edit_order', 'edit_order_msg', `${urlroot}editOrder`);
  editOrder.setCallback(orderEdited);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>