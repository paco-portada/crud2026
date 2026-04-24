<?php

include("db.php");

if(isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  // Si no se ha confirmado la eliminación, mostramos un cuadro de diálogo (UI)
  if (!isset($_GET['confirm'])) {
    include('includes/header.php'); ?>
    <div class="container p-4">
      <div class="row">
        <div class="col-md-4 mx-auto">
          <div class="card card-body text-center">
            <h5 class="mb-4">¿Estás seguro de que deseas eliminar esta tarea?</h5>
            <div class="d-flex justify-content-around">
              <a href="delete_task.php?id=<?php echo $id; ?>&confirm=1" class="btn btn-danger">Sí, eliminar</a>
              <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('includes/footer.php');
    exit();
  }

  $query = "DELETE FROM task WHERE id = $id";
    try {
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Deleted Successfully';
    $_SESSION['message_type'] = 'success';
  } catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = 'Task Delete Failed: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
  }
  header('Location: index.php');
}

?>
