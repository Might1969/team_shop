<?php
  include_once 'header.php';
?>

<section class="index-intro">
  <?php 
  if (isset($_SESSION["useruid"])){
      echo"<p>Hello there " . $_SESSION["useruid"]. "</p>";
  }?>
  <h1>This Is DC228428 Zhang JiaQi</h1>
  <p>This is a page for login/signup system</p>
</section>

<section class="index-categories">
  <h2>Basic Categories</h2>
  <div class="index-categories-list">
    <div>
      <h3>Fun Stuff</h3>
    </div>
    <div>
      <h3>Serious Stuff</h3>
    </div>
    <div>
      <h3>Exciting Stuff</h3>
    </div>
    <div>
      <h3>Boring Stuff</h3>
    </div>
  </div>
</section>

<?php
  include_once 'footer.php';
?>
