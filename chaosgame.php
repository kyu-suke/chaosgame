<?php

$width = 5000;
$height = 5000;
//$iterations = 5000000;
$iterations = 50000;
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
    $pixels[$last_point['x'].':'. $last_point['y']] = [0, 0, 0];
    imagefilledellipse($img, $last_point['x'], $last_point['y'], 50, 50, $color);

    $chosen_vertex = $vertex_points[mt_rand(0, count($vertex_points) - 1)];

    $last_point = ['x' => ($last_point['x'] + $chosen_vertex[0]) * $factor, 'y' => ($last_point['y'] + $chosen_vertex[1]) * $factor];
}

//$color = imagecolorallocate($img, 255, 255, 255);
//imagefilledellipse($img, 100, 100, 10, 10, $color);
imagepng($img, 'out.png');

// Rainbow road
if ($rainbow_road) {
    $img = imagecreate($width, $height);
    imagecolorallocate($img, 255, 255, 255);
    foreach (range(0, $width) as $i) {
        foreach (range(0, $height) as $j) {
            if (
                $pixels[$i.':'.$j][0] != 255 &&
                $pixels[$i.':'.$j][1] != 255 &&
                $pixels[$i.':'.$j][2] != 255
            ) {
                $r = ($i / 255) % 2 == 0 ? $i % 255 : 255 - ($i % 255);
                $g = ($j / 255) % 2 == 0 ? $j % 255 : 255 - ($j % 255);
                $b = 60;

                $color = imagecolorallocate($img, $r, $g, $b);
                imagefilledellipse($img, $i, $j, 50, 50, $color);
                $pixels[$i.':'.$j] = [$r, $g, $b];
            }
        }
    }
}

imagepng($img, 'out2.png');




