<?php
    include "components/header.php";

    // include "classes/dbh.classes.php";
    include "classes/profileinfo.classes.php";
    include "classes/profileinfo-view.classes.php";
    $profileInfo = new ProfileInfoView();
?>

<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-info">
              <div class="profile-info-img">
                <p>
                  <?php
                      echo $_SESSION["uid"];
                  ?>
                </p>
                <div class="break"></div>
                <a href="profilesettings.php" class="follow-btn">PROFILE SETTINGS</a>
              </div>
              <div class="profile-info-about">
                <h3>ABOUT</h3>
                <p>
                  <?php
                    $profileInfo->fetchAbout($_SESSION["id"]);
                  ?>
                </p>
                <h3>FOLLOWERS</h3>
                <h3>FOLLOWING</h3>
              </div>
            </div>
            <div class="profile-content">
              <div class="profile-intro">
                <h3>
                  <?php
                      $profileInfo->fetchTitle($_SESSION["id"]);
                  ?>
                </h3>
                <p>
                  <?php
                      $profileInfo->fetchText($_SESSION["id"]);
                  ?>
                </p>
              </div>
              <div class="profile-posts">
                <h3>POSTS</h3>
                <div class="profile-post">
                  <h2>IT IS A BUSY DAY IN TOWN</h2>
                  <p>Sed porttitor nulla quis lectus gravida rutrum. Fusce dapibus odio id nibh tincidunt finibus. Praesent in massa at urna feugiat iaculis. Vivamus dictum ante in eleifend semper. Cras nec maximus ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam diam ligula, semper sed semper posuere.</p>
                  <p>12:46 - 09/11/2021</p>
                </div>
                <div class="profile-post">
                  <h2>RE-USING ELECTRONICS IS A GOOD IDEA</h2>
                  <p>Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut lacinia ligula eget gravida fermentum. Curabitur arcu risus, ornare eu nibh a, porta interdum nunc. Mauris gravida velit dui, eu ultrices lacus finibus sit amet.</p>
                  <p>16:11 - 11/11/2021</p>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

<style>

/* profile页面专用样式 */
.profile-bg {
    background-color: var(--light-bg);
    padding: 4rem 0;
}

.profile-info {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 3rem;
    margin-bottom: 4rem;
    background: var(--white);
    padding: 3rem;
    border-radius: .5rem;
    box-shadow: var(--box-shodow);
}

.profile-info-img {
    text-align: center;
    border-right: var(--border);
    padding-right: 3rem;
}

.profile-info-img p {
    font-size: 2.4rem;
    color: var(--black);
    margin-bottom: 1.5rem;
    text-transform: capitalize;
}

.break {
    height: 1px;
    background-color: var(--light-bg);
    margin: 2rem 0;
}

.follow-btn {
    display: inline-block;
    padding: 1rem 2.5rem;
    background-color: var(--orange);
    color: var(--white);
    border-radius: .5rem;
    font-size: 1.6rem;
    transition: background .3s;
}

.follow-btn:hover {
    background-color: #e77600;
}

.profile-info-about h3 {
    font-size: 2rem;
    color: var(--black);
    margin-bottom: 1.5rem;
}

.profile-info-about p {
    font-size: 1.6rem;
    color: var(--light-color);
    line-height: 1.6;
    margin-bottom: 2rem;
}

.profile-info-about h3:last-of-type {
    margin-top: 2rem;
}

.profile-content {
    background: var(--white);
    padding: 3rem;
    border-radius: .5rem;
    box-shadow: var(--box-shodow);
}

.profile-intro h3 {
    font-size: 2.4rem;
    color: var(--main-color);
    margin-bottom: 1.5rem;
}

.profile-intro p {
    font-size: 1.6rem;
    color: var(--light-color);
    line-height: 1.8;
    margin-bottom: 3rem;
}

.profile-posts h3 {
    font-size: 2rem;
    color: var(--black);
    border-bottom: var(--border);
    padding-bottom: 1.5rem;
    margin-bottom: 2rem;
}

.profile-post {
    padding: 2rem;
    border: var(--border);
    border-radius: .5rem;
    margin-bottom: 2rem;
    background: var(--light-bg);
}

.profile-post h2 {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: 1rem;
}

.profile-post p {
    font-size: 1.5rem;
    color: var(--light-color);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.profile-post p:last-child {
    font-size: 1.4rem;
    color: #666;
}

/* 响应式设计 */
@media (max-width: 768px) {
    .profile-info {
        grid-template-columns: 1fr;
        padding: 2rem;
    }
    
    .profile-info-img {
        border-right: none;
        padding-right: 0;
        border-bottom: var(--border);
        padding-bottom: 2rem;
    }
    
    .profile-content {
        padding: 2rem;
    }
}

@media (max-width: 450px) {
    .profile-info {
        padding: 1.5rem;
    }
    
    .profile-info-img p {
        font-size: 2rem;
    }
    
    .profile-intro h3 {
        font-size: 2rem;
    }
    
    .profile-post {
        padding: 1.5rem;
    }
}

</style>
    
</body>
</html>