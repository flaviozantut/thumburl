## thumburl for laravel

Thumbnail from url for laravel





## Installation

Installation with Laravel Artisan

	php artisan bundle:install thumburl

## Bundle Registration

	'thumburl' => array('handles' => 'thumburl', 'auto' => true),

## Usage
	
	http://myproject.com/thumburl/thumbnail/[size]/[mode]/[url]
	
* [size] = thumbnail size widthXheight in px : 800X600, 800 is equivalent to 800X800

* [mode] = inbound or outbound, user inbound for preserve aspect ratio or outbound for crope

* [url]  = address image from the publicfolder or full url

## Example

	http://myproject.com/thumburl/thumbnail/390/inbound/images/photo.png