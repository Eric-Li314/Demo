<?php
//截取以鼠标点为圆心，指定宽高的图片
//以图片左上角为原点 0->右(正),0->下(正)
//源文件，截取宽度，截取高度，鼠标点x，鼠标点y
//$flag=0 默认直接输出在浏览器上，1保存到目录下
function cut_image($src_file, $new_width, $new_height, $x, $y,$flag=0) {
    //创建截图的存放路径
    $pathinfo = pathinfo($src_file);
    $dst_file = $pathinfo['dirname'] . '/' . $pathinfo['filename'] .'_'. $new_width . 'x' . $new_height . '.' . $pathinfo['extension'];

    if ($new_width < 1 || $new_height < 1) {
        echo "截图的宽高设置不正确！!";
        die;
    }
    if (!file_exists($src_file)) {
        echo $src_file . " 文件不存在！";
        die;
    }
    // 图像类型，判断是否支持
    $img_type = exif_imagetype($src_file); //返回编号，获取源图片类型编号1-G，2-J，3—P
    $support_type = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF); //能够支持的类型
    if (!in_array($img_type, $support_type)) {
        echo "只支持jpg、png、gif格式图片裁剪";
        die;
    }
    /* 根据源图片类型载入图像 */
    switch ($img_type) {
        case IMAGETYPE_JPEG :
            $src_img = imagecreatefromjpeg($src_file);
            break;
        case IMAGETYPE_PNG :
            $src_img = imagecreatefrompng($src_file);
            break;
        case IMAGETYPE_GIF :
            $src_img = imagecreatefromgif($src_file);
            break;
        default:
            echo "载入图像错误!";
            die;
    }
    /* 获取源图片的宽度和高度 */
    $src_width = imagesx($src_img); //宽度
    $src_height = imagesy($src_img); //高度
    /* 判断鼠标点合法性，是否在图片内部 */
    if($x>$src_width || $x<0){
        echo "鼠标点X轴不在图片内！";
        die;
    }
    if($y>$src_height || $y<0){
        echo "鼠标点Y轴不在图片内！";
        die;
    }
    //计算截图的起点x坐标和截取宽
    if($src_width<=$new_width){ //截图的宽大于等于原图的宽
        $x_start = 0;
        $x_width = $src_width; //x轴截取宽度为原图宽度
    }elseif($x<=$new_width/2){ //截图左侧出界
        $x_start = 0;
        $x_width = $new_width;
    }elseif(($src_width-$x)<=$new_width/2){ //截图右侧出界
        $x_start = $src_width-$new_height;
        $x_width = $new_width;
    }else{ //正常情况
        $x_start = $x-($new_width/2);
        $x_width = $new_width;
    }
    //计算截图的起点y坐标和截取高
    if($src_height<=$new_height){ //截图的高大于等于原图的高
        $y_start = 0;
        $y_height = $src_height; //y轴截取高度
    }elseif($y<=$new_height/2){
        $y_start = 0;
        $y_height = $new_height;
    }elseif(($src_height-$x)<=$new_height/2){
        $y_start = $src_height-$new_height;
        $y_height = $new_height;
    }else{ //正常情况
        $y_start = $y-($new_height/2);
        $y_height = $new_height;
    }

    // 为剪切图像创建背景画板
    $new_img = imagecreatetruecolor($x_width, $y_height);
    //拷贝剪切的图像数据到画板，生成剪切图像
    imagecopy($new_img, $src_img, 0, 0, $x_start, $y_start, $x_width, $y_height);

    if($flag){ //保存图片到原图同级目录下
        switch ($img_type) {
            case IMAGETYPE_JPEG :
                imagejpeg($new_img, $dst_file, 100);
                break;
            case IMAGETYPE_PNG :
                imagepng($new_img, $dst_file, 9);
                break;
            case IMAGETYPE_GIF :
                imagegif($new_img, $dst_file, 100);
                break;
            default:
                break;
        }
        return ltrim($dst_file, '.'); //返回截图的文件名
    }else{ //直接在浏览器上输出图片
        switch ($img_type) {
            case IMAGETYPE_JPEG :
                header('Content-type: image/jpeg');
                imagejpeg($new_img);
                break;
            case IMAGETYPE_PNG :
                header('Content-type: image/png');
                imagepng($new_img);
                break;
            case IMAGETYPE_GIF :
                header('Content-type: image/gif');
                imagegif($new_img);
                break;
            default:
                break;
        }
    }
}


$a = "11.jpg";
echo cut_image($a,80,80,390,390);

