<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Vendor</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Vendor</li>
    </ul>

  </div>
  <div class="main-cards">
    <!-- BUTTON add new -->
    <div class="form-group">
      <a class="btn" id="btn_add_catg" href="<?php echo URLROOT; ?>vendors/add" tabindex="0">Add New Vendor</a>
    </div>

    <!--CARD: vendor list-->
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

        <div class="table">
          <div class="thead">
            <div class="tr">
              <div class="th" id="dl_sort_1">Vendor Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_2">Phone<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_3">Email<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_4">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th">Action</div>
            </div>
          </div>
          <div class="tbody" id="dl_tbl_body">
            <div class="tr">
              <div class="td">ABC Pvt Ltd</div>
              <div class="td">012-345-6789</div>
              <div class="td">abc@xyz.com</div>
              <div class="td">Inactive</div>
              <div class="td">
                <a class="btn green mr-1" role="button" title="View more">
                  <i class="fas fa-eye"></i>
                </a>
                <a class="btn yellow mr-1" role="button" title="Edit Vendor">
                  <i class="fas fa-edit"></i>
                </a>
                <a class="btn red" role="button" title="Delete Vendor">
                  <i class="fas fa-trash-alt"></i>
                </a>
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

<div id="mod_deltvendr" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltvendr')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Vendor</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Vendor?</p>
        <p>This will delete all the information of this Vendor.</p>
      </div>
      <form id="delt_vendr" name="delt_vendr" novalidate>
        <span id="delt_vendr_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Vendor Id</label> -->
          <input class="" type="hidden" id="delt_vendr_id" name="delt_vendr_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltvendr');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>vendors/";
  /////////////////////////////////////////////////////////////////////////////////
  function viewVendorLoader() {

  }
  /////////////////////////////////////////////////////////////////////////////////

  function editVendorLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = "<?php echo URLROOT; ?>vendors/edit/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function vendrDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltvendr');
  }

  let deltVendr = new FormHandler('delt_vendr', 'delt_vendr_msg', `${urlroot}deleteVendor`);
  deltVendr.setCallback(vendrDeleted);

  function deltVendorLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_vendr_id").value = rowId;
    showHide('mod_deltvendr');
  }
  /////////////////////////////////////////////////////////////////////////////////
  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["vendr_id"];

    // create Vendor Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["vendr_name"];
    tblData1.appendChild(span1);

    // create Phone column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["vendr_phone"];
    tblData2.appendChild(span2);

    // create Email column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["vendr_email"];
    tblData3.appendChild(span3);

    // create status column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = (dataRow["brand_state"] == "1") ? "Active" : "Inactive";
    tblData4.appendChild(span4);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create view button
    let btnView = document.createElement("a");
    btnView.className = "btn-sm green mr-md-1";
    btnView.title = "View Vendor";
    btnView.onclick = viewVendorLoader;
    tblDataAct.appendChild(btnView);
    let icoView = document.createElement("i");
    icoView.className = "fas fa-eye";
    btnView.appendChild(icoView);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Vendor";
    btnEdit.onclick = editVendorLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Vendor";
    btnDelt.onclick = deltVendorLoader;
    tblDataAct.appendChild(btnDelt);
    let icoDelt = document.createElement("i");
    icoDelt.className = "fas fa-trash-alt";
    btnDelt.appendChild(icoDelt);

    return tblRow;
  }

  function displayData(result) {
    // console.log("Reload Dataset");
    tblBody.textContent = "";

    for (const row of result) {
      let tblRow = createTblRow(row);
      tblBody.appendChild(tblRow);
    }
  }

  let dataList = new DataList(`${urlroot}getVendorDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3", "dl_sort_4");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>