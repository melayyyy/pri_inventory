<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Machinery & Equipment</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-outline card-danger shadow">
        <div class="card-header">
          <h3 class="card-title"><b>Asset Reconciliation & Monitoring</b></h3>
          <button type="button" class="btn btn-primary btn-sm float-right rounded-0" data-toggle="modal" data-target="#addMachineryModal">
            <i class="fas fa-plus"></i> Add Equipment
          </button>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="machineryTable" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-light">
                  <th>List of Inventory</th> <th>Sub-Category</th> <th>Initial Inventory</th> <th>No. of Issued</th> <th>Inventory Balance</th> <th>Division Concerned</th> <th>Health (%)</th> <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Desktop Computer (Admin)</td>
                  <td><span class="badge badge-info">ICT</span></td>
                  <td>15 units</td>
                  <td>10</td>
                  <td>5</td>
                  <td>AFS</td>
                  <td>90%</td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Two-Way Radio</td>
                  <td><span class="badge badge-warning">COMMUNICATION</span></td>
                  <td>20 units</td>
                  <td>15</td>
                  <td>5</td>
                  <td>CATS</td>
                  <td>85%</td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Railway Signaling Unit</td>
                  <td><span class="badge badge-success">RAILWAY</span></td>
                  <td>5 units</td>
                  <td>2</td>
                  <td>3</td>
                  <td>RDD</td>
                  <td>100%</td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>