<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <h2>Monthly Sales</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li><a href="<?php echo URLROOT; ?>reports">Reports</a></li>
      <li>Monthly Sales</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="row mb-2">
      <button class="btn purple" onclick="printData();"><i class="fas fa-print mr-2"></i>Print Report</button>
      <!-- <a class="btn purple" href="<?php echo URLROOT; ?>report/print/2" tabindex="0">Print Report</a> -->
    </div>

    <div class="card">
      <div id="tbl_data_list">
        <div class="dlist_top">
          <div class="fleft">
            <span id="dl_detail">Pages</span>
          </div>
          <div class="fright">
            <!-- <input id="dl_search_inp" type="text" minlength="3"> -->
            <select class="" id="dl_search_inp" required style="width: 150px;">
              <option value="" selected>Total</option>
              <!-- <?php for ($i = 1; $i < date('n') + 1; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo date('F'); ?></option>
              <?php endfor; ?> -->
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
            <a class="btn blue" id="dl_search_btn" tabindex="0"><i class="fas fa-search mr-2"></i>Search</a>
          </div>
        </div>

        <div class="table-wrap">
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" id="dl_sort_1" title="Sort by SKU">SKU<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_2" title="Sort by Description">Description<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_3" title="Sort by Category">Category<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_4" title="Sort by Quntity">Quantity<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
                <div class="th" id="dl_sort_5" title="Sort by Date">Date<i class="fas fa-exchange-alt fa-rotate-90"></i></div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td"><span>PR-0000002</span></div>
                <div class="td"><span>prd_002</span></div>
                <div class="td">Door Handle</div>
                <div class="td">20</div>
                <div class="td">2020-12-20</div>
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
    tblRow.dataset.rowId = dataRow["sales_pid"];

    // create pruduct sku column
    let tblData1 = document.createElement("div");
    tblData1.className = "td";
    tblRow.appendChild(tblData1);
    let span1 = document.createElement("span");
    span1.textContent = dataRow["sales_psku"];
    tblData1.appendChild(span1);

    // create product name des column
    let tblData2 = document.createElement("div");
    tblData2.className = "td";
    tblRow.appendChild(tblData2);
    let span2 = document.createElement("span");
    span2.textContent = dataRow["sales_desp"];
    tblData2.appendChild(span2);

    // create category column
    let tblData3 = document.createElement("div");
    tblData3.className = "td";
    tblRow.appendChild(tblData3);
    let span3 = document.createElement("span");
    span3.textContent = dataRow["sales_catg"];
    tblData3.appendChild(span3);

    // create quantity column
    let tblData4 = document.createElement("div");
    tblData4.className = "td";
    tblRow.appendChild(tblData4);
    let span4 = document.createElement("span");
    span4.textContent = dataRow["sales_qty"];
    tblData4.appendChild(span4);

    // create date column
    let tblData5 = document.createElement("div");
    tblData5.className = "td";
    tblRow.appendChild(tblData5);
    let span5 = document.createElement("span");
    span5.textContent = dataRow["sales_date"];
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

  let dataList = new DataList(`${urlroot}getSalesMonthData`, displayData);
  dataList.setControls("dl_prev", "dl_next");
  dataList.setDetail("dl_detail");
  dataList.setSortHeader("dl_sort_1", "dl_sort_2", "dl_sort_3", "dl_sort_4", "dl_sort_5");
  dataList.setSearch('dl_search_inp', 'dl_search_btn');

  /////////////////////////////////////////////////////
  function printData() {
    let settings = dataList.exportProperty();
    console.log(settings);
    location.href = urlroot + "print/sales/" + settings[0] + "/" + settings[1] + "/" + settings[2];
  }
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>