<?php
	define('ENCRYPT',1);
	define('DECRYPT',-1);
	
	if ($_POST['submit']=='Encrypt')
	{
		$clear=$_POST['clear'];
		$key=$_POST['key'];
		$cipher=vigenere($clear,$key,ENCRYPT);
	}
	else if ($_POST['submit']=='Decrypt') 
	{
		$cipher=$_POST['cipher'];
		$key=$_POST['key'];
		$clear=vigenere($cipher,$key,DECRYPT);
	}
	
	function vigenere($text,$key,$direction)
	{
		$cipher="";
		for ($i=0;$i<strlen($text);$i++)
		{
			$value=(char($text[$i])+char($key[$i % strlen($key)])) % 26;
			$cipher.=text($value);
		}
		return $cipher;
	}
	
	function char($character)
	{
		$number=ord(strtolower($character));
		if ($number>=97 && $number<=122) return $number-97;
	}
	
	function text($number)
	{
		if ($number>=97 && $number<=122) return chr($number+97);
	}
	
?><?='<?xml version="1.0" encoding="iso-8859-1"?>'?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Vigen&egrave;re | The Ermarian Network</title>
<!-- InstanceEndEditable --> 
<meta name="author" lang="de" content="Arancaytar Ilyaran" />
<!-- InstanceBeginEditable name="meta" -->
<meta name="Description" content="The Vigen&egrave;re cipher is a polyalphabetic substitution that uses a seed keyword. This page will encrypt and decrypt texts if given a keyword." lang="en" xml:lang="en" />
<meta name="Keywords" content="ermarian, arancaytar" lang="en" xml:lang="en" />
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
			  <!-- InstanceEndRepeatEntry --><!-- InstanceEndRepeat --> 
			</ul>

			<div class="filler">
				<!-- InstanceBeginEditable name="filler" -->
				<!-- InstanceEndEditable -->
			</div>

		</div>
		<div id="main">
			<div id="main2">
				<h2><!-- InstanceBeginEditable name="Maintitle" -->Vigen&egrave;re<!-- InstanceEndEditable --></h2>
				<!-- InstanceBeginEditable name="Maintext" -->
				
      <p class="maintext">The <a href="http://en.wikipedia.org/wiki/Vigen&egrave;re cipher" class="external">Vigen&egrave;re 
        cipher</a> is a polyalphabetic substitution cipher that uses a "seed" 
        keyword to encrypt a text. This page will encode or decode a text for 
        you, given the clear text and a keyword. As a keyword, you can also enter 
        a One Time Pad, which will make the cipher text unbreakable as long as 
        the Pad remains secret.</p>
      <form action='services/encryption/vigenere' method='post'>
					<p><strong>Clear text</strong></p>
					<p><textarea cols="60" rows="8" name="clear"><?=$clear?></textarea></p>
					<p><input type="submit" name="submit" value="Encrypt" /><input type="submit" name="submit" value="Decrypt" />
					<label>Key: </label><input type="text" name="key" value="<?=$key?>"/></p>
					<p><strong>Cypher text</strong></p>
					<p><textarea cols="60" rows="8" name="cypher"><?=$cypher?></textarea></p>					
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
