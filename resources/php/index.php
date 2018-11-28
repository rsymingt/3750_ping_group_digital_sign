<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Digital Sign</title>
  <meta name="description" content="Digital Signage System">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="/css/bootstrap.css">
  <link rel="stylesheet" href="/css/mdb.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <style>

    #main-content > *{
      opacity: 0;
    }

    #main-content > .active{
      opacity: 1;
    }

  </style>

</head>

<body>

  <!--Navbar-->
  <nav class="navbar navbar-expand-md navbar-dark primary-color">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">Navbar</a>
    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
      aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="main-nav">
      <!-- Links -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#" onclick="load(this, 'displays')">Displays
            <span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" onclick="load(this, 'presentations')">Presentations</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" onclick="load(this, 'slides')">Slides</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#" onclick="load(this, 'user-management')">User Management</a>
        </li>
      </ul>
    </div>
    <!-- Collapsible content -->
  </nav>
  <!--/.Navbar-->

  <div id="main-content" class="container text-center">
    <?php
      include("resources/php/pages.php");
    ?>
  </div>

  <script src="/js/popper.min.js"></script>
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/js/bootstrap.js"></script>
  <script src="/js/mdb.js"></script>

  <script>

    var $main = $("#main-content");
    var animating = false;

    function load(el, page)
    {
      if(animating) return;

      var $load = $main.find("#"+page);

      if(!$load.length)
        return;

      var $this = $(el);

      $("#main-nav .nav-item.active").removeClass("active");
      $this.parent().addClass("active");

      animating = true;

      $main.find(".active").fadeOut(function(){
        $(this).removeClass("active");
        $load.addClass("active");
        $load.fadeIn(function(){
          animating = false;
        });
      });
    }

    $(function(){
      $("#main-content > *:not(.active)").hide();
    });
  </script>

</body>
</html>
