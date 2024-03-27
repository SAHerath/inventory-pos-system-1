<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Attribute Values</h2>
      <h3>of <?php echo $data['display']; ?> Attribute</h3>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>attributes">Attributes</a></li>
      <li>Attribute Values</li>
    </ul>

  </div>
  <div class="main-cards">

    <!-- BUTTON add new -->
    <div class="form-group">
      <a class="btn" id="btn_add_atval" onclick="showHide('mod_addatval')" tabindex="0">Add New Value</a>
    </div>
    <!--CARD: attribute value list-->
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
              <div class="th" id="dl_sort_1">Attribute Value<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th">Action</div>
            </div>
          </div>
          <div class="tbody" id="dl_tbl_body">
            <div class="tr" data-row-id="1">
              <div class="td">AttributeValue_1</div>
              <div class="td">
                <a class="yellow mr-1" role="button" title="Edit Attribute Value">
                  <i class="fas fa-edit"></i>
                </a>
                <a class="btn red" role="button" title="Delete Attribute Value">
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

<div id="mod_addatval" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addatval')">&times;</span>
    <div class="modal-header">
      <h4>Add Attribute Value</h4>
    </div>
    <div class="modal-body">
      <form id="add_atval" name="add_atval" novalidate>
        <span id="add_atval_msg" class="status" aria-live="polite"></span>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Attribute Value Name</label>
          <input class="" type="text" placeholder="Enter Attribute Value" id="add_atval_name" name="add_atval_name" required autocomplete="off">
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_addatval'); addAtval.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_editatval" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_editatval')">&times;</span>
    <div class="modal-header">
      <h4>Edit Attribute Value</h4>
    </div>
    <div class="modal-body">
      <form id="edit_atval" name="edit_atval" novalidate>
        <span id="edit_atval_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Attribute Value Id</label> -->
          <input class="" type="hidden" id="edit_atval_id" name="edit_atval_id" required hidden>
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Attribute Value Name</label>
          <input class="" type="text" placeholder="Enter Attribute Value" id="edit_atval_name" name="edit_atval_name" required autocomplete="off">
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_editatval'); editAtval.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_deltatval" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltatval')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Attribute Value</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Attribute Value?</p>
      </div>
      <form id="delt_atval" name="delt_atval" novalidate>
        <span id="delt_atval_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Attribute Id</label> -->
          <input class="" type="hidden" id="delt_atval_id" name="delt_atval_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltatval');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>attributes/";
  /////////////////////////////////////////////////////////////////////////////

  function atvalAdded() {
    // console.log("hi");
    dataList.refreshData();
  }

  let addAtval = new FormHandler('add_atval', 'add_atval_msg', `${urlroot}addAttribval`);
  addAtval.setCallback(atvalAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function atvalEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editatval');
  }

  let editAtval = new FormHandler('edit_atval', 'edit_atval_msg', `${urlroot}editAttribval`);
  editAtval.setCallback(atvalEdited);

  function editAttribvalLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    let dataElem = this.parentElement.parentElement.getElementsByTagName("span");
    // console.log(dataElem);
    document.getElementById("edit_atval_id").value = rowId;
    document.getElementById("edit_atval_name").value = dataElem[0].textContent;
    showHide('mod_editatval');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function atvalDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltatval');
  }

  let deltAtval = new FormHandler('delt_atval', 'delt_atval_msg', `${urlroot}deleteAttribval`);
  deltAtval.setCallback(atvalDeleted);

  function deltAttribvalLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_atval_id").value = rowId;
    showHide('mod_deltatval');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["atval_id"];

    // create Brand Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["atval_name"];
    tblData1.appendChild(span1);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Attribute Value";
    btnEdit.onclick = editAttribvalLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Attribute Value";
    btnDelt.onclick = deltAttribvalLoader;
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

  let dataList = new DataList(`${urlroot}getAttribvalDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>