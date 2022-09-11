 <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Message Board</h4>
    </div>

    <div class="col-sm-9">
      <h4><small>Message Details</small></h4>
      <hr>
      <h2><?php echo $message['Messages']['title'];?></h2>
      <h5><i class="fa fa-clock-o" aria-hidden="true"></i> Posted by <?php echo $message['Users']['name'];?>, <?php echo date("F j, Y g:i a",strtotime($message['Messages']['posted']));?></h5>
      <h5><span class="badge badge-dark"><?php echo $message['Recipients']['name'];?></span></h5><br>
      <p><?php echo $message['Messages']['body'];?></p>
      <br><br>
      
      <h4 style="font-size: 18px;">Leave a Comment:</h4>
      <form role="form" id="commentForm">
        <input type="hidden" name="message_id" value="<?php echo $message['Messages']['id'];?>">
        <div class="form-group">
          <textarea class="form-control" rows="3" id="content" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
      </form>
      <br><br>

      <div id="comments"></div>
       <button class="btn btn-dark" id="btnShowMore2">Show More</button>
      
      <!-- <div class="row">
        <div class="col-sm-2 text-center">
          <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar">
        </div>
        <div class="col-sm-10">
          <h4>Anja <small>Sep 29, 2015, 9:12 PM</small></h4>
          <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <br>
        </div>
      </div> -->
       <!--  <div class="col-sm-2 text-center">
          <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
        </div>
        <div class="col-sm-10">
          <h4>John Row <small>Sep 25, 2015, 8:25 PM</small></h4>
          <p>I am so happy for you man! Finally. I am looking forward to read about your trendy life. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
         <!--  <br>
          <p><span class="badge">1</span> Comment:</p><br>
          <div class="row">
            <div class="col-sm-2 text-center">
              <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
            </div>
            <div class="col-xs-10">
              <h4>Nested Bro <small>Sep 25, 2015, 8:28 PM</small></h4>
              <p>Me too! WOW!</p>
              <br>
            </div>
          </div> -->
<!--         </div> -->
      <!-- </div> -->
    </div>
  </div>