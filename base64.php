<?php
$fp = fopen('php://stdin', 'r');

while($line=fgets($fp))
{

 print base64_decode($line);
}
?>

