<?php
/*
Crossing the bridge, you've barely reached the other side of the stream when a
program comes up to you, clearly in distress. "It's my child process," she says,
"he's gotten lost in an infinite grid!"
 
Fortunately for her, you have plenty of experience with infinite grids.

Unfortunately for you, it's a hex grid.

The hexagons ("hexes") in this grid are aligned such that adjacent hexes can be
found to the north, northeast, southeast, south, southwest, and northwest:

  \ n  /
nw +--+ ne
  /    \
-+      +-
  \    /
sw +--+ se
  / s  \

You have the path the child process took. Starting where he started, you need
to determine the fewest number of steps required to reach him. (A "step" means
to move from the hex you are in to any adjacent hex.)
  
For example:

    ne,ne,ne is 3 steps away.
    ne,ne,sw,sw is 0 steps away (back where you started).
    ne,ne,s,s is 2 steps away (se,se).
    se,sw,se,sw,sw is 3 steps away (s,s,sw).
*/

$input = <<<INPUT
INPUT;

$path = explode(',', $input);

$endpoint = find_endpoint($path);
$dist = shortest_path_length_to_origin($endpoint);
print print_r($dist, 1) . "\n";

// Find the shortest path length from $vect to origin using hex grid.
//         (0, 2)      (2, 2)
//   (-1, 1),   (1, 1), ...
//         (0, 0),     (2, 0)
//  (-1, -1),  (1, -1), ...
//         (0, -2),   (2, -2)
//
// X cannot be incremented independantly of Y.
// Y can only be independantly altered by +/- 2.
// n = y+2
// s = y-2
// ne = x+1; y+1
// nw = x-1; y+1
// se = x+1; y-1
// sw = x-1; y-1
// There's probably a math way of doing this without loops.

function shortest_path_length_to_origin($point) {
  extract($point);
  if (abs($x) == abs($y)) {
    return abs($x);
  }
  $smaller = abs($y) < abs($x) ? abs($y) : abs($x);
  $d1 = abs($x - $y) / 2;
  return $smaller + $d1;
}

function find_endpoint($path) {
  $endpoint = ['x' => 0, 'y' => 0];
  foreach ($path as $dir) {
    switch ($dir) {
    case 'n':
      $endpoint['y'] -= 1;
      break;

    case 's':
      $endpoint['y'] += 1;
      break;

    case 'ne':
      $endpoint['x'] += 1;
      $endpoint['y'] -= 1;
      break;

    case 'nw':
      $endpoint['x'] -= 1;
      break;

    case 'se':
      $endpoint['x'] += 1;
      break;

    case 'sw':
      $endpoint['x'] -= 1;
      $endpoint['y'] += 1;
      break;

    }
  }
  return $endpoint;
}

function cube_distance($a, $b) {
  return (abs(a['x'] - b['x']) + abs(a['y'] - b['y']) + abs(a['z'] - b['z'])) / 2;
}

function axial_to_cube($hex) {
  $x = $hex.q;
  $z = $hex.r;
  $y = -$x - $z;
  return Cube(x, y, z);
}
