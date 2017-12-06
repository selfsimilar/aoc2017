<?php

/**
--- Day 3: Spiral Memory ---

You come across an experimental new kind of memory stored on an infinite two-dimensional grid.

Each square on the grid is allocated in a spiral pattern starting at a location marked 1 and then counting up while spiraling outward. For example, the first few squares are allocated like this:

17  16  15  14  13
18   5   4   3  12
19   6   1   2  11
20   7   8   9  10
21  22  23---> ...

While this is very space-efficient (no squares are skipped), requested data must be carried back to square 1 (the location of the only access port for this memory system) by programs that can only move up, down, left, or right. They always take the shortest path: the Manhattan Distance between the location of the data and square 1.

For example:

    Data from square 1 is carried 0 steps, since it's at the access port.
    Data from square 12 is carried 3 steps, such as: down, left, left.
    Data from square 23 is carried only 2 steps: up twice.
    Data from square 1024 must be carried 31 steps.

How many steps are required to carry the data from the square identified in your puzzle input all the way to the access port?

Your puzzle answer was 326.

The first half of this puzzle is complete! It provides one gold star: *
--- Part Two ---

As a stress test on the system, the programs here clear the grid and then store the value 1 in square 1. Then, in the same allocation order as shown above, they store the sum of the values in all adjacent squares, including diagonals.

So, the first few squares' values are chosen as follows:

    Square 1 starts with the value 1.
    Square 2 has only one adjacent filled square (with value 1), so it also stores 1.
    Square 3 has both of the above squares as neighbors and stores the sum of their values, 2.
    Square 4 has all three of the aforementioned squares as neighbors and stores the sum of their values, 4.
    Square 5 only has the first and fourth squares as neighbors, so it gets the value 5.

Once a square is written, its value does not change. Therefore, the first few squares would receive the following values:

147  142  133  122   59
304    5    4    2   57
330   10    1    1   54
351   11   23   25   26
362  747  806--->   ...

What is the first value written that is larger than your puzzle input?

Your puzzle input is still 361527.
*/

// As a 'fib triangle' values look like
// 1
// 1 2 4 5 10 11 23 25
// 26 54 57 59 122 133 142 147 304 330 351 362 747 806 880 931

// row(2) = r
$target = 361527;
// $target = 25;

$x = 0;
$y = 0;
$i = 1;
$curr_val = $spiral[0][0] = 1;
print "Cell $x, $y = {$spiral[$x][$y]}. ($i)\n";
$x++;
while ($curr_val < $target) {
  $spiral[$x][$y] = sum_neighbors($x, $y, $spiral);
  $curr_val = $spiral[$x][$y];
  print "Cell $x, $y = {$spiral[$x][$y]}. ($i)\n";
  increment($x, $y, $i);
  $i++;
}

function sum_neighbors($x, $y, $spiral) {
  $val = 0;
  for ($i = $x - 1; $i <= $x + 1; $i++) {
    for ($j = $y - 1; $j <= $y + 1; $j++) {
      $val+= isset($spiral[$i][$j]) ? $spiral[$i][$j] : 0;
    }
  }
  return $val;
}

function increment(&$x, &$y, $i) {
  // determine ring by absolute value of larger value.
  $max = abs($x) < abs($y) ? abs($y) : abs($x);
  $ring = floor(sqrt($i));
  $ring = $ring % 2 ? $ring : $ring - 1;
  $next_ring = $ring + 2;

  $dist_from_ring_start = $i - ($ring * $ring);
  $side = floor($dist_from_ring_start / ($next_ring - 1));
  // Anti-Clockwise starting from bottom right.
  // increment $y until positive $ring
  // decrement $x until negative $ring
  // decrement $y until negative ring
  // increment $x until positive ring
  if ($x == $max && $y == ($max * -1)) {
    $x++;
  }
  else {
    print "side $side\n";
    switch ($side) {
    case 0:
      if ($y == $max) {
        $x--;
      }
      else {
        $y++;
      }
      break;

    case 1:
      if (abs($x) == $max) {
        $y--;
      }
      else {
        $x--;
      }
      break;

    case 2:
      if (abs($y) == $max) {
        $x++;
      }
      else {
        $y--;
      }
      break;

    case 3:
      if ($x == $max) {
        $y++;
      }
      else {
        $x++;
      }
      break;
    }
  }
}
