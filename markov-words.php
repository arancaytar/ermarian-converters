<?php
require_once 'markov.php';
require_once 'ermarian/template.php';
require_once 'template/navigation.inc';

$_POST += array(
  'input' => '',
  'length' => 100,
  'coherence' => 2,
);

$input     = $_POST['input'];
$length    = min(2000, $_POST['length']);
$coherence = min(10, $_POST['coherence']);
$output    = '';

if ($input) {
  $relations = w_build_relations($input, $coherence);
#  $profile = tabulate_profile($relations);
  $output = w_generate_text($relations, $length);
}

$page['title'] = 'Markov text generator';
$page['navigation'] = theme_navigation(navigation_tree());
$page['meta']['description'] = 'This page runs an input text through a random word scrambler.';
$page['meta']['keywords'] = array('markov chain', 'neural net', 'artificial intelligence', 'convert');

$page['content'] = <<<DOC

  <p class="maintext">This converter will read your input text and build a probability function. This function indicates how likely a certain word follows another given word. It will then randomly generate a text by using this probability function.</p>

  <form action='' method='post'>

    <p class="maintext">
      <textarea name="input" rows="10" cols="60">$input</textarea>
    </p>
    
    <p>Give me <input type="text" name="length" value="$length" /> words.</p>
    <p>Chain length: <input type="text" name="coherence" value="$coherence" /> words. (Lower = less coherent, higher = less deviation from the input text. Anything above 10 is likely to result in a word-for-word excerpt, depending on input size.)</p>
    <p class="maintext"><input type="submit" value="Yank that Markov chain" /></p>
  </form>

  <h3>Output</h3>
  <p class="maintext"><textarea rows="10" cols="60">$output</textarea></p>
DOC;

print theme_page($page);