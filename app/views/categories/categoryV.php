<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <span>Category</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Category</li>
    </ul>

  </div>
  <div class="main-cards">

    <!-- BUTTON add new -->
    <div class="form-group">
      <a class="btn" id="btn_add_catg" onclick="showHide('mod_addcateg')" tabindex="0">Add New Category</a>
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
        <div class="table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <!-- <div class="th" id="dl_sort_1" style="width: 150px;">Category Id<i class="fas fa-exchange-alt fa-rotate-90"></i></div> -->
                <div class="th" id="dl_sort_2">Category Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th">Action</div>
              </div>
            </div>
            <div class="tbody stripes" id="dl_tbl_body">
              <div class="tr">
                <!-- <div class="td">1</div> -->
                <div class="td">Category_1</div>
                <div class="td">Inactive</div>
                <div class="td">
                  <a class="btn-sm yellow mr-md-1" role="button" title="Edit Category">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a class="btn-sm red mr-md-1" role="button" title="Delete Category">
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

<div id="mod_addcateg" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_addcateg')">&times;</span>
    <div class="modal-header">
      <h4>Add Category</h4>
    </div>
    <div class="modal-body">
      <form id="add_categ" name="add_categ" novalidate>
        <span id="add_categ_msg" class="status" aria-live="polite"></span>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Category Name</label>
          <input class="" type="text" placeholder="Enter Category Name" id="add_categ_name" name="add_categ_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Status</label>
          <select class="" id="add_categ_state" name="add_categ_state" required autocomplete="off">
            <option value="" selected>Select Status</option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_addcateg'); addCateg.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_editcateg" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_editcateg')">&times;</span>
    <div class="modal-header">
      <h4>Edit Category</h4>
    </div>
    <div class="modal-body">
      <form id="edit_categ" name="edit_categ" novalidate>
        <span id="edit_categ_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Category Id</label> -->
          <input class="" type="hidden" id="edit_categ_id" name="edit_categ_id" required hidden>
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Category Name</label>
          <input class="" type="text" placeholder="Enter Category Name" id="edit_categ_name" name="edit_categ_name" required autocomplete="off">
        </div>
        <div class="row pb-2 pb-sm-3">
          <label class="mb-1">Status</label>
          <select class="" id="edit_categ_state" name="edit_categ_state" required autocomplete="off">
            <option value="" selected>Select Status</option>
            <option value="1">Active</option>
            <option value="2">Inactive</option>
          </select>
        </div>
        <div class="row pt-3">
          <button class="btn green mr-3" type="submit">Save</button>
          <button class="btn blue" type="button" onclick="showHide('mod_editcateg'); editCateg.resetForm();">Cancel</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<div id="mod_deltcateg" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltcateg')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Category</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this category?</p>
      </div>
      <form id="delt_categ" name="delt_categ" novalidate>
        <span id="delt_categ_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Category Id</label> -->
          <input class="" type="hidden" id="delt_categ_id" name="delt_categ_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltcateg');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>categories/";
  /////////////////////////////////////////////////////////////////////////////

  function categAdded() {
    // console.log("hi");
    dataList.refreshData();
  }

  let addCateg = new FormHandler('add_categ', 'add_categ_msg', `${urlroot}addCategory`);
  addCateg.setCallback(categAdded);
  /////////////////////////////////////////////////////////////////////////////////

  function categEdited() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_editcateg');
  }

  let editCateg = new FormHandler('edit_categ', 'edit_categ_msg', `${urlroot}editCategory`);
  editCateg.setCallback(categEdited);

  function editCategoryLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    // let dataElem = this.parentElement.parentElement.getElementsByClassName("td");
    let dataElem = this.parentElement.parentElement.getElementsByTagName("span");
    // console.log(dataElem);
    document.getElementById("edit_categ_id").value = rowId;
    document.getElementById("edit_categ_name").value = dataElem[0].textContent;
    document.getElementById("edit_categ_state").value = (dataElem[1].textContent == "Active") ? 1 : 2;
    showHide('mod_editcateg');
    // console.log(dataSet);
  }
  /////////////////////////////////////////////////////////////////////////////////
  function categDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltcateg');
  }

  let deltCateg = new FormHandler('delt_categ', 'delt_categ_msg', `${urlroot}deleteCategory`);
  deltCateg.setCallback(categDeleted);

  function deltCategoryLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_categ_id").value = rowId;
    showHide('mod_deltcateg');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["categ_id"];

    // create Category Name column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["categ_name"];
    tblData1.appendChild(span1);

    // create Status column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = (dataRow["categ_state"] == "1") ? "Active" : "Inactive";
    tblData2.appendChild(span2);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Category";
    btnEdit.onclick = editCategoryLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Category";
    btnDelt.onclick = deltCategoryLoader;
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


  let dataList = new DataList(`${urlroot}getCategoryDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_2", "dl_sort_3");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>