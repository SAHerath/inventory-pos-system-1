<?php include_once(APPROOT . '/views/includes/header.php'); ?>
<?php include_once(APPROOT . '/views/includes/navigation.php'); ?>

<main class="main" id="main">
  <div class="main-header">
    <div class="heading">
      <h2>Reports</h2>
    </div>

    <ul class="breadcrumb">
      <li><a href="<?php echo URLROOT; ?>home">Home</a></li>
      <li>Reports</li>
    </ul>

  </div>
  <div class="main-cards">

    <div class="card">
      <div id="tbl_data_list">
        <div class="dlist_top">
          <div class="fleft">
            <span id="dl_detail">Pages</span>
          </div>
          <!-- <div class="fright">
            <input id="dl_search_inp" type="text" minlength="3">
            <a class="btn blue" id="dl_search_btn" tabindex="0">Search</a>
          </div> -->
        </div>

        <div class="table-wrap">

          <!-- <div style="flex: 0 0 auto; background-color: palegreen; width: 600px;">Hello There</div> -->
          <div class="table">
            <div class="thead">
              <div class="tr">
                <div class="th" title="Report Type" style="width: 250px;">Report Type</div>
                <div class="th" title="Report Description">Description</div>
              </div>
            </div>
            <div class="tbody" id="dl_tbl_body">
              <div class="tr">
                <div class="td txt-center">
                  <a class="btn green" href="<?php echo URLROOT; ?>reports/show/stock" style="width: max-content; height:max-content;">Stock Details</a>
                </div>
                <div class="td">
                  <span>Report Description</span>
                </div>
              </div>
              <div class="tr">
                <div class="td txt-center">
                  <a class="btn green" href="<?php echo URLROOT; ?>reports/show/sales" style="width: max-content; height:max-content;">Monthly Sales</a>
                </div>
                <div class="td">
                  <span>Report Description</span>
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


<script type="text/javascript">
  const urlroot = "<?php echo URLROOT; ?>reports/";
  /////////////////////////////////////////////////////////////////////////////////
</script>
<?php include_once(APPROOT . '/views/includes/footer.php'); ?>