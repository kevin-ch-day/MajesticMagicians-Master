<?php
  require '../../includes/sessionsconfig.inc.php';
  require '../../includes/dbh.inc.php';
  require '../../includes/functions.inc.php';
  if(!$loggedIn){
    header("Location: ../../loginpage.php");
  }

  //Get the microscope name and query the database for microscope information
  $microscopeName = getMyMicroscopeName(dirname(__FILE__));
  $sql = "SELECT experiment_name, course_name, availability, youtube, description, state FROM microscopes WHERE microscope_name = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "s", $microscopeName);
  mysqli_stmt_execute($stmt);
  if(mysqli_stmt_bind_result($stmt, $col1, $col2, $col3, $col4, $col5, $col6)){
          mysqli_stmt_fetch($stmt);
          $experimentName = $col1; //Define the experiment name
          $className = $col2; // Define the course name
          $availability = $col3; // Define the availability
          $youtube = $col4; // Define the youtube link
          $description = $col5; // Define the description
          $state = $col6; // Get the state
          
          // Close the statement
          mysqli_stmt_close($stmt);
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  
  // Close connection
  mysqli_close($conn);

  if($userType !='admin' && $state != "active"){
    header("Location: ../../microscopeunavailable.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>VirtualScope</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../styles/streampage-style.css">
  <link rel="stylesheet" href="../../styles/navbar-style.css">
  <script>
  
async function moveMotor(){
	    $.ajax({
        url: "http://localhost/includes/jsontoserver.inc.php",
        type: "GET",
        data: { zoomDirection: true, zoomHowMuch: 100 },
        dataType: "json",
		//contentType: "application/json; charset=utf-8",
        success: function (result) {
            switch (result) {
                case true:
                    processResponse(result);
                    break;
                default:
                    resultDiv.html(result);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        //alert(xhr.status);
        //alert(thrownError);
        }
    });
}

async function light(bool_arg){
	    $.ajax({
        url: "http://localhost/includes/jsontoserver.inc.php",
        type: "GET",
        data: { setLightValue: bool_arg, light: "0" },
        dataType: "json",
		//contentType: "application/json; charset=utf-8",
        success: function (result) {
            switch (result) {
                case true:
                    processResponse(result);
                    break;
                default:
                    resultDiv.html(result);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        //alert(xhr.status);
        //alert(thrownError);
        }
    });
}

async function zoom(level_arg){
}

async function timer(int_arg){
}


  </script>
</head>
<body>

<!-- Navigation -->
<?php include '../../navbar.php'; ?>

<!-- Content -->
<div class="container" style="margin-top:30px">
  <div class="row justify-content-center">
    <div class="col-9">
      <div class="card">
        <div class="card-body">
          <div class="videoWrapper">
            <!-- Put YOUTUBE link below -->
            <iframe width="560" height="349" src="<?php echo $youtube ?>" frameborder="0" allowfullscreen></iframe>
          </div>
          <hr>
            <div class="UserInterface" style="display: inline-block; padding-left:5px; padding-right:5px; " >
              
            <form action="" method="">
              <label for="zoomInput"><b>Zoom: </b></label>
                <input type="text" placeholder="Zoom Level" id="zoomInput">
              </form>

              <button onclick="light(1)">Light On</button>
              <button onclick="moveMotor()">Move Motor</button>
              <button onclick="light(0)">Light Off</button>
              
              <form action="" method="">
              <label for="timerInput"><b>Timer: </b></label>
                <input type="text" placeholder="Seconds" id="timerInput">
                <input type="submit" value="Submit">
              </form>
              
            </div>
          <hr>
          <button class="btn" name ="viewphoto-submit" type="submit" onclick="window.location.href='./viewphotos.php'">View Archived Photos</button>
          <button class="btn" name ="googledocs-submit" type="submit" onclick="window.open('https://docs.google.com/forms/d/1Oa1WRS4LZLZQ9nuTjRTILW01rp9zHC7eG6cFWW6NvHs/edit')">Complete Experiment WorkSheet</button>
        </div>
      </div>
      <div class="card" style="margin-top: 30px; margin-bottom: 30px">
        <div class="card-header"><?php echo $experimentName; ?></div>
        <div class="card-body">
          <?php echo $description; ?>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-header"><?php echo ucfirst($microscopeName); ?></div>
        <div class="card-body">
          <b>Experiment:</b>
          <p><?php echo $experimentName ?></p>
          <b>Class:</b>
          <p><?php echo $className ?></p>
          <b>Available:</b>
          <p><?php echo $availability ?></p>
        </div>
      </div>
      <div class="card" style="margin-top: 30px; margin-bottom: 30px">
        <div class="card-header">Latest Images</div>
        <div class="card-body">
          <a href="viewphotos.php" style="margin-top: -10px; float: right;">View all</a><br/>
          <?php 
          // Most recent images. parameters are (folder, number of images)
          displayLatest('./images', 3); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include '../../footer.php' ?>

</body>
</html>
