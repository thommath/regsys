
<div class="modal fade" id="regnskapModal" tabindex="-1" role="dialog" aria-labelledby="regnskapModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="regnskapModalLabel">Bill</h4>
      </div>
      <div class="modal-body">
        <div class="modal-visible">
          <strong>Date: </strong><p id="modal-date"></p>
          <strong>Category: </strong><p id="modal-category"></p>
          <strong>Desc: </strong><p id="modal-desc"></p>
          <strong>Sum: </strong><p id="modal-sum"></p>
        </div>

        <form id="editForm" action="/editBill/editBill.php" method="post"  class="modal-hidden">
          <div class="form-group">
            <label for="form-date" class="col-sm-2 control-label">Date: </label>
            <input type="date" name="date" id="form-date" class="form-control" value=""></input>
          </div>
          <div class="form-group">
            <label for="form-category" class="col-sm-2 control-label">Category: </label>
            <select name="category" class="form-control" id="form-category">
              <?php
              //Printing categories
              foreach ($data['categories'] as $key => $value) {
                echo "<option value=\"" . $value['id'] . "\" id=\"" . $value['name'] . "\">" . $value['name'] . "</option>\n";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="form-description" class="col-sm-2 control-label">Description: </label>
            <input type="text" name="description" class="form-control" value="" placeholder="Description" id="form-description"></input>
          </div>

          <div class="form-group">
            <label for="form-sum" class="col-sm-2 control-label">Sum: </label>
            <input type="text" name="sum" value=""class="form-control"  placeholder="Eks. 100.32" id="form-sum" step="any"></input>
          </div>
          <input type="hidden" name="id" id="form-billid"/>
        </form>

      </div>
      <form id="deleteForm" style="display: none" action="components/editBill/deleteBill.php" method="post">
        <input type="hidden" name="id" id="form-billid2">
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="deleteFormSubmit" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-primary modal-visible" id="modalEdit">Edit</button>
        <button type="button" class="btn btn-primary modal-hidden" data-toggle="form" id="editFormSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#regnskapModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var date = button.data('date') // Extract info from data-* attributes
    var category = button.data('category')
    var categoryid = button.data('categoryid')
    var desc = button.data('desc')
    var sum = button.data('sum')
    var billid = button.data('billid')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#modal-date').text(date)
    modal.find('#modal-category').text(category)
    modal.find('#modal-desc').text(desc)
    modal.find('#modal-sum').text(sum)
    modal.find('#form-date').val(date)
    modal.find('#form-category').val(categoryid)
    modal.find('#form-description').val(desc)
    modal.find('#form-sum').val(sum)
    modal.find('#form-billid').val(billid)
    modal.find('#form-billid2').val(billid)
  });
  $( '#deleteFormSubmit' ).click(function() {
    $( '#deleteForm' ).submit();
  });
  $( '#editFormSubmit' ).click(function() {
    $( '#editForm' ).submit();
  });
  $( '#modalEdit' ).click(function() {
    var visible = $( '.modal-visible' );
    $( '.modal-hidden' ).toggleClass('modal-hidden modal-visible');
    visible.toggleClass('modal-visible modal-hidden');
  });
</script>
