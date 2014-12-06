<?php

require_once 'ermarian/template.php';
require_once 'net/mime.inc';

function c2p($x, $y) {
  return [pow($x*$x + $y*$y, 0.5), atan2($y,$x)];
}

function p2c($r, $a) {
  return [$r * cos($a), $r * sin($a)];
}

function convert($input, $direction, $v) {
  $shift = ['e' => 0, 's' => 0.5, 'w' => 1, 'n' => 1.5];
  $shift = $shift[$v['azimuth-origin']];
  $shift *= pi();
  if ($direction == 'c2p' && preg_match('/^(?<x>-?(?:\d*\.)?\d+)[^\d]+?(?<y>-?(?:\d*\.)?\d+)$/u', $input, $args)) {
    $x = c2p($args['x'], $args['y']);
    $x[1] -= $shift;
    if ($v['azimuth-direction'] == 'cw') $x[1] *= -1;
    $x[1] = fmod(fmod($x[1], 2*pi()) + 2*pi(), 2*pi());
    if ($x[1] > pi()) $x[1] -= 2*pi();
  }
  elseif ($direction == 'p2c' && preg_match('/^(?<r>(?:\d*\.)?\d+)[^\d]+?(?<theta>-?(?:\d*\.)?\d+)(?<deg>°?)$/u', $input, $args)) {
    if ($args['deg']) {
      $args['theta'] *= pi() / 180;
    }
    $args['theta'] = fmod(180/pi() * ($args['theta'] + $shift), 360) * pi()/180;
    if ($v['azimuth-direction'] == 'cw') $args['theta'] *= -1; // reverse azimuth
    $x = p2c($args['r'], $args['theta']);
  }
  else return 'Error: format not recognized.';
  return sprintf('%.6f, %.6f', $x[0], $x[1]);
}

$defaults = [
  'input' => '',
  'output' => '',
  'op' => 'c2p',
  'json' => FALSE,
  'azimuth-direction' => 'ccw',
  'azimuth-origin' => 'e',
];

$v = $_REQUEST + $defaults;

if (!in_array($v['azimuth-direction'], ['cw', 'ccw']))
  unset($v['azimuth-direction']);
if (!in_array($v['azimuth-origin'], ['n', 'e', 's', 'w']))
  unset($v['azimuth-origin']);
$v += $defaults;


if ($v['input']) {
  $v['output'] = convert(trim($v['input']), $v['op'], $v);
}

if ($v['json']) {
  mime('json');
  print json_encode($v);
  exit;
}

$input = $v['input'];
$output = $v['output'];
$selected = 'selected="selected"';
$cw = $ccw = $n = $e = $s = $w = '';
${$v['azimuth-direction']} = ${$v['azimuth-origin']} = $selected;


$page['meta']['keywords'] = ['polar', 'cartesian', 'coordinates', 'conversion', 'converter'];
$page['scripts'] = ['js/jquery', 'js/jquery.form', 'js/ajax'];

$page['content'] = <<<DOC
<p>This page will convert between polar and cartesian coordinates.</p>
<form action="{$_SERVER['PHP_SELF']}" method="post">
  <p>
    <input type="hidden" name="json" value="" />
    <label for="input">Coordinates:</label>
    <input type="text" id="input" name="input" value="{$input}" />
    <button type="submit" name="op" value="c2p">Cartesian &rarr; Polar</button>
    <button type="submit" name="op" value="p2c">Polar &rarr; Cartesian</button>
  </p>
  <div id="output" class="filled-box codeblock">{$output}</div>
  <fieldset id="azimuth">
    <legend>Azimuth</legend>
    <label for="azimuth-direction">Azimuth increases</label>
    <select id="azimuth-direction" name="azimuth-direction">
      <option value="cw" {$cw}>clockwise</option>
      <option value="ccw" {$ccw}>counterclockwise</option>
    </select>
    <label for="azimuth-origin">from this axis: </label>
    <select id="azimuth-origin" name="azimuth-origin">
      <option value="n" {$n}>North (+y)</option>
      <option value="e" {$e}>East (+x)</option>
      <option value="s" {$s}>South (-y)</option>
      <option value="w" {$w}>West (-x)</option>
    </select>
  </fieldset>
</form>
<p>Enter two numbers and pick the conversion direction. Per convention, the format for cartesian coordinates is <strong>x,y</strong>, and the format for polar coordinates is <strong>radius,azimuth</strong>. If appended with &deg;, the azimuth will be interpreted as degrees; it will always be given in radians.</p>
DOC;
print theme_page($page);
