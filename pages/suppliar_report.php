<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Transportation Equipment Inventory</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-outline card-danger shadow">
        <div class="card-header">
          <h3 class="card-title"><b>Vehicle & Fleet Monitoring</b></h3>
          <button type="button" class="btn btn-primary btn-sm float-right rounded-0" data-toggle="modal" data-target="#addTransportModal">
            <i class="fas fa-plus"></i> Add Vehicle
          </button>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="transportTable" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-light">
                  <th>Plate No. / ID</th>
                  <th>Vehicle Description</th>
                  <th>Initial Inventory</th>
                  <th>No. of Issued</th>
                  <th>Inventory Balance</th>
                  <th>Division Concerned</th>
                  <th>Serviceability (%)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>SAB-1234</td>
                  <td class="text-left">Toyota Hi-Ace (Service Van)</td>
                  <td>1</td>
                  <td>1</td>
                  <td>0</td>
                  <td>AFS - Motorpool</td>
                  <td><span class="badge badge-success">95%</span></td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>SAB-5678</td>
                  <td class="text-left">Mitsubishi L300 (Utility Van)</td>
                  <td>2</td>
                  <td>2</td>
                  <td>0</td>
                  <td>CAD</td>
                  <td><span class="badge badge-warning">70%</span></td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>SAB-9012</td>
                  <td class="text-left">Toyota Camry (Executive Car)</td>
                  <td>1</td>
                  <td>1</td>
                  <td>0</td>
                  <td>OSEC</td>
                  <td><span class="badge badge-success">100%</span></td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>SAB-3456</td>
                  <td class="text-left">Isuzu D-Max (Service Pickup)</td>
                  <td>3</td>
                  <td>2</td>
                  <td>1</td>
                  <td>RDD - Field Team</td>
                  <td><span class="badge badge-success">90%</span></td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>MC-7890</td>
                  <td class="text-left">Honda TMX (Messenger Bike)</td>
                  <td>5</td>
                  <td>4</td>
                  <td>1</td>
                  <td>CATS</td>
                  <td><span class="badge badge-danger">45%</span></td>
                  <td>
                    <button class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>SAB-4321</td>
                  <td class="text-left">Hyundai Coaster (Staff Bus)</td>
                  <td>1</td>
                  <td>1</td>
                  <td>0</td>
                  <td>AFS - Motorpool</td>
                  <td><span class="badge badge-success">88%</span></td>
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