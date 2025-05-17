<?php
/**
 * Generate theme screenshot
 * 
 * This file generates a preview image for the theme that appears in the WordPress admin panel.
 * The screenshot should be 1200x900 pixels.
 */

header('Content-Type: image/png');

// Create image
$image = imagecreatetruecolor(1200, 900);

// Colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 238, 238, 238);

// Fill background
imagefill($image, 0, 0, $white);

// Add header area
imagefilledrectangle($image, 0, 0, 1200, 80, $white);

// Add logo area
imagefilledrectangle($image, 50, 20, 200, 60, $gray);
imagestring($image, 5, 80, 30, 'The Hair Lab', $black);

// Add hero section
imagefilledrectangle($image, 0, 80, 1200, 400, $gray);
imagestring($image, 5, 500, 200, 'Customized Hair Care', $black);
imagestring($image, 4, 400, 240, 'Based on Your Hair Biology', $black);

// Add product grid
for ($i = 0; $i < 4; $i++) {
    imagefilledrectangle($image, 50 + ($i * 300), 450, 300 + ($i * 300), 650, $white);
    imagerectangle($image, 50 + ($i * 300), 450, 300 + ($i * 300), 650, $gray);
    imagestring($image, 4, 100 + ($i * 300), 500, 'Product ' . ($i + 1), $black);
}

// Add footer
imagefilledrectangle($image, 0, 700, 1200, 900, $gray);

// Output image
imagepng($image);
imagedestroy($image);
