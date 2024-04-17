<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Attributes</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Attributes</li>
    </ul>

  </div>
  <div class="main-cards">

    <!-- BUTTON add new -->
    <div class="form-group">
      <a class="btn" id="btn_add_attrb" onclick="showHide('mod_addattrb')" tabindex="0">Add New Attribute</a>
    </div>
    <!--CARD: attributes list-->
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
              <div class="th" id="dl_sort_1">Attribute Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th" id="dl_sort_2">Total Values<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              <div class="th">Action</div>
            </div>
          </div>
          <div class="tbody" id="dl_tbl_body">
            <div class="tr" data-row-id="1">
              <div class="td">Attribute_1</div>
              <div class="td">Inactive</div>
              <div class="td">
                <a class="btn green mr-1" role="button" title="View Attribute Values">
                  <i class="fas fa-eye"></i>
                </a>
                <a class="btn yellow mr-1" role="button" title="Edit Attribute">
                  <i class="fas fa-edit"></i>
                </a>
                <a class="btn red" role="button" title="Delete Attribute">
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

<div id="mod_addattrb" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addattrb')">&times;</span>
    <div class="modal-header">
      <h4>Add Attribute</h4>
    </div>
    <div class="modal-body">
      <form id="add_attrb" name="add_attrb" novalidate>
        <span id="add_attrb_msg" class="status" aria-live="polite"></span>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Attribute Name</label>
          <input class="" type="text" placeholder="Enter Attribute Name" id="add_attrb_name" name="add_attrb_name" required autocomplete="off">
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_addattrb'); addAttrb.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_editattrb" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_editattrb')">&times;</span>
    <div class="modal-header">
      <h4>Edit Attribute</h4>
    </div>
    <div class="modal-body">
      <form id="edit_attrb" name="edit_attrb" novalidate>
        <span id="edit_attrb_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Attribute Id</label> -->
          <input class="" type="hidden" id="edit_attrb_id" name="edit_attrb_id" required hidden>
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Attribute Name</label>
          <input class="" type="text" placeholder="Enter Attribute Name" id="edit_attrb_name" name="edit_attrb_name" required autocomplete="off">
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_editattrb'); editAttrb.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_deltattrb" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltattrb')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Attribute</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Attribute?</p>
        <p>This will delete all its values.</p>
      </div>
      <form id="delt_attrb" name="delt_attrb" novalidate>
        <span id="delt_attrb_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Attribute Id</label> -->
          <input class="" type="hidden" id="delt_attrb_id" name="delt_attrb_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltattrb');">Cancel</button>
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

  function attrbAdded() {
    // console.log("hi");
    dataList.refreshData();
  }

  let addAttrb = new FormHandler('add_attrb', 'add_attrb_msg', `${urlroot}addAttribute`);
  addAttrb.setCallback(attrbAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function viewAttributeLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    // location.replace("attributes/attribValues/" + encodeURIComponent(rowId));
    location.href = "<?php echo URLROOT; ?>attributes/attribValues/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////

  function attrbEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editattrb');
  }

  let editAttrb = new FormHandler('edit_attrb', 'edit_attrb_msg', `${urlroot}editAttribute`);
  editAttrb.setCallback(attrbEdited);

  function editAttributeLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    let dataElem = this.parentElement.parentElement.getElementsByTagName("span");
    // console.log(dataElem);
    document.getElementById("edit_attrb_id").value = rowId;
    document.getElementById("edit_attrb_name").value = dataElem[0].textContent;
    showHide('mod_editattrb');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function attrbDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltattrb');
  }

  let deltAttrb = new FormHandler('delt_attrb', 'delt_attrb_msg', `${urlroot}deleteAttribute`);
  deltAttrb.setCallback(attrbDeleted);

  function deltAttributeLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_attrb_id").value = rowId;
    showHide('mod_deltattrb');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["attrb_id"];

    // create Brand Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["attrb_name"];
    tblData1.appendChild(span1);

    // create Status column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["value_total"];
    tblData2.appendChild(span2);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create view button
    let btnView = document.createElement("a");
    btnView.className = "btn-sm green mr-md-1";
    btnView.title = "View Attribute";
    btnView.onclick = viewAttributeLoader;
    tblDataAct.appendChild(btnView);
    let icoView = document.createElement("i");
    icoView.className = "fas fa-eye";
    btnView.appendChild(icoView);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Attribute";
    btnEdit.onclick = editAttributeLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Attribute";
    btnDelt.onclick = deltAttributeLoader;
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


  let dataList = new DataList(`${urlroot}getAttributeDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>