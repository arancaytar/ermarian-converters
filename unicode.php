<?php

require_once 'ermarian/template.php';
require_once 'net/mime.inc';
require_once 'unicode.inc';

$v = $_REQUEST + [
  'input' => '',
  'output' => '',
  'submit' => 'Encode',
  'encoding' => 'utf8',
  'format' => 'bin',
  'json' => FALSE,
];

if (!in_array($v['encoding'], ['utf8', 'utf16', 'utf32'])) {
  $v['encoding'] = 'utf8';
}

if (!in_array($v['format'], ['bin', 'oct', 'hex'])) {
  $v['format'] = 'bin';
}

$bases = ['bin' => 2, 'oct' => 8, 'hex' => 16];

if ($v['input']) {
  if ($v['submit'] == 'Encode') {
    $data = parse_raw($v['input']);
    $fn = "encode_{$v['encoding']}";
    $bytes = $fn($data);
    $fn = "generate_{$v['format']}";
    $v['output'] = implode(' ', $fn($bytes));
  }
  else {
    $bytes = parse_bytes($v['input'], $bases[$v['format']]);
    $fn = "decode_{$v['encoding']}";
    $data = $fn($bytes);
    $v['output'] = implode('', generate_entities($data));
  }
}

if ($v['json']) {
  mime('json');
  print json_encode($v);
  exit;
}

$selected = 'selected="selected"';
$c = [
  'encoding' => ['utf8' => '', 'utf16' => '', 'utf32' => ''],
  'format' => ['bin' => '', 'oct' => '', 'hex' => ''],
];
$c['encoding'][$v['encoding']] = $selected;
$c['format'][$v['format']] = $selected;

$page['meta']['keywords'] = ['unicode', 'ascii', 'binary', 'conversion', 'convert', 'converter'];
$page['scripts'] = ['js/jquery', 'js/jquery.form', 'js/ajax'];
$page['content'] = <<<DOC
<p>This tool will convert Unicode text to and from its binary representation.</p>
<form action="{$_SERVER['PHP_SELF']}" method="post">
  <p><textarea name="input" rows="5" style="width:100%">{$v['input']}</textarea></p>
  <fieldset id="options">
    <legend>Options</legend>
    <label for="encoding">Encoding:</label>
    <select name="encoding" id="encoding">
      <option value="utf8" {$c['encoding']['utf8']}>UTF-8</option>
      <option value="utf16" {$c['encoding']['utf16']}>UTF-16</option>
      <option value="utf32" {$c['encoding']['utf32']}>UTF-32 / UCS-4</option>
    </select>
    <label for="format">Representation:</label>
    <select name="format" id="format">
      <option value="bin" {$c['format']['bin']}>Binary</option>
      <option value="oct" {$c['format']['oct']}>Octal</option>
      <option value="hex" {$c['format']['hex']}>Hexadecimal</option>
    </select>
    <input type="hidden" name="json" value="" />
    <input type="submit" name="submit" value="Encode" />
    <input type="submit" name="submit" value="Decode" />
  </fieldset>
</form>
<div id="output" class="filled-box codeblock" style="white-space:pre-wrap">{$v['output']}</div>
DOC;

print theme_page($page);

