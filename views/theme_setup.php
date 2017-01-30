<?php

if (!defined('MH_DO_NOT_LOAD_CUSTOM_CSS')) {
	define('MH_DO_NOT_LOAD_CUSTOM_CSS', 1);
}


/*
* This file contains image definitions for Themes. When creating a theme you should include a copy 
* of this file at the root level of the theme folder
*
* Methods to resize images
*
* fit:    proportionally scales (up or down) the image to fit into desired size. 
*         This method doesn't use all available space when proportions are diferent.
* bfit:   Same as fit but creates a image with the def
*ined size and white background
* reduce: the same as fit but only scales down whe image is bigger than desired
* fill:   scales and crop the image to fill the desired size keeping aspect ratio. 
*         Crops the image if proportions are different from available space
* scale:  Scales the image to the given size without respecting the aspect ratio. 
*         If any dimension is equal to 0 then the scaling is proportional
*         (useful to comply with some design requirements) 
*
**/

$theme['Theme']['sizes']['homePageImage']		= array('width' => 2048, 'height' => 409, 'method' => 'fill');
$theme['Theme']['sizes']['menuIcon'] 			= array('width' => 32, 'height' => 32, 'method' => 'fit');
$theme['Theme']['sizes']['imageThumb'] 			= array('width' => 48, 'height' => 48, 'method' => 'fill');
$theme['Theme']['sizes']['headerLogo'] 			= array('width' => 76, 'height' => 76, 'method' => 'fit');
$theme['Theme']['sizes']['itemListImage'] 		= array('width' => 120, 'height' => 120, 'method' => 'fill');
$theme['Theme']['sizes']['itemMainImage'] 		= array('width' => 640, 'height' => 280, 'method' => 'fill');
$theme['Theme']['sizes']['itemFullImage']		= array('width' => 1024, 'height' => 1024, 'method' => 'fit');
$theme['Theme']['sizes']['itemBxGallery'] 		= array('width' => 490, 'height' => 0, 'method' => 'scale');
$theme['Theme']['sizes']['itemGalleryThumb'] 	= array('width' => 85, 'height' => 85, 'method' => 'fill');
$theme['Theme']['sizes']['itemAuthorImage'] 	= array('width' => 48, 'height' => 48, 'method' => 'fit');
$theme['Theme']['sizes']['featuredListImage'] 	= array('width' => 120, 'height' => 60, 'method' => 'fill');
$theme['Theme']['sizes']['channelMenuIcon'] 	= array('width' => 64, 'height' => 64, 'method' => 'fit');
$theme['Theme']['sizes']['channelDescription'] 	= array('width' => 210, 'height' => 105, 'method' => 'fill');
$theme['Theme']['sizes']['channelMainImage'] 	= array('width' => 960, 'height' => 309, 'method' => 'fill');
$theme['Theme']['sizes']['tableImageCell'] 		= array('width' => 64, 'height' => 64, 'method' => 'fit');
$theme['Theme']['sizes']['tablePreviewCell'] 	= array('width' => 64, 'height' => 64, 'method' => 'fit');
$theme['Theme']['sizes']['uploadPreviewImage'] 	= array('width' => 250, 'height' => 250, 'method' => 'fit');
$theme['Theme']['sizes']['previewIcon'] 		= array('width' => 125, 'height' => 125, 'method' => 'fit');
$theme['Theme']['sizes']['directLinksIcon']		= array('width' => 67.7, 'height' => 67.7, 'method' => 'fill');
$theme['Theme']['sizes']['itemListImage-1'] 	= array('width' => 130, 'height' => 130, 'method' => 'fill');
$theme['Theme']['sizes']['itemListImage-2'] 	= array('width' => 270, 'height' => 130, 'method' => 'fill');
$theme['Theme']['sizes']['itemListImage-3'] 	= array('width' => 410, 'height' => 130, 'method' => 'fill');
$theme['Theme']['sizes']['itemListImage-4'] 	= array('width' => 550, 'height' => 275, 'method' => 'fill');


$theme['Theme']['limits']['page'] 				= 15;
$theme['Theme']['limits']['index'] 				= 15;
$theme['Theme']['limits']['widget'] 			=  5;
$theme['Theme']['limits']['featured']			=  3;
$theme['Theme']['limits']['special'] 			=  3;

?>