<?php 

function char_frequencies($text) {
  $characters = array();
  foreach (str_split($text) as $char) {
    $characters[$char] = isset($characters[$char]) ? $characters[$char] + 1 : 1;
  }
  return $characters;
}

function generate_tree($queue) {
  asort($queue);
  $tree = array();
  foreach ($queue as $character => $probability) {
    $tree[] = array('#value' => $character, '#probability' => $probability);
  }
  
  while (count($tree) > 1) {
    $a = array_shift($tree);
    $b = array_shift($tree);
    $tree[] = array('#children' => array($a, $b), '#probability' => $a['#probability'] + $b['#probability']);
    uasort($tree, 'tree_cmp');
  }
  return current($tree);
}

function generate_codes($tree, &$codebook, $prefix = '') {
  if (isset($tree['#value'])) $codebook[$tree['#value']] = $prefix;
  else {
    generate_codes($tree['#children'][0], $codebook, "{$prefix}0");
    generate_codes($tree['#children'][1], $codebook, "{$prefix}1");
  }
}

function tree_cmp($a, $b) {
  if ($a['#probability'] == $b['#probability']) {
    return 0;
  }
  return ($a['#probability'] < $b['#probability']) ? -1 : 1;
}

$text = "This is a rather normal text. Please compress it.";
$queue = char_frequencies($text);
var_dump($queue);
$tree = generate_tree($queue);
var_dump($tree);
$codebook = array();
generate_codes($tree, $codebook);
var_dump($codebook);
var_dump(str_replace(array_keys($codebook), $codebook, $text));

