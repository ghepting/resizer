<?php
session_start();

if( isset($_REQUEST['bookmarked']) ) {
  setcookie('bookmarked', 'true');
}

function root_url() {
  $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
  $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
  $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
  return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
}

$path = $_SERVER['PHP_SELF'];
$path = str_replace('index.php','', $path);

function iframe_url() {
  $url = $_REQUEST['url'];
  $url = parse_url($url);
  return $url['scheme'] . "://" . $url['host'] . ($url['port'] ? ":" . $url['port'] : "");
}

$iframe_access = (root_url() == iframe_url());

$title = Array();
array_push( $title, 'Flexy' );
array_push( $title, 'A viewport resizing tool for testing and demonstrating responsive designs.' );
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <title><?php echo join(": ", $title); ?></title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
  <meta name="description" content="<?php echo $title[1]; ?>">
  <!-- Modernizr -->
  <script src="js/libs/modernizr-2.6.2.min.js"></script>
  <!-- jQuery-->
  <script type="text/javascript" src="js/libs/jquery-1.10.2.min.js"></script>
  <!-- jQuery Cookie -->
  <script type="text/javascript" src="js/libs/jquery.cookie.js"></script>
  <!-- groundwork css -->
  <!--[if gt IE 9]><!-->
  <link type="text/css" rel="stylesheet" href="css/groundwork.css">
  <!--<![endif]-->
  <!--[if lte IE 9]>
  <link type="text/css" rel="stylesheet" href="css/groundwork-core.css">
  <link type="text/css" rel="stylesheet" href="css/groundwork-type.css">
  <link type="text/css" rel="stylesheet" href="css/groundwork-ui.css">
  <link type="text/css" rel="stylesheet" href="css/groundwork-anim.css">
  <link type="text/css" rel="stylesheet" href="css/groundwork-ie.css">
  <![endif]-->
  <link href="http://fonts.googleapis.com/css?family=Gorditas:400,700" rel="stylesheet" type="text/css">
  <link type="text/css" rel="stylesheet" href="css/resizer.css">
  <script type="text/javascript" src="js/resizer.js"></script>
