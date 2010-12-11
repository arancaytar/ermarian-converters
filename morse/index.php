<?php

require_once 'parsers/morse.inc';
require_once 'net/mime.inc';

function is_morse($string) {
	return preg_match('/^[\-\. \/]*$/', $string);
}

$input = $output = '';

if (isset($_REQUEST['input']) && $input = trim($_REQUEST['input'])) {
	if (is_morse($input)) $output = morse_decode($input);
	else  $output = morse_encode($input);
}

if (!empty($_REQUEST['json'])) {
	mime('json');
	print json_encode(array('output' => $output));
	exit;
}
if (!empty($_REQUEST['auto'])) {
  mime('json');
  print json_encode(array($_REQUEST['input'], array($output)));
  exit;
}

?><?='<?xml version="1.0" encoding="iso-8859-1"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Morse Converter | The Ermarian Network</title>
<!-- InstanceEndEditable --> 
<meta name="author" lang="de" content="Arancaytar Ilyaran" />
<!-- InstanceBeginEditable name="meta" -->
<meta name="Description" content="This AJAX tool will convert Morse code into regular text, and regular text into Morse. It supports OpenSearch." lang="en" xml:lang="en" />
<meta name="Keywords" content="morse, code, morse code, converter, encoder, encryption, conversion, convert, ermarian, arancaytar" lang="en" xml:lang="en" />
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
<base href="http://ermarian.net" />
<!-- related documents -->
<!-- InstanceBeginEditable name="related" -->
<link rel="prev"  href="services/search/http" />
<link rel="contents" href="services" />
<link rel="help" href="about" />
<link rel="alternate" 
      type="application/rss+xml" 
      title="RSS" 
      href="rss.xml" />
<link rel="search" type="application/opensearchdescription+xml" title="Morse Convert" href="services/converters/morse/morse" />
<link rel="shortcut icon" type="image/bmp" href="data:image/bmp;base64,Qk32AAAAAAAAAHYAAAAoAAAAEAAAABAAAAABAAQAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAgAAAAICAAIAAAACAAIAAgIAAAICAgADAwMAAAAD%2FAAD%2FAAAA%2F%2F8A%2FwAAAP8A%2FwD%2F%2FwAA%2F%2F%2F%2FAAAAAAAAAAAAC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwCwC7u7u7u7ALALu7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7sAAAALsAu7uwAAAAuwC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7u7u7u7sAAAAAAAAAAA" />
<!-- InstanceEndEditable -->
<link rel="start" href="/" />
<link rel="stylesheet" 
      type="text/css" 
      media="all" 
      href="style/default.css" />
<link rel="stylesheet" 
      type="text/css" 
      media="screen" 
      href="style/screen.css" />
<link rel="stylesheet" 
      type="text/css" 
      media="print" 
      href="style/print.css" />
<script type="text/javascript" src="clickheat/js/clickheat"></script>
<script type="text/javascript" src="style/clickheat"></script>
<!-- InstanceBeginEditable name="stylesheets" -->
<script type="text/javascript" src="style/jquery"></script>
<script type="text/javascript" src="style/jquery.form"></script>
<script type="text/javascript" src="style/ajax"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#input').change(function() {
        $('form').ajaxSubmit();
    });
});
</script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
	<div id="content">
		
  <div class="filled-box" id="title"> 
    <h1>The Ermarian Network</h1>
  </div>
		<div class="filled-box" id="navside">
			<h2 class="navside">Navigation</h2>	
			<ul>
			  <!-- InstanceBeginRepeat name="NavItem" --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href=".">Main</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="about">About 
        me </a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a class="external" href="http://arancaytar.ermarian.net">Blog</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="sites">Sites</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="services">Services</a>
			  <ul class="secondary">
			    <li><a href="services/converters">Converters</a></li>
			    <li><a href="services/encryption">Encryption</a></li>
			    <li><a href="services/file-hosting">File Hosting</a></li>
			    <li><a href="services/jabber">Jabber</a></li>
			    <li><a href="services/news">News</a></li>
			    <li><a href="services/search">Search</a></li>
			  </ul><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="downloads">Downloads</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="links">Links</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceBeginRepeatEntry --> 
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="newsletter">Newsletter</a><!-- InstanceEndEditable --></li>
			  <!-- InstanceEndRepeatEntry --><!-- InstanceEndRepeat --> 
			</ul>

			<div class="filler">
				<!-- InstanceBeginEditable name="filler" -->
				<!-- InstanceEndEditable -->
			</div>

		</div>
		<div id="main">
			<div id="main2">
                        <script type="text/javascript"><!--
                        google_ad_client = "pub-7276462266487251";
                        /* 728x90, created 5/2/08 */
                        google_ad_slot = "9786486556";
                        google_ad_width = 728;
                        google_ad_height = 90;
                        //-->
                        </script>
                        <script type="text/javascript"
                        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
				<h2><!-- InstanceBeginEditable name="Maintitle" -->Morse Converter<!-- InstanceEndEditable --></h2>
				<!-- InstanceBeginEditable name="Maintext" -->
				      <p class="maintext"> You may enter a morse code to convert here, or a normal text
              to convert to morse. Format: "." for dit, "-" for dah, " " between letters, "/" between words.</p>
      <form action="services/converters/morse/" method="post">
      <input type="hidden" name="json" value="0" />
      <p class="maintext" style="text-align:center; vertical-align:center"> 
        <input id="input" type="text" name="input" size="80" value="<?=$input?>" />
        <input type="submit" value="Convert" style="vertical-align:center"/>
      </p></form>
<p class="maintext">The resulting string is:</p>           
<div id="output" class="codeblock" style="white-space:normal"><?=$output?></div>
<p class="maintext">You can also add this to your Firefox search box! Auto-completion ensures as-you-type translation!</p>
<p class="maintext"><em>Morse Converter was made by <a href="mailto:arancaytar.ilyaran@gmail.com">Arancaytar</a> and is an <a href="/">Ermarian Network</a></em> production.</p>
				<!-- InstanceEndEditable -->
				<div class="filled-box" id="footer">
					<a href="http://validator.w3.org/check?uri=referer">
						<img 	src="images/validation/valid-xhtml10.png"
								alt="Valid XHTML 1.0 Strict" height="31" width="88" style="float:left" />
					</a>
					<a href="http://jigsaw.w3.org/css-validator/validator">
						<img 	style="border:0;width:88px;height:31px;float:left"
								src="images/validation/valid-css.png" alt="Valid CSS!" />
					</a>
					This page can be viewed in any standards-compliant browser.<br/>
					Recommended: 
					<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=96065&amp;t=54">Firefox 3.0</a> or 
					<a href="http://www.opera.com">Opera 9</a>.
				</div>
				<div class="filled-box" id="copyright">
					All content on this page, unless stated otherwise, is owned by 
					<a class="mail" title="arancaytar.ilyaran@gmail.com" href="mailto:&quot;Arancaytar Ilyaran&quot; &lt;arancaytar.ilyaran@gmail.com&gt;?subject=Enquiry about Ermarian Network site&amp;body=%0D--%0DSent by ermarian.net contact link">Arancaytar</a>, &copy; 2006-2007, all rights reserved.
					No responsibility is taken for the content of external links, which are marked by <img src="images/external.png" alt="[external marker]" />.
				</div>
			</div>
		</div>
	</div>
</body>
<!-- InstanceEnd --></html>
