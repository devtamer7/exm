<!-- This Is A Batches Page -->
<?php  
require("../includes/header.php");
require("../includes/sidebar.php");
?>

<!-- Here Batches Crud Design -->
	<div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Batches List</h4>
                                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
 <i class="fas fa-plus"></i>&nbsp;
 Add New Batch
</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Batch Name</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       <tbody id="btachesTable">
                                        <!-- The Data Coming As Js -->
                                               
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>     
                    
                    
<!-- Insert Modal -->
 <!-- Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="insertModalLabel">Add New Batch</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-group" id="insertForm" >
            <input class="form-control"  type="text" name="batchName" id="batchName" placeholder="Enter Batch Name" required>
     <input type="text" name="batchStartDate"  class="form-control mt-2" placeholder="YYYY-MM-DD" id="mdate">
     <h5 class="my-2">Select Batch Status</h5>
        <div class="d-flex align-items-center mt-2">
            <label style="align-self:center;">Complete <input style="margin-top:3px;" type="radio" class="form-radio" value="Complete" name="batchStatus" id="batchStatus"></label>
            <label style="align-self:center; margin-left: 10px;" class="ml-2" >Ongoing <input class="form-radio" style="margin-top:3px;" type="radio" value="Ongoing" name="batchStatus" id="batchStatus"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Update Batch</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" class="form-group" id="updateForm">
            <input type="hidden" name="batchId" id="updateBatchId">
            <input class="form-control" type="text" name="batchName" id="updateBatchName" placeholder="Enter Batch Name" required>
            <input type="text" name="batchStartDate" class="form-control updateMdate mt-2" placeholder="YYYY-MM-DD" id="mdate">
            <h5 class="my-2">Select Batch Status</h5>
            <div class="d-flex align-items-center mt-2">
                <label style="align-self:center;">Complete <input style="margin-top:3px;" type="radio" class="form-radio" value="Complete" name="batchStatus" id="updateBatchStatusComplete"></label>
                <label style="align-self:center; margin-left: 10px;" class="ml-2" >Ongoing <input class="form-radio" style="margin-top:3px;" type="radio" value="Ongoing" name="batchStatus" id="updateBatchStatusOngoing"></label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
require("../includes/footer.php");
?>
<script src="js/batches.js"></script>
