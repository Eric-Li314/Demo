<?php
error_reporting(0);

$uptypes=array(
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);
$max_file_size=2000000;	 //上传文件大小限制, 单位BYTE
$destination_folder="uploadimg/"; //上传文件路径
$cun="../../images/uploadimg/";
$imgpreview=1;	  //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize=1/2;	//缩略图比例


$picname = $_FILES['mypic']['name'];
$picsize = $_FILES['mypic']['size'];
$pic_path = "./files/".$picname ;
move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
echo json_encode($picname);


function img_create_small($big_img, $width, $height, $small_img) {//原始大图地址，缩略图宽度，高度，缩略图地址
    $imgage = getimagesize($big_img); //得到原始大图片
    switch ($imgage[2]) { // 图像类型判断
        case 1:
            $im = imagecreatefromgif($big_img);
            break;
        case 2:
            $im = imagecreatefromjpeg($big_img);
            break;
        case 3:
            $im = imagecreatefrompng($big_img);
            break;
    }
    $src_W = $imgage[0]; //获取大图片宽度
    $src_H = $imgage[1]; //获取大图片高度
    $tn = imagecreatetruecolor($width, $height); //创建缩略图
    imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
    imagejpeg($tn, $small_img); //输出图像
}

img_create_small("./files/1.png",100,100,"./files/1-as.png");