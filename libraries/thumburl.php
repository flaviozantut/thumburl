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
     * Save image in cache
     *
     * @param string $file file
     * 
     * @return file
     */
    public function setCache($tipe, $size, $mode, $url , $thumb)
    {
        $name = md5($tipe . $size . $mode . $url);
        Cache::put($name , base64_encode($thumb), \Config::get('thumburl::options.caching.time'));
        
    }

    /**
     * Get image from cache
     *
     * @param string $file file
     * 
     * @return Response
     */
    public function getCache($tipe, $size, $mode, $url)
    {
        $name = md5($tipe . $size . $mode . $url);
        return base64_decode(Cache::get($name));
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

        if (\Config::get('thumburl::options.caching.enabled')) {
           $thumb = $this->getCache('thumbnail', $size, $mode, $url);
            if ($thumb) {
                return $thumb;
            } else {

                $thumb = $Imagine
                    ->open( $this->url($url) )
                    ->thumbnail($this->boxSize($size), $this->mode($mode));   
                $this->setCache('thumbnail', $size, $mode, $url, $thumb);
                return  $thumb;
               // return $this->getCache('thumbnail', $size, $mode, $url);
            }
            
            //$thumb = $this->getCache('thumbnail', $size, $mode, $url);
           // var_dump($thumb);
           //die();
            /*$thumb = $Imagine
                    ->open( $this->url($url) )
                    ->thumbnail($this->boxSize($size), $this->mode($mode));*/


            return $thumb;
        } else {
            return $Imagine
                ->open($this->url($url))
                ->thumbnail($this->boxSize($size), $this->mode($mode));
        }
        
    }

}
