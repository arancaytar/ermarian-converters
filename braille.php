<?php

$square = 
" OO O   O O  O  O  OO O 
 OO  O OO  O O  O      O
    O  O     O  O  O    
  O O  O   O  O  O O  O 
 OO OO    OO O  O   O  O
  O       O     O       ";

$in = fopen('php://stdin', 'r');
$input = '';
while (!feof($in)) {
  $input .= fgets($in);
}
braille_decode($input);

function braille_decode($square) {
  $codebook = file('braille.inc.txt');
  foreach ($codebook as $line) {
    $line = explode(":", rtrim($line));
    $index[$line[1]] = $line[0];
  }
  $codes = braille_parse($square);
  foreach ($codes as $line) {
    foreach ($line as $code) print isset($index[$code]) ? $index[$code] : '_';
    print "\n";
  }
}

function braille_parse($square) {
  $lines = explode("\n", trim($square, "\n\r"));
  $cells = array();
  $width = 0;
  foreach ($lines as $line) {
    $width = max($width, strlen($line));
  }
  $width = ceil($width / 2);
  $height = ceil(count($lines) / 3);
  
  foreach ($lines as $line) {
    $line = str_pad($line, $width * 2, ' ', STR_PAD_RIGHT);
    $cells[] = str_split($line);
  }
  while (count($cells) < $height * 3) $cells[] = array_fill(0, $width * 2, ' ');
  
  $map = array();
  
  foreach ($cells as $i => $row) {
    foreach ($row as $j => $cell) {
      $map[$i][$j] = $cell == 'O' ? 1 : 0;
    }
  }
  
  $codes = array_fill(0, $height, array_fill(0, $width, ''));
  //var_dump($map);
  foreach ($codes as $i => $row) {
    foreach ($row as $j => $code) {
      $y = 3*$i;
      $x = 2*$j;
      //var_dump($i, $j);
      $codes[$i][$j] = $map[$y][$x] . $map[$y][$x+1] . $map[$y+1][$x] . $map[$y+1][$x+1] . $map[$y+2][$x] . $map[$y+2][$x+1];
    }
  }
  
  return $codes;
}
