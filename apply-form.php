<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
//index.php
//Include Configuration File
include('googleconfig.php');
include('fbconfig.php');
//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
   //It will Attempt to exchange a code for an valid authentication token.
$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);
  //Store "access_token" value in $_SESSION variable for future use.
   $_SESSION['access_token'] = $token['access_token'];
  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);
  //Get user profile data from google
  $data = $google_service->userinfo->get();
  //get data
  $_SESSION["userid"] = $data["email"];
 }
/* echo "<pre>";
 print_r ($data);
 echo "</pre>";*/
/**/
}
/*$facebook_login_url ='';
$facebook_helper = $facebook->getRedirectLoginHelper();
if(isset($_GET['code']))
{
 if(isset($_SESSION['access_token']))
 {
  $access_token = $_SESSION['access_token'];
 }
 else
 {
     $access_token = $facebook_helper->getAccessToken();
  $_SESSION['access_token'] = $access_token;
  $facebook->setDefaultAccessToken($_SESSION['access_token']);
 }
 $_SESSION['user_id'] = '';
 $_SESSION['user_name'] = '';
 $_SESSION['user_email_address'] = '';
 $_SESSION['user_image'] = '';
 $graph_response = $facebook->get("/me?fields=name,email", $access_token);
 $facebook_user_info = $graph_response->getGraphUser();
 $_SESSION['userid'] = $facebook_user_info['email'];
 if(!empty($facebook_user_info['id']))
  {
  $_SESSION['user_image'] = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';
 }
 if(!empty($facebook_user_info['name']))
  {
  $_SESSION['user_name'] = $facebook_user_info['name'];
 }
 if(!empty($facebook_user_info['email']))
 {
  $_SESSION['user_email_address'] = $facebook_user_info['email'];
 }
}
else
{
 // Get login url
    $facebook_permissions = ['email']; // Optional permissions
    $facebook_login_url = $facebook_helper->getLoginUrl('http://localhost/project/index.php', $facebook_permissions);
    // Render Facebook login button
    $facebook_login_url = '<div align="center"><a href="'.$facebook_login_url.'"><img src="https://miro.medium.com/fit/c/1838/551/1*InDQe4dYjE72rNr37TVI1Q.png" /></a></div>';
}
*/
?>
<?php 
include('includes/dbconnection.php');
session_start();
error_reporting(0);
if (!$_SESSION['userid']) {
  header("Location:index.php"); 
}
if(isset($_POST['submit']))
  {

    $packages=$_POST['packages'];
    $trainingdate=$_POST['trainingdate'];
    $time=$_POST['time'];
    $fullname=$_POST['fullname'];
    $email=$_POST['email'];
    $mobilenumber=$_POST['mobilenumber'];
    $gender=$_POST['gender'];
    $age=$_POST['age'];
    $licno=$_POST['licno'];
    $address=$_POST['address'];
    $altnumber=$_POST['altnumber'];
    $regnumber = mt_rand(100000000, 999999999);
   $licnence=$_FILES["licpic"]["name"];
   $extension = substr($licnence,strlen($licnence)-4,strlen($licnence));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
    $licnencenew=md5($licnence).$extension;
     move_uploaded_file($_FILES["licpic"]["tmp_name"],"licimagesimages/".$licnencenew);
    $query=mysqli_query($con,"insert into tbluser(PackID,RegNumber,FullName,Email,MobileNumber,Gender,Age,LicenceNumber,Address,AlternateNumber,TrainingDate,TrainingTiming,UploadLicence) value('$packages','$regnumber','$fullname','$email','$mobilenumber','$gender','$age','$licno','$address','$altnumber','$trainingdate','$time','$licnencenew')");
    if ($query) {
$ret=mysqli_query($con,"select RegNumber from tbluser where Email='$email' and  MobileNumber='$mobilenumber'");
$result=mysqli_fetch_array($ret);
$_SESSION['regno']=$result['RegNumber'];
 echo '<script>alert("Invoice created successfully. Invoice number is "+"'.$_SESSION['regno'].'")</script>';
echo "<script>window.location.href ='apply-form.php'</script>";
  }
  else
    {
 echo '<script>alert("Something Went Wrong. Please try again")</script>';    
 echo "<script>window.location.href ='apply-form.php'</script>";  
    }

  
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CDSMS Apply Now</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //custom-theme -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script src="js/main.js"></script>
<!-- //js -->
<!-- font-awesome-icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome-icons -->
<link href="//fonts.googleapis.com/css?family=Prompt:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,thai,vietnamese" rel="stylesheet">
</head>
<body>
<!-- banner -->
  <?php include_once('includes/header.php');?>
  <div class="banner1">
  </div>
<!-- //banner -->
<!-- contact -->    
  <div class="contact"> 
    <div class="container">
      <div class="w3l-heading">
        <h2 class="w3ls_head">Apply Now</h2>
      </div>
      <div class="contact-agileinfo">
        <div class="col-md-12 contact-right"> 
          <form  method="post" enctype="multipart/form-data">
  
<p style="padding-top: 20px; font-size: 15px"><strong>Packages:  </strong>
                                    <select name="packages" id="packages" required="true">
                                        <option value="">Select</option>
                                        <?php $query=mysqli_query($con,"select * from tblpackages");
              while($row=mysqli_fetch_array($query))
              {
              ?>    
             
              <option value="<?php echo $row['ID'];?>"><?php echo $row['PackageName'];?></option>
                  <?php } ?> 
                                    </select></p>
                                    

                                  <p style="padding-top: 20px; font-size: 15px"><strong>Training Start Date:  </strong>
                                    <input type="date" id="datepicker" name="trainingdate" placeholder="Trainin Date" required="true"></p>

<p style="padding-top: 20px; font-size: 15px"><strong>Training Time:  </strong>
                                    <select name="time" id="Time" required="">
                                        <option value="hide">-- Choose --</option>
                                        <option value="09:00AM - 10:00AM">09:00AM - 10:00AM</option>
                                        <option value="10:00AM - 11:00AM">10:00AM - 11:00AM</option>
                                        <option value="11:00AM - 12:00PM">11:00AM - 12:00PM</option>
                                        <option value="12:00PM - 01:00PM">12:00PM - 01:00PM</option>
                                        <option value="01:00PM - 02:00PM">01:00PM - 02:00PM</option>
                                        <option value="02:00PM - 03:00PM">02:00PM - 03:00PM</option>
                                        <option value="03:00PM - 04:00PM">03:00PM - 04:00PM</option>
                                        <option value="04:00PM - 05:00PM">04:00PM - 05:00PM</option>
                                        <option value="05:00PM - 06:00PM">05:00PM - 06:00PM</option>
                                        <option value="06:00PM - 07:00PM">06:00PM - 07:00PM</option>
                                        <option value="07:00PM - 08:00PM">07:00PM - 08:00PM</option>
                                        <option value="08:00PM - 09:00PM">08:00PM - 09:00PM</option>
                                    </select></p>



          <p style="padding-top: 30px; font-size: 15px"><strong>Contact Details</strong></p>
          <p> <input type="text" name="fullname" placeholder="Your Name" required="true"></p>
            <input type="text" class="email" name="email" placeholder="Your Email" required="true">
            <input type="text" name="mobilenumber" placeholder="Your Phone" required="true" maxlength="10" pattern="[0-9]{10}">

            <div class="radio">

                               <p style="padding-top: 20px; font-size: 15px"> <strong>Gender:</strong> <label>
                                    <input type="radio" name="gender" id="gender" value="Female" checked="true">
                                    Female
                                </label>
                                <label>
                                    <input type="radio" name="gender" id="gender" value="Male">
                                    Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" id="gender" value="Transgender">
                                   Transgender
                                </label></p>
                            </div>
            

<p style="padding-top: 20px; font-size: 15px"><input type="text" name="age" placeholder="Age" required="true" maxlength="2"></p>

<p style="padding-top: 20px; font-size: 15px"><input type="text" name="licno" placeholder="Licence Number" required="true" maxlength="15"></p>
<p style="padding-top: 20px; font-size: 15px">Upload Licence :
  <input type="file" name="licpic" required="true"></p>
            

            <p style="padding-top: 20px; font-size: 15px"><textarea name="address" id="address" placeholder="Your Address" required="true"></textarea></p>
          <p style="padding-top: 20px; font-size: 15px"><input type="text" name="altnumber" placeholder="Alternate Number" required="true" maxlength="10"></p>
            <input type="submit" name="submit" value="Apply Now" > 
          </form>
        </div>
        
        <div class="clearfix"></div>
      </div>
    </div> 
  </div>
  
  <!-- //contact -->  
  
  <!-- footer -->
  <?php include_once('includes/footer.php');?>
  <!-- //footer -->

<!-- start-smooth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".scroll").click(function(event){   
      event.preventDefault();
      $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });
  });
</script>
<!-- start-smooth-scrolling -->
<!-- for bootstrap working -->
  <script src="js/bootstrap.js"></script>
<!-- //for bootstrap working -->
<!-- here stars scrolling icon -->
  <script type="text/javascript">
    $(document).ready(function() {
      /*
        var defaults = {
        containerID: 'toTop', // fading element id
        containerHoverID: 'toTopHover', // fading element hover id
        scrollSpeed: 1200,
        easingType: 'linear' 
        };
      */
                
      $().UItoTop({ easingType: 'easeOutQuart' });
                
      });
  </script>
<!-- //here ends scrolling icon -->
</body>
</html>