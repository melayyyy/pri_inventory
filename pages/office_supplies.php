<?php
include_once 'connectdb.php'; 

// DEBUGGING: Tingnan natin kung may connection at kung anong ID ang nakuha
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

$category_id = isset($_GET['category']) ? $_GET['category'] : 1;
echo "";

$query = "SELECT * FROM office_supplies WHERE category_type = '$category_id'";
$result = mysqli_query($conn, $query);

if(!$result){
    echo "Error sa SQL: " . mysqli_error($conn); // Lalabas dito kung mali ang table name o column
}
?>

<div class="content-wrapper" style="min-height: 100vh; background-color: #f4f6f9; padding: 20px; margin-left: 250px;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="m-0 text-dark font-weight-bold"><?php echo $current_title; ?></h1>
                <a href="index.php?page=dashboard" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background-color: #343a40; color: white;">
                            <tr>
                                <th style="border-top-left-radius: 15px;">Stock No.</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th style="border-top-right-radius: 15px; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(mysqli_num_rows($result) > 0):
                                while($row = mysqli_fetch_assoc($result)): 
                            ?>
                            <tr>
                                <td class="align-middle"><?php echo $row['stock_no']; ?></td>
                                <td class="align-middle"><strong><?php echo $row['item_name']; ?></strong></td>
                                <td class="align-middle"><?php echo $row['unit']; ?></td>
                                <td class="align-middle">
                                    <span class="badge badge-info px-3 py-2"><?php echo $row['quantity']; ?></span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary">View Details</button>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i><br>
                                    <p class="text-muted">Walang items sa category na ito.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Spacing adjustment para sa layout */
    .content-wrapper { transition: margin-left .3s; }
    @media (max-width: 768px) { .content-wrapper { margin-left: 0; } }
    .table thead th { border: none; padding: 15px; }
    .table tbody td { padding: 15px; }
</style>