<?php

function parse_bytes($input, $base) {
  $chunksizes = [2 => 8, 8 => 3, 16 => 2];
  $chunksize = $chunksizes[$base];
  $values = ['0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4,
             '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
             'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15];
  $buffer = $j = 0;
  $out = [];
  for ($i = 0; $i < strlen($input); $i++) {
    if (isset($values[$input[$i]]) && $values[$input[$i]] < $base) {
      $buffer = $buffer * $base + $values[$input[$i]];
      $j++;
      if ($j >= $chunksize) {
        $out[] = $buffer;
        $buffer = 0;
        $j = 0;
      }
    }
  }
  return $out;
}

function parse_raw($text) {
  $bytes = [];
  for ($i = 0; $i < strlen($text); $i++) {
    $bytes[] = ord($text[$i]);
  }
  return $bytes;
}

function encode_utf8($data) {
  $out = [];
  foreach ($data as $codepoint) {
    if ($codepoint < 0x0080) {
      $out[] = $codepoint;                       # 0b0xxxxxxx
    }
    elseif ($codepoint < 0x0800) {
      $out[] = 0xc0 | ($codepoint >> 6);         # 0b110xxxxx
      $out[] = 0x80 | ($codepoint % 0x40);       # 0b10xxxxxx
    }
    elseif ($codepoint < 0x10000) {
      $out[] = 0xe0 | ($codepoint >> 12);        # 0b1110xxxx
      $out[] = 0x80 | (($codepoint >>  6) % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint % 0x40);       # 0b10xxxxxx
    }
    elseif ($codepoint < 0x20000) {
      $out[] = 0xf0 | ($codepoint >> 18);        # 0b11110xxx
      $out[] = 0x80 | ($codepoint >> 12 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint >>  6 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint % 0x40);       # 0b10xxxxxx
    }
    elseif ($codepoint < 0x4000000) {
      $out[] = 0xf8 | ($codepoint >> 24);        # 0b111110xx
      $out[] = 0x80 | ($codepoint >> 18 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint >> 12 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint >>  6 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint % 0x40);       # 0b10xxxxxx
    }
    else {
      $out[] = 0xfc | ($codepoint >> 30);        # 0b1111110x
      $out[] = 0x80 | ($codepoint >> 24 % 0x40); # 0b10xxxxxx      
      $out[] = 0x80 | ($codepoint >> 18 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint >> 12 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint >>  6 % 0x40); # 0b10xxxxxx
      $out[] = 0x80 | ($codepoint % 0x40);       # 0b10xxxxxx    
    }
  }
  return $out;
}

function decode_utf8($bytes) {
  $data = [];
  $buffer = 0;
  for ($i = 0; $i < count($bytes); $i++) {
    if (($bytes[$i] & 0x80) == 0) {          # 0xxxxxxx ASCII
      $buffer = $bytes[$i];
      $extra = 0;
    }
    elseif (($bytes[$i] & 0xe0) == 0xc0) {   # 110xxxxx
      $buffer = $bytes[$i] & 0x1f;
      $extra = 1;
    }
    elseif (($bytes[$i] & 0xf0) == 0xe0) {   # 1110xxxx
      $buffer = ($bytes[$i] & 0xf);
      $extra = 2;
    }
    elseif (($bytes[$i] & 0xf8) == 0xf0) {   # 11110xxx
      $buffer = ($bytes[$i] & 0x7);
      $extra = 3;
    }
    elseif (($bytes[$i] & 0xfc) == 0xf8) {   # 111110xx
      $buffer = ($bytes[$i] & 0x3);
      $extra = 4;
    }
    else {
      $buffer = ($bytes[$i] & 0x1);          # 1111110x
      $extra = 5;
    }
    for ($j = $i+1; $j <= $i+$extra; $j++) {
      $buffer = $buffer << 6 | ($bytes[$j] & 0x3f);
    }
    $i += $extra;
    $data[] = $buffer;
    $buffer = 0;
  }
  return $data;
}

function encode_utf16($data) {
  $pairs = [];
  foreach ($data as $codepoint) {
    if ($codepoint < 0x10000) {
      $pairs[] = $codepoint;
    }
    else {
      $pairs[] = 0xd800 | (($codepoint - 0x10000) >> 10);
      $pairs[] = 0x03ff | (($codepoint - 0x10000) % 0x400);
    }
  }
  $out = [];
  foreach ($pairs as $pair) {
    $out[] = $pair >> 8;
    $out[] = $pair % 0x100;
  }
  return $out;
}

function decode_utf16($bytes) {
  $buffer = 0;
  $out = [];
  for ($i = 0; $i < count($bytes) - 1; $i+=2) {
    $pair = ($bytes[$i]<<8) | $bytes[$i+1];
    if ($pair < 0xd800 || $pair > 0xe000) {
      if ($buffer) {
        $out[] = $buffer;
      }
      $buffer = 0;
      $out[] = $pair;
    }
    elseif ($pair < 0xdc00) {
      if ($buffer) {
        $out[] = $buffer;
      }
      $buffer = $pair;
    }
    elseif ($buffer) {
      $out[] = ($buffer - 0xd800) << 10 | ($pair - 0xdc00);
    }
    else {
      $out[] = $pair;
    }
  }
  return $out;
}

function encode_utf32($data) {
  $out = [];
  foreach ($data as $codepoint) {
    $out[] = $codepoint >> 24;
    $out[] = $codepoint >> 16 % 0x100;
    $out[] = $codepoint >>  8 % 0x100;
    $out[] = $codepoint % 0x100;
  }
  return $out;
}

function decode_utf32($bytes) {
  $out = [];
  for ($i = 0; $i+3 < count($bytes); $i+=4) {
    $out[] = (($bytes[$i] << 8 | $bytes[$i+1]) << 8 | $bytes[$i+2]) << 8 | $bytes[$i+3];
  }
  return $out;
}

function generate_bin($bytes) {
  $out = [];
  foreach ($bytes as $byte) {
    $out[] = str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
  }
  return $out;
}

function generate_oct($bytes) {
  $out = [];
  foreach ($bytes as $byte) {
    $out[] = str_pad(decoct($byte), 3, '0', STR_PAD_LEFT);
  }
  return $out;
}

function generate_hex($bytes) {
  $out = [''];
  foreach ($bytes as $i => $byte) {
    $out[ceil($i / 2)] = '';
    $out[floor($i / 2)] .= str_pad(dechex($byte), 2, '0', STR_PAD_LEFT);
  }
  return $out;
}

function generate_entities($data) {
  $out = [];
  foreach ($data as $codepoint) {
    $out[] = '&#' . $codepoint . ';';
  }
  return $out;
}

