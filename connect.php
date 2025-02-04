<?php
  $firstname = htmlspecialchars($_POST['firstname']);
  $password = htmlspecialchars($_POST['password']);
  
  // Establish database connection
  $conn = new mysqli('localhost', 'root', '', 'userlogin');
  
  if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
  } else {
    // Use prepared statements to validate login
    $stmt = $conn->prepare("SELECT password FROM registration WHERE firstname = ?");
    $stmt->bind_param("s", $firstname);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    
    if ($stmt->fetch()) {
      if (password_verify($password, $hashed_password)) {
        echo "Login successful";
      } else {
        echo "Invalid username or password";
      }
    } else {
      echo "Invalid username or password";
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
  }
?>

