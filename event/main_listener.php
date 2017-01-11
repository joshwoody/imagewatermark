<?php
/**
 *
 * Image Watermark. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Josh Woody, joshwoody.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace joshwoody\imagewatermark\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Image Watermark Event listener.
 */
class main_listener implements EventSubscriberInterface
{
    protected $config;
    protected $root_path;

    function __construct(
            \phpbb\config\db $config,
            $phpbb_root_path 
    )
    {
        $this->config = $config;
        $this->root_path = $phpbb_root_path;
    }

    /**
    * Assign functions defined in this class to event listeners in the core
    *
    * @return array
    * @static
    * @access public
    */
    static public function getSubscribedEvents()
    {
        return array(
                'core.modify_uploaded_file'                     => 'image_add_watermark',
        );
    }

    public function image_add_watermark($event)
    {
        if (!$event['is_image'] || !$event['filedata']['post_attach'])
        {
            return;
        }

        if (!@extension_loaded('gd'))
        {
            // TODO: Throw an error?
            return;
        }

        $watermark = imagecreatefrompng($this->root_path .  'images/' . 
            $this->config['watermark_file']);

        $watermark_x = imagesx($watermark);
        $watermark_y = imagesy($watermark);

        $image = $this->image_get_handle($event);
        $image_x = imagesx($image);
        $image_y = imagesy($image);

        imagecopy($image, $watermark, $image_x - $watermark_x, 
            $image_y - $watermark_y, 0, 0, $watermark_x, $watermark_y);

        $this->image_write($event, $image);
        
        imagedestroy($watermark);

        // Update file size 
        $filedata = $event['filedata'];
        clearstatcache();
        $filedata['filesize'] = filesize($this->root_path . $this->config['upload_path'] . '/' . $filedata['physical_filename']);
        $event['filedata'] = $filedata;
    }


    private function image_get_handle($event)
    {
        switch($event['filedata']['mimetype'])
        {
            case 'image/png':
                $image = imagecreatefrompng($this->root_path . 
                    $this->config['upload_path'] . '/' . 
                    $event['filedata']['physical_filename']);
            break;

            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($this->root_path . 
                    $this->config['upload_path'] . '/' . 
                    $event['filedata']['physical_filename']);
            break;

            case 'image/gif':
                // TODO: Bail out gracefully (without doing anything) if 
                // this is an animated GIF
                $image = imagecreatefromgif($this->root_path . 
                    $this->config['upload_path'] . '/' . 
                    $event['filedata']['physical_filename']);
            break;

            default:
            break;
        }

        return $image;
    }

    private function image_write($event, $image)
    {
        switch($event['filedata']['mimetype'])
        {
            case 'image/png':
              imagepng($image, $this->root_path . 
                  $this->config['upload_path'] . '/' . 
                  $event['filedata']['physical_filename']);
            break;

            case 'image/jpeg':
            case 'image/jpg':
              imagejpeg($image, $this->root_path . 
                  $this->config['upload_path'] . '/' . 
                  $event['filedata']['physical_filename']);
            break;

            case 'image/gif':
              imagegif($image, $this->root_path . 
                  $this->config['upload_path'] . '/' . 
                  $event['filedata']['physical_filename']);
            break;

            default:
            break;
        }

        imagedestroy($image);
    }

}
