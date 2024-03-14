<?php

namespace Infrastructure;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\St;
use Illuminate\Support\Facades\Storage;

class FileService
{
    protected $image_path;

    public function __construct()
    {
        $this->image_path = Config::get('images.upload_path');
    }

    /**
     * Read the contents of a file.
     *
     * @param $path
     * @return string
     */

    public function getContents($path)
    {
        return file_get_contents($path);
    }

    /**
     * store given file in the given path
     * @param $file
     * @param $name
     * @param $path
     * @param $mode
     */

    public function storeFile($file, $name, $path, $mode)
    {
      $fp = fopen(($path . "/" . $name), $mode);
      fwrite($fp, $file);
      fclose($fp);
    }

    /**
     * Generate new name for uploaded file
     * @param $file
     * 
     * @param $file
     * 
     * @return string - The new string for file
     */

    public function makeName($file = null, $url = null)
    {
      // Return the name of the file with extension if file contains a file in parameters
      if(!$file == null){
        return md5(date( 'yyyy.mm.dd.hh.ss' ). $file . rand(0, 999)) . '.' . $file->getClientOriginalExtension();
      }

      // Return the name of the file with extension if method contains a url in parameters
      if(!$url == null){
        return md5(date( 'yyyy.mm.dd.hh.ss' ). $file . rand(0, 999)) . '.' . $file->getExt($url);
      }
      
      // Return the name of the file without extension if the file parameter is null
      return md5(date( 'yyyy.mm.dd.hh.ss' ). $file . rand(0, 999));
    }

    /**
     * Download the file from url
     * @param $url
     * @param $name
     * @param $path
     * @return string
     */

    public function download($url, $name, $path)
    {
      Storage::put($path . '/' . $name, file_get_contents($url), 'public');

      return $name;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
      return $this->image_path;
    }

    /**
     * @param $file
     * @return mixed
     */
    public function getExt($file)
    {
      $ext = pathinfo($file, PATHINFO_EXTENSION);

      if(strpos($ext, '?')){
        return substr($ext, 0, strpos($ext, '?'));
      } else {
        return $ext;
      }
    }

    /**
     * @param $file
     * @return int
     */
    public function getSize($file)
    {
      $ch = curl_init($file);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, TRUE);
      curl_setopt($ch, CURLOPT_NOBODY, TRUE);
      $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

      curl_close($ch);
      return $size;
    }

    /**
     * Get name of given file
     * @param $file
     */
    public function getName($file)
    {
      return pathinfo($file)['basename'];
    }

    /**
     * Validate given extension with file
     * @param $file
     * @param $ext
     * @return bool
     */
    public function validateExt($file, $ext)
    {
      if(is_object($file)){
        return $file->extension() == $ext;
      } else {
        return $this->getExt($file) == $ext;
      }
    }

    
    


}