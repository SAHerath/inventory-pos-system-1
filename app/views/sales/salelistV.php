<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>Sales Order</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Sales Order</li>
    </ul>

  </div>
  <div class="main-cards">
    <div class="row mb-2">
      <a class="btn blue" href="<?php echo URLROOT; ?>sales/add" tabindex="0">Add New Sales Order</a>
    </div>
    <div class="card">
      <div id="tbl_data_list">
        <div class="dlist_top">
          <div class="fleft">
            <span id="dl_detail">Pages</span>
          </div>
          <div class="fright">
            <input id="dl_search_inp" type="text" minlength="3">
            <a class="btn blue" id="dl_search_btn" tabindex="0">Search</a>
          </div>
        </div>

        <div class="table-wrap">

          <!-- <div style="flex: 0 0 auto; background-color: palegreen; width: 600px;">Hello There</div> -->
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" id="dl_sort_1" title="Sort by Order No.">Order No<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2" title="Sort by Date">Date<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3" title="Sort by Customer">Customer<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_4" title="Sort by Status">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_5" title="Sort by Total Amt.">Total<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_6" title="Sort by Paid Amt.">Paid<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_7" title="Sort by Balance">Balance<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th">Action</div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td"><span>ODR-0000002</span></div>
                <div class="td"><span>15/01/2021</span></div>
                <div class="td">David Smith</div>
                <div class="td">Open</div>
                <div class="td">1250.00</div>
                <div class="td">1500.00</div>
                <div class="td">250.00</div>
                <div class="td txt-center">
                  <a class=" btn-sm green mr-md-1" role="button" title="View more">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a class=" btn-sm yellow mr-md-1" role="button" title="Edit Vendor">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a class=" btn-sm red mr-md-1" role="button" title="Delete Vendor">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="dlist_bot">
          <button class="btn blue" id="dl_prev"><i class="fas fa-caret-left"></i> Previous</button>
          <button class="btn blue" id="dl_next">Next <i class="fas fa-caret-right"></i></button>
        </div>
      </div>
    </div>
  </div>
</main>

<div id="mod_deltsales" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltsales')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Sales Order</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Sales Order?</p>
        <p>This will delete all the information of this Order.</p>
      </div>
      <form id="delt_sales" name="delt_sales" novalidate autocomplete="off">
        <span id="delt_sales_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Order Id</label> -->
          <input class="" type="hidden" id="delt_sales_id" name="delt_sales_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltsales');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>sales/";
  /////////////////////////////////////////////////////////////////////////////////

  function viewSalesLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = urlroot + "show/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////

  function editSalesLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = urlroot + "edit/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function salesOrderDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltsales');
  }

  let deltSales = new FormHandler('delt_sales', 'delt_sales_msg', `${urlroot}deleteSales`);
  deltSales.setCallback(salesOrderDeleted);

  function deltSalesLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_sales_id").value = rowId;
    showHide('mod_deltsales');
  }
  /////////////////////////////////////////////////////////////////////////////////
  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["sales_id"];

    // create order no column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["sales_no"];
    tblData1.appendChild(span1);

    // create date column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["sales_date"];
    tblData2.appendChild(span2);

    // create customer column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["sales_customer"];
    tblData3.appendChild(span3);

    // create status column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = dataRow["sales_state"];
    tblData4.appendChild(span4);

    // create total column
    let tblData5 = document.createElement("div");
    tblData5.className = "td txt-right";
    tblRow.appendChild(tblData5);
    let span5 = document.createElement("span");
    span5.textContent = dataRow["sales_totalamt"];
    tblData5.appendChild(span5);

    // create paid column
    let tblData6 = document.createElement("div");
    tblData6.className = "td txt-right";
    tblRow.appendChild(tblData6);
    let span6 = document.createElement("span");
    span6.textContent = dataRow["sales_paidamt"];
    tblData6.appendChild(span6);

    // create balance column
    let tblData7 = document.createElement("div");
    tblData7.className = "td txt-right";
    tblRow.appendChild(tblData7);
    let span7 = document.createElement("span");
    span7.textContent = dataRow["sales_balance"];
    tblData7.appendChild(span7);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create view button
    let btnView = document.createElement("a");
    btnView.className = "btn-sm green mr-md-1";
    btnView.title = "View Order";
    btnView.onclick = viewSalesLoader;
    tblDataAct.appendChild(btnView);
    let icoView = document.createElement("i");
    icoView.className = "fas fa-eye";
    btnView.appendChild(icoView);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Order";
    btnEdit.onclick = editSalesLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Order";
    btnDelt.onclick = deltSalesLoader;
    tblDataAct.appendChild(btnDelt);
    let icoDelt = document.createElement("i");
    icoDelt.className = "fas fa-trash-alt";
    btnDelt.appendChild(icoDelt);

    return tblRow;
  }

  function displayData(result) {
    // console.log("Reload Dataset");
    tblBody.textContent = "";
    // console.log(result);
    for (const row of result) {
      let tblRow = createTblRow(row);
      tblBody.appendChild(tblRow);
    }
  }

  let dataList = new DataList(`${urlroot}getSalesDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>