<?php 
require 'db.php';
if(isset($_POST['Import'])){
    $filename =$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0){
        $file = fopen($filename, "r");
        while(($data = fgetcsv($file, 10000, ",")) !== FALSE){
            $sql = 'INSERT INTO people(name, email) VALUES(:name, :email)';
            $statement = $connection->prepare($sql);
            $statement->execute([':name' => $data[0], ':email' => $data[1]]);
        }
        fclose($file);
        header("Location: /php_crud");
    }
    else {
        echo "Please rechech your file";
    }
}
?>

<?php require 'header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Upload file</h2>
    </div>
    <div class="card-body">
      <?php if(!empty($message)): ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form  method="post" name="upload_excel" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Upload Excel File</label>
          <input type="file" name="file">
        </div>
        <div class="form-group">
          <button type="submit" id="submit" name="Import" class="btn btn-info" data-loading-text="Loading....">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>
