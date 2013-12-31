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

function p2c($r, $a) {
  return array(
    $r * cos($a),
    $r * sin($a),
  );
}

function convert($input, $direction, $v) {
  $shift = (($v['o2'] == 'y') * 0.5) + ($v['o1'] == 'minus');
  if ($direction == 'c2p' && preg_match('/^(?<x>-?(?:\d*\.)?\d+)[,\s]+(?<y>-?(?:\d*\.)?\d+)$/u', $input, $args)) {
    $x = c2p($args['x'], $args['y']);
    $x[1] = fmod(180/pi() * ($x[1] - $shift*pi()), 360) * pi()/180;
    if ($v['azimuth'] == 'cw') $x[1] = 2*pi() - $x[1]; // reverse azimuth
  }
  elseif ($direction == 'p2c' && preg_match('/^(?<r>-?(?:\d*\.)?\d+)[,\s]+(?<theta>-?(?:\d*\.)?\d+)(?<deg>°?)$/u', $input, $args)) {
    if ($args['deg']) {
      $args['theta'] *= pi() / 180;
      if ($v['azimuth'] == 'cw') $x[1] = 2*pi() - $x[1]; // reverse azimuth
      $args['theta'] = fmod(180/pi() * ($args['theta'] + $shift*pi()), 360) * pi()/180;
    }
    $x = p2c($args['r'], $args['theta']);
  }
  else return 'Error: format not recognized.';
  return sprintf('%.6f, %.6f', $x[0], $x[1]);
}

$v = $_REQUEST + [
  'input' => '',
  'output' => '',
  'op' => 'c2p',
  'json' => FALSE,
  'azimuth' => 'ccw',
  'o1' => 'plus',
  'o2' => 'x',
];
$v['op'] = $v['op'] == 'c2p' ? 'c2p' : 'p2c';

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
$ccw = $v['azimuth'] == 'ccw' ? 'checked="checked"' : '';
$cw = $v['azimuth'] == 'cw' ? 'checked="checked"' : ''	;
$o1plus = $v['o1'] == 'plus' ? 'checked="checked"' : '';
$o1minus = $v['o1'] == 'minus' ? 'checked="checked"' : ''	;
$o2x = $v['o2'] == 'x' ? 'checked="checked"' : '';
$o2y = $v['o2'] == 'y' ? 'checked="checked"' : ''	;


$page['meta']['keywords'] = ['polar', 'cartesian', 'coordinates', 'conversion', 'converter'];
$page['scripts'] = ['js/jquery', 'js/jquery.form', 'js/ajax'];

$page['content'] = <<<DOC
<p>This page will convert between polar and cartesian coordinates.</p>
<form action="{$SELF}" method="post">
  <p>
    <input type="hidden" name="json" value="" />
    <label for="input">Coordinates:</label>
    <input type="text" id="input" name="input" value="{$input}" />
    <button type="submit" name="op" value="c2p">Cartesian &rarr; Polar</button>
    <button type="submit" name="op" value="p2c">Polar &rarr; Cartesian</button>
  </p>
  <div id="output" class="filled-box codeblock">{$output}</div>
  <fieldset id="phi">
    <legend>Azimuth</legend>
    +θ is:<br />
    <input type="radio" id="cw" name="azimuth" value="cw" {$cw} />
    <label for="ccw">clockwise</label>
    <br />
    <input type="radio" id="ccw" name="azimuth" value="ccw" {$ccw} />
    <label for="ccw">counterclockwise</label>
  </fieldset>
  <fieldset id="orientation">
    <legend>Orientation</legend>
    <table style="border:none;background:none;">
      <caption>θ = 0° is:</caption>
      <tr>
        <td>
          <input type="radio" id="o1plus" name="o1" value="plus" {$o1plus} />
          <label for="o1plus">+</label>
        </td>
        <td>
          <input type="radio" id="o2x" name="o2" value="x" {$o2x} />
          <label for="o2x">x</label>
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" id="o1minus" name="o1" value="minus" {$o1minus} />
          <label for="o1minus">-</label>
        </td>
        <td>
          <input type="radio" id="o2y" name="o2" value="y" {$o2y} />
          <label for="o2y">y</label>
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<p>Enter two numbers and pick the conversion direction. Per convention, the format for cartesian coordinates is <strong>x,y</strong>, and the format for polar coordinates is <strong>radius,azimuth</strong>. If appended with &deg;, the azimuth will be interpreted as degrees; it will always be given in radians. The azimuth is counter-clockwise from <code>+x</code>.</p>
DOC;
print theme_page($page);
