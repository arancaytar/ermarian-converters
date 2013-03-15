<?php
require_once 'markov.inc';
require_once 'net/mime.inc';
require_once 'ermarian/template.php';

$_REQUEST += [
  'input' => '',
  'length' => 100,
  'coherence' => 2,
  'json' => FALSE,
];

$input     = substr($_REQUEST['input'], 0, 100000);
$length    = min($_REQUEST['length'], 2000);
$coherence = min($_REQUEST['coherence'], 20);
$output    = '';

if ($input) {
  $relations = w_build_relations($input, $coherence);
  $output = w_generate_text($relations, $length);
}

$input = htmlentities($input);
$output = htmlentities($output);

if ($_REQUEST['json']) {
  mime('json');
  print json_encode(['output' => $output]);
  exit;
}

$page['title'] = 'Markov text generator';
$page['meta']['description'] = 'This page runs an input text through a random word scrambler.';
$page['meta']['keywords'] = array('markov chain', 'neural net', 'artificial intelligence', 'convert');

$page['scripts'] = ['style/jquery', 'style/jquery.form', 'style/ajax'];

$page['content'] = <<<DOC
    <p>This converter will read your input text and build a probability function. This function indicates how likely a certain word follows another given word. It will then randomly generate a text by using this probability function.</p>
    <form action='' method='post'>
      <input type='hidden' name='json' value='' />
      <p><textarea name="input" rows="5" style="width:100%">$input</textarea></p>
      <p>Generate <input type="text" name="length" value="$length" /> words.</p>
      <p>Chain length: <input type="text" name="coherence" value="$coherence" /> words. (Lower = less coherent, higher = less deviation from the input text. Anything above 10 is likely to result in a word-for-word excerpt, depending on input size.)</p>
      <p><input type="submit" value="Generate" /></p>
    </form>

    <h3>Output</h3>
    <div id="output" class="filled-box codeblock" style="white-space:pre-line">$output</div>
DOC;

print theme_page($page);