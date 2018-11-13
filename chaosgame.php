<?php
ini_set('memory_limit', -1);
error_reporting(E_ALL);

$width = 5000;
$height = 5000;
//$iterations = 5000000;
$iterations = 5000;
$rainbow_road = true;

$triangle = [
    [$width / 2, 0],
    [0, $height],
    [$width, $height]
];

$square = [
    [0, 0],
    [$width, 0],
    [$width, $height],
    [0, $height]
];

$hexagon = [
    [$width / 5, 0],
    [4 * $width / 5, 0],
    [$width / 5, $height],
    [4 * $width / 5, $height],
    [0, $height / 2],
    [$width, $height / 2]
];


// Vertex points are by the shape of
$vertex_points = $triangle;

// Factor by
$factor = 0.5;

//$image = Image.new('RGB', ($width, $height), 'white')
// image create
$img = imagecreate($width, $height);
imagecolorallocate($img, 255, 255, 255);

// Create 'seed'
$last_point = ['x' => $width / 2, 'y' => $height / 2];


$color = imagecolorallocate($img, 0, 0, 0);

// Iterate
foreach (range(0, $iterations) as $i) {
    // put dot
    $pixels[] = $last_point;
    imagefilledellipse($img, $last_point['x'], $last_point['y'], 50, 50, $color);

    $chosen_vertex = $vertex_points[mt_rand(0, count($vertex_points) - 1)];

    $last_point = ['x' => ($last_point['x'] + $chosen_vertex[0]) * $factor, 'y' => ($last_point['y'] + $chosen_vertex[1]) * $factor];
}

//$color = imagecolorallocate($img, 255, 255, 255);
//imagefilledellipse($img, 100, 100, 10, 10, $color);
imagepng($img, 'out.png');

// Rainbow road
if ($rainbow_road) {
    $img2 = imagecreate($width, $height);
    imagecolorallocate($img2, 255, 255, 255);
    foreach ($pixels as $v) {
        $r = 25;//($v['x'] / 255) % 2 == 0 ? $v['x'] % 255 : 255 - ($v['x'] % 255);
        $g = 25;//($v['y'] / 255) % 2 == 0 ? $v['y'] % 255 : 255 - ($v['y'] % 255);
        $b = 60;

        $color = imagecolorallocate($img2, $r, $g, $b);
        imagefilledellipse($img2, $v['x'], $v['y'], 50, 50, $color);
    }
    imagepng($img2, 'out2.png');
}





