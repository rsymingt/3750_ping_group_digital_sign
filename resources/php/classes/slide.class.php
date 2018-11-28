<?php

  class Slide
  {
    private $conn;

    private $_slide_id;

    public $_data;

    public function __construct($slide_id)
    {
      $this->_slide_id = $slide_id;

      $this->_conn = new mysqli($host, $user, $pass, $db);
      if($this->_conn->connect_errno)
      {
        die('Could not connect: ' . $this->_conn->connect_error);
      }

      $sql = "SELECT * FROM slide WHERE slide_id=$slide_id";
      if($result = $this->_conn->query($sql))
      {
        if($row = $result->fetch_assoc())
        {
          $this->_data = $row;
        }

        $result->close();
      }
    }

    public function __destruct()
    {
      if($this->_conn) $this->_conn->close();
    }

    public function generate($main)
    {
      if($main === "true"):?>
        <div id="slide-id" data-id="<?php echo $this->_data['slide_id']; ?>" style="display:none;"></div>
        <h2 class="inner-slide-title text-center">
          <?php echo $this->_data['slide_name']; ?>
          <a href="/slide?id=<?php echo $this->_data['slide_id']; ?>"><i class="fa fa-edit"></i></a>
        </h2>
        <div class="inner-slide">
          <img class="card slide-img" src="<?php echo $this->_data['img']; ?>"
          style ="height:auto; max-width:100%; width:auto; max-height:100vh; margin:auto;">
        </div>
      <?php else: ?>
        <img class="card slide-img" src="<?php echo $this->_data['img']; ?>"
        style ="height:auto; max-width:100%; width:auto; max-height:100vh; margin:auto;">
      <?php endif;
    }

  }

?>
