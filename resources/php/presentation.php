<?php
  // echo "<h1> test </h1>";
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include("classes/presentation.class.php");

  if($argc > 1)
  {
    $presentation = new Presentation($argv[1]);
    $presentation->pull_slides();
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

  </head>

  <body>

    <div id="main">
      <div class="main-upper">
        <h1 class="text-center">Presentation Edit (DEMO)</h1>

        <div class="main fluid-container">

          <div class="fluid-container">
            <div id="slide-select" class="text-center">
              <i class="fa fa-arrow-up">
              </i>
              <?php
                $presentation->generate_slide_select();
              ?>
              <i class="fa fa-arrow-down"></i>
            </div>

            <div id="slide-wrapper">
              <!-- <div id="slide" class="card"> -->
                <!-- <div class="row">
                  <div class="col-sm text-center">
                    <button class="btn btn-primary">Upload</button>
                  </div>
                </div> -->
              <div id="slide">
                  <?php
                    $presentation->generate_slide(0, "true");
                  ?>
              </div>
            </div>

            <div id="sidebar">
              <h2 class="text-center">Options</h2>

              <hr>

              <form>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="position">Position</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <select id="position" class="browser-default custom-select">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                  </div>
                </div>

                <h2 class="text-center">Slide Overrides</h2>
                <hr>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="duration">Duration</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <input type="text" id="duration" class="form-control" placeholder="(secs)">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-4 col-form-label font-weight-normal" for="aspect">Aspect Ratio</label>
                  <div class="col-lg-8">
                    <div class="md-form mt-0">
                      <select id="aspect" class="browser-default custom-select">
                        <option value="1">16:9</option>
                      </select>
                    </div>
                  </div>
                </div>

                <h2 class="text-center">Presentation Options/Overrides</h2>
                <hr>

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

        <div id="preview" onclick="loadPreview();">
          <h1 id="timer">3</h1>
          <!-- SLIDE PREVIEW GENERATE -->
        </div>
      </div>

      <div id="preview-btn" class="fluid-container text-right">
        <button class="btn btn-primary" onclick="showPreview();">Preview</button>
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

      var timing_interval;

      function load(el, id)
      {
        var $id = $("#slide-id").data("id");
        if(parseInt($id) == id)
          return;
        $.ajax({
          url: "/ajax-slide",
          type: "get",
          data:
          {
              action: "get",
              id: id,
              main: "true"
          },
          error:function(err)
          {
            console.log(err);
          },
          success:function(data)
          {
            $slide.fadeOut(function(){
              $slide.html(data).fadeIn();
            });
          }
        });
      }

      function showPreview()
      {
        var $preview = $("#preview");

        $preview.addClass("active");

        timing_interval = setInterval(function(){
          var $timer = $("#timer");
          var time = Number($timer.text());
          var newTime = (time-1).toString();

          if(newTime == 0)
          {
            $(".slide.active").trigger("next");
            newTime = timer;
            $timer.text(newTime);
            return;
          }

          $timer.text(newTime);
        }, 1000);
      }

      function closePreview()
      {
        $("#preview").removeClass("active").find(".slide").each(function(index){
          var $this = $(this);

          $this.removeClass("active last")

          $this.addClass((index==0)? "active" : "next");
        });

        $("#timer").text(timer);
      }

      function active(){
        var $this = $(this);
        var $next = $this.next();

        if(!$next.length || !finish)
        {
          clearInterval(timing_interval);
          closePreview();
          return;
        }

        finish = false;

        $next.on('transitionend webkitTransitionEnd oTransitionEnd', function(){
          finish = true;
        });

        $next.addClass("active");
        $this.addClass("last").removeClass("active");

        // setTimeout(function(){
        //   $next.trigger("next");
        // }, timer * 1000);
      }

      function resize(){
        $("iframe").each(function(){
          var $this = $(this);
          var ratio = $this.width()/__ideal;
          var percent = ratio*100;

          $this.on("load", function(){
            $this.contents().find("body").css({
              overflow: "hidden",
              margin: "0",
              padding: "0",
              height: "100%",
              display: "flex"
            });
            $this.contents().find("h1").css("font-size", percent+"%");

            $this.addClass("active");
          });
        });

        $("body").css("maxHeight", $window.height())
          .css("height", $window.height());
        $("#main").addClass("active");

      }

      $(function(){
        $("#timer").text(timer);
        $(".slide").on("next", active);

        $(".slide-thumb").each(function(){
          var $this = $(this);

          var slide = $this.data("target");

          // alert(slide);
        });

        // $(".slide-info iframe").each(function(){
        //   var $this = $(this);
        //   var id = $this.data("id");
        //
        //   if(id)
        //   {
        //
        //     $.ajax({
        //       url: "/ajax-slide",
        //       type: "get",
        //       data:
        //       {
        //         action: "get",
        //         id: id
        //       },
        //       error: function(err)
        //       {
        //         // $.alert(err);
        //         console.log(err);
        //       },
        //       success: function(data)
        //       {
        //         $this.contents().find('body').html(data);
        //       }
        //     });
        //
        //   }
        // });

        $window.on("resize", resize);

        $window.trigger("resize");

      });

    </script>
  </body>

</html>