</head>
<?php
if(!isset($_REQUEST['url']) || empty($_REQUEST['url'])) {
?>
  <div class="container">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="get">
      <div class="row">
        <div class="one whole triple-padded">
          <h1 class="responsive" data-compression="4.3" data-min="60" data-max="150">
            <i class="icon-desktop"></i> 
            <i class="icon-laptop"></i> 
            <i class="icon-tablet"></i> 
            <i class="icon-mobile-phone"></i>
          </h1>
          <h1 class="logo quicksand responsive" data-compression="5" data-min="52" data-max="95"><i class="icon-strong-arm-left"></i><?php echo $title[0]; ?><i class="icon-strong-arm-right"></i></h1>
          <h3 class="museo-slab"><?php echo $title[1]; ?></h3>
          <p></p>
        </div>
      </div>
      <div class="row">
        <div class="six sevenths centered triple-padded">
          <h5 class="source-sans-pro responsive" data-compression="15" data-min="20" data-max="30">Enter URL</h5>
          <div class="flex-wrapper">
            <div class="pad-right" style="line-height:1.2;">
              <label for="url" class="zero"><i class="icon-globe icon-3x"></i></label>
            </div>
            <div class="flex-box">
              <input type="text" class="large" autofocus tabindex="1" id="url" name="url" placeholder="http://www.example.com" />
            </div>
            <div class="pad-left">
              <button type="submit" class="black" tabindex="2" style="line-height:1.2;padding:0;border:0;background:none;"><i class="icon-circle-arrow-right icon-3x"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
<?php
if( !isset($_REQUEST['bookmarked']) && !isset($_COOKIE['bookmarked']) ) {
?>
        <div class="one small-tablet half pad-left pad-right align-right align-center-mobile">
          <a id="bookmarklet" class="red grab block-mobile" rel="bookmark" role="button" href="javascript:document.location='<?php echo root_url() . $path; ?>?url=' + document.location.href + '&bookmarked=true';" title="Drag me to bookmarks"><span class="hidden"><?php echo $title[0]; ?> Viewport Resizer</span></a>
        </div>
        <div class="one small-tablet half pad-left pad-right align-left align-center-mobile pad-top-mobile">
<?php
}else{
?>
        <div class="one whole pad-left pad-right align-center">
<?php
}
?>
          <a class="red block-mobile" role="button" href="https://github.com/ghepting/resizer" title="Another open-source project by @ghepting" target="_blank">Github Project<span class="gap-left border-left pad-left small">v2.1.6</span></a>
        </div>
      </div>
    </form>
  </div>
<?php
}else{
  $url = $_REQUEST['url'];
  if (!preg_match("~https?://~i", $url)) {
    $url = "http://" . $url;
  }
  if( !isset($_REQUEST['bookmarked']) && !isset($_COOKIE['bookmarked']) ) {
?>
  <div id="ribbon-wrapper">
    <a id="ribbon" rel="bookmark" class="noicon" href="javascript:document.location='<?php echo root_url() . $path; ?>?url=' + document.location.href + '&bookmarked=true';" class="grab" title="Drag me to bookmarks">
      <div class="content museo-slab" title="Drag me to your bookmarks"><span class="hidden"><?php echo $title[0]; ?> Viewport Resizer</span></div>
      <div class="inset"></div>
      <div class="container">
        <div class="base"></div>
        <div class="end"></div>
      </div>
    </a>
  </div>
<?php
  }
?>
  <div id="address-bar" style="display:none;">
    <div class="square box charcoal relative" style="z-index:1;">
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="absolute top left black gapped" style="border:none;padding:0;background:none;line-height:1.2;text-decoration:none;"><i class="icon-home icon-2x"></i></a>
      <button data-toggle="#address-bar" class="absolute top right black gapped" style="border:none;padding:0;background:none;line-height:1.2;"><i class="icon-remove-sign icon-2x"></i></button>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="small-container">
          <div class="triple-pad-right triple-pad-left">
            <div class="flex-wrapper">
              <div class="pad-right" style="line-height:1.2;">
                <label for="url" class="zero"><i class="icon-globe icon-2x"></i></label>
              </div>
              <div class="flex-box">
                <input name="url" type="text" id="url" placeholder="http://www.example.com" value="<?php echo $_REQUEST['url']; ?>" />
              </div>
              <div class="pad-left no-pad-left-mobile">
                <button type="submit" class="black" style="line-height:1.2;padding:0;border:0;background:none;"><i class="icon-circle-arrow-right icon-2x"></i></button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div id="resizer" class="bounceInDown animated">
    <ul class="button-group">
      <li><button class="charcoal" title="Enter URL" data-toggle="#address-bar"><i class="icon-terminal"></i></button></li>
<?php
if($iframe_access) {
?>
      <li><button class="charcoal refresh" title="Refresh Page"><i class="icon-refresh"></i></button></li>
<?php
}
?>
      <li><button class="charcoal desktop-only" title="Fullscreen" data-device="fullscreen" data-viewport-width="100%" data-viewport-height="100%" data-user-agent=""><i class="icon-fullscreen"></i></button></li>
      <li><button class="charcoal desktop-only" title="Desktop" data-device="desktop" data-viewport-width="1920px" data-viewport-height="1080px" data-user-agent=""><i class="icon-desktop"></i></button></li>
      <li><button class="charcoal desktop-only" title="13 &#39; MacBook Pro" data-device="macbook" data-viewport-width="1280px" data-viewport-height="800px" data-user-agent=""><i class="icon-laptop"></i></button></li>
      <li><button class="charcoal hide-on-small-tablet hide-on-mobile" data-device="ipad" title="iPad" data-rotate="true" data-viewport-width="768px" data-viewport-height="1024px" data-user-agent="Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25"><i class="icon-tablet"></i></button></li>
      <li><button class="charcoal hide-on-mobile" title="Android Tablet" data-device="tablet" data-rotate="true" data-viewport-width="720px" data-viewport-height="1280px" data-user-agent="Mozilla/5.0 (Linux; U; Android 4.0.2; en-us; Galaxy Nexus Build/ICL53F) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30"><i class="android icon-tablet"></i></button></li>
      <li><button class="charcoal" title="Android Phone" data-rotate="true" data-device="android" data-viewport-width="480px" data-viewport-height="720px" data-user-agent="Mozilla/5.0 (Linux; U; Android 2.3.6; en-us; Nexus S Build/GRK39F) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"><i class="android icon-mobile-phone"></i></button></li>
      <li><button class="charcoal" title="iPhone" data-rotate="true" data-device="iphone" data-viewport-width="320px" data-viewport-height="640px" data-user-agent="Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25"><i class="icon-mobile-phone"></i></button></li>
      <li><button class="charcoal rotate" data-rotate="true" title="Toggle Landscape/Portrait"><i class="icon-rotate-left"></i></button></li>
<?php
if($iframe_access) {
?>
      <li><button class="close charcoal" id="closeResizer"><i class="icon-remove"></i></button></li>
<?php
}else{
?>
      <li><a class="close charcoal" href="<?php echo $_SERVER['PHP_SELF']; ?>"><i class="icon-remove"></i></a></li>
<?php
}
?>
    </ul>
  </div>
  <div id="resizerFrameWrapper">
    <iframe id="resizerFrame" class="relative" style="z-index:1;" src="<?php echo $url; ?>" frameborder="0"></iframe>
  </div>
<?php
}
?>
  <p class="museo-slab fixed left right bottom align-center" style="z-index:0;">Another open-source project by <a href="http://garyhepting.com/" target="_blank">Gary Hepting</a></p>
  <!-- scripts -->
  <script type="text/javascript" src="js/groundwork.all.js"></script>

  <!-- google analytics -->
  <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-17121602-5']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>

</body>
</html>
