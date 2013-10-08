<?php
function root_url() {
  $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
  $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
  $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
  return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
}

function iframe_url() {
  $url = $_REQUEST['url'];
  $url = parse_url($url);
  return $url['scheme'] . "://" . $url['host'] . ($url['port'] ? ":" . $url['port'] : "");
}

$iframe_access = (root_url() == iframe_url());
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
  <title><?php echo preg_replace('~https?://~i', '', $_REQUEST['url']) ?></title>
  <!-- Modernizr -->
  <script src="http://groundworkcss.github.io/js/libs/modernizr-2.6.2.min.js"></script>
  <!-- jQuery-->
  <script type="text/javascript" src="http://groundworkcss.github.io/js/libs/jquery-1.10.2.min.js"></script>
  <!-- framework css -->
  <!--[if gt IE 9]><!-->
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork.css">
  <!--<![endif]-->
  <!--[if lte IE 9]>
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork-core.css">
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork-type.css">
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork-ui.css">
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork-anim.css">
  <link type="text/css" rel="stylesheet" href="http://groundworkcss.github.io/css/groundwork-ie.css">
  <![endif]-->
</head>
  <style type="text/css">
    html, body {
      width: 100%;
      height: 100%;
      text-align: center;
      background: #333 url('http://groundworkcss.github.io/images/black_linen_v2.png') center repeat;
      overflow: hidden;
      color: #fff;
    }
    #resizerFrame {
      width: 100%;
      max-width: 100%;
      height: 100%;
      max-height: 100%;
      margin: 0 auto;
      background: white;
      box-shadow: 0 0 50px #000;
      -webkit-transition: max-width 0.35s ease-out, max-height 0.35s ease-out;
      -moz-transition: max-width 0.35s ease-out, max-height 0.35s ease-out;
      -ms-transition: max-width 0.35s ease-out, max-height 0.35s ease-out;
      -o-transition: max-width 0.35s ease-out, max-height 0.35s ease-out;
      transition: max-width 0.35s ease-out, max-height 0.35s ease-out;
    }
    #resizer {
      text-align: center;
      line-height: 1;
    }
    #resizer ul {
      font-size: 13px;
      display: inline-block;
      margin: -0.2em auto 0.2em;
      -webkit-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -moz-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -ms-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -o-filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      filter: drop-shadow(0 1px 5px rgba(0,0,0,.25));
      -ms-transform: translateZ(0);
      -o-transform: translateZ(0);
      -moz-transform: translateZ(0);
      -webkit-transform: translateZ(0);
      transform: translateZ(0);
    }
    button.rotate i:before, button[data-rotate] i:before {
      -webkit-transition: all 0.15s linear;
      -moz-transition: all 0.15s linear;
      -ms-transition: all 0.15s linear;
      -o-transition: all 0.15s linear;
      transition: all 0.15s linear;
    }
    .landscape i:before {
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      -ms-transform: rotate(-90deg);
      -o-transform: rotate(-90deg);
      transform: rotate(-90deg);
    }
  </style>
  <script type="text/javascript">
    function setCookie(name,value,days) {
      if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
      }
      else var expires = "";
      document.cookie = name+"="+value+expires+"; path=/";
    }

    function readCookie(name) {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
    }

    function eraseCookie(name) {
      setCookie(name,"",-1);
    }

    function basename(str) {
      var base = new String(str).substring(str.lastIndexOf('/') + 1);
      if(base.lastIndexOf(".") != -1) {
        base = base.substring(0, base.lastIndexOf("."));
      }
      return base;
    }

    function updateQueryStringParameter(uri, key, value) {
      var re = new RegExp("([?|&])" + key + "=.*?(&|$)", "i");
      separator = uri.indexOf('?') !== -1 ? "&" : "?";
      var url = window.location.href;
      if (uri.match(re)) {
        url = uri.replace(re, '$1' + key + "=" + value + '$2');
      }
      else {
        url = uri + separator + key + "=" + value;
      }
      return url;
    }

    $(document).ready(function() {

      $('body').on('click', 'button[data-viewport-width]', function(e) {
        if($(this).attr('data-viewport-width') == '100%') {
          newWidth = '100%';
        }else{
          newWidth = $(this).attr('data-viewport-width');
        }
        if($(this).attr('data-viewport-height') == '100%') {
          newHeight = '100%';
        }else{
          newHeight = $(this).attr('data-viewport-height');
        }
        $('button[data-viewport-width]').removeClass('active');
        $(this).addClass('active');
        setCookie('device', $(this).attr('data-device'));
        // $('#resizerFrame').stop().animate({'max-width': newWidth, 'max-height': newHeight}, 200);
        $('#resizerFrame').css({'max-width': newWidth, 'max-height': newHeight});
        e.preventDefault();
        return false;
      });

      $('body').on('click', 'button.rotate', function(e) {
        // $(this).toggleClass('landscape');
        $('button[data-rotate=true]').each(function() {
          $(this).toggleClass('landscape');
          width = $(this).attr('data-viewport-width');
          height = $(this).attr('data-viewport-height');
          // shuffle values
          $(this).attr('data-viewport-width', height);
          $(this).attr('data-viewport-height', width);
          if($(this).hasClass('active')) {
            $(this).trigger('click');
            if( $(this).hasClass('landscape') ) {
              setCookie('orientation', 'landscape');
            }else{
              eraseCookie('orientation');
            }
          }
        });
      });

      $('body').on('click', 'button.refresh', function(e) {
        $(this).find('i[class*="icon-"]').addClass('icon-rotate-360');
        document.getElementById('resizerFrame').contentWindow.location.reload();
      });

      $('body').on('click', '#closeResizer', function(e) {
        newWidth = $(window).width();
        newHeight = $(window).height();
        $('button[data-viewport-width]').removeClass('active');
        // $('#resizerFrame').stop().animate({'max-width': newWidth, 'max-height': newHeight}, 200);
        $('#resizerFrame').css({'max-width': newWidth, 'max-height': newHeight});
        $('#resizer').fadeOut(500, function() {
          document.location = document.getElementById("resizerFrame").contentWindow.location.href;
        });
        e.preventDefault();
        return false;
      });

      $('#resizerFrame').on('load', function() {
        var url = basename(this.contentWindow.location.href);
        var stateObj = { resizer: 'resizer' };
        history.pushState(stateObj, url, href);
      });

      if( readCookie('device') ) {
        $('[data-device="'+readCookie('device')+'"]').trigger('click');
      }
      if( readCookie('orientation') == 'landscape' ) {
        $('.rotate').trigger('click');
      }

      var iframe = document.getElementById('resizerFrame');
      var origin = window.location.protocol + '//' + window.location.host;
      if( origin =='<?php echo $root_url ?>' ) {

      }
    });
  </script>
