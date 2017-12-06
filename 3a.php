<?php

// Day 3: Spiral Memoery.

// Thoughts: if we can count the number of  elements per 'ring' we can use that
// to get a minimum distance or ring distance. We'll still need an offset from
// that but it's a start.

// Ring 1: 1
// Ring 2: 8 = 3^2 - 1 = (1 + 2)^2 - 1
// Ring 3: 14 = 5^2 - 9 = (3 + 2)^2 - (8 + 1) = 
// Ring n: (side_length_eof(ring n-1) + 2) ^ 2 - sum_of(previous squares)

// $ring = array(width => volume);
// 
//  Rings are just odd squares, so so each ring starts at ((nth odd)^2 + 1)
// and goes to ((n+1th odd)^2, e.g. n=2 => 10 to 25 == (3^2)+1 to (5^2).
$rings = [1 => 1, 3 => 8, 5 => 14]; // index = side length; value is ring size;

// ring loop n width = (n*2 + 1) and volume is width^2 - (width - 2)^2

$target = 361527;

$ring = floor(sqrt($target));
$ring = $ring % 2 ? $ring : $ring - 1;
$next_ring = $ring + 2;

$dist_from_ring_start = $target - ($ring * $ring);
$side = floor($dist_from_ring_start / ($next_ring - 1));
$offset = ($dist_from_ring_start - ($side * ($next_ring - 1))) - (($next_ring - 1) / 2);

print "$next_ring $side $offset $dist_from_ring_start\n";

$steps = floor($next_ring / 2) + $offset;
print $steps . " steps\n";
