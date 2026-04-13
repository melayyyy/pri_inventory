<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid mt-5">
      <div class="row">
        <div class="col-md-6">
          <h1 class="m-0 text-dark">Inventory Financial Report</h1>
        </div><div class="col-md-6 mt-3">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Financial Report</li>
          </ol>
        </div></div></div></div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <div class="card shadow">
            <div class="card-body">
              <table class="table">
                <tr>
                  <td class="text-info" colspan="2"><b>Stock-In / Procurement (Supplies Received)</b></td>
                </tr>
                <tr>
                  <td>Total Procurement Cost</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`purchase_subtotal`) FROM `purchase_products`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $total_purchase = $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Paid to Suppliers</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`payment_amount`) FROM `purchase_payment`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Pending Payments (Accounts Payable)</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`total_due`) FROM `suppliar`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Returned to Suppliers</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`netTotal`) FROM `purchase_return`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $total_return = $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Net Procurement Value</b></td>
                  <td class="text-right"><b><?php echo number_format($total_purchase - $total_return, 2); ?></b></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-6">
          <div class="card shadow">
            <div class="card-body">
              <table class="table">
                <tr>
                  <td class="text-info" colspan="2"><b>Stock-Out / Issuance (Supplies Distributed)</b></td>
                </tr>
                <tr>
                  <td>Total Value Issued</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`sub_total`) FROM `invoice`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $total_sell_amount = $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Reimbursed / Liquidated</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`payment_amount`) FROM `sell_payment`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Unliquidated Claims</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`total_due`) FROM `member`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Returned by Divisions</td>
                  <td class="text-right">
                    <?php  
                      $stmt = $pdo->prepare("SELECT SUM(`amount`) FROM `sell_return`");
                      $stmt->execute();
                      $res = $stmt->fetch(PDO::FETCH_NUM);
                      echo $total_sell_return = $res[0] ?? 0;
                    ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Net Issuance Value</b></td>
                  <td class="text-right"><b><?php echo number_format($total_sell_amount - $total_sell_return, 2); ?></b></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>