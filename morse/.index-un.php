<?php
function is_morse($string) {
	return preg_match('/^[\-\. \/]*$/',$string);
}

function morse_to_alpha($input) {
	$alphabet=file("alphabet.txt");
	foreach($alphabet as $line) {
		$line = explode("|",rtrim($line));
		$to_morse[$line[0]]=$line[1];
		$from_morse[$line[1]]=$line[0];
		//var_dump($to_morse);
	}
	$codes = explode(" ",$input);
	foreach ($codes as $code) {
		if (!$from_morse[$code]) return "Invalid: $code";
		$output.=$from_morse[$code];
	}
	return strtolower($output);
}

function alpha_to_morse($input) {
	$alphabet=file("alphabet.txt");
	foreach($alphabet as $line) {
		$line = explode("|",rtrim($line));
		$to_morse[$line[0]]=$line[1];
		$from_morse[$line[1]]=$line[0];
		//var_dump($to_morse);
	}
	$input = strtoupper($input);
	//$input = preg_replace('/[^A-Z0-9]*/','',$input);
	///var_dump($input);
	for ($i=0;$i<strlen($input);$i++) {
		//var_dump($input[$i]);
		if (!$to_morse[$input[$i]]) return "Invalid: ".$input[$i];
		//else var_dump($to_morse[$input[$i]]);
		$output.=$to_morse[$input[$i]]." ";
	}
	return $output;
}

if ($input=trim($_GET['input'])) {
	if (is_morse($input)) $output=morse_to_alpha($input);
	else  $output=alpha_to_morse($input);
}


if ($_GET['auto']) {
	//if (is_morse($input)) $type="M: ";
	//else $type="L: ";
	header("Content-type: text/plain");
	print "[\"$input\", [\"$type$output\"]]";
	exit;

}
?><<??>?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Morse Converter | The Ermarian Network</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<base href="http://ermarian.net/"/>
<!-- related documents -->

<link rel="Start" href="/" />
<link rel="Contents" href="scripts" />
<link rel="Help" href="about.html" />
<link rel="stylesheet" 
      type="text/css" 
      media="screen" 
      href="style/default.css" />
<link rel="search" type="application/opensearchdescription+xml" title="Morse Convert" href="scripts/morse/morse.xml" />
<link rel="shortcut icon" type="image/bmp" href="data:image/bmp;base64,Qk32AAAAAAAAAHYAAAAoAAAAEAAAABAAAAABAAQAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAgAAAAICAAIAAAACAAIAAgIAAAICAgADAwMAAAAD%2FAAD%2FAAAA%2F%2F8A%2FwAAAP8A%2FwD%2F%2FwAA%2F%2F%2F%2FAAAAAAAAAAAAC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwCwC7u7u7u7ALALu7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7sAAAALsAu7uwAAAAuwC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7u7u7u7sAAAAAAAAAAA" />
</head>

<body>
	<div id="content">
		<div class="filled-box" id="title">
			<h1>The Ermarian Network</h1>
		</div>
		<div class="filled-box" id="navside">
			<h2 class="navside">Navigation</h2>	
			<ul>
			  
			  <li><a href=".">Main</a></li>
			  
			  <li><a href="about">About 
        me </a></li>
			  
			  <li><a class="external" href="http://arancaytar.ermarian.net">Blog</a></li>
			  
			  <li><a href="sites">Sites</a></li>
			  <li><!-- InstanceBeginEditable name="NavItemLink" --><a href="services">Services</a>
			  <ul class="secondary">
			    <li><strong>Morse Converter</strong></li>
			    <li><a href="services/converters/ascii">ASCII Converter</a></li>
			    <li><a href="services/search/http">HTTP Codes</a></li>
			    <li><a href="services/file-hosting">File Hosting</a></li>
			    <li><a href="services/jabber">Jabber</a></li>
			  </ul>
			  <!-- InstanceEndEditable --></li> 
			  <li><a href="links">Links</a></li>
			  
			  <li><a href="newsletter">Newsletter</a></li>
 
			</ul>

			<div class="filler">

			</div>

		</div>
		<div id="main">
			<div id="main2">
			<h2>Morse Converter</h2>
      <p class="maintext"> You may enter a morse code to convert here, or an alphanumeric 
        string to convert to morse. </p>
      <form action='services/converters/morse' method='get'>
      <p class="maintext" style="text-align:center"> 
        <input type="text" size="30" name="input" value="<?=$_GET['input']?>" />
        <input type="submit" value="Convert" />
      </p></form>
<p class="maintext">The resulting string is: <br/>
  <textarea rows="3" cols="30" onclick="this.select()" readonly="readonly"><?=$output?></textarea>
</p>
<p class="maintext">You can also add this to your Firefox search box! Auto-completion ensures as-you-type translation!</p>
	
			</div>
		</div>
		<p><em>Morse Converter was made by <a href="mailto:arancaytar.ilyaran@gmail.com">Arancaytar</a> 
on the <a href="/">Ermarian Network</a></em>. </p>
	</div>
	

<div class="filled-box" id="footer">
		<a href="http://validator.w3.org/check?uri=referer">
			<img 	src="http://stuff.ermarian.net/arancaytar/images/buttons/valid-xhtml10.png"
					alt="Valid XHTML 1.0 Strict" height="31" width="88" style="float:left" />
		</a>
		<a href="http://jigsaw.w3.org/css-validator/validator">
			<img 	style="border:0;width:88px;height:31px;float:left"
					src="http://stuff.ermarian.net/arancaytar/images/buttons/valid-css.png" alt="Valid CSS!" />
		</a>
		This page can be viewed in any standards-compliant browser.<br/>
		Recommended: 
		<a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=96065&amp;t=54">Firefox 2</a> or 
		<a href="http://www.opera.com">Opera 9</a>.
	</div>
</body>
</html>
