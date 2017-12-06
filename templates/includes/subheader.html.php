<?php #autologowanie
if(isset($_COOKIE['remember']) && !isset($_SESSION['user'])){
    $user = new classes\User\User();
    if($user->autoLogin($_COOKIE['remember'])){
        if($user->getType() == 1){
            $user = new classes\User\StandardUser($user->getId());
        }elseif($user->getType() == 2){
            $user = new classes\User\ModelUser($user->getId());
        }
        $_SESSION['user'] = base64_encode(serialize($user));
    }else{
        setcookie('remember', null, time() - 1, "/");
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo $phrases['meta']['description'] ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<title>Ask For Me - where virtual world touch real</title>
        
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
	
	<!-- jquery -->
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<!-- end jquery -->
        
    <!-- fonts -->
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700|Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://use.fontawesome.com/5fa0eb3fea.js"></script>      
	<!-- end fonts -->
		
	<!-- bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- end bootstrap -->
        
    <!-- videojs -->
		<link href="https://vjs.zencdn.net/6.2.0/video-js.css" rel="stylesheet">
        <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
	<!-- end -->
        
    <!--bootstrap select-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<!--end-->
        
    <!--bootstrap datepicker-->
        <script type="text/javascript" src="/js/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css" />
	<!--end-->
        
    <!--file input-->
        <script type="text/javascript" src="/js/fileinput.min.js"></script>
        <link rel="stylesheet" href="/css/fileinput.min.css" />
    <!--end-->
    
    <!--scrollbar-->
        <script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!--end-->
    
    <!--slick slider-->
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <!--end-->
    
    <!--captcha-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <!--end-->
        
    <!--masonry-->
	    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
        <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
	<!--end masonry-->

    <!-- update functions -->
        <script src="/js/updateFunctions.js"></script>
    <!-- end update functions -->
        
	<!--styles-->
        <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
        <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="/css/cs-select.css" />
        <link rel="stylesheet" type="text/css" href="/css/awesome-bootstrap-checkbox.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link href="/css/style.css" rel="stylesheet">	
    <!--end style-->
    
    <!-- socket -->
    <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
    <script src="/js/globalSocketFunctions.js"></script>
    <!-- end socket -->
	</head>
	
	<body class="cbp-spmenu-push">

        <div class="body-container">
            
            <div class="se-pre-con">
                <img src="/img/logo.png" alt="logo" title="logo" />
                <img src="/img/loading.gif" alt="loader" title="loader" />
            </div>
