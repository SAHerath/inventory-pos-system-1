<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>Add Purchase Order</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>purchases">Purchase Order</a></li>
      <li>Add Purchase Order</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="card">
      <form id="add_pordr" name="add_pordr" novalidate autocomplete="off">
        <span id="add_pordr_msg" class="status" aria-live="polite"></span>

        <div class="row pb-4">
          <div class="col col-sm-6 o-sm-2 pl-sm-4 pl-md-8">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Date</label>
              <input class="" id="pordr_date" name="pordr_date" type="date" placeholder="" required value="<?php echo $data['date']; ?>">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Location</label>
              <select class="" id="pordr_locat" name="pordr_locat" required>
                <option value="" selected></option>
                <?php foreach ($data['locat'] as $row) : ?>
                  <option value="<?php echo $row['loca_code']; ?>"><?php echo $row['loca_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col col-sm-6 o-sm-1 pr-sm-4 pr-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Vendor Name</label>
              <select class="" id="pordr_vendr" name="pordr_vendr" required>
                <option value="" selected></option>
                <?php foreach ($data['vendr'] as $row) : ?>
                  <option value="<?php echo $row['vend_code']; ?>"><?php echo $row['vend_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Vendor Note</label>
              <textarea class="" id="pordr_vendnote" name="pordr_vendnote" type="text" placeholder="" rows="2" required></textarea>
            </div>
          </div>
        </div>

        <div class="row pb-2 mb-4 table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" title="Stock Keeping Unit">SKU</div>
                <div class="th" title="Vendor Part Number">Vendor Part No</div>
                <div class="th" title="Quantity" style="width: 80px;">Qty</div>
                <div class="th" title="Unit Price" style="width: 100px;">Rate<?php echo $data['currency']; ?></div>
                <div class="th" title="Sub Total" style="width: 100px;">Amount<?php echo $data['currency']; ?></div>
                <div class="th">Action</div>
              </div>
            </div>

            <div class="tbody stripes" id="dl_tbl_body">

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
          </div>
          <div class="col col-sm-6 pl-sm-4 pl-md-6">
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Sub Total</label>
              <input class="txt-right" id="pordr_subtotal" name="porder_subtotal" type="text" placeholder="" required disabled>
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1">Additinal Charges</label>
              <input onchange="calculatePay();" class="txt-right" id="pordr_addcharg" name="pordr_addcharg" type="text" placeholder="" required value="0.00">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Total</b></label>
              <input class="txt-right" id="pordr_totalamt" name="pordr_totalamt" type="text" placeholder="" required disabled>
            </div>
            <div class="row pb-2 pb-sm-3 mt-3">
              <label class="mb-1">Paid</label>
              <input onchange="calculatePay();" class="txt-right" id="pordr_paidamt" name="pordr_paidamt" type="text" placeholder="" required value="0.00">
            </div>
            <div class="row pb-2 pb-sm-3">
              <label class="mb-1"><b>Balance</b></label>
              <input class="txt-right" id="pordr_balance" name="pordr_balance" type="text" placeholder="" required disabled>
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
      document.getElementById(rowId + "_pordr_sku").value = resp['prodt']['prodt_sku'];
      document.getElementById(rowId + "_pordr_prt").value = resp['prodt']['prodt_name'];
      document.getElementById(rowId + "_pordr_qty").value = 1;
      document.getElementById(rowId + "_pordr_rat").value = parseFloat(resp['prodt']['prodt_venprice']).toFixed(2);
      document.getElementById(rowId + "_pordr_amt").value = parseFloat(resp['prodt']['prodt_venprice']).toFixed(2);
      document.getElementById(rowId).getElementsByTagName("button")[0].disabled = false;
      document.getElementById(rowId + "_pordr_sku").disabled = true;
      return true;
    } else {
      return false;
    }
  }

  function updateRowTbl(rowId) {
    let inpQtyVal = document.getElementById(rowId + "_pordr_qty").value;
    let inpRatVal = document.getElementById(rowId + "_pordr_rat").value;
    document.getElementById(rowId + "_pordr_amt").value = (inpRatVal * inpQtyVal).toFixed(2);
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
          let inpSku = document.getElementById("tblr_" + ind + "_pordr_sku");

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
              document.getElementById("tblr_" + ind + "_pordr_qty").value++;
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
            document.getElementById("tblr_" + (tblRowCount - 1) + "_pordr_sku").focus();
            calculatePay();
          } else {
            // console.log("data not ok");
            document.getElementById("tblr_" + (tblRowCount - 1) + "_pordr_sku").value = "";
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
          document.getElementById("tblr_" + (tblRowCount - 1) + "_pordr_sku").value = "";
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
    updateRowTbl(tblRowId);
    calculatePay();
  }

  function calculatePay() {
    var subTotal = 0;
    for (let ind = 1; ind < tblRowCount - 1; ind++) {
      let inpAmt = document.getElementById("tblr_" + ind + "_pordr_amt");
      if (inpAmt) {
        subTotal = subTotal + (+inpAmt.value); // unary operator makes it number
      }
    }
    // console.log("Total", subTotal);
    document.getElementById("pordr_subtotal").value = subTotal.toFixed(2);
    let inpOther = document.getElementById("pordr_addcharg");
    inpOther.value = (+inpOther.value).toFixed(2);
    let totalAmt = (subTotal + (+inpOther.value));
    document.getElementById("pordr_totalamt").value = totalAmt.toFixed(2);
    let inpPaid = document.getElementById("pordr_paidamt");
    inpPaid.value = (+inpPaid.value).toFixed(2);
    let balance = (+inpPaid.value) - totalAmt;
    document.getElementById("pordr_balance").value = balance.toFixed(2);
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
    input1.id = tblRow.id + "_pordr_sku";
    input1.placeholder = "Enter Barcode";
    // input1.onkeyup = checkInput;
    input1.addEventListener("keyup", checkInput);
    tblData1.appendChild(input1);

    // create Vendor Part No column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let input2 = document.createElement("input");
    input2.type = "text";
    input2.id = tblRow.id + "_pordr_prt";
    tblData2.appendChild(input2);

    // create Qty column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let input3 = document.createElement("input");
    input3.type = "number";
    input3.id = tblRow.id + "_pordr_qty";
    // input3.oninput = calculateAll;
    input3.addEventListener("input", calculateAll);
    tblData3.appendChild(input3);

    // create Rate column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let input4 = document.createElement("input");
    input4.type = "text";
    input4.id = tblRow.id + "_pordr_rat";
    input4.className = "txt-right";
    input4.disabled = true;
    tblData4.appendChild(input4);

    // create Amount column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let input5 = document.createElement("input");
    input5.type = "text";
    input5.id = tblRow.id + "_pordr_amt";
    input5.className = "txt-right";
    input5.disabled = true;
    tblData5.appendChild(input5);

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


  const tblBody = document.getElementById("dl_tbl_body");
  var tblRowCount = 1;
  tblBody.appendChild(createTblRow(tblRowCount++));

  function pordrAdded() {
    console.log("pordrAdded");
    for (let ind = 1; ind < tblRowCount; ind++) {
      let tblRow = document.getElementById("tblr_" + ind);
      if (tblRow) {
        tblRow.remove();
      }
    }
    tblRowCount = 1;
    tblBody.appendChild(createTblRow(tblRowCount++));
  }

  let addOrder = new FormHandler('add_pordr', 'add_pordr_msg', `${urlroot}addOrder`);
  addOrder.setCallback(pordrAdded);
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>