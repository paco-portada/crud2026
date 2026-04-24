<?php

include('db.php');

if (isset($_POST['save_task'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $query = "INSERT INTO task(title, description) VALUES ('$title', '$description')";
  try {
    mysqli_query($conn, $query);
    $_SESSION['message'] = 'Task Saved Successfully';
    $_SESSION['message_type'] = 'success';
    header('Location: index.php');
  } catch (mysqli_sql_exception $e) {
    $_SESSION['message'] = 'Task Save Failed: ' . $e->getMessage();
    $_SESSION['message_type'] = 'danger';
    header('Location: insert.php');
  }
}

?>
