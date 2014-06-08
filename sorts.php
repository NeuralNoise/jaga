<?php

ini_set('display_errors', '1');

// BUBBLE SORT

function bubblesort(&$array) {
    for ($index = 0; $index < $size; $index++) {
    $size = count($array);
        for ($j = 0; $j < $size - 1 - $index; $j++) {
            if ($array[$j+1] < $array[$j]) {
                swap($array, $j, $j+1);
            }
        }
}
    }

// QUICKSORT

function quicksort(&$array, $leftIndex, $rightIndex) {
    $index = partition($array,$leftIndex,$rightIndex);
    if ($leftIndex < $index - 1) { quicksort($array, $leftIndex, $index - 1); }
    if ($index < $rightIndex) { quicksort($array, $index, $rightIndex); }
}

function partition(&$array,$leftIndex,$rightIndex) {
    
	$pivot = $array[($leftIndex+$rightIndex)/2];

	while ($leftIndex <= $rightIndex) {
	
		while ($array[$leftIndex] < $pivot) { $leftIndex++; }
		while ($array[$rightIndex] > $pivot) { $rightIndex--; }
        if ($leftIndex <= $rightIndex) {  
			
			swap($array, $leftIndex, $rightIndex);
			
			$leftIndex++;
			$rightIndex--;
		
		}
	}
    return $leftIndex;
}

// ARRAY SWAP

function swap(&$array, $leftIndex, $rightIndex) {
	$swap = $array[$leftIndex];
	$array[$leftIndex] = $array[$rightIndex];
	$array[$rightIndex] = $swap;
}



// TEST

$array = array(11,17,6,21,14,7,3,16,15,9,2,10,18,8,5,1,19,20,12,13,4);
$clone = $array;

echo 'Original: [' . implode(',',$array) . ']<hr />';

quicksort($array, 0, 20);
echo 'Quicksort: [' . implode(',',$array) . ']<hr />';

bubblesort($clone, 0, 20);
echo 'Bubble Sort: [' . implode(',',$clone) . ']<hr />';

















?>