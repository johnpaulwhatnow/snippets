<?php
/**
 * Created by PhpStorm.
 * User: johnpaul
 * Date: 2/15/2016
 * Time: 8:05 AM
 *
 *
 * This is a little service used to upload files from filepicker.  Be this script needs a few things.  it needs a temp location to store files (line 30), and a finale place to store files. Line 74 for the root path
 *
 *
 *
 */

namespace AppBundle\Services;


class Uploader
{

    public function upload($post_arr){

        $file = $post_arr['url'];
        $filename = $post_arr['filename'];
        $directory = $post_arr['dir'];
        $user_file = file_get_contents( $file );

        //let's store in locally
        //
        $location = 'temp/'.$filename;
        file_put_contents($location,$user_file);

        //let's get the name right.  we need it to be all lowercase without spacing
        $filename = strtolower(preg_replace('/\s+/', '_', $filename));
       // var_dump($filename);
        //let's get some information about the file.
        $path_info = pathinfo($location);
        $file_no_ext = $path_info['filename'];
        $extension = $path_info['extension'];

        //store the photo in an image resource
        $photo = imagecreatefromstring($user_file);

        //unset user file, we don't need it anymore
        unset($user_file);

        //image rotation
        // $photo needs to be a PHP image resource
        // $location is the path to the image file
        //try to read data, but we don't need to on pngs
        if( $extension != 'png'){
            $exif = exif_read_data($location);
            if(!empty($exif['Orientation'])) {
                switch($exif['Orientation']) {
                    case 8:
                        $photo = imagerotate($photo,90,0);
                        break;
                    case 3:
                        $photo = imagerotate($photo,180,0);
                        break;
                    case 6:
                        $photo = imagerotate($photo,-90,0);
                        break;
                }
            }
        }
        // now $photo now contains a resource with the image oriented correctly,

        //give it a unique name

        //get the absolute path to the uploads dir and ocmbine it with our filebame
        $root_path = __DIR__;
        $root_path = $root_path.'/../'.$directory;
        $root_path = '/xampp/htdocs/internal/web/'.$directory;
        $newuploadfile = $filename;

        // Check if file exists, create unique name if so.
        $i = 0;
        while(file_exists($root_path.$newuploadfile)){

            $newuploadfile = $file_no_ext.'_'.$i.'.'.$path_info['extension'];
            $i++;
        }
        //var_dump( $root_path.$newuploadfile );
        //var_dump($extension);
        // Save image to destination file
        if($extension == "jpg" || $extension == "jpeg" || $extension =='JPG'  ){
            imagejpeg($photo, $root_path.$newuploadfile, 90);
        }
        elseif($extension == "gif") {
            imagegif($photo, $root_path.$newuploadfile);
        }
        elseif($extension == "png") {
            imagepng($photo, $root_path.$newuploadfile);
        }
        else{
            return FALSE;
        }
        return $newuploadfile;
    }
}
