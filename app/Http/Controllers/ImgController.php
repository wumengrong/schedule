<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ImgController extends Controller{
    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function index(){
        var_dump("sdsdd");
    }

    public function uploadImg(){

    }
    public function delete(){

    }

    /**
     * get file md5 key by file path
     * @param $path
     * @return bool|string
     */
    public function getKeyByFilePath($path){
        if(!empty($path)){
            return md5_file($path);
        }
        return false;
    }

    /**
     * get type of img ,for example jpg gif and so on.
     */
    public function getTypeOfImg($ImgPath){
        $imgInfo=getimagesize($ImgPath);

        $type=$imgInfo[2];
        $typename='';
        switch ($type){
            case 1:
                $typename='gif';
                break;
            case 2:
                $typename='jpg';
                break;
            case 3:
                $typename='png';
                break;
            case 4:
                $typename='swf';
                break;
            case 5:
                $typename='psd';
                break;
            case 6:
                $typename='bmp';
                break;
            case 7:
                $typename='tiff';
                break;
        }
        return $typename;
    }

    /**
     * get size of img, for example 512 KB attention the unit is KB
     */
    public function getSizeOfImg($ImgPath){
        if(!empty($ImgPath)){
            return filesize($ImgPath);
        }
        return 0;
    }

    /**
     * get width and height of img ,the result is width and height,the unit is px
     */
    public function getWidthAndHeightOfImg($ImgPath){
        if(!empty($imgInfo)){
            $imgInfo=getimagesize($ImgPath);
            $width=$imgInfo[0];
            $height=$imgInfo[1];
            $result=array(
                'width'=>$width,
                'height'=>$height
            );
            return $result;
        }
        return false;

    }

    /**
     * get img all property by img file path
     * @param $ImgPath
     */
    public function getProperty($ImgPath){
        $size=filesize($ImgPath);  //获取文件大小，单位字节，统计的结果和在windows系统上查看的结果又差异，文件系统的原因
        $imgInfo=getimagesize($ImgPath);
        $width=$imgInfo[0];
        $height=$imgInfo[1];
        $type=$imgInfo[2];
        $typename='';
        switch ($type){
            case 0:
                $typename='gif';
                break;
            case 1:
                $typename='jpg';
                break;
            case 3:
                $typename='png';
                break;
            case 4:
                $typename='swf';
                break;
            case 5:
                $typename='psd';
                break;
            case 6:
                $typename='bmp';
                break;
            case 7:
                $typename='tiff';
                break;
        }
        $result=array(
            'size'=>$size,
            'type'=>$typename,
            'width'=>$width,
            'height'=>$height
        );
        return $result;
    }


}