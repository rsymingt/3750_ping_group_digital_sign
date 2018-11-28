<?php
  include("slide.class.php");
  class Presentation
  {

    private $_conn;
    private $_id;
    private $_pres_id;

    private $_slide;
    private $_num_slides;

    public function __construct($pres_id)
    {
      $this->_conn = NULL;
      $this->_num_slides = 0;
      $this->_slide = array();

      $this->_pres_id = $pres_id;

      $this->_conn = new mysqli($host, $user, $pass, $db);
      if($this->_conn->connect_errno)
      {
        die('Could not connect: ' . $this->_conn->connect_error);
      }

      // $sql = "SELECT * FROM presentation WHERE pres_id=$pres_id";
      // if($result = $this->_conn->query($sql))
      // {
      //   while($obj = $result->fetch_object())
      //   {
      //
      //   }
      //   $result->close();
      // }
    }

    public function __destruct()
    {
      if($this->_conn)
        $this->_conn->close();
    }

    public function pull_slides()
    {
      $sql = "SELECT * FROM presentation_slide NATURAL JOIN slide WHERE pres_id={$this->_pres_id} ORDER BY order_number";
      if($result = $this->_conn->query($sql))
      {
        while($obj = $result->fetch_assoc())
        {
          $this->_slide[] = new Slide($obj['slide_id']);
          $this->_num_slides += 1;
        }

        $result->close();
      }
    }

    public function generate_slide_select()
    {
      for($i = 0; $i < $this->_num_slides; $i ++)
      {
        $slide = $this->_slide[$i];
        ?>
          <div class="card slide-info <?php if($i == 0) echo "active"; ?>"
            data-id="<?php echo $slide->_data['slide_id']; ?>" onclick="load(this, <?php echo $slide->_data['slide_id']; ?>);">
            <iframe src="ajax-slide?action=get&id=<?php echo $slide->_data['slide_id']; ?>&main=false">
            </iframe>
            <div class="hover-center">
              <h6><?php echo $slide->_data["slide_name"]; ?></h6>
            </div>
          </div>
        <?php
      }
    }

    public function generate_slide($order, $main)
    {
      $slide = $this->_slide[$order];

      $slide->generate($main);
    }

  }

?>
