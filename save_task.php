<?php

include('db.php');

if (isset($_POST['save_task'])) {
  if (!$conn) {
    $_SESSION['message'] = 'Database connection failed. Cannot save task.';
    $_SESSION['message_type'] = 'danger';
    header('Location: insert.php');
    exit();
  }

  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $query = "INSERT INTO task(title, description) VALUES ('$title', '$description')";
  try {
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Saved Successfully';
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');
    exit();
  } catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = 'Task Save Failed: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: insert.php');
    exit();
  }
}

?>
