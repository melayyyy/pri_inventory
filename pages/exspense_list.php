<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><!-- Dashboard v2 --></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense catagory</li>
            </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">

              <div class="row">
                   <div class="col-12 col-sm-6 col-md-4">
                          <div class="info-box bg-success">
                            
                            <div class="info-box-content">
                              <span class="info-box-text">Total Supplies Issued</span>
                              <span class="info-box-number"> 
                                <?php 
  $stmt = $pdo->prepare("SELECT SUM(`amount`) FROM `expense`");
  $stmt->execute();
  $res = $stmt->fetch(PDO::FETCH_NUM);

  // Nilagyan natin ng check: kung walang laman or error, "0" ang lalabas
  if ($res && isset($res[0])) {
      echo $res[0];
  } else {
      echo "0";
  }
?>
                                </span>
                            </div>
                            <span class="info-box-icon"><i class="material-symbols-outlined">inventory_2</i></span>

                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>


                        </div>
              </div>
              <!-- .row -->
              <div class="card">
               <div class="card-body">
            <div class="card-header">
                <h3 class="card-title"><b>Supply Issuance Logs</b></h3>
               <a href="index.php?page=add_expense" class="btn btn-primary btn-sm float-right rounded-0">+ Log New Issuance</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <div class="table-responsive">
                    <table id="expenseList" class="display dataTable text-center">
                      <thead>
                        <tr>
                          <th>SI</th>
                          <th>Date Issued</th>
                          <th>Requesting Division/Personnel</th>
                          <th>Quantity Issued</th>
                          <th>Item Category</th>
                          <th>Purpose / Remarks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <!-- /.row -->
            </div><!--/. container-fluid -->
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->