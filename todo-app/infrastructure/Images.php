<?php

namespace Infrastructure;

use App\Models\Image;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Infrastructure\Facades\FileFacade;
use Intervention\Image\ImageManager;

class Images
{
    protected $image_path;
    public function __construct()
    {
        $this->image_path = public_path(Config::get('images.upload_path'));
    }

    /**
     * Upload the uploaded file to specific path
     * 
     * @param $file
     * @param $thumb_sizes
     * @param $name
     * 
     * @return string Generated name of the file
     */
    public function up($file, $thumb_sizes, $name = null)
    {
      if($name) {
        $renamed_uploaded_file = FileFacade::makeGivenName($file,$name);
      } else {
        $renamed_uploaded_file = FileFacade::makeName($file);
      }
      if($file->move($this->image_path . "/", $renamed_uploaded_file)){
        foreach($thumb_sizes as $size){
          $this->saveThumb($renamed_uploaded_file, $size);
        }

        return $this->makeObject($renamed_uploaded_file);
      }
    }

    public function saveThumb($file, $size_type)
    {
      $manager = new ImageManager(array('driver' => Config::get('images.driver')));
      $image = $manager->make($this->image_path . '/' . $file);
      $size = $this->getThumbSize($size_type);

      /**
       * resize image with maintaining aspect ratio
       */
      if($image->getWidth() > $image->getHeight()){
        $image->resize(null, $size['height'], function ($image) {$image->aspectRatio();});
        $image->crop($size['width'], $size['height'], intval(($image->getWidth() - $size['width']) / 2), 0);
      } else {
        $image->resize($size['width'], null, function ($image) {$image->aspectRatio();});
        $image->crop($size['width'], $size['height'], intval(($image->getWidth() - $size['width']) / 2), 0);
      }

      if (!file_exists($this->image_path . '/thumb')) {
        File::makeDirectory($this->image_path . '/thumb');
      }

      if (!file_exists($this->image_path . '/thumb' . $size['width'] . 'x' . $size['height'])) {
        File::makeDirectory($this->image_path . '/thumb' . $size['width'] . 'x' . $size['height']);
      }

      $image->save($this->image_path . '/thumb' . $size['width'] . 'x' . $size['height'] . '/' . $file);
    }

    /**
     * function to delete images from the directory and database
     * @param $id
     * @param $sizes
     * @internal parram $file
     */
    public function delete($id, $sizes)
    {
      // find the image using the id
      $image = Image::find($id);

      // delete image from directory
      File::delete($this->image_path . '/' . $image->name);

      // delete image from thumbnailes from directories
      foreach($sizes as $size_type){
        $size = $this->getThumbSize($size_type);
        File::delete($this->image_path . '/thumb/' . $size['width'] . 'x' . $size['height'] . '/' . $image->name);
      }

      // remove image from the database
      Image::destroy($id);
    }

    /**
     * function to delete images from the directory
     * @param $name
     * @param $sizes
     */

    public function clear($name, $sizes)
    {
      // delete image from directory
      File::delete($this->image_path . '/' . $name);

      // delete image from thumbnailes from directories
      foreach($sizes as $size_type){
        $size = $this->getThumbSize($size_type);
        File::delete($this->image_path . '/thumb/' . $size['width'] . 'x' . $size['height'] . '/' . $name);
      }
    }

    /**
     * Get image name from uploaded image list string
     * @param $array_list
     * @return array
     */
    public function get($array_list)
    {
      return explode(',', $array_list);
    }

    /**
     * Download Facebook profile picture from profile id
     * 
     * @param $contents
     * @param $thumb_sizes
     * @internal parram $fb_id
     * @return string
     */
    public function downloadImage($contents, $thumb_sizes)
    {
      $new_image = FileFacade::makeName() . '.jpg';

      // Store in the filesystem
      FileFacade::storeFile($contents, $new_image_name, $this->image_path, 'w');

      foreach($thumb_sizes as $size){
        $this->saveThumb($new_image_name, $size);
      }

      return $this->makeObject($new_image_name);
    }

    /**
     * Store many of images as an array
     * Returns stored image names
     * @param $images
     * @param $thumb_sizes
     * @return array
     */
    public function store($images, $thumb_sizes)
    {
      $response = [];
      $status = false;
      $created_images = [];
      $error = null;

      if($images != null){
        if(is_array($images)){
          foreach($images as $image){
            // uploading file using ImageFacade
            // Get uploaded file name and assign to $file name variable
            $file = $this->up($image, $thumb_sizes);

            array_push($created_images, $file);
          }
        } else {
          $created_images = $this->up($images, $thumb_sizes);
        }

        $status = true;
      } else {
        $error = 'Please add at least one image';
      }

      $response['status'] = $status;
      $response['error'] = $error;
      $response['created_images'] = $created_images;

      return $response;
    }

    /**
     * Crop image
     * @param $id
     * @param array $image_details
     * @param array $image_sizes
     */
    public function crop($id, array $image_details, array $image_sizes)
    {
      $file_name = Image::find($id)->name;
      $manager = new ImageManager(array('driver' => Config::get('images.driver')));
      $image = $manager->make($this->image_path . '/' . $file_name);
      $image->crop(
        intval($image_details['width']),
        intval($image_details['height']),
        intval($image_details['x']),
        intdiv($image_details['y'], 2)
      );

      $image->save($this->image_path . '/' . $file_name);

      // Replace image thumbs with crpped image
      foreach($image_sizes as $size){
        $this->saveThumb($file_name, $size);
      }
    }

    /**
     * Create image object and store in database
     * @param $new_image_name
     * @return Image object
     */
    public function makeObject($new_image_name)
    {
      $image_service = new Image();

      $image = $image_service::create([
        'name' => $new_image_name
      ]);

      return $image;
    }

    


}