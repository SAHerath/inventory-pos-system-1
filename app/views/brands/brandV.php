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
              <div class="th" id="dl_sort_1" style="width: 150px;">Brand Id<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_2">Brand Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_3">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th">Action</div>
            </div>
          </div>
          <div class="tbody" id="dl_tbl_body">
            <div class="tr">
              <div class="td">1</div>
              <div class="td">Brand_1</div>
              <div class="td">Inactive</div>
              <div class="td">
                <a class="tbl_btn_edit btn yellow mr-1" role="button" title="Edit Brand">
                  <i class="fas fa-edit"></i>
                </a>
                <a class="tbl_btn_delt btn red" role="button" title="Delete Brand">
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

  let addBrand = new FormHandler('add_brand', 'add_brand_msg', urlroot + 'addBrand');
  addBrand.setCallback(brandAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function brandEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editbrand');
  }

  let editBrand = new FormHandler('edit_brand', 'edit_brand_msg', urlroot + 'editBrand');
  editBrand.setCallback(brandEdited);

  function editBrandLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    let dataElem = this.parentElement.parentElement.getElementsByClassName("td");
    // console.log(dataElem);
    document.getElementById("edit_brand_id").value = rowId;
    document.getElementById("edit_brand_name").value = dataElem[1].dataset.value;
    document.getElementById("edit_brand_state").value = dataElem[2].dataset.value;
    showHide('mod_editbrand');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function brandDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltbrand');
  }

  let deltBrand = new FormHandler('delt_brand', 'delt_brand_msg', urlroot + 'deleteBrand');
  deltBrand.setCallback(brandDeleted);

  function deltBrandLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_brand_id").value = rowId;
    showHide('mod_deltbrand');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");
  const btnEditHtml = '<a class="tbl_btn_edit btn yellow mr-1" role="button" title="Edit Brand"><i class="fas fa-edit"></i></a>';
  const btnDeleteHtml = '<a class="tbl_btn_delt btn red" role="button" title="Delete Brand"><i class="fas fa-trash-alt"></i></a>';

  function displayData(result) {
    // console.log("Reload Dataset");
    tblBody.innerHTML = "";

    for (let i in result) {
      // console.log(result[i]);
      let tblRow = document.createElement("div");
      tblRow.classList.add("tr");
      tblRow.dataset.rowId = result[i]["brand_id"];
      // tblRow.dataset.rowId = i;

      createTblData(tblRow, result[i]["brand_id"], result[i]["brand_id"]);
      createTblData(tblRow, result[i]["brand_name"], result[i]["brand_name"]);
      createTblData(tblRow, (result[i]["brand_state"] == 1) ? "Active" : "Inactive", result[i]["brand_state"]);
      createTblData(tblRow, btnEditHtml + btnDeleteHtml);

      // console.log(tblRow);
      tblBody.appendChild(tblRow);
    }
    setEventsByClass("tbl_btn_edit", editBrandLoader);
    setEventsByClass("tbl_btn_delt", deltBrandLoader);
  }


  let dataList = new DataList(urlroot + "getDataset", displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>