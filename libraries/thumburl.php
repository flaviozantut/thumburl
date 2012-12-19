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

/**
 * Thumburl Lib
 *
 * @category Libraries
 * @package  Thumburl
 * @author   Flavio Zantut  <flaviozantut@gmail.com>
 * @license  MIT License <http://www.opensource.org/licenses/mit>
 * @link     http://link.com
 */
class Thumburl
{
    public $imagine , $mode;

     /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $lib = \Config::get('thumburl::options.lib');
        $Imagine = "Imagine\\{$lib}\\Imagine";
        $this->imagine = new $Imagine();
    }

    /**
     * Get Box Size
     *
     * @param string $size image size
     *
     * @return Imagine\Image\Box
     */
    public function boxSize($size)
    {
        $size = explode('X', strtoupper($size));
        $w = ( isset($size[0]) and is_numeric($size[0]) )  ?$size[0]:100;
        $h = (isset($size[1]) and is_numeric($size[1]))?$size[1]:$w;

        return new Imagine\Image\Box($w, $h);
    }


    /**
     * Image mode
     *
     * @param string $mode mode
     *
     * @return Imagine\Image\Box
     */
    public function mode($mode)
    {
        $mode = strtolower($mode);
        switch ($mode) {
        case 'inset' :
            $this->mode = \Config::get('thumburl::options.mode_inset');
            break;
        case 'outbound':
            $this->mode = \Config::get('thumburl::options.mode_outbound');
            break;
        default:
            $this->mode = \Config::get('thumburl::options.mode_inset');
            break;
        }
        return $this->mode;
    }



    /**
     * Get image file
     *
     * @param string $url image url
     *
     * @return string
     */
    public function url($url)
    {
        $file = \Config::get('thumburl::options.error_image');
        if(in_array(strtolower(File::extension($url)), \Config::get('thumburl::options.extensions'))) {
            if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url)) {
                $file = $url;
            } elseif (is_file(path('public') . $url)) {
                $file = path('public') . $url;
            }
        }
        return $file;
    }




    /**
     * Resize Image
     *
     * @param string $size image size
     * @param string $url  image url
     *
     * @return Response
     */
    public function thumbnail($size, $mode, $url)
    {
        $Imagine =& $this->imagine;

        if (!file_exists(path('public') . "thumburl/thumbnail/{$size}/{$mode}/{$url}")) {
            @mkdir(path('public') . "thumburl/thumbnail/{$size}/{$mode}/uploads" , 0777, true );

            $sizeX = explode('X', strtoupper($size));
            $w = ( isset($sizeX[0]) and is_numeric($sizeX[0]) )  ?$sizeX[0]:100;
            $h = (isset($sizeX[1]) and is_numeric($sizeX[1]))?$sizeX[1]:$w;
            $thumb = $Imagine
                ->open( $this->url($url) )
                ->thumbnail($this->boxSize($size), $this->mode($mode));

            $thumbSize = $thumb->getSize();
            $collage = $Imagine->create(new Imagine\Image\Box($w, $h), new Imagine\Image\Color('#fff', 100));
            $collage->paste($thumb, new Imagine\Image\Point(($w-$thumbSize->getWidth())/2, ($h-$thumbSize->getHeight())/2));

            if (\Config::get('thumburl::options.caching.enabled')) {
                $collage->save(path('public') . "thumburl/thumbnail/{$size}/{$mode}/{$url}");
            }
            return $collage;
        }
    }

}