<?php
if(!isset($_REQUEST['url']) || empty($_REQUEST['url'])) {
?>
  <div class="container">
    <form action="<?php $_SERVER['PHP_SELF']?>" method="get">
      <div class="row">
        <div class="one whole tripple padded">
          <h3 class="responsive" data-compression="4.3">
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
          <div class="row">
            <div class="four mobile fifths">
              <p><input type="text" name="url" placeholder="http://www.example.com" /></p>
            </div>
            <div class="one mobile fifth pad-left">
              <p><input type="submit" class="info" value="Go" /></p>
            </div>
          </div>
          <p><small>Another open-source project by <a href="http://garyhepting.com/">Gary Hepting</a></small></p>
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
?>
  <div id="resizer" class="bounceInDown animated">
    <ul class="button-group">
<?php
if($iframe_access) {
?>
      <li><button class="charcoal refresh" title="Refresh Page"><i class="icon-refresh"></i></button></li>
<?php
}
?>
      <li><button class="charcoal desktop-only" title="Fullscreen" data-device="fullscreen" data-viewport-width="100%" data-viewport-height="100%"><i class="icon-fullscreen"></i></button></li>
      <li><button class="charcoal desktop-only" title="Desktop" data-device="desktop" data-viewport-width="1920px" data-viewport-height="1080px"><i class="icon-desktop"></i></button></li>
      <li><button class="charcoal desktop-only" title="13 &#39; MacBook Pro" data-device="macbook" data-viewport-width="1280px" data-viewport-height="800px"><i class="icon-laptop"></i></button></li>
      <li><button class="charcoal hide-on-small-tablet hide-on-mobile" data-device="ipad" title="iPad" data-rotate="true" data-viewport-width="768px" data-viewport-height="1024px"><i class="icon-tablet"></i></button></li>
      <li><button class="charcoal hide-on-mobile" title="Android Tablet" data-device="tablet" data-rotate="true" data-viewport-width="720px" data-viewport-height="1280px"><i class="android icon-tablet"></i></button></li>
      <li><button class="charcoal" title="Android Phone" data-rotate="true" data-device="android" data-viewport-width="480px" data-viewport-height="720px"><i class="android icon-mobile-phone"></i></button></li>
      <li><button class="charcoal" title="iPhone" data-rotate="true" data-device="iphone" data-viewport-width="320px" data-viewport-height="640px"><i class="icon-mobile-phone"></i></button></li>
      <li><button class="charcoal rotate" data-rotate="true" title="Toggle Landscape/Portrait"><i class="icon-rotate-left"></i></button></li>
<?php
if($iframe_access) {
?>
      <li><button class="charcoal" id="closeResizer"><i class="icon-remove"></i></button></li>
<?php
}
?>
    </ul>
  </div>
  <iframe id="resizerFrame" src="<?php echo $url ?>" frameborder="0"></iframe>
<?php
}
?>
  <!-- scripts -->
  <script type="text/javascript" src="http://groundworkcss.github.io/js/groundwork.all.js"></script>

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
