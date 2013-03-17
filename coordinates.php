<?php

require_once 'ermarian/template.php';
require_once 'net/mime.inc';

$SELF = $_SERVER['SCRIPT_URL'];

function c2p($x, $y) {
  return array(
    pow($x*$x + $y*$y, 0.5),
    atan2($y,$x),
  );
}

function p2c($r, $a, $deg = FALSE) {
  if ($deg) $a *= pi()/180;
  return array(
    $r * cos($a),
    $r * sin($a),
  );
}

function convert($input, $direction) {
  if ($direction == 'c2p' && preg_match('/(?<x>-?(?:\d*\.)?\d+)[,\s]+(?<y>-?(?:\d*\.)?\d+)/u', $input, $args)) {
    $x = c2p($args['x'], $args['y']);
  }
  elseif ($direction == 'p2c' && preg_match('/(?<r>-?(?:\d*\.)?\d+)[,\s]+(?<phi>-?(?:\d*\.)?\d+)(?<deg>°?)/u', $input, $args)) {
    $x = p2c($args['r'], $args['phi'], !empty($args['deg']));
  }
  else return 'Error: format not recognized.';
  return sprintf('%.6f, %.6f', $x[0], $x[1]);
}

$v = [
  'input' => '',
  'output' => '',
  'direction' => 'c2p',
  'json' => FALSE,
];
$v = $_REQUEST + $v;
$v['direction'] = $v['direction'] == 'c2p' ? 'c2p' : 'p2c';

if ($v['input']) {
  $v['output'] = convert($v['input'], $v['direction']);
}

if ($v['json']) {
  mime('json');
  print json_encode($v);
  exit;
}

$input = $v['input'];
$output = $v['output'];
$c2p = $v['direction'] == 'c2p' ? 'checked="1"' : '';
$p2c = $v['direction'] == 'p2c' ? 'checked="1"' : ''	;

$page['meta']['keywords'] = ['polar', 'cartesian', 'coordinates', 'conversion', 'converter'];
$page['scripts'] = ['js/jquery', 'js/jquery.form', 'js/ajax'];
$page['content'] = <<<DOC
<p>This page will convert between polar and cartesian coordinates.</p>
<form action="{$SELF}" method="post" />
  <input type="hidden" name="json" value="" />
  <p>
    <label for="in">Coordinates:</label>
    <input type="text" id="input" name="input" value="{$input}" />
    <input type="submit" id="submit" value="Convert" />
  </p>
  <p>
    <input type="radio" id="c2p" name="direction" value="c2p" {$c2p} /><label for="c2p">Cartesian &rarr; Polar</label>
  </p>
  <p>
  <input type="radio" id="p2c" name="direction" value="p2c" {$p2c} /><label for="c2p">Polar &rarr; Cartesian</label>
  </p>
</form>
<div id="output" class="filled-box codeblock">{$output}</div>
<p>Enter two numbers and pick the conversion direction. Per convention, the format for cartesian coordinates is <strong>x,y</strong>, and the format for polar coordinates is <strong>radius,azimuth</strong>. If appended with &deg;, the azimuth will be interpreted as degrees; it will always be given in radians. The azimuth is counter-clockwise from <code>+x</code>.</p>
DOC;
print theme_page($page);
