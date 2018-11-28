<?php
  // echo "<h1> test </h1>";
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include("classes/presentation.class.php");

  if($argc > 1)
  {
    $slide = new Slide($argv[1]);
  }
  else
  {
    die("NOPE");
  }
?>

<!DOCTYPE HTML>
<html>

  <head>

    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/mdb.css">
    <link rel="stylesheet" href="/css/jquery-confirm.css">
    <!-- <link rel="stylesheet" href="/css/jquery-ui.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">

    <style>

      #upload-btn
      {
        position: absolute;
        top:50%;
        left:50%;

        transform: translate(-50%, -50%);
      }

      #slide
      {
        position:relative;
      }

    </style>

  </head>

  <body>

    <div id="main">
      <div class="main-upper">
        <h1 class="text-center"><?php echo $slide->_data['slide_name']; ?></h1>

        <div class="main fluid-container">

          <div class="fluid-container">

            <div id="slide-wrapper">
              <div id="slide" data-id="<?php echo $slide->_data['slide_id']; ?>">
                  <?php
                    $slide->generate("false");
                  ?>
                  <button id="upload-btn" class="btn btn-primary" onclick="upload();">
                    Upload
                  </button>
              </div>
            </div>

            <div id="sidebar">
              <h2 class="text-center">Slide Defaults</h2>
              <hr>

              <form>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="background">Background</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <select id="background" disabled class="browser-default custom-select">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="audio">Audio</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <select disabled id="audio" disabled class="browser-default custom-select">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="duration">Duration</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <input type="text" id="duration" class="form-control" placeholder="(secs)">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="timing-input">Aspect Ratio</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <select class="browser-default custom-select">
                        <option value="1">16:9</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- <h2 class="text-center">Slide Defaults</h2>
                <hr> -->

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="countdown">
                  <label class="custom-control-label font-weight-normal" for="countdown">Countdown</label>
                </div>

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="timeline">
                  <label class="custom-control-label font-weight-normal" for="timeline">Timeline</label>
                </div>

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="digital-clock">
                  <label class="custom-control-label font-weight-normal" for="digital-clock">Digital Clock</label>
                </div>

              </form>

            </div>

          </div>
        </div>
      </div>
    </div>

    <script src="/js/popper.min.js"></script>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/mdb.js"></script>
    <!-- <script src="/js/jquery-ui.js"></script> -->
    <script src="/js/jquery-confirm.js"></script>

    <script type="text/javascript">

      var timer = Number($("#timer").text());
      var $window = $(window);
      var finish = true;
      var __ideal = "720";
      var $slide = $("#slide");
      var $slideWrapper = $("#slide-wrapper");
      var slide_id = $("#slide").data("id");

      function upload()
      {
        alert(slide_id);
      }

      function resize(){
        $("body").css("maxHeight", $window.height())
          .css("height", $window.height());
        $("#main").addClass("active");
      }

      $(function(){

        $window.on("resize", resize);

        $window.trigger("resize");

      });

    </script>
  </body>

</html>
