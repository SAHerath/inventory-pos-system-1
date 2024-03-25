<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>User</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>">Home</a></li>
      <li>User</li>
    </ul>

  </div>
  <div class="main-cards">

    <!-- BUTTON add new -->
    <div class="row mb-2">
      <a class="btn blue" href="<?php echo URLROOT; ?>users/add" tabindex="0">Add New User</a>
    </div>

    <!--CARD: user list-->
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
                <div class="th" id="dl_sort_1">First Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2">Last Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3">Username<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_4">Role<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_5">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th">Action</div>
              </div>
            </div>
            <div class="tbody stripes" id="dl_tbl_body">
              <div class="tr">
                <div class="td">NameF</div>
                <div class="td">NameL</div>
                <div class="td">UserN</div>
                <div class="td">Admin</div>
                <div class="td">Active</div>
                <div class="td">
                  <a class="tbl_btn_edit btn yellow mr-1" role="button" title="Edit User">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a class="tbl_btn_delt btn red" role="button" title="Delete User">
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


<div id="mod_deltusers" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltusers')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete User</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this user?</p>
      </div>
      <form id="delt_users" name="delt_categ" novalidate>
        <span id="delt_users_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Category Id</label> -->
          <input class="" type="hidden" id="delt_users_id" name="delt_users_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltusers');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>users/";
  /////////////////////////////////////////////////////////////////////////////

  function editUserLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = urlroot + "edit/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////

  function usersDeleted() {
    // console.log("hi");
    dataList.refreshData();
    showHide('mod_deltusers');
  }

  let deltUsers = new FormHandler('delt_users', 'delt_users_msg', `${urlroot}deleteUser`);
  deltUsers.setCallback(usersDeleted);

  function deltUserLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_users_id").value = rowId;
    showHide('mod_deltusers');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["users_id"];

    // create firstname column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["users_fname"];
    tblData1.appendChild(span1);

    // create lastname column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["users_lname"];
    tblData2.appendChild(span2);

    // create username column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["users_usrname"];
    tblData3.appendChild(span3);

    // create role column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = dataRow["users_role"];
    tblData4.appendChild(span4);

    // create Status column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let span5 = document.createElement("span");
    span5.textContent = dataRow["users_state"];
    tblData5.appendChild(span5);

    // create Action column
    let tblData6 = document.createElement("div");
    tblData6.className = "td txt-center";
    tblRow.appendChild(tblData6);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-2";
    btnEdit.title = "Edit User";
    btnEdit.onclick = editUserLoader;
    tblData6.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-2";
    btnDelt.title = "Delete User";
    btnDelt.onclick = deltUserLoader;
    tblData6.appendChild(btnDelt);
    let icoDelt = document.createElement("i");
    icoDelt.className = "fas fa-trash-alt";
    btnDelt.appendChild(icoDelt);

    return tblRow;
  }

  function displayData(result) {
    // console.log("Reload Dataset");
    tblBody.innerHTML = "";

    for (const row of result) {
      let tblRow = createTblRow(row);
      tblBody.appendChild(tblRow);
    }
  }


  let dataList = new DataList(`${urlroot}getUserDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3", "dl_sort_4", "dl_sort_5");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>