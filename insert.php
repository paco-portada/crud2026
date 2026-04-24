<?php include('db.php'); ?>

<?php include('includes/header.php'); ?>

<main class="container p-4">
  <div class="row">
    <div class="col-md-8">

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
      <?php unset($_SESSION['db_error']); } ?>

      <!-- ADD TASK FORM -->
      <?php if ($conn) { ?>
      <div class="card card-body">
        <form action="save_task.php" method="POST">
          <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Task Title" autofocus>
          </div>
          <div class="form-group">
            <textarea name="description" rows="2" class="form-control" placeholder="Task Description"></textarea>
          </div>
          <input type="submit" name="save_task" class="btn btn-success btn-block" value="Save Task">
          <hr>
          <a class="btn btn-secondary btn-block" href="index.php">Cancel</a>
        </form>
      </div>
      <?php } else if (!isset($_SESSION['db_error'])) { ?>
        <div class="alert alert-warning">
          The database connection is unavailable. Please check your configuration.
        </div>
        <a href="index.php" class="btn btn-secondary btn-block">Back to Home</a>
      <?php } ?>
    </div>
  </div>
</main>
<?php include('includes/footer.php'); ?>
