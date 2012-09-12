<?php
/**
 * Thumburl
 *
 * @category Thumburl
 * @package  Thumburl
 * @author   Flavio Zantut  <flaviozantut@gmail.com>
 * @license  MIT License <http://www.opensource.org/licenses/mit>
 * @link     http://link.com
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Cache folder
    |--------------------------------------------------------------------------
    |
    |Cache files location
    |
    */

   'caching' => array(
        /**
         * Caching
         *
         * Globally enable caching for all assets, this is only recommended once an application
         * is live.
         */
        'enabled' => true,
        /**
         * Time
         *
         * The time in minutes to cache the assets for. By default it is set to one month, or 44640
         * minutes.
         */
        'time' => 44640,
    ),

   /*
    |--------------------------------------------------------------------------
    | extension
    |--------------------------------------------------------------------------
    |
    |extensions allowed
    |
    */
   'extensions' => array(
        'png', 
        'jpg', 'jpeg',
        'gif',
    ) ,


   /*
    |--------------------------------------------------------------------------
    | Lib to images manipulation
    |--------------------------------------------------------------------------
    |
    |'Gd' or 'Imagick' or 'Gmagick'
    |
    */
   'error_image' => Bundle::path('thumburl') . 'images/error/not-found.jpg' ,


    /*
    |--------------------------------------------------------------------------
    | Lib to images manipulation
    |--------------------------------------------------------------------------
    |
    |'Gd' or 'Imagick' or 'Gmagick'
    |
    */
   'lib' => 'Gd' ,

   /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    |THUMBNAIL_INSET or THUMBNAIL_OUTBOUND
    |
    | Imagine\Image\ImageInterface::THUMBNAIL_INSET
    | Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
    |
    */
   'mode_outbound' => Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND ,
   'mode_inset' => Imagine\Image\ImageInterface::THUMBNAIL_INSET ,
);
