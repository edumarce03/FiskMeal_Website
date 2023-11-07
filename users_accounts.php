<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `user` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Usuarios</title>
   <link rel="shortcut icon" href="images/logoWebFiskMeal.ico" type="image/x-icon">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom admin style link  -->
   <link rel="stylesheet" href="css/estilos_admin.css">

</head>
<body>

<?php include 'admin_header.php' ?>

<section class="accounts">

   <h1 class="heading">Cuentas de Usuario</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `user`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> ID : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Usuario : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> Correo : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">¡No hay cuentas disponibles!</p>';
      }
   ?>

   </div>

</section>



<script src="js/admin_script.js"></script>

</body>
</html>