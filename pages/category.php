<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detailed Inventory List</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title">List of All Supplies & Equipment</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItemModal">
                        <i class="fas fa-plus"></i> Add New Item
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="inventoryTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-light">
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Initial Qty</th> <th>Current Balance</th> <th>Health Status</th> <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SUP-001</td>
                            <td><b>Stapler Heavy Duty</b><br><small></small></td>
                            <td>Office Supplies</td>
                            <td>50 pcs</td>
                            <td><span class="badge badge-success">45 pcs</span></td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="progress-bar bg-success" style="width: 90%"></div>
                                </div>
                                <small>90% - Good</small>
                            </td>
                            <td>
                                <button class="btn btn-info btn-xs" title="View Logs"><i class="fas fa-history"></i></button>
                                <button class="btn btn-primary btn-xs" title="Issue Item"><i class="fas fa-hand-holding"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    $(function () {
        $("#inventoryTable").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#inventoryTable_wrapper .col-md-6:eq(0)');
    });
</script>