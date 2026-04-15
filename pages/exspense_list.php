<div class="content-wrapper mt-5">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Digital Archive Dashboard</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-file-archive"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Archived Slips</span>
              <span class="info-box-number">
                <?php 
                  $stmt = $conn->query("SELECT COUNT(*) FROM `archives` ");
                  $res = $stmt->fetch_row();
                  echo ($res[0]) ? $res[0] : "0";
                ?>
              </span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-boxes"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Units Issued</span>
              <span class="info-box-number">
                <?php 
                  // Ina-assume natin na ang 'amount' column ang nag-tatrack ng quantity
                  $stmt = $conn->query("SELECT SUM(id) FROM `archives` "); 
                  $res = $stmt->fetch_row();
                  echo ($res[0]) ? $res[0] : "0";
                ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="card card-outline card-navy">
        <div class="card-header">
          <h3 class="card-title"><b>Master List of Scanned RIS</b></h3>
          <a href="index.php?page=add_archive" class="btn btn-primary btn-sm float-right rounded-0">
            <i class="fas fa-plus"></i> New Digital Backup
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="risLogs" class="table table-bordered table-striped text-center">
              <thead>
                <tr class="bg-light">
                  <th>Date Encoded</th>
                  <th>Stock No.</th>
                  <th>Item Description</th>
                  <th>Division / Office</th>
                  <th>Signatories</th>
                  <th>File Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // Kumukuha tayo ng data mula sa 'archives' table na pinagawa mo kanina
                  $all_archives = $conn->query("SELECT * FROM archives ORDER BY date_archived DESC");
                  while($row = $all_archives->fetch_assoc()):
                ?>
                <tr>
                  <td><?= date('M d, Y', strtotime($row['date_archived'])) ?></td>
                  <td><span class="badge badge-secondary"><?= $row['stock_no'] ?></span></td>
                  <td><?= $row['doc_name'] ?></td>
                  <td>
                    <strong><?= $row['division'] ?></strong><br>
                    <small class="text-muted"><?= $row['office'] ?></small>
                  </td>
                  <td>
                    <small>Req: <?= $row['requested_by'] ?></small><br>
                    <small>App: <b><?= $row['approved_by'] ?></b></small>
                  </td>
                  <td>
                    <a href="<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-info">
                      <i class="fas fa-eye"></i> View Scan
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>