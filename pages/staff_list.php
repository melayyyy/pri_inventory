<?php 
// Error suppressor para malinis ang taas
@include_once 'connectdb.php'; 
?>

<div class="content-wrapper" style="padding-top: 50px !important;">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark mt-3">Division Directory</h1>
        </div>
        <div class="col-sm-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Divisions</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header bg-white py-3">
              <h3 class="card-title"><b>List of Registered Divisions & Sections</b></h3>
            </div>
            
            <div class="card-body">
              <div class="table-responsive">
                <table id="divisionTable" class="table table-bordered table-striped text-center">
                  <thead class="bg-light">
                    <tr>
                      <th style="width: 50px;">ID</th>
                      <th>Division / Section Name</th>
                      <th>RC Code</th>
                      <th>Office Location</th>
                      <th>Remarks</th>
                      <th style="width: 100px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(isset($pdo)){
                        $select = $pdo->prepare("SELECT * FROM tbl_division ORDER BY id DESC");
                        $select->execute();
                        
                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                          echo "<tr>
                                  <td>".$row['id']."</td>
                                  <td class='text-left'><b>".$row['division_name']."</b></td>
                                  <td><span class='badge badge-secondary'>".$row['center_code']."</span></td>
                                  <td>".$row['location']."</td>
                                  <td>".$row['remarks']."</td>
                                  <td>
                                    <div class='btn-group'>
                                      <a href='index.php?page=edit_division&id=".$row['id']."' class='btn btn-sm btn-info'>
                                        <i class='fas fa-edit'></i>
                                      </a>
                                      <button class='btn btn-sm btn-danger'>
                                        <i class='fas fa-trash'></i>
                                      </button>
                                    </div>
                                  </td>
                                </tr>";
                        }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div> ```

---

