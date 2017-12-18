<?php

$input = <<<INPUT
INPUT;

$gen_a_seed = 703;
$gen_b_seed = 516;
// $gen_a_seed = 65;
// $gen_b_seed = 8921;

$gen_a_factor = 16807;
$gen_b_factor = 48271;

$mod = 2147483647;

$max = 5000000;
$pair_count = $total = 0;
$format = '(%1$2d = %1$032b) = (%2$2d = %2$032b)'
        . ' %3$s (%4$2d = %4$032b)' . "\n";

while ($pair_count < $max) {
  if ($pair_count % 1000 == 0) {
    print "{$pair_count}\n";
  }
  if (!isset($gen_a_pair)) {
    $gen_a_seed = ($gen_a_seed * $gen_a_factor) % $mod;
    if ($gen_a_seed % 4 == 0) {
      $gen_a_pair = $gen_a_seed;
    }
  }
  if (!isset($gen_b_pair)) {
    $gen_b_seed = ($gen_b_seed * $gen_b_factor) % $mod;
    if ($gen_b_seed % 8 == 0) {
      $gen_b_pair = $gen_b_seed;
    }
  }
  // print "{$gen_a_seed} {$gen_b_seed}\n";
  // If lowest 16 binary bits match on new seeds, increment total.
  if (isset($gen_a_pair) && isset($gen_b_pair)) {
    $pair_count++;
    if (substr(decbin($gen_a_pair), -16) == substr(decbin($gen_b_pair), -16)) {
      $total++;
    }
    unset($gen_a_pair, $gen_b_pair);
  } 
}
print "total = $total\n";
