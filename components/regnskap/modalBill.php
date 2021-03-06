
<div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="billModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="billModalLabel">Bill</h4>
      </div>
      <div class="modal-body">
        <div class="modal-visible">
          <strong>Date: </strong><p id="billModal-date"></p>
          <strong>Category: </strong><p id="billModal-category"></p>
          <strong>Desc: </strong><p id="billModal-desc"></p>
          <strong>Sum: </strong><p id="billModal-sum"></p>
        </div>

        <form id="editBillForm" action="/bill/submitEditBill.php" method="post"  class="modal-hidden">
          <div class="form-group">
            <label for="form-date" class="col-sm-2 control-label">Date: </label>
            <input type="date" name="date" id="billForm-date" class="form-control" value=""></input>
          </div>
          <div class="form-group">
            <label for="form-category" class="col-sm-2 control-label">Category: </label>
            <select name="category" class="form-control" id="billForm-category">
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
            <input type="text" name="description" class="form-control" value="" placeholder="Description" id="billForm-description"></input>
          </div>

          <div class="form-group">
            <label for="form-sum" class="col-sm-2 control-label">Sum: </label>
            <input type="text" name="sum" value=""class="form-control"  placeholder="Eks. 100.32" id="billForm-sum" step="any"></input>
          </div>
          <input type="hidden" name="id" id="billForm-billid"/>
        </form>

      </div>
      <form id="deleteBillForm" style="display: none" action="/bill/submitDeleteBill.php" method="post">
        <input type="hidden" name="id" id="billForm-billid2">
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger modal-visible" id="deleteBillFormSubmit">Delete</button>
        <button type="button" class="btn btn-primary modal-visible" id="editBillModal">Edit</button>
        <button type="button" class="btn btn-primary modal-hidden" data-toggle="form" id="editBillFormSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#billModal').on('show.bs.modal', function (event) {
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
    modal.find('#billModal-date').text(date)
    modal.find('#billModal-category').text(category)
    modal.find('#billModal-desc').text(desc)
    modal.find('#billModal-sum').text(sum)
    modal.find('#billForm-date').val(date)
    modal.find('#billForm-category').val(categoryid)
    modal.find('#billForm-description').val(desc)
    modal.find('#billForm-sum').val(sum)
    modal.find('#billForm-billid').val(billid)
    modal.find('#billForm-billid2').val(billid)
  });
  $( '#deleteBillFormSubmit' ).click(function() {
    $( '#deleteBillForm' ).submit();
  });
  $( '#editBillFormSubmit' ).click(function() {
    $( '#editBillForm' ).submit();
  });
  $( '#editBillModal' ).click(function() {
    var visible = $( '.modal-visible' );
    $( '.modal-hidden' ).toggleClass('modal-hidden modal-visible');
    visible.toggleClass('modal-visible modal-hidden');
  });
</script>
