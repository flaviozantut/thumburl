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
 * Thumburl Controller
 *
 * @category Controller
 * @package  Thumburl
 * @author   Flavio Zantut  <flaviozantut@gmail.com>
 * @license  MIT License <http://www.opensource.org/licenses/mit>
 * @link     http://link.com
 */
class Thumburl_Thumburl_Controller extends Controller
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();

        \Config::set('application.profiler', false);
    }

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param string $method     method
     * @param array  $parameters parameters
     *
     * @return Response
     */
    public function __call($method, $parameters)
    {
        return Response::error('404');
    }

    /**
     * Get thumbnail of image
     *
     * Exemplo: _http://myproject.com/thumburl/thumbnail/390/inbound/images/photo.png_
     *
     * @param string $size image size Wxh ex.: 150x120 or 150
     * @param string $mode image mode inbound or outbound
     * @param string $url  image url
     *
     * @return Response
     */
    public function action_thumbnail($size, $mode, $url)
    {
        $url = implode('/', array_diff(func_get_args(), array($size, $mode)));

        $thumb = new Thumburl();
        $response = $thumb->thumbnail($size, $mode, $url);

        //require extension=php_fileinfo
        $finfo   = new finfo(FILEINFO_MIME_TYPE);

        $headers = array(
            'Accept-Ranges'  => 'bytes',
            'Cache-Control'=>   'max-age=2592000',
            'Content-type' => $finfo->buffer($response),
            'Date' =>   gmdate('D, d M Y H:i:s \G\M\T', time()),
            'Expires' => gmdate('D, d M Y H:i:s \G\M\T', time() + 3600),
        );
        return Response::make($response, 200, $headers);
    }
}
