<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Machinery & Equipment</h1>
          <p class="text-muted"></p>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Machinery</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      
      <div class="card card-outline card-danger shadow-sm">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box bg-danger mb-3">
                <div class="info-box-content">
                  <span class="info-box-text">Total Initial Units</span>
                  <span class="info-box-number"> 
                    <?php 
                      // Binago natin ang query para mag-count ng units sa machinery table
                      $stmt = $pdo->prepare("SELECT SUM(`initial_qty`) FROM `machinery` ");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? '0';
                    ?>
                  </span>
                </div>
                <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box bg-success mb-3">
                <div class="info-box-content">
                  <span class="info-box-text">Total Issued</span>
                  <span class="info-box-number"> 
                    <?php 
                      $stmt = $pdo->prepare("SELECT SUM(`issued_qty`) FROM `machinery` ");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? '0';
                    ?>
                  </span>
                </div>
                <span class="info-box-icon"><i class="fas fa-hand-holding"></i></span>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box bg-info mb-3">
                <div class="info-box-content">
                  <span class="info-box-text">Operational Health</span>
                  <span class="info-box-number"> 
                    <?php 
                      // Average health status ng mga makinarya
                      $stmt = $pdo->prepare("SELECT AVG(`health_percent`) FROM `machinery` ");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo round($res[0] ?? 0) . "%";
                    ?>
                  </span>
                </div>
                <span class="info-box-icon"><i class="fas fa-heartbeat"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card card-outline card-danger shadow">
        <div class="card-header border-0">
          <h3 class="card-title"><b>Machinery & Equipment Inventory</b></h3>
          <button type="button" class="btn btn-danger btn-sm float-right rounded-pill" data-toggle="modal" data-target=".machineryModal">
            <i class="fas fa-plus mr-1"></i> Add New Equipment
          </button>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="machineryTable" class="table table-hover text-center align-middle">
              <thead class="bg-light">
                <tr>
                  <th>Property No.</th>
                  <th>Item / Description</th>
                  <th>Sub-Category</th> <th>Initial Stock</th> <th>Issued To</th> <th>Inventory Health</th> <th>Monthly Recon</th> <th>Action</th>
                </tr>
              </thead>
              <tbody>
                </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
$(document).ready(function() {
    $('#machineryTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "desc"]]
    });
});
</script>