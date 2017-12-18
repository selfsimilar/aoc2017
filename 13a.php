<?php

$input = <<<INPUT
0: 3
1: 2
4: 4
6: 4
INPUT;

// 0*3 + 6*4
$desired_output = 24;

foreach ($input as $i) {
  $layer = explode(': ', $i);
}