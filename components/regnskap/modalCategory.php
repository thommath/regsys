
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="categoryModalLabel">Category</h4>
      </div>
      <div class="modal-body">
        <div class="modal-visible">
          <strong>Name: </strong><p id="categoryModal-name"></p>
          <strong>Desc: </strong><p id="categoryModal-description"></p>
        </div>

        <form id="editCategoryForm" action="/category/submitEditCategory.php" method="post"  class="modal-hidden">

          <div class="form-group">
            <label for="form-sum" class="col-sm-2 control-label">Name: </label>
            <input type="text" name="name" value="" class="form-control"  placeholder="Hello" id="categoryForm-name"></input>
          </div>
          <div class="form-group">
            <label for="form-description" class="col-sm-2 control-label">Description: </label>
            <input type="text" name="description" class="form-control" value="" placeholder="Description" id="categoryForm-description"></input>
          </div>
          <input type="hidden" name="id" id="categoryForm-categoryid"/>
        </form>

      </div>
      <form id="deleteCategoryForm" style="display: none" action="/category/submitDeleteCategory.php" method="post">
        <input type="hidden" name="id" id="categoryForm-categoryid2">
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger modal-visible" id="deleteCategoryFormSubmit">Delete</button>
        <button type="button" class="btn btn-primary modal-visible" id="editCategoryModal">Edit</button>
        <button type="button" class="btn btn-primary modal-hidden" data-toggle="form" id="editCategoryFormSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#categoryModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var name = button.data('name') // Extract info from data-* attributes
    var desc = button.data('desc')
    var categoryid = button.data('categoryid')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#categoryModal-name').text(name)
    modal.find('#categoryModal-description').text(desc)
    modal.find('#categoryForm-name').val(name)
    modal.find('#categoryForm-description').val(desc)
    modal.find('#categoryForm-categoryid').val(categoryid)
    modal.find('#categoryForm-categoryid2').val(categoryid)
  });
  $( '#deleteCategoryFormSubmit' ).click(function() {
    $( '#deleteCategoryForm' ).submit();
  });
  $( '#editCategoryFormSubmit' ).click(function() {
    $( '#editCategoryForm' ).submit();
  });
  $( '#editCategoryModal' ).click(function() {
    var visible = $( '.modal-visible' );
    $( '.modal-hidden' ).toggleClass('modal-hidden modal-visible');
    visible.toggleClass('modal-visible modal-hidden');
  });
</script>
