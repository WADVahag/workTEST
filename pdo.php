<?php

class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=testwork', 'root', 'root');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }


    public function getUser($user){
        $l = strval($user['login']); 
        $p = strval($user['password']); 


        $statement = $this->pdo->prepare("SELECT * FROM users WHERE login = '$l' AND password = '$p' ");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($user)
    {
   
          $n =strval($user['name']); 
          $e = strval($user['email']); 
          $l = strval($user['login']); 
          $p = strval($user['password']); 

        $statement = $this->pdo->prepare("INSERT INTO users (name,email,login,password) VALUES ( '$n' , '$e' , '$l' , '$p' )");
        
        return $statement->execute();

    }

    public function updateUser($id, $user)
    {

        $n =strval( $user['name']); 
        $e = strval($user['email']); 
        $l = strval($user['login']); 
        $p = strval($user['password']); 

        $statement = $this->pdo->prepare("UPDATE users SET name = '$n', email = '$e' , login = '$l' password = '$p'  WHERE id = $id");

        return $statement->execute();
    }

    public function getDuplicateEmails(){

        $statement = $this->pdo->prepare("SELECT email FROM users  GROUP BY email HAVING COUNT(email) > 1 ");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    
    }


    public function getUsersWirhoutOrders(){

        $statement = $this->pdo->prepare("SELECT login FROM users,orders WHERE users.id <> orders.user_id ");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    
    }

    public function getUsersWIthOrdersMoreThan($number){
 
        // $statement = $this->pdo->prepare("SELECT login FROM users,orders WHERE users.id  = SELECT user_id FROM orders  GROUP BY user_id HAVING COUNT(user_id) > $number ");
        $statement = $this->pdo->prepare("SELECT users.login FROM users INNER JOIN orders ON users.id = orders.user_id HAVING COUNT(orders.user_id) > $number");

        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    
    }
    
}

return new Connection();
