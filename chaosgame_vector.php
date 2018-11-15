<?php
ini_set('memory_limit', -1);

$time_start = microtime(true);

$width = 5000;
$height = 5000;
$iterations = 1000;

$triangle = [
    [$width / 2, 0],
    [0, $height],
    [$width, $height]
];


$vertex_points = $triangle;
$factor = 0.5;
$img = imagecreate($width, $height);
imagecolorallocate($img, 255, 255, 255);

echo 'get points'.PHP_EOL;

$pixels = new \ds\vector();
$last_point = ['x' => $width / 2, 'y' => $height / 2];
foreach (range(0, $iterations) as $i) {
    $chosen_vertex = $vertex_points[mt_rand(0, count($vertex_points) - 1)];
    $last_point = ['x' => ($last_point['x'] + $chosen_vertex[0]) * $factor, 'y' => ($last_point['y'] + $chosen_vertex[1]) * $factor];
    $pixels->push($last_point);
}

echo 'prot points'.PHP_EOL;

$color = imagecolorallocate($img, 0, 0, 0);
$pixels->map(function($v) use ($img, $color) {
    imagefilledellipse($img, $v['x'], $v['y'], 1, 1, $color);
});

imagepng($img, 'out_vector.png');
echo 'end'.PHP_EOL;

$time = microtime(true) - $time_start;
echo ' microtime: '.$time.PHP_EOL;
echo ' memory: '.memory_get_peak_usage(true).PHP_EOL;
exit;


