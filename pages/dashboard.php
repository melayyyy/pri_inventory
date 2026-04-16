<div class="content-wrapper" style="min-height: 100vh; background-color: #f4f6f9; padding: 20px;">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark font-weight-bold">Inventory Dashboard</h1>
            <p class="text-muted">Select a category to manage stocks.</p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php
                $categories = [
                    1 => ["title" => "Office Supplies", "sub" => "Stationery & Consumables", "color" => "linear-gradient(45deg, #1a2a6c, #b21f1f)"],
                    2 => ["title" => "Machinery and Equipment", "sub" => "ICT & Railway Equipment", "color" => "linear-gradient(45deg, #0f0c29, #302b63)"],
                    3 => ["title" => "Furniture and Fixtures", "sub" => "Office Desks & Chairs", "color" => "linear-gradient(45deg, #2c3e50, #4ca1af)"],
                    4 => ["title" => "Transportation Equipment", "sub" => "Motor Vehicles", "color" => "linear-gradient(45deg, #373B44, #4286f4)"],
                    5 => ["title" => "Building and Structures", "sub" => "Office Facilities", "color" => "linear-gradient(45deg, #1e3c72, #2a5298)"]
                ];

                foreach ($categories as $id => $cat):
                ?>
                <div class="col-12 mb-3">
                    <div class="card border-0 shadow-sm" style="background: <?php echo $cat['color']; ?>; border-radius: 15px; color: white;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="mb-1 font-weight-bold" style="font-size: 1.5rem;">
                                        <?php echo $id . ". " . $cat['title']; ?>
                                    </h3>
                                    <p class="mb-0" style="opacity: 0.8; font-size: 0.9rem;">
                                        <?php echo $cat['sub']; ?>
                                    </p>
                                </div>
                                <div>
                                    <a href="index.php?page=inventory_list&category=<?php echo $id; ?>" 
                                       class="btn btn-light rounded-pill px-4 font-weight-bold shadow-sm">
                                        VIEW LIST
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<style>
    /* Ito ang taga-ayos para hindi pumasok sa ilalim ng sidebar */
    .content-wrapper {
        margin-left: 250px; /* Sukat ng sidebar mo */
        transition: margin-left .3s ease-in-out;
    }
    
    /* Responsive adjustment para sa mobile */
    @media (max-width: 768px) {
        .content-wrapper {
            margin-left: 0;
        }
    }
</style>