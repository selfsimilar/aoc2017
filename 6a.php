<?php

$input = <<< INPUT
2	8	8	5	4	2	3	1	5	5	1	2	15	13	5	14
INPUT;

$banks = explode("\t", $input);
$next = $input;
$seen = [];
$i = 0;

do {
  $i++;
  $seen[] = $next;
  // find larget bank
  $largest = get_largest($next);
  // reallocate
  $next = reallocate(explode("\t", $next), $largest);
  // evaluate if seen before
}
while (!in_array($next, $seen));

print_r($seen);
print "loop length $i\n";
$start = array_search($next, $seen);
$length = count($seen) - $start;
print "loop length $length\n";

function get_largest($banks) {
  $array = explode("\t", $banks);
  $largest = 0;
  foreach ($array as $k => $v) {
    if ($v > $largest) {
      $largest = $v;
      $largest_index = $k;
    }
  }
  return $largest_index;
}

function reallocate($banks, $index) {
  $size = count($banks);
  $amount = $banks[$index];
  $banks[$index] = 0;
  for ($x = $amount; $x > 0; $x--) {
    $banks[($index + $x) % $size]++;
  }
  return implode("\t", $banks);
}
