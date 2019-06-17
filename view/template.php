<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $pageDescription ?>">
    <meta name="author" content="William Gathoye">
    <title><?php echo $pageTitle ?></title>

    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOT_WEB ?>/public/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOT_WEB ?>/public/css/styles.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ROOT_WEB ?>/public/css/all.min.css" />

    <script type="text/javascript" src="<?php echo ROOT_WEB ?>/public/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_WEB ?>/public/js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_WEB ?>/public/js/scripts.js"></script>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <a class="my-0 mr-md-auto font-weight-normal home" href="<?php ROOT_WEB ?> /index.php"><h5 class="my-0">Quiz<span>Up</span><i class="fas fa-rocket"></i></h5></a>
        <nav class="my-2 my-md-0 mr-md-3">
          <a class="p-2 text-dark" href="#">Features</a>
          <a class="p-2 text-dark" href="#">Enterprise</a>
          <a class="p-2 text-dark" href="#">Support</a>
          <a class="p-2 text-dark" href="#">Pricing</a>
        </nav>
        <a class="btn btn-outline-primary" href="<?php echo ROOT_CGI . "/index.php?action=register" ?>">Sign up</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">QuizUp</h1>
      <p class="lead">Your quizzes made simple.</p>
    </div>

    <div class="container">

      <?php echo $pageContent ?>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">&copy; <?php echo date('Y') . " William Gathoye" ?></small>
          </div>
          <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Cool stuff</a></li>
              <li><a class="text-muted" href="#">Random feature</a></li>
              <li><a class="text-muted" href="#">Team feature</a></li>
              <li><a class="text-muted" href="#">Stuff for developers</a></li>
              <li><a class="text-muted" href="#">Another one</a></li>
              <li><a class="text-muted" href="#">Last time</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Resource</a></li>
              <li><a class="text-muted" href="#">Resource name</a></li>
              <li><a class="text-muted" href="#">Another resource</a></li>
              <li><a class="text-muted" href="#">Final resource</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Team</a></li>
              <li><a class="text-muted" href="#">Locations</a></li>
              <li><a class="text-muted" href="#">Privacy</a></li>
              <li><a class="text-muted" href="#">Terms</a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>

