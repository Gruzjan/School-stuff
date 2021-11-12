<!DOCTYPE html>
<html lang="en" class="h-100">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <link rel="icon" type="image/svg" href="img/625.svg"/>

    <title>625 Words!</title>
</head>
<body class="d-flex flex-column h-100">

  <header>
  <!-- burger content -->
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">

          <div class="col-sm-8 col-md-7 py-4">
            <h4 class="text-white">About</h4>
            <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
          </div>

          <div class="col-sm-4 offset-md-1 py-4">
            <h4 class="text-white">Contact</h4>
            <ul class="list-unstyled">
              <li><i class="demo-icon icon-email text-white"> </i><a href="#" class="text-white">translate@words.com</a></li>
            </ul>
          </div>
          
        </div>
      </div>
    </div>

    <!-- Navbar -->
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">

      <!-- navbar content -->
      <ul class="nav justify-content-end">

        <!-- dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Language</a>
          <ul class="dropdown-menu dropdown-menu-dark popout" aria-labelledby="navbarDarkDropdownMenuLink">
            <!-- dropdown items -->
            <li><a class="dropdown-item" href="#"><img src="https://www.countryflags.io/gb/shiny/16.png"> English</a></li>
            <li><a class="dropdown-item" href="#"><img src="https://www.countryflags.io/pl/shiny/16.png"> Polish</a></li>
          </ul>
        </li><!-- /dropdown -->

        <li class="nav-item">
          <a class="nav-link" href="#">Log in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="siema" href="#">Register</a>
        </li>

      </ul><!-- /navbar conent -->


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>
  
  <main>

    <!-- jumbotron -->
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">625 Words!</h1>
          <p class="lead text-muted">Welcome fellow language enthusiast! If you're starting with learning a new language this site is perfect for you. You will learn here words for family members, animals, directions and many more, Enjoy!</p>
        </div>
      </div> 
    </section> <!-- /jumbotron -->

    <div class="py-5 bg-light">
      <div class="container">

        <div class="row row-cols-3 g-4">
          <div class="col">
            <div class="card shadow-lg">
              <img src="img/Germany.svg" class="card-img-top" alt="Flag of Germany">
            </div>
          </div>
          <div class="col">
            <div class="card shadow-lg">
              <img src="img/Spain.svg" class="card-img-top" alt="Flag of Spain">
            </div>
          </div>
          <div class="col">
            <div class="card shadow-lg">
              <img src="img/France.svg" class="card-img-top" alt="Flag of France">
            </div>
          </div>
        </div>

      </div>
    </div> 

  </main>

  <footer class="footer mt-auto py-3 bg-dark">
    <div class="container">
      <span class="text-muted"><i class="demo-icon icon-email"> </i>translate@words.com</span>
    </div>
  </footer>

</body>
</html>