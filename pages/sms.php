<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Buildings & Other Structures</h1>
          <p class="text-muted">DOTr Infrastructure & Facility Management</p>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Buildings</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-5 mt-3">
          <div class="card card-outline card-danger shadow">
            <div class="card-header">
              <h4><b>Update Structure Status</b></h4>
            </div>
            <div class="card-body">
              <form id="buildingStatusForm">
                <div class="form-group">
                  <label for="structure_name">Building / Room Name</label>
                  <input type="text" class="form-control" id="structure_name" placeholder="e.g. DOTr Central Office 5th Floor">
                </div>
                <div class="form-group">
                  <label for="occupancy_status">Occupancy / Division Concerned</label>
                  <input type="text" class="form-control" id="occupancy_status" placeholder="e.g. Accounting Division">
                </div>
                <div class="form-group">
                  <label for="structural_health">Structural Health (%)</label>
                  <input type="number" class="form-control" id="structural_health" placeholder="100">
                </div>
                <div class="form-group">
                  <label for="maintenance_remarks">Maintenance Remarks</label>
                  <textarea rows="3" class="form-control" id="maintenance_remarks" placeholder="Notes on electrical, plumbing, or paint..."></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-danger btn-block mt-4 rounded-0">
                    <i class="fas fa-save"></i> Save Structure Update
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-7 mt-3">
          <div class="card card-outline card-danger shadow">
            <div class="card-header border-0">
              <h3 class="card-title"><b>Inventory of Structures</b></h3>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover text-center m-0">
                  <thead class="bg-light">
                    <tr>
                      <th>Structure ID</th>
                      <th>Location</th>
                      <th>Health</th>
                      <th>Last Recon</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>BLDG-05F</td>
                      <td><b>5th Floor Main</b></td>
                      <td><span class="badge badge-success">98% Good</span></td>
                      <td><small>April 2026</small></td>
                    </tr>
                    <tr>
                      <td>BLDG-06F</td>
                      <td><b>6th Floor Annex</b></td>
                      <td><span class="badge badge-warning">85% Fair</span></td>
                      <td><small>March 2026</small></td>
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