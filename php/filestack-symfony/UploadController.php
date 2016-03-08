<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
 * Upload controller.
 *
 */
class UploadController extends Controller
{
    /**
     * upload - default when logged in as user.
     *
     */
    public function uploadAction(Request $request)
    {

        $post = $request->request->all();
        $result = $this->get('app_bundle.uploader')->upload($post);
        $response = new JsonResponse();
        $response_arr = array();
        if( $result !== false){
            $response_arr['is_success'] = true;
            $response_arr['filename'] = $result;
        } else{
            $response_arr['is_success'] = false;
        }
        $response->setData( array('response'=>$response_arr));
        return $response;

    }

}
