<?php
session_start();

try {
  $conn = mysqli_connect(
    'localhost',
    'crudUser',
    'malaga2526',
    'php_mysql_crud'
  );
} catch (mysqli_sql_exception $e) {
  $_SESSION['db_error'] = $e->getMessage();
  $conn = false;
}
