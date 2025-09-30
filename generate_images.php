<?php
// Create hero image
$width = 800;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Set background color (light green)
$bgColor = imagecolorallocate($image, 220, 255, 220);
imagefill($image, 0, 0, $bgColor);

// Add text
$textColor = imagecolorallocate($image, 0, 100, 0);
$text = "AgriPower";
$fontSize = 5;
$x = ($width - imagefontwidth($fontSize) * strlen($text)) / 2;
$y = ($height - imagefontheight($fontSize)) / 2;
imagestring($image, $fontSize, $x, $y, $text, $textColor);

// Save the image
imagejpeg($image, 'assets/images/hero-image.jpg', 90);
imagedestroy($image);

echo "Images generated successfully!";
?> 