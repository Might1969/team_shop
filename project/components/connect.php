<?php

   $db_name = 'mysql:host=localhost;dbname=team_shop';
   $db_user_name = 'root';
   $db_user_pass = '';

   $conn = new PDO($db_name, $db_user_name, $db_user_pass);
   //$conn = connect();
   function create_unique_id(){
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 20; $i++) {
          $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  class Dbh{
      protected function connect(){
          try{
              $db_name = 'mysql:host=localhost;dbname=team_shop';
              $db_user_name = 'root';
              $db_user_pass = '';
              $dbh = new PDO($db_name, $db_user_name, $db_user_pass);
              return $dbh;
          }
          catch (PDOException $e){
              print "Error!: " . $e->getMessage() . "<br/>";
              die();
          }
      }
  }
  
?>