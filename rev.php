<?php

$in = fopen('php://stdin', 'r');
while (!feof($in)) {
  print strrev(rtrim(fgets($in), "\n")) . "\n";
}
fclose($in);
