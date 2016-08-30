<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="header-wrapper">
  <div id="header" class="container-logo">
  <div id="logo"> <img src="images/logowhitestroke.png" alt="" width= "225"/>
    <h1>&nbsp;</h1>
  </div>
  <div id="menu">
    <ul>
      <li ><a href="index.php" accesskey="1" title="">Homepage</a></li>
      <li class="current_page_item"><a href="aboutus.php" accesskey="3" title="">About Us</a></li>
      <li><a href="signup.php" accesskey="5" title="">Sign Up</a></li>
      <li><a href="signin.php" accesskey="7" title="">Sign In</a></li>
            <?php 
			session_start();
	  if (isset($_SESSION["user"])){?>
      <li><a href="member_page.php" accesskey="9" title="">Account</a></li>
	  <?php
}
?>


    </ul>
  </div>
</div>
<div id="wrapper">
<div id="page" class="container">
      <div id="content2">
        <div class="title">
          <h3><strong>Our Mission</strong></h3>
        </div>
        <p>Here at <strong> SiteShopper</strong>, we love the Internet. The opportunities, variety, and creativity evident on it and in it are overwhelming. We want anyone who desires, whether they be a business, a company, or a single person, to be able to have their little corner of it. That's why we created our search tools that give you the best service for the best price for your exact needs. This is our mission, to help bring as much of the world into the Net age as we can, and we believe we're more than capable of accomplishing it. Unlike our competitors, you are our top priority. We believe that every future site-owner is unique. Your  individual goals and interests can easily be fulfilled with our search-engines and design starter tools. And don't worry, your trust will not be abused. User privacy always comes first. </p>
      </div>
      <div class="image-logo">
      <img src="images/logo.png" alt="" width=1000"/> </div>
  </div>
</div>
<div id="copyright" class="container">
  <p>SiteShopper&copy; All rights reserved. | Photos by <a href="#">Fotogrph</a> | Design by <a href="#" rel="nofollow">TEMPLATED</a>.</p>
</div>
</body>
</html>
