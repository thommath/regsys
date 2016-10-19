

<section>
  <h3>Add Category</h3>
  <form class="form-horizontal" action="/components/addCategory/addCategory.php" method="post">
    <div class="form-group">
      <label for="name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10">
        <input type="text" name="name" id="name" value="" placeholder="Name" class="form-control"></input>
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10">
        <input type="text" name="description" value="" id="description" placeholder="Description" class="form-control"></input>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</section>
