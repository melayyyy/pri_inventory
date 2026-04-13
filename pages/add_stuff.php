<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Divisions & Sections</h1>
        </div><div class="col-sm-6 mt-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Division</li>
          </ol>
        </div></div></div></div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-3">
          <div class="card card-primary shadow">
            <div class="card-header">
              <h3 class="card-title">Register New Division (RIS Reference)</h3>
            </div>
            <div class="card-body">
              <form id="addDivisionForm" action="" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Division / Section Name *:</label>
                      <input type="text" class="form-control" id="name" placeholder="e.g. Admin and Finance Section" name="txt_division_name" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="center_code">Responsibility Center Code:</label>
                      <input type="text" class="form-control" id="center_code" placeholder="Enter Code from RIS Form" name="txt_center_code">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="location">Office Location / Floor:</label>
                      <input type="text" class="form-control" id="location" placeholder="e.g. 6th Floor, DOTr-PRI" name="txt_location">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="remarks">Description / Remarks:</label>
                      <textarea rows="3" class="form-control" placeholder="Additional details about this division..." id="remarks" name="txt_remarks"></textarea>
                    </div>
                  </div>
                </div>

                <button type="submit" name="btn_add_division" class="btn btn-primary btn-block">Add Division</button>
              </form>
            </div></div></div></div></div></section>
  </div>