<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Transportation Equipment</h1>
          <p class="text-muted">DOTr Fleet & Vehicle Asset Monitoring</p>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Transportation</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 mt-3">
          <div class="card card-outline card-danger shadow">
            <div class="card-header">
              <h3 class="card-title text-info"><b>Transportation Inventory Report</b></h3>
            </div>
            
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-12 col-sm-6 col-md-4">
                  <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon elevation-1"><i class="fas fa-car"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Initial Units</span>
                      <span class="info-box-number">
                        <?php 
                          $stmt = $pdo->prepare("SELECT SUM(`initial_qty`) FROM `transportation` ");
                          $stmt->execute();
                          $res = $stmt->fetch(PDO::FETCH_NUM);
                          echo $res[0] ?? '0';
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-4">
                  <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon elevation-1"><i class="fas fa-key"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Issued / In-Use</span>
                      <span class="info-box-number">
                        <?php 
                          $stmt = $pdo->prepare("SELECT SUM(`issued_qty`) FROM `transportation` ");
                          $stmt->execute();
                          $res = $stmt->fetch(PDO::FETCH_NUM);
                          echo $res[0] ?? '0';
                        ?>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                  <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon elevation-1"><i class="fas fa-tools"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Serviceable Rate</span>
                      <span class="info-box-number">
                        <?php 
                          $stmt = $pdo->prepare("SELECT AVG(`health_percent`) FROM `transportation` ");
                          $stmt->execute();
                          $res = $stmt->fetch(PDO::FETCH_NUM);
                          echo round($res[0] ?? 0) . "%";
                        ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table id="transport_report_data" class="table table-bordered table-hover text-center">
                  <thead class="bg-light">
                    <tr>
                      <th>Plate No. / ID</th>
                      <th>Vehicle Description</th>
                      <th>Initial Inventory</th> <th>Division Assigned</th> <th>Current Balance</th> <th>Health (%)</th> <th>Monthly Recon</th> </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>SAB-1234</td>
                      <td><b>Toyota Hi-Ace (Service Vehicle)</b></td>
                      <td>1</td>
                      <td>Admin - Motorpool</td>
                      <td>1</td>
                      <td>
                        <span class="badge badge-success">95% Serviceable</span>
                      </td>
                      <td><small>April 2026</small></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function() {
    $('#transport_report_data').DataTable({
        "responsive": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": ["excel", "pdf", "print"]
    });
});
</script>