<?php

$input = "123123";
// Transform string or digits into array sequence.
$seq = str_split($input);

$seq_length = count($seq);
$offset = $seq_length / 2;
$sum = 0;
for ($current = 0; $current < $seq_length; $current++) {
  $next = $current + $offset;
  if ($next >= $seq_length) {
    $next = $next % $offset;
  }
  if ($seq[$current] == $seq[$next]) {
    $sum += $seq[$current];
  }
}
print $sum . "\n";