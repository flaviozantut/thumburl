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
namespace Thumburl;
/**
 * Thumburl Building html image
 *
 * @category Libraries
 * @package  Thumburl
 * @author   Flavio Zantut  <flaviozantut@gmail.com>
 * @license  MIT License <http://www.opensource.org/licenses/mit>
 * @link     http://link.com
 */
class Html extends \Html
{

    /**
     * call Static
     * 
     * @param string $method method
     * @param string $args   args
     * 
     * @todo testing and refatoring
     * @return Html
     */
    static public function __callStatic($method, $args) 
    {
        $url  = isset($args[0])?$args[0]:'';
        $size = isset($args[1])?$args[1]:'';
        $mode = isset($args[2])?$args[2]:'inbound';
        $alt  = isset($args[3])?$args[3]:'';
        $atr  = isset($args[4])?$args[4]:'';

        $thumb = "thumburl/{$method}/{$size}/{$mode}/$url";
        return HTML::image($thumb, $alt,  $atr);
    }


}
