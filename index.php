<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <title>Viewport Resizer for Testing Responsive Web Design</title>
  <!-- Modernizr -->
  <script src="http://groundwork.sidereel.com/js/libs/modernizr-2.6.2.min.js"></script>
  <!-- jQuery -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript">window.jQuery || document.write('<script src="http://groundwork.sidereel.com/js/libs/jquery-1.8.2.min.js"><\/script>')</script>
  <!-- Groundwork CSS -->
  <link type="text/css" rel="stylesheet" href="http://groundwork.sidereel.com/css/groundwork.css">
  <!--[if IE 7]>
  <link type="text/css" rel="stylesheet" href="http://groundwork.sidereel.com/css/font-awesome-ie7.min.css">
  <![endif]-->
  <script type="text/javascript">
    Modernizr.load({
      test: Modernizr.svg,
      nope: 'http://groundwork.sidereel.com/css/groundy/no-svg.css'
    });
  </script>
</head>
<body>

  <style type="text/css">
    html, body {
      width:100%;
      height:100%;
      text-align:center;
      background:#333 url('http://groundwork.sidereel.com/images/black_linen_v2.png') center repeat;
      overflow:hidden;
      color:#fff;
    }
    .container {
      max-width:480px;
    }
    #resizerFrame {
      width:100%;
      max-width:100%;
      height:100%;
      max-height:100%;
      margin:0 auto;
      background:white;
      box-shadow:0 0 50px #000;
    }
    #resizer {
      position:fixed;
      top:0;
      z-index:99;
      width:300px;
      left:50%;
      height:2em;
      margin:0 auto;
      margin-left:-150px;
    }
    #resizer ul {
      -webkit-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -moz-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -ms-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -o-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      margin:-0.2em auto 0;
    }
    #closeResizer, #openHome {
      padding:0.3em 0.5em;
      background:#fff;
      border-radius:0.3em;
      margin:1px 2px;
      text-decoration:none;
      color:#222;
      box-shadow:0 0 5px rgba(0,0,0,0.35);
    }
    a.rotate i, a[data-rotate] i {
      -webkit-transition: all 0.15s linear;
      -moz-transition: all 0.15s linear;
      -mx-transition: all 0.15s linear;
      -o-transition: all 0.15s linear;
      transition: all 0.15s linear;
    }
    .rotate-90-ctr    {
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      -ms-transform: rotate(-90deg);
      -o-transform: rotate(-90deg);
      transform: rotate(-90deg);
    }
  </style>
<?php
if(!isset($_REQUEST['url']) || empty($_REQUEST['url'])) {
?>
  <div class="container">
    <form action="<?php $_SERVER['PHP_SELF']?>" method="get">
      <div class="row">
        <div class="one whole tripple padded">
          <h3 class="responsive" data-compression="4">
            <i class="icon-desktop"></i> 
            <i class="icon-laptop"></i> 
            <i class="icon-tablet"></i> 
            <i class="icon-mobile-phone"></i>
          </h3>
          <h1 class="responsive" data-compression="12">Viewport Resizer</h1>
        </div>
      </div>
      <div class="row">
        <div class="one whole tripple padded">
          <h1 class="responsive" data-compression="8">Enter URL</h1>
          <p><input type="text" name="url" placeholder="http://www.example.com" /></p>
          <p><small>Another open-source project by <a href="http://garyhepting.com/">Gary Hepting</a></small></p>
        </div>
      </div>
    </form>
  </div>
<?php
}else{
  $url = $_REQUEST['url'];
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
?>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#resizerFrame').each(function() {
        $(this).css('max-width',$(window).width());
        $(this).css('max-height',$(window).height());
      });
      $('a[data-viewport-width]').on('click', function(e) {
        if($(this).attr('data-viewport-width') == '100%') {
          newWidth = $(window).width();
        }else{
          newWidth = $(this).attr('data-viewport-width');
        }
        if($(this).attr('data-viewport-height') == '100%') {
          newHeight = $(window).height();
        }else{
          newHeight = $(this).attr('data-viewport-height');
        }
        $('a[data-viewport-width]').removeClass('active');
        $(this).addClass('active');
        $('#resizerFrame').stop().animate({'max-width': newWidth, 'max-height': newHeight}, 200);
        e.preventDefault();
        return false;
      });
      $('a.rotate').on('click', function(e) {
        $(this).children('i[class*=icon]').toggleClass('rotate-90-ctr');
        $('a[data-rotate=true]').each(function() {
          $(this).children('i[class*=icon]').toggleClass('rotate-90-ctr');
          width = $(this).attr('data-viewport-width');
          height = $(this).attr('data-viewport-height');
          // shuffle values
          $(this).attr('data-viewport-width', height);
          $(this).attr('data-viewport-height', width);
          if($(this).hasClass('active')) {
            $(this).trigger('click');
          }
        });
      });
      $('#closeResizer').on('click', function(e) {
        newWidth = $(window).width();
        newHeight = $(window).height();
        $('a[data-viewport-width]').removeClass('active');
        $('#resizerFrame').stop().animate({'max-width': newWidth, 'max-height': newHeight}, 200);
        $('#resizer').fadeOut(500, function() {
          document.location = document.getElementById("resizerFrame").contentWindow.location.href || $("#resizerFrame").attr('src');
        });
        e.preventDefault();
        return false;
      });
    });
    $(window).resize(function() {
      if($('#resizer li:first-child a').hasClass('active')) {
        $('#resizerFrame').css('max-width', $(window).width());
        $('#resizerFrame').css('max-height', $(window).height());
      }
    });
  </script>
  <div id="resizer">
    <ul class="button-list pull-left">
      <li><a class="active" title="Desktop" href="#" data-viewport-width="100%" data-viewport-height="100%"><i class="icon-desktop"></i></a></li>
      <li><a title="13&quot; MacBook" href="#" data-viewport-width="1280px" data-viewport-height="800px"><i class="icon-laptop"></i></a></li>
      <li><a title="Small Tablet" href="#" data-rotate="true" data-viewport-width="600px" data-viewport-height="1024px"><i class="icon-tablet"></i></a></li>
      <li><a title="Mobile Phone" href="#" data-rotate="true" data-viewport-width="360px" data-viewport-height="640px"><i class="icon-mobile-phone"></i></a></li>
      <li><a title="Rotate" href="#" class="rotate"><i class="icon-refresh"></i></a></li>
    </ul>
    <a id="closeResizer" class="pull-left" title="Close Resizer" href="./home.html"><i class="icon-remove"></i></a>
  </div>
  <iframe id="resizerFrame" src="<?php echo $url ?>"></iframe>
<?php
}
?>
  <!-- scripts -->
  <script type="text/javascript" src="http://groundwork.sidereel.com/js/plugins/jquery.orbit-1.4.0.js"></script>
  <script type="text/javascript" src="http://groundwork.sidereel.com/js/groundwork.js"></script>

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
