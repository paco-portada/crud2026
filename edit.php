<?php
include("db.php");
$title = '';
$description= '';

if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM task WHERE id=$id";
  try {
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $description = $row['description'];
    } else {
        $_SESSION['message'] = 'Task Not Found';
        $_SESSION['message_type'] = 'danger';
        header('Location: index.php');
        exit();
    }
  } catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = 'Task Not Found: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit();
  }

}

if (isset($_POST['update'])) {
  if (!$conn) {
    $_SESSION['message'] = 'Database connection failed. Cannot update task.';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit();
  }

  $id = (int)$_GET['id'];
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $query = "UPDATE task SET title = '$title', description = '$description' WHERE id = $id";
  try {
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Updated Successfully';
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');
    exit();
  } catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = 'Task Update Failed: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
  }
}
?>

<?php include('includes/header.php'); ?>
<div class="container p-4">
  <?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['message']?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php 
      unset($_SESSION['message']);
      unset($_SESSION['message_type']);
  } ?>

  <?php if (isset($_SESSION['db_error'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Error de conexión a la base de datos: <?= htmlspecialchars($_SESSION['db_error']) ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php 
      unset($_SESSION['message']);
      unset($_SESSION['message_type']);
  } ?>

  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
      <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
        <div class="form-group">
          <input name="title" type="text" class="form-control" value="<?php echo htmlspecialchars($title); ?>" placeholder="Update Title">
        </div>
        <div class="form-group">
        <textarea name="description" class="form-control" cols="30" rows="10"><?php echo htmlspecialchars($description);?></textarea>
        </div>
        <input type="submit" class="btn btn-success btn-block" name="update" value="Update">
        <hr>
        <a class="btn btn-secondary btn-block" href="index.php">Cancel</a>
      </form>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
