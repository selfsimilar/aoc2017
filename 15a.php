<?php

$input = <<<INPUT
INPUT;

$gen_a_seed = 703;
$gen_b_seed = 516;

$gen_a_factor = 16807;
$gen_b_factor = 48271;

$mod = 2147483647;

$max = 40000000;
$total = 0;
$format = '(%1$2d = %1$032b) = (%2$2d = %2$032b)'
        . ' %3$s (%4$2d = %4$032b)' . "\n";

for ($i = 0; $i < $max; $i++) {
  if ($i % 1000 == 0) {
    print "{$i}\n";
  }
  $gen_a_seed = ($gen_a_seed * $gen_a_factor) % $mod;
  $gen_b_seed = ($gen_b_seed * $gen_b_factor) % $mod;
  // print "{$gen_a_seed} {$gen_b_seed}\n";
  // If lowest 16 binary bits match on new seeds, increment total.
  if (substr(decbin($gen_a_seed), -16) == substr(decbin($gen_b_seed), -16)) {
    $total++;
  }
}
print "total = $total\n";
