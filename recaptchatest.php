<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <title>Nityam - Contact Page</title>
  <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="favicon/android-icon-192x192.png" sizes="192x192">
  <link rel="shortcut icon" href="favicon/favicon.ico">
  <link rel="icon" type="image/png" href="favicon/android-icon-36x36.png" sizes="36x36">
  <link rel="icon" type="image/png" href="favicon/android-icon-48x48.png" sizes="48x48">
  <link rel="icon" type="image/png" href="favicon/android-icon-72x72.png" sizes="72x72">
  <link rel="icon" type="image/png" href="favicon/android-icon-96x96.png" sizes="96x96">
  <link rel="manifest" href="favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="I am a Student web designer & front‑end developer focused on crafting clean & user‑friendly experiences. Code and Chatbot Never Lies" />
  <meta name="keywords" content="Chatbot and code , MrNityam, Mr Nityam." />
  <meta name="author" content="Nityam" />
</head>
<body>
    

<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>

<form action="" method="post">
    <!-- Form fields -->
    <div class="input-group">
        <input type="text" name="name" value="<?php echo !empty($postData['name'])?$postData['name']:''; ?>" placeholder="Your name" required="" />
    </div>
    <div class="input-group">	
        <input type="email" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" placeholder="Your email" required="" />
    </div>
    <div class="input-group">
        <textarea name="message" placeholder="Type message..." required="" ><?php echo !empty($postData['message'])?$postData['message']:''; ?></textarea>
    </div>
		
    <!-- Google reCAPTCHA box -->
    <div class="g-recaptcha" data-sitekey="6Le0w8YaAAAAAF63YnIG4WSVj9PvvDHurW8sDyvR"></div>
	
    <!-- Submit button -->
    <input type="submit" name="submit" value="SUBMIT">
</form>
<?php 
$postData = $statusMsg = ''; 
$status = 'error'; 
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
    $postData = $_POST; 
     
    // Validate form fields 
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])){ 
         
        // Validate reCAPTCHA box 
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
            // Google reCAPTCHA API secret key 
            $secretKey = '6Le0w8YaAAAAAIbOXnywo_COXMl11TL7S7oa3rBi'; 
             
            // Verify the reCAPTCHA response 
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
             
            // Decode json data 
            $responseData = json_decode($verifyResponse); 
             
            // If reCAPTCHA response is valid 
            if($responseData->success){ 
                // Posted form data 
                $name = !empty($_POST['name'])?$_POST['name']:''; 
                $email = !empty($_POST['email'])?$_POST['email']:''; 
                $message = !empty($_POST['message'])?$_POST['message']:''; 
                 
                // Send email notification to the site admin 
                $to = 'ThisisNityam@gmail.com'; 
                $subject = 'New contact form have been submitted'; 
                $htmlContent = " 
                    <h1>Contact request details</h1> 
                    <p><b>Name: </b>".$name."</p> 
                    <p><b>Email: </b>".$email."</p> 
                    <p><b>Message: </b>".$message."</p> 
                "; 
                 
                // Always set content-type when sending HTML email 
                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                // More headers 
                $headers .= 'From:'.$name.' <'.$email.'>' . "\r\n"; 
                 
                // Send email 
                @mail($to,$subject,$htmlContent,$headers); 
                 
                $status = 'success'; 
                $statusMsg = 'Your contact request has submitted successfully.'; 
                $postData = '';
            }else{ 
                $statusMsg = 'Robot verification failed, please try again.'; 
            } 
        }else{ 
            $statusMsg = 'Please check on the reCAPTCHA box.'; 
        } 
    }else{ 
        $statusMsg = 'Please fill all the mandatory fields.'; 
    } 
} 
?>

<!--contact form ends-------------------------------------->
</body>
</html>