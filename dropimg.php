<?php
  if (!file_exists('image')) {
      mkdir('image', 0775, true);
  }
  $upload_dir = 'image/';
  $img = $_POST['img'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = $upload_dir.mktime().'.png';
  $success = file_put_contents($file, $data);
  echo $success ? $file : 'Unable to save the file.';

  include_once 'db.php';
  try {
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $db->prepare("INSERT INTO gallery (login, img) VALUES (:login, :file)");
      $stmt->bindParam(':login', $_POST[user], PDO::PARAM_STR);
      $stmt->bindParam(':file', $file, PDO::PARAM_STR);
      $stmt->execute();
  } catch (PDOException $e) {
      echo 'Error: '.$e->getMessage();
      exit;
  }
