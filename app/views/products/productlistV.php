<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>
<main class="main">
  <div class="main-header">
    <div class="heading">
      <h2>Product</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Product</li>
    </ul>

  </div>
  <div class="main-cards">
    <!-- BUTTON add new -->
    <div class="row mb-2">
      <a class="btn blue" href="<?php echo URLROOT; ?>products/add" tabindex="0">Add New Product</a>
    </div>


    <!--CARD: Product list-->
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
                <div class="th" style="width: 300px;">Image</div>
                <div class="th" id="dl_sort_1" title="Sort by SKU" style="width: 120px;">SKU<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2" title="Sort by Name" style="width: 200px;">Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3" title="Sort by Description" style="width: 200px;">Description<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_4" title="Sort by Category" style="width: 200px;">Category<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_5" title="Sort by Brand" style="width: 200px;">Brand<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_6" title="Sort by Quantity">Quantity<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_7" title="Sort by Locations">Locations<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_8" title="Sort by Status">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th">Action</div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td"><span>Image</span></div>
                <div class="td">PRD-002</div>
                <div class="td">product_name</div>
                <div class="td">This is a test product. Here's a detail description of this product.</div>
                <div class="td">category_02</div>
                <div class="td">Brand_06</div>
                <div class="td">8</div>
                <div class="td">3</div>
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
        </div>

        <div class="dlist_bot">
          <button class="btn blue" id="dl_prev"><i class="fas fa-caret-left"></i> Previous</button>
          <button class="btn blue" id="dl_next">Next <i class="fas fa-caret-right"></i></button>
        </div>
      </div>
    </div>

  </div>
</main>

<div id="mod_deltprodt" class="modal">
  <div class="modal-content">
    <span class="modal-close" onclick="showHide('mod_deltprodt')">&times;</span>
    <div class="modal-header">
      <!-- <span class="fas fa-check-circle" style="color: #5cb85c;"></span> -->
      <span class="fas fa-times-circle" style="color: #f44336;"></span>
      <!-- <span class="fas fa-question-circle" style="color: #ff9800;"></span>   -->
      <!-- <span class="fas fa-exclamation-circle" style="color: #2196F3;"></span> -->
      <!-- <h3>Are you sure?</h3> -->
      <h4>Delete Product</h4>
    </div>
    <div class="modal-body">
      <div class="row pb-2 pb-sm-3">
        <p>Are you sure you want to delete this Product?</p>
        <p>This will delete all the information of this Product.</p>
      </div>
      <form id="delt_prodt" name="delt_prodt" novalidate>
        <span id="delt_prodt_msg" class="status" aria-live="polite"></span>
        <div class="row">
          <!-- <label class="mb-1">Product Id</label> -->
          <input class="" type="hidden" id="delt_prodt_id" name="delt_prodt_id" required hidden>
        </div>
        <div class="row right pt-3">
          <button class="btn blue" type="button" onclick="showHide('mod_deltprodt');">Cancel</button>
          <button class="btn red ml-3" type="submit">Delete</button>
        </div>
      </form>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>

<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>products/";
  /////////////////////////////////////////////////////////////////////////////////

  function viewProductLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = urlroot + "show/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////

  function editProductLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    location.href = urlroot + "edit/" + encodeURIComponent(rowId);
  }
  /////////////////////////////////////////////////////////////////////////////////

  function deltProductLoader() {
    let rowId = this.parentElement.parentElement.dataset.rowId;
    document.getElementById("delt_prodt_id").value = rowId;
    showHide('mod_deltprodt');
  }
  /////////////////////////////////////////////////////////////////////////////////

  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["pid"];

    // create Image column
    let tblData1 = document.createElement("div");
    tblData1.className = "td txt-center";
    tblRow.appendChild(tblData1);
    let image = document.createElement("img");
    image.src = "<?php echo URLROOT; ?>img/uploads/product/" + dataRow["pimg"];
    image.alt = "Product Image";
    image.style.maxHeight = "5rem";
    image.style.maxWidth = "5rem";
    tblData1.appendChild(image);

    // create SKU column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = "PRD-" + dataRow["pid"].padStart(8, "0");
    tblData2.appendChild(span2);

    // create Name column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["pname"];
    tblData3.appendChild(span3);

    // create Description column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = dataRow["pdesc"];
    tblData4.appendChild(span4);

    // create Category column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let span5 = document.createElement("span");
    span5.textContent = dataRow["pcatg"];
    tblData5.appendChild(span5);

    // create Brand column
    let tblData6 = document.createElement("div");
    tblData6.className = "td";
    tblRow.appendChild(tblData6);
    let span6 = document.createElement("span");
    span6.textContent = dataRow["pbrnd"];
    tblData6.appendChild(span6);

    // create Quantity column
    let tblData7 = document.createElement("div");
    tblData7.className = "td";
    tblRow.appendChild(tblData7);
    let span7 = document.createElement("span");
    span7.textContent = dataRow["pqty"];
    tblData7.appendChild(span7);

    // create Locations column
    let tblData8 = document.createElement("div");
    tblData8.className = "td";
    tblRow.appendChild(tblData8);
    let span8 = document.createElement("span");
    span8.textContent = dataRow["plocs"];
    tblData8.appendChild(span8);

    // create Status column
    let tblData9 = document.createElement("div");
    tblData9.className = "td";
    tblRow.appendChild(tblData9);
    let span9 = document.createElement("span");
    span9.textContent = (dataRow["pstat"] == "1") ? "Active" : "Inactive";
    tblData9.appendChild(span9);

    // create Action column
    let tblDataAct = document.createElement("div");
    tblDataAct.className = "td txt-center";
    tblRow.appendChild(tblDataAct);
    // create view button
    let btnView = document.createElement("a");
    btnView.className = "btn-sm green mr-md-1";
    btnView.title = "View Product";
    btnView.onclick = viewProductLoader;
    tblDataAct.appendChild(btnView);
    let icoView = document.createElement("i");
    icoView.className = "fas fa-eye";
    btnView.appendChild(icoView);
    // create edit button
    let btnEdit = document.createElement("a");
    btnEdit.className = "btn-sm yellow mr-md-1";
    btnEdit.title = "Edit Product";
    btnEdit.onclick = editProductLoader;
    tblDataAct.appendChild(btnEdit);
    let icoEdit = document.createElement("i");
    icoEdit.className = "fas fa-edit";
    btnEdit.appendChild(icoEdit);
    // create delete button
    let btnDelt = document.createElement("a");
    btnDelt.className = "btn-sm red mr-md-1";
    btnDelt.title = "Delete Product";
    btnDelt.onclick = deltProductLoader;
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


  let dataList = new DataList(`${urlroot}getProductDataset`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3", "dl_sort_4", "dl_sort_5", "dl_sort_6", "dl_sort_7", "dl_sort_8");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>