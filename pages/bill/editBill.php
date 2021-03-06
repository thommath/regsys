<section>
  <formaction="submitEditBill.php" method="post"  class="modal-hidden">
    <div class="form-group">
      <label for="form-date" class="col-sm-2 control-label">Date: </label>
      <input type="date" name="date" class="form-control" value=""></input>
    </div>
    <div class="form-group">
      <label for="form-category" class="col-sm-2 control-label">Category: </label>
      <select name="category" class="form-control" >
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
      <input type="text" name="description" class="form-control" value="" placeholder="Description"></input>
    </div>

    <div class="form-group">
      <label for="form-sum" class="col-sm-2 control-label">Sum: </label>
      <input type="text" name="sum" value=""class="form-control"  placeholder="Eks. 100.32" step="any"></input>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </form>
</section>
