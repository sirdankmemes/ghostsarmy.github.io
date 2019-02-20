<?php
$images = glob(""."*.png");

foreach($images as $image) {
    echo ' <img alt="'.$image.'"src="'.$image.'" />';
}