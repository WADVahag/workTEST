<?php 

// setting up connection with PDO
$connection = require_once 'pdo.php';

 if(!empty($_POST) && $_POST['role']=='login'){


  $user['login'] = $_POST['login'];
  $user['password'] = $_POST['password'];
   
  $loggedUser = $connection->getUser($user);

 }
 
 elseif(!empty($_POST) && $_POST['role']=='register'){

  $newUser['name'] = $_POST['userName'];
  $newUser['email'] = $_POST['email'];
  $newUser['login'] = $_POST['login'];
  $newUser['password'] = $_POST['password'];
  
  $connection->addUser($newUser);
  echo 'user is successfully created! try to login )';
 
}

elseif(!empty($_POST) && $_POST['role']=='changeUserData'){

  $newUser['id'] = $_POST['userId'];
  $newUser['name'] = $_POST['userName'];
  $newUser['email'] = $_POST['email'];
  $newUser['login'] = $_POST['login'];
  $newUser['password'] = $_POST['password'];
  
  $connection->addUser($newUser);
  echo 'user is successfully created! )';
 
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<style>
 input{
   display:block;
   width:12%;
   height:4.5%;
   font-size: 1vw;
   margin:3vw 2vw;

 }

 button{
   display:block;
   width:12%;
   height:4.5%;
   font-size: 1vw;
   margin:3vw 2vw;

 }
</style>

<?php if (empty($loggedUser)):?>

  <form action="#" method='post'>

    <input type='hidden' name='role'  value ='login'>
    <input type="text" name='login' placeholder = 'login' required>
    <input type="text" name='password' placeholder = 'password' required>
    <button> Log in </button>
  
  </form>
  
  <form action="#" method='post'>
  
    <input type="hidden" name = 'role' value='register'>
    <input type="text" name='userName' placeholder = 'name' required>
    <input type="text" name='login' placeholder = 'login' required>
    <input type="text" name='password' placeholder = 'password' required>
    <input type="text" name='email'  placeholder = 'email' required>
    <button> Register</button>
  
  </form>

<?php else:?>

  <h1> CHange User Data </h1>
<form action="#" method='post'>
  
  <input type="hidden" name = 'role' value='changeUserData'>
  <input type="hidden" name = 'userId' value='<?=$loggedUser['id']?>'>

  <input type="text" value='<?=$loggedUser['name']?>' name='userName' required>
  <input type="text" value='<?=$loggedUser['login']?>' name='login' required>
  <input type="text" value='<?=$loggedUser['password']?>' name='password' required>
  <input type="text" value='<?=$loggedUser['email']?>' name='email' required>
  
  <button> changeUserData</button>

</form>

  <h1> Querys Answers </h1>

<h2> Duplicate Emails </h2>
 
  <?php $duplicateEmails = $connection->getDuplicateEmails();

    echo '<ul>';
      // var_dump($duplicateEmails);
      if(empty($duplicateEmails)){
        echo 'there is no duplicate emails';
      }else{
        foreach($duplicateEmails as $emailU){
          echo '<li><h3>'.$emailU.'</h3></li>';
        };
      }
    echo '</ul>';
  
  ?>

<h2> UserNames without orders </h2>
 
  <?php $usersWithoutOrder = $connection->getUsersWirhoutOrders();

    echo '<ul>';
      // var_dump($usersWithoutOrder);
      if(empty($usersWithoutOrder)){
        echo 'no users without Orders';
      }else{
        foreach($usersWithoutOrder as $nameUSer){
          echo '<li><h3>'.$nameUSer.'</h3></li>';
        };
      }
    echo '</ul>';
  
  ?>
  <h2> UserNames with orders more than two </h2>
 
 <?php $usersWithOrders= $connection->getUsersWIthOrdersMoreThan(2);

   echo '<ul>';
    //  var_dump($usersWithOrders);
     if(empty($usersWithOrders)){
       echo ' NO such USers founds';
     }else{
      foreach($usersWithOrders as $name){
        echo '<li><h3>'.$name.'</h3></li>';
      };

     }
   echo '</ul>';
 
     

 ?>


<?php endif?>

</body>
</html>