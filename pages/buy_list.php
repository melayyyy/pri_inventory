<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Supply Delivery History</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Inventory</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Procurement Value</span>
              <span class="info-box-number"> 
                ₱ <?php 
                  $stmt = $pdo->prepare("SELECT SUM(`purchase_subtotal`) FROM `purchase_products`") ;
                  $stmt->execute();
                  $res = $stmt->fetch(PDO::FETCH_NUM);
                  echo number_format($res[0] ?? 0, 2); 
                ?>
              </span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Payments Made</span>
              <span class="info-box-number"> 
                ₱ <?php 
                  $stmt = $pdo->prepare("SELECT SUM(`paid_amount`) FROM `invoice`") ;
                  $stmt->execute();
                  $res = $stmt->fetch(PDO::FETCH_NUM);
                  echo number_format($res[0] ?? 0, 2);
                ?>
              </span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Outstanding Balance</span>
              <span class="info-box-number"> 
                ₱ <?php 
                  $stmt = $pdo->prepare("SELECT SUM(`due_amount`) FROM `invoice`") ;
                  $stmt->execute();
                  $res = $stmt->fetch(PDO::FETCH_NUM);
                  echo number_format($res[0] ?? 0, 2);
                ?>
              </span>
            </div>
          </div>
        </div>
      </div> <div class="row mb-4"></div>

      <div class="card shadow">
        <div class="card-header border-transparent">
          <h3 class="card-title"><b>Supply Delivery Ledger</b></h3>
          <div class="card-tools">
             <a href="index.php?page=buy_product" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Record New Delivery
             </a>
          </div>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="purchaseTable" class="table table-bordered table-striped text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Item Description</th>
                  <th>Date Received</th>
                  <th>Quantity</th>
                  <th>Unit Cost</th>
                  <th>Ref. Value</th>
                  <th>Total Amount</th>
                  <th>Balance</th>
                  <th>Remarks</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  </tbody>
            </table>
          </div>
        </div> </div> </div> </section>
</div> ```

