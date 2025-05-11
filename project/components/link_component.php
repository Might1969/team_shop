<?php
   session_start(); 
include 'components/connect.php';

if(isset($_SESSION['id'])){
   $user_id = $_SESSION['id'];
}else{

}
?>