<?php

$input =<<<INPUT
120,93,0,90,5,80,129,74,1,165,204,255,254,2,50,113
INPUT;

$modulo = 256;
$ring = make_ring($modulo);
$skip = 0;
$current_position = 0;

// Seems like a job for a ring buffer.
foreach (explode(',', $input) as $moveahead) {
  $subgroup = [];
  // Select subgroup starting at $current_position and of length $moveahead
  for ($i = $current_position; $i < $current_position + $moveahead; $i++) {
    $subgroup[] = $ring[$i % $modulo];
  }
  // reverse subgroup
  $subgroup = array_reverse($subgroup);
  for ($i = $current_position; $i < $current_position + $moveahead; $i++) {
    $ring[$i % $modulo] = $subgroup[$i - $current_position];
  }
  $current_position = ($current_position + $moveahead + $skip) % $modulo;
  $skip++;
  // print "Current Ring condition:\n";
  // print_r($ring);
}
print print_r($ring[0] * $ring[1], 1) . "\n";

function make_ring($mod) {
  $ring = [];
  for ($i = 0; $i < $mod; $i++) {
    $ring[$i] = $i;
  }
  return $ring;
}