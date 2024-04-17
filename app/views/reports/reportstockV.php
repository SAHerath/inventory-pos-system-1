<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <span>Stock Details</span>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>reports">Reports</a></li>
      <li>Stock Details</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="row mb-2">
      <button class="btn purple" onclick="printData();"><i class="fas fa-print mr-2"></i>Print Report</button>
    </div>

    <div class="card">
      <div id="tbl_data_list">
        <div class="dlist_top">
          <div class="fleft">
            <span id="dl_detail">Pages</span>
          </div>
          <div class="fright">
            <input id="dl_search_inp" type="text" minlength="3">
            <a class="btn blue" id="dl_search_btn" tabindex="0"><i class="fas fa-search mr-2"></i>Search</a>
          </div>
        </div>

        <div class="table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" id="dl_sort_1" title="Sort by Order No.">SKU<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2" title="Sort by Date">Product Name<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3" title="Sort by Customer">Quantity<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_4" title="Sort by Status">Reorder Level<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_5" title="Sort by Total Amt.">Status<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td"><span>PR-0000002</span></div>
                <div class="td"><span>prd_002</span></div>
                <div class="td">23</div>
                <div class="td">20</div>
                <div class="td txt-center">OK</div>
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


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>reports/";
  /////////////////////////////////////////////////////////////////////////////////
  const tblBody = document.getElementById("dl_tbl_body");

  function createTblRow(dataRow) {

    let tblRow = document.createElement("div");
    tblRow.className = "tr";
    tblRow.dataset.rowId = dataRow["prodt_id"];

    // create pruduct sku column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["prodt_sku"];
    tblData1.appendChild(span1);

    // create product name column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["prodt_name"];
    tblData2.appendChild(span2);

    // create quantity column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["prodt_qty"];
    tblData3.appendChild(span3);

    // create reorder level column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = dataRow["prodt_rord"];
    tblData4.appendChild(span4);

    // create status column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let span5 = document.createElement("span");
    span5.textContent = dataRow["prodt_stat"];
    tblData5.appendChild(span5);

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

  let dataList = new DataList(`${urlroot}getReportStockData`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3", "dl_sort_4", "dl_sort_5");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');

  /////////////////////////////////////////////////////
  function printData() {
    let settings = dataList.exportProperty();
    console.log(settings);
    location.href = urlroot + "print/stock/" + settings[0] + "/" + settings[1] + "/" + settings[2];
  }
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>