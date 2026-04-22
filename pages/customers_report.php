<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Furniture & Fixtures</h1>
          <p class="text-muted">Office Assets & Accommodation Monitoring</p>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Furniture</li>
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
              <h3 class="card-title text-bold">Office Furniture Inventory Report</h3>
              <div class="card-tools">
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addFurnitureModal">
                  <i class="fas fa-plus"></i> Add Furniture
                </button>
              </div>
            </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="furniture_fixtures_report" class="table table-bordered table-hover text-center">
                  <thead class="bg-light">
                    <tr>
                      <th>Property ID</th>
                      <th>Description</th> <th>Initial Qty</th> <th>Location</th> <th>Issued To</th> <th>Condition/Health</th> <th>Monthly Recon</th> <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>FF-2026-045</td>
                      <td><b>Clerical Chair (Blue)</b></td>
                      <td>10 Units</td>
                      <td>6th Floor - Cashier</td>
                      <td>Various Staff</td>
                      <td>
                        <span class="badge badge-success">Good Condition</span>
                      </td>
                      <td><small>April 2026</small></td>
                      <td>
                        <button class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></button>
                      </td>
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
    $('#furniture_fixtures_report').DataTable({
        "responsive": true,
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": ["excel", "pdf", "print"]
    });
});
</script>