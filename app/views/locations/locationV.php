<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Location</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Location</li>
    </ul>

  </div>
  <div class="main-cards">

    <!-- BUTTON add new -->
    <div class="form-group">
      <a class="btn" id="btn_add_locat" onclick="showHide('mod_addlocat')" tabindex="0">Add New Location</a>
    </div>

    <!--CARD: Location list-->
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
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" id="dl_sort_1">Location Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2">Address<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th">Action</div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td">Location_1</div>
                <div class="td">Location_Address</div>
                <div class="td">
                  <a class="btn yellow mr-1" role="button" title="Edit Location">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a class="btn red" role="button" title="Delete Location">
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

<div id="mod_addlocat" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addlocat')">&times;</span>
    <div class="modal-header">
      <h4>Add Location</h4>
    </div>
    <div class="modal-body">
      <form id="add_locat" name="add_locat" novalidate>
        <span id="add_locat_msg" class="status" aria-live="polite"></span>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Name</label>
          <input class="" type="text" placeholder="Enter Location Name" id="add_locat_name" name="add_locat_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Address</label>
          <textarea class="" id="add_locat_address" name="add_locat_address" type="text" placeholder="Enter Location Address" rows="3" required></textarea>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_addlocat'); addLocat.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_editlocat" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_editlocat')">&times;</span>
    <div class="modal-header">
      <h4>Edit Location</h4>
    </div>
    <div class="modal-body">
      <form id="edit_locat" name="edit_locat" novalidate>
        <span id="edit_locat_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">locatory Id</label> -->
          <input class="" type="hidden" id="edit_locat_id" name="edit_locat_id" required hidden>
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Name</label>
          <input class="" type="text" placeholder="Enter Location Name" id="edit_locat_name" name="edit_locat_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Address</label>
          <textarea class="" id="edit_locat_address" name="edit_locat_address" type="text" placeholder="Enter Location Address" rows="3" required></textarea>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_editlocat'); editLocat.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_deltlocat" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltlocat')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Location</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Location?</p>
      </div>
      <form id="delt_locat" name="delt_locat" novalidate>
        <span id="delt_locat_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">locatory Id</label> -->
          <input class="" type="hidden" id="delt_locat_id" name="delt_locat_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltlocat');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>locations/";
  /////////////////////////////////////////////////////////////////////////////

  function locatAdded() {
    // console.log("hi");
    dataList.refreshData();
  }

  let addLocat = new FormHandler('add_locat', 'add_locat_msg', `${urlroot}addLocation`);
  addLocat.setCallback(locatAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function locatEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editlocat');
  }

  let editLocat = new FormHandler('edit_locat', 'edit_locat_msg', `${urlroot}editLocation`);
  editLocat.setCallback(locatEdited);

  function editLocationLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    let dataElem = this.parentElement.parentElement.getElementsByTagName("span");
    // console.log(dataElem);
    document.getElementById("edit_locat_id").value = rowId;
    document.getElementById("edit_locat_name").value = dataElem[0].textContent;
    document.getElementById("edit_locat_address").value = dataElem[1].textContent;
    showHide('mod_editlocat');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function locatDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltlocat');
  }

  let deltlocat = new FormHandler('delt_locat', 'delt_locat_msg', `${urlroot}deleteLocation`);
  deltlocat.setCallback(locatDeleted);

  function deltLocationLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_locat_id").value = rowId;
    showHide('mod_deltlocat');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["locat_id"];

    // create Location Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["locat_name"];
    tblData1.appendChild(span1);

    // create Address column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["locat_address"];
    tblData2.appendChild(span2);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Location";
    btnEdit.onclick = editLocationLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Location";
    btnDelt.onclick = deltLocationLoader;
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

  let dataList = new DataList(`${urlroot}getLocationDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>