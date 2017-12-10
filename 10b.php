<?php

$input = '120,93,0,90,5,80,129,74,1,165,204,255,254,2,50,113';

// print array_reduce([65, 27, 9, 1, 4, 3, 40, 50, 91, 7, 6, 0, 2, 5, 68, 22], 'fxor');
print knot_hash('') . "\n";
print knot_hash('AoC 2017') . "\n";
print knot_hash('1,2,3') . "\n";
print knot_hash('1,2,4') . "\n";
print knot_hash($input) . "\n";

$modulo = 256;
$sparse_hash = make_ring($modulo);
$dense_hash = compact_hash($sparse_hash);

function knot_hash($input) {
  $modulo = 256;
  $sparse_hash = make_ring($modulo);
  $skip = 0;
  $current_position = 0;

  for ($round = 0; $round < 64; $round++) {
    knot_hash_round($input, $current_position, $skip, $sparse_hash);
  }
  $dense_hash = compact_hash($sparse_hash);
  // Convert to hex string.
  $out = '';
  foreach ($dense_hash as $char) {
    $out .= substr('0' . dechex($char), -2);
  }
  return $out;
}

function knot_hash_round(&$in, &$cp, &$skp, &$ring) {
  $modulo = count($ring);
  $ord = array_map('ord', str_split($in));
  $suffix = [17, 31, 73, 47, 23];
  foreach (array_merge($ord, $suffix) as $moveahead) {
    $subgroup = [];
    // Select subgroup starting at $cp and of length $moveahead
    for ($i = $cp; $i < $cp + $moveahead; $i++) {
      $subgroup[] = $ring[$i % $modulo];
    }
    // reverse subgroup
    $subgroup = array_reverse($subgroup);
    for ($i = $cp; $i < $cp + $moveahead; $i++) {
      $ring[$i % $modulo] = $subgroup[$i - $cp];
    }
    $cp = ($cp + $moveahead + $skp) % $modulo;
    $skp++;
    // print "Current Ring condition:\n";
    // print_r($ring);
  }
}

function make_ring($mod) {
  $ring = [];
  for ($i = 0; $i < $mod; $i++) {
    $ring[$i] = $i;
  }
  return $ring;
}

function compact_hash($sparse_hash) {
  $dense_hash = [];
  for ($i = 0; $i < 16; $i++) {
    $sub = array_slice($sparse_hash, $i * 16, 16);
    $dense_hash[$i] = array_reduce($sub, 'fxor');
  }
  return $dense_hash;
}

function fxor($carry, $item) {
  return $carry ^ $item;
}