<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Liquidation / Collection Report</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Liquidation Report</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow">
        <div class="card-body">
          <div class="box-body">
            <div id="allSearchMethods" class="box-body" style="border: 1px solid #ebedef; padding: 15px;">
              <div class="row">
                <div class="col-md-5 issueDateMethod" id="issueDateMethod">
                  <div class="form-group">
                    <label for="">Select Date Range</label>
                    <div class="input-group">
                      <div id="reportrange" style="background: #fff; cursor: pointer; padding: 6px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span id="search_date"></span> <i class="fa fa-caret-down"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="form-group">
                    <label>Select Division / Section</label>
                    <select name="customer" id="customer" class="form-control">
                      <option value="all">- All Divisions -</option>
                      <?php 
                        $all_customer = $obj->all('member');
                        foreach ($all_customer as $customer) {
                          echo '<option value="'.$customer->id.'">'.$customer->name.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-2" id="form-submit-btn" style="margin-top: 30px;">
                  <div class="form-group">
                    <input type="submit" id="search_sell_payment_report" class="btn btn-primary btn-block rounded-0" value="Generate">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow">
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead class="bg-light">
              <tr>
                <th>#</th>
                <th>Date Liquidated</th>   <th>Division ID</th>      <th>Division Name</th>    <th>Payment / Fund Type</th> <th>Amount Liquidated</th> </tr>
            </thead>
            <tbody id="search_sell_payment_report_res">
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
  $(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
      $('#reportrange span').html(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
    }

    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, cb);

    cb(start, end);

    $(document).on('click', '#search_sell_payment_report', function(event) {
      event.preventDefault();
      var issuedate = $.trim($("#search_date").text());
      var customer = $("#customer option:selected").val();

      $.post('app/ajax/search_sell_paymen_report.php', {customer:customer, issuedate:issuedate}, function(data) {
        $("#search_sell_payment_report_res").html(data);
      });
    });
  });
</script>