<?php

//init db connection
define('DB_HOST','localhost');
define('DB_NAME','users');
define('DB_USER','root');
define('DB_PASSWORD','');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if ($conn ->connect_error){
  die('Cannot connect to database' . $conn->connect_error);
}


//get input values and set them to empty strings
$firstname = $lastname = $email ='';
$ferror = $lerror=$emerror='';

//check for form submission
if(isset($_POST['submit'])){
  if(empty($_POST['firstname'])){
    $ferror ='Firstname is required!';
  }else{
    $firstname = filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

  if(empty($_POST['lastname'])){
    $lerror ='Lastname is required!';
  }else{
    $lastname = filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

  if(empty($_POST['email'])){
    $emerror ='Email is required!';
  }else{
    $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
  }

  if(empty($ferror) && empty($lerror) && empty($emerror)){
    $sql = "INSERT INTO employees (firstname,lastname,email) VALUES('$firstname','$lastname','$email')";
    if(mysqli_query($conn,$sql)){
      header('Location: index.php');
    }
  }
}
?>

<?php 
$sql = 'SELECT * FROM employees';
$response = mysqli_query($conn,$sql);
$employees = mysqli_fetch_all($response,MYSQLI_ASSOC)

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Tracker</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="container">
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
    <div>
      <label for="firstname">Firstname:</label>
      <p>
        <input type="text" name="firstname">
      </p>
  <p style="color: red;font-size:12px"><?php echo  $ferror; ?></p>
</div>
    <div>
      <label for="lastname">Lastname:</label>
      <p>
        <input type="text" name="lastname">
      </p>
  <p style="color: red;font-size:12px"><?php echo $lerror;?></p>

    </div>
    <div>
      <label for="email">Email:</label>
      <p>
        <input type="email" name="email">
      </p>
  <p style="color: red;font-size:12px"><?php echo $emerror;?></p>

    </div>
    <div class="add">
      <input type="submit" name="submit" value="Add Employee" >
    </div>
  </form>
    <table>      
      <caption>Employees List</caption>
      <thead>
        <tr>
          <th>id</th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($employees as $employee):?>
        <tr>
          <td><?php echo $employee['id']?></td>
          <td><?php echo $employee['firstname']?></td>
          <td><?php echo $employee['lastname']?></td>
          <td><?php echo $employee['email']?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</body>
</html>