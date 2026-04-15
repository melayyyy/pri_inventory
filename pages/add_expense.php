<div class="content-wrapper mt-5">
  <section class="content mt-5">
    <div class="container-fluid">
      <div class="row mt-4">
        <div class="col-md-10 offset-md-1 mt-3">
          <div class="card">
            <div class="card-header bg-navy">
              <h3 class="card-title"><b>Log New Requisition and Issue Slip (RIS)</b></h3>
            </div>
            <div class="card-body">
              <form id="addIssuanceForm">
                
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Issuance Date</label>
                      <input type="text" class="form-control datepicker" name="issuance_date">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Division</label>
                      <input type="text" class="form-control" name="division" placeholder="e.g. Certification Division">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Office</label>
                      <input type="text" class="form-control" name="office" placeholder="e.g. Philippine Railways Institute">
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Stock No.</label>
                      <input type="text" class="form-control" name="stock_no">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Unit</label>
                      <input type="text" class="form-control" name="unit" placeholder="Ream/Pcs">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>Item Description</label>
                      <select name="item_description" class="form-control select2">
                        <?php 
                          $items = $obj->all('office_supplies');
                          foreach ($items as $item) {
                            echo "<option value='{$item->id}'>{$item->item_name}</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Quantity Requested</label>
                      <input type="number" class="form-control" name="qty_requested">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Stock Available?</label>
                      <select name="stock_available" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label>Purpose</label>
                      <input type="text" class="form-control" name="purpose" placeholder="e.g. RDD Office Supplies">
                    </div>
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Requested By</label>
                      <input type="text" class="form-control" name="requested_by">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Approved By</label>
                      <input type="text" class="form-control" name="approved_by" value="ANNA KATRINA P. FLORES">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Issued By</label>
                      <input type="text" class="form-control" name="issued_by">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Received By</label>
                      <input type="text" class="form-control" name="received_by">
                    </div>
                  </div>
                </div>

                <div class="form-group mt-4">
                  <button type="submit" class="btn btn-success btn-block rounded-0">Save RIS Record</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>