<?php

/* This converter will convert your Latin letters into an alternate representation belonging to one of the dialects referred to as 'l33t-speak'. This alternate representation relies on letters, numbers and special characters to replace letters by character combinations closely resembling their shape visually.

    

The original purpose of this dialect was to communicate electronically without encryption while foiling attempts to analyze the text for keywords (see Carnivore). Since then this mode of writing became fashionable among adolescent internet users ("wannabe" hackers), and was generally denounced among actual hackers. Nowadays it is almost exclusively used for purposes of parody.
*/

require_once 'net/mime.inc';

$input = isset($_POST['input']) ? $_POST['input'] : '';
$decrypt = isset($_POST['direction']) ? $_POST['direction'] == 'decrypt' : FALSE;

$map = explode("\n", trim(file_get_contents('leet.inc.txt')));

foreach($map as $i=>$line) $map[$i] = explode(' ', trim($line));
foreach($map as $array) {
  $leet[] = $array[0];
  $plain[] = $array[1];
}

if ($decrypt) {
  $output = str_replace($leet, $plain, $input);
  $output = strtolower($output);
}
else {
  $output = strtoupper($input);
  $output = str_replace($plain, $leet, $output);
}

if (!empty($_POST['json'])) {
  mime('json');
  print json_encode($output);
  exit;
}

//mime('xhtml');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Leet-Speak Converter | The Ermarian Network</title>
<!-- InstanceEndEditable --> 
<meta name="author" lang="de" content="Arancaytar Ilyaran" />
<!-- InstanceBeginEditable name="meta" -->
<meta name="description" lang="en" content="This page provides conversion from normal text to a 'l33t' dialect." />
<meta name="keywords" lang="en" content="l33t, leet, l33tsp33k, conversion, convert, arancaytar, ermarian" />
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
<base href="http://ermarian.net" />
<!-- related documents -->
<!-- InstanceBeginEditable name="related" -->
<link rel="prev"  href="services/converters/ascii" />
<link rel="next"  href="services/converters/morse" />
<link rel="contents" href="services/converters" />
<link rel="help" href="about" />
<link rel="alternate" 
      type="application/rss+xml" 
      title="RSS" 
      href="rss.xml" />
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
<script type="text/javascript">

$(document).ready(function() {
    $('form').ajaxForm({
        dataType:"json",
        beforeSubmit:function(data) {
          $('#output').html('<img src="images/ajax-loader" />').show();
          for (i in data) {
            if (data[i].name == 'json') data[i].value = true;
          }
        },
        success:function(json) {
          $('#output').html(json);
        }
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
				<!-- InstanceBeginEditable name="filler" --><!-- InstanceEndEditable -->
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
				<h2><!-- InstanceBeginEditable name="Maintitle" -->Leet-Speak Converter<!-- InstanceEndEditable --></h2>
				<!-- InstanceBeginEditable name="Maintext" -->
    <p class="maintext"><span class="note" title="'Leet' is slang for 'elite'">Leetspeak</span> is an alternate representation of text that replaces letters with numbers and character combinations resembling their shape visually, such as "A" and "4".</p>
    <form action='services/converters/leet' method='post'>
      <input type="hidden" name="json" value="" />
    <p class="maintext">
      <textarea style="float:left" name="input" rows="3" cols="60"><?=htmlentities($input)?></textarea>
      <ul>
        <li><input type="radio" name="direction" value="encrypt" <?=$decrypt ? '' : 'checked="checked"'?>/>Plain text --&gt; Leet</li>
        <li><input type="radio" name="direction" value="decrypt" <?=$decrypt ? 'checked="checked"' : ''?>/>Leet --&gt; Plain text</li>
      </ul>
      <input type="submit" value="Convert" />
    </p>
    <p class="maintext"><div class="codeblock" style="white-space:pre-wrap; <?=$output ? '' : 'display:none'?>" id="output"><?=htmlentities($output)?></div></p>
                <p class="maintext">The original purpose was to foil attempts at keyword-analysis (see <a href="http://www.wikipedia.org/Carnivore_(software)" class="external">Carnivore</a> and <a href="http://www.wikipedia.org/Steganography" class="external">Steganography</a>) while discussing illegal or questionable activities online. 
    Leetspeak soon became fashionable among adolescent internet users ("wannabe" hackers), and was generally derided among actual hackers. Nowadays it is almost exclusively used in parody.</p>

    </form>
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
					<a href="http://www.opera.com">Opera 9.5</a>.
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
