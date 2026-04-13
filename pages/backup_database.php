<?php 
// 1. Gumawa ka muna ng folder na "uploads" sa loob ng iyong project folder para dito pumasok ang mga PDF.
$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['upload_pdf'])) {
    $doc_name = $_POST['doc_name'];
    $file = $_FILES['pdf_file'];

    if ($file['type'] == 'application/pdf') {
        $file_name = time() . '_' . basename($file['name']); // Nilagyan ng time para walang kaparehong filename
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Dito mo i-save sa database table mo (halimbawa 'digital_archives') ang $doc_name at $file_name
            // $query = "INSERT INTO digital_archives (doc_name, file_path, date_uploaded) VALUES (?, ?, NOW())";
            $success = "Document '$doc_name' has been archived successfully.";
        } else {
            $error = "Failed to upload file.";
        }
    } else {
        $error = "Please upload PDF files only.";
    }
}
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Digital Document Archive</h1>
        </div>
        <div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Digital Archive</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
          <div class="card-header bg-primary">
            <h3 class="card-title text-white">Upload Scanned Document</h3>
          </div>
          <div class="card-body">
            <?php 
                if (isset($success)) echo "<div class='alert alert-success'>$success</div>";
                if (isset($error)) echo "<div class='alert alert-danger'>$error</div>";
             ?>
            <form method="post" action="#" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Document Description</label>
                    <input type="text" name="doc_name" class="form-control" placeholder="e.g. RIS-2026-03-30-6th-Floor" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Select Scanned PDF</label>
                    <input type="file" name="pdf_file" class="form-control" accept="application/pdf" required>
                  </div>
                </div>
              </div>
              <div class="form-group border-top pt-3">
                 <button type="submit" name="upload_pdf" class="btn btn-primary">
                    <i class="fas fa-file-upload"></i> Archive Document
                 </button>
              </div>
            </form>
          </div>
        </div>

        <div class="card shadow">
          <div class="card-header">
            <h3 class="card-title"><b>Archived Inventory Records</b></h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Date Uploaded</th>
                        <th>Document Name</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2026-04-08</td>
                        <td>Supply Issuance - 17th Floor (March)</td>
                        <td class="text-right">
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                            <a href="#" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
    </div>
  </section>
</div>