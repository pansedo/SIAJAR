<?php
$numbers = range(1, 5);
shuffle($numbers);
foreach ($numbers as $number) {
    echo "$number ";
}
?>
