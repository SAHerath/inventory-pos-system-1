<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Brand</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li>Brand</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="form-group">
      <a class="btn" id="btn_add_brand" onclick="showHide('mod_addbrand')" tabindex="0">Add New Brand</a>
    </div>

    <!--CARD: category list-->
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
              <div class="th" id="dl_sort_1">Brand Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_2">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th">Action</div>
            </div>
          </div>
          <div class="tbody" id="dl_tbl_body">
            <div class="tr">
              <div class="td">Brand_1</div>
              <div class="td">Inactive</div>
              <div class="td">
                <a class="btn yellow mr-1" role="button" title="Edit Brand">
                  <i class="fas fa-edit"></i>
                </a>
                <a class="btn red" role="button" title="Delete Brand">
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

<div class="modal" id="mod_addbrand">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addbrand')">&times;</span>
    <div class="modal-header">
      <h4>Add Brand</h4>
    </div>
    <div class="modal-body">
      <form id="add_brand" name="add_brand" novalidate>
        <span id="add_brand_msg" class="status" aria-live="polite"></span>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Brand Name</label>
          <input class="" type="text" placeholder="Enter Brand Name" id="add_brand_name" name="add_brand_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Status</label>
          <select class="" id="add_brand_state" name="add_brand_state" required>
            <option value="" selected>Select Status</option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_addbrand'); addBrand.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div class="modal" id="mod_editbrand">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_editbrand')">&times;</span>
    <div class="modal-header">
      <h4>Edit Brand</h4>
    </div>
    <div class="modal-body">
      <form id="edit_brand" name="edit_brand" novalidate>
        <span id="edit_brand_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Brand Id</label> -->
          <input class="" type="hidden" id="edit_brand_id" name="edit_brand_id" required hidden>
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Brand Name</label>
          <input class="" type="text" placeholder="Enter Brand Name" id="edit_brand_name" name="edit_brand_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Status</label>
          <select class="" id="edit_brand_state" name="edit_brand_state" required>
            <!-- <option value="" selected>Select Status</option> -->
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_editbrand'); editBrand.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div class="modal" id="mod_deltbrand">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltbrand')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Brand</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this brand?</p>
      </div>
      <form id="delt_brand" name="delt_brand" novalidate>
        <span id="delt_brand_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Brand Id</label> -->
          <input class="" type="hidden" id="delt_brand_id" name="delt_brand_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltbrand');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>brands/";
  /////////////////////////////////////////////////////////////////////////////

  function brandAdded() {
    // console.log("hi");
    dataList.refreshData();
  }

  let addBrand = new FormHandler('add_brand', 'add_brand_msg', `${urlroot}addBrand`);
  addBrand.setCallback(brandAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function brandEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editbrand');
  }

  let editBrand = new FormHandler('edit_brand', 'edit_brand_msg', `${urlroot}editBrand`);
  editBrand.setCallback(brandEdited);

  function editBrandLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    let dataElem = this.parentElement.parentElement.getElementsByTagName("span");
    // console.log(dataElem);
    document.getElementById("edit_brand_id").value = rowId;
    document.getElementById("edit_brand_name").value = dataElem[0].textContent;
    document.getElementById("edit_brand_state").value = (dataElem[1].textContent == "Active") ? 1 : 2;
    showHide('mod_editbrand');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function brandDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltbrand');
  }

  let deltBrand = new FormHandler('delt_brand', 'delt_brand_msg', `${urlroot}deleteBrand`);
  deltBrand.setCallback(brandDeleted);

  function deltBrandLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_brand_id").value = rowId;
    showHide('mod_deltbrand');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["brand_id"];

    // create Brand Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["brand_name"];
    tblData1.appendChild(span1);

    // create Status column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = (dataRow["brand_state"] == "1") ? "Active" : "Inactive";
    tblData2.appendChild(span2);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Brand";
    btnEdit.onclick = editBrandLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Brand";
    btnDelt.onclick = deltBrandLoader;
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

  let dataList = new DataList(`${urlroot}getDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>