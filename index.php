<?php include("db.php"); ?>

<?php include('includes/header.php'); ?>

<main class="container p-4">
  <div class="row">
    <div class="col-md-12">
      <!-- MESSAGES -->

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
        Error de conexión a la base de datos: <?= $_SESSION['db_error'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php unset($_SESSION['db_error']); } ?>
    </div>

  <?php if ($conn) { ?>
  <div class="row">
    <div class="col-md-12">
      <a href="insert.php"  class="btn btn-primary mt-4">Crear tarea</a>
      <hr>
    </div>
  </div>

    <div class="col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $query = "SELECT * FROM task";
          try {
            $result_tasks = mysqli_query($conn, $query);   
            while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              <td>
                <a href="edit.php?id=<?php echo (int)$row['id']?>" class="btn btn-secondary">
                  <i class="fas fa-marker"></i>
                </a>
                <a href="delete_task.php?id=<?php echo (int)$row['id']?>" class="btn btn-danger">
                  <i class="far fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            <?php } 
            } catch (mysqli_sql_exception $e) {
            $_SESSION['message'] = 'Error fetching tasks: ' . $e->getMessage();
            $_SESSION['message_type'] = 'danger';
            $result_tasks = [];
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php } ?>
</main>

<?php include('includes/footer.php'); ?>
