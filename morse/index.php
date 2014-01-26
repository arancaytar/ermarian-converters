<?php

require_once 'ermarian/template.php';
require_once 'net/mime.inc';
require_once 'parsers/morse.inc';

function is_morse($string) {
	return preg_match('/^[\-\. \/]*$/', $string);
}

$input = $output = '';

$v = $_REQUEST + [
  'input' => '',
  'json' => FALSE,
  'auto' => FALSE,
];

if ($v['input']) {
  $input = trim($v['input']);
	if (is_morse($input)) $output = morse_decode($input);
	else $output = morse_encode($input);
}

if ($v['json']) {
	mime('json');
	print json_encode(array('output' => $output));
	exit;
}
if ($v['auto']) {
  mime('json');
  print json_encode(array($v['input'], [$output]));
  exit;
}

$page['meta']['keywords'] = ['morse', 'code', 'morse code', 'converter', 'encoder', 'conversion', 'convert'];
$page['meta']['extra'] = <<<DOC
<link rel="search" type="application/opensearchdescription+xml" title="Morse Convert" href="services/converters/morse/morse" />
<link rel="shortcut icon" type="image/bmp" href="data:image/bmp;base64,Qk32AAAAAAAAAHYAAAAoAAAAEAAAABAAAAABAAQAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAgAAAAICAAIAAAACAAIAAgIAAAICAgADAwMAAAAD%2FAAD%2FAAAA%2F%2F8A%2FwAAAP8A%2FwD%2F%2FwAA%2F%2F%2F%2FAAAAAAAAAAAAC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwCwC7u7u7u7ALALu7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7sAAAALsAu7uwAAAAuwC7u7u7u7u7ALu7u7u7u7sAu7u7u7u7uwC7u7u7u7u7ALu7u7u7u7sAAAAAAAAAAA" />
DOC;
$page['scripts'] = ['js/jquery', 'js/jquery.form', 'js/ajax'];
$page['content'] = <<<DOC
  <p>You may enter a morse code to convert here, or a normal text to convert to
  morse. Format: <code>"."</code> for short, <code>"-"</code> for long, any
  amount of white space between letters, and <code>"/"</code> between words.</p>
  <p>This tool supports OpenSearch, and provides autocompletion.</p>
  <form action="{$_SERVER['PHP_SELF']}" method="post">
    <input type="hidden" name="json" value="0" />
    <p style="text-align:center; vertical-align:middle">
      <input id="input" type="text" name="input" size="80" value="{$input}" />
      <input type="submit" value="Convert" style="vertical-align:middle" />
    </p>
  </form>
  <h3>Output</h3>
  <div id="output" class="filled-box codeblock" style="white-space:normal">{$output}</div>
DOC;

print theme_page($page);
