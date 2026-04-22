<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Category Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Category</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title"><b>Inventory & PPE Reconciliation</b></h3>
          <button type="button" class="btn btn-primary btn-sm float-right rounded-0" data-toggle="modal" data-target="#addCategoryModal">
            <i class="fas fa-plus"></i> Add New Category
          </button>
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="categoryTable" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-light">
                  <th>List of Inventory</th> <th>Initial Inventory</th> <th>No. of Issued</th> <th>Inventory Balance</th> <th>Division Concerned</th> <th>Health (%)</th> <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left">Acetate</td>
                  <td>100 Rolls</td>
                  <td>20</td>
                  <td>80</td>
                  <td>AFS</td>
                  <td>80%</td>
                  <td>
                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Sigurado ka bang buburahin ito?')"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">AIR FRESHENER, Aerosol Type</td>
                  <td>50 cans</td>
                  <td>15</td>
                  <td>35</td>
                  <td>CAD</td>
                  <td>70%</td>
                  <td>
                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Alcohol, Ethyl, 1 Gallon</td>
                  <td>30 units</td>
                  <td>10</td>
                  <td>20</td>
                  <td>RDD</td>
                  <td>66%</td>
                  <td>
                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">Alcohol, Ethyl, 500 ml</td>
                  <td>200 bottles</td>
                  <td>50</td>
                  <td>150</td>
                  <td>CATS</td>
                  <td>75%</td>
                  <td>
                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td class="text-left">DISINFECTANT SPRAY, aerosol, 400g</td>
                  <td>60 cans</td>
                  <td>30</td>
                  <td>30</td>
                  <td>AFS</td>
                  <td>50%</td>
                  <td>
                    <button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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