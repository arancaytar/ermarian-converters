<?php
require_once("markov.php");
$_POST['input'] = substr($_POST['input'], 0, 100000); // 100k and that's it.
$input = $_POST['input'];
$length = $_POST['length'];
$coherence = $_POST['coherence'];

if ($words > 2000) $words = 2000; // don't crash my server.
if ($coherence > 20) $coherence = 20; // "

if ($input) {
  if (!$length) $length = 100;
  if (!$coherence) $coherence = 2;
  $relations = l_build_relations($input, $coherence);
  $profile = tabulate_profile($relations);
  $output = l_generate_text($profile, $length);
}

?>
<?php require_once("content-type.php") ?>
<?='<?xml version="1.0" encoding="iso-8859-1"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Markov Letters | The Ermarian Network</title>
<!-- InstanceEndEditable --> 
<meta name="author" lang="de" content="Arancaytar Ilyaran" />
<!-- InstanceBeginEditable name="meta" -->
<meta name="description" lang="en" content="This page runs the Perl script 'travesty' on your text." />
<meta name="keywords" lang="en" content="markov chain, neural net, artificial intelligence, convert, arancaytar, ermarian" />
<!-- InstanceEndEditable -->
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
<base href="http://ermarian.net" />
<!-- related documents -->
<!-- InstanceBeginEditable name="related" -->
<link rel="prev"  href="" />
<link rel="next"  href="" />
<link rel="contents" href="services" />
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
<!-- InstanceBeginEditable name="stylesheets" --><!-- InstanceEndEditable -->
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
				<h2><!-- InstanceBeginEditable name="Maintitle" -->Markov Letters<!-- InstanceEndEditable --></h2>
				<!-- InstanceBeginEditable name="Maintext" --> 
    <p class="maintext">This page will process your input texts and, using statistics and random numbers, will generate a string of output with letters that are approximately pronouncable.</p>
    <form action='' method='post'>
    <p class="maintext"><textarea name="input" rows="10" cols="60"><?=htmlentities($_POST['input'])?></textarea></p>
    <p>Gimme <input type="text" name="length" value="<?=$length?>" /> characters.</p>
    <p>Chain length: <input type="text" name="coherence" value="<?=$coherence?>" /> characters. (Lower = less coherent, higher = less deviation from the input text. Anything above 10 is likely to result in a word-for-word excerpt, depending on input size.)</p>
    <p class="maintext"><input type="submit" value="Yank that Markov chain" /></p>
    <h3>Output</h3>
    <p class="maintext"><textarea rows="10" cols="60"><?=htmlentities($output)?></textarea></p>
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
