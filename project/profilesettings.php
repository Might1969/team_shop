<?php

session_start();
include_once 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>


<?php
    include_once "components/header.php";

    //include "classes/dbh.classes.php";
    include "classes/profileinfo.classes.php";
    include "classes/profileinfo-view.classes.php";
    $profileInfo = new ProfileInfoView();
?>

<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-settings">
              <h3>PROFILE SETTINGS</h3>
              <p>Change your about section here!</p>
              <form action="includes/profileinfo.inc.php" method="post">
                  <textarea name="about" rows="10" cols="30" placeholder="Profile about section..." value=""><?php $profileInfo->fetchAbout($_SESSION["id"]); ?></textarea>
                  <br><br>
                  <p>Change your profile page intro here!</p>
                  <br>
                  <input type="text" name="introtitle" placeholder="Profile title..." value="<?php $profileInfo->fetchTitle($_SESSION["id"]); ?>">
                  <textarea name="introtext" rows="10" cols="30" placeholder="Profile introduction..."><?php $profileInfo->fetchText($_SESSION["id"]); ?></textarea>
                  <button type="submit" name="submit">SAVE</button>
              </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* 个人资料设置页面样式 */
.profile-settings {
    background: var(--white);
    padding: 3rem;
    border-radius: .5rem;
    box-shadow: var(--box-shodow);
    max-width: 800px;
    margin: 0 auto;
}

.profile-settings h3 {
    font-size: 2.4rem;
    color: var(--main-color);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--orange);
    padding-bottom: 1rem;
}

.profile-settings p {
    font-size: 1.6rem;
    color: var(--light-color);
    margin-bottom: 2rem;
}

.profile-settings form {
    display: grid;
    gap: 2rem;
}

.profile-settings textarea,
.profile-settings input[type="text"] {
    width: 100%;
    padding: 1.2rem;
    border: var(--border);
    border-radius: .5rem;
    background: var(--light-bg);
    font-size: 1.6rem;
    resize: vertical;
}

.profile-settings textarea:focus,
.profile-settings input[type="text"]:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(255,153,0,0.1);
}

.profile-settings button[type="submit"] {
    background: var(--orange);
    color: var(--white);
    padding: 1.2rem 3rem;
    border-radius: .5rem;
    font-size: 1.6rem;
    cursor: pointer;
    transition: background .3s;
    justify-self: start;
}

.profile-settings button[type="submit"]:hover {
    background: #e77600;
}

/* 响应式调整 */
@media (max-width: 768px) {
    .profile-settings {
        padding: 2rem;
    }
    
    .profile-settings h3 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .profile-settings {
        padding: 1.5rem;
    }
    
    .profile-settings form {
        gap: 1.5rem;
    }
    
    .profile-settings textarea {
        rows: 8;
    }
}
</style>
    
</body>
</html>