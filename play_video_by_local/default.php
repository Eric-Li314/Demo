<?php
header("content-type:text/html;charset=utf-8");

function read_all_dir ( $dir )
{
    $result = array();
    $handle = opendir($dir);
    if ( $handle )
    {
        while ( ( $file = readdir ( $handle ) ) !== false )
        {
            if ( $file != '.' && $file != '..')
            {
                $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
                if ( is_dir ( $cur_path ) )
                {
                    $result['dir'][$cur_path] = read_all_dir ( $cur_path );
                }
                else
                {
                    $result['file'][] = $cur_path;
                    $result['files'][] = $file;
                }
            }
        }
        closedir($handle);
    }
    return $result;
}

$all = read_all_dir("D:\\wamp\\www\\123");
$files = $all['files'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>播放本地视频</title>
    <script src="jquery-1.8.3.min.js"></script>
    <script>
        $(function(){
            //以下是调用浏览器判断的函数
            var mb = myBrowser();
            if ("IE" == mb) {
                //alert("我是 IE");
            }
            if ("FF" == mb) {
                //alert("我是 Firefox");
            }
            if ("Chrome" == mb) {
                alert("该浏览器播放视频时会出现异常，请切换到其他浏览器！");
            }
            /*if ("Opera" == mb) {
             alert("我是 Opera");
             }
             if ("Safari" == mb) {
             alert("我是 Safari");
             }*/


            $('ol li').click(function(){
                var fname = $(this).html();
                $(this).css("color","blue").siblings().css("color","black");
                $('video').attr("src","http://localhost/123/"+fname);
            });
        });

        function myBrowser(){
            var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
            var isOpera = userAgent.indexOf("Opera") > -1;
            if (isOpera) {
                return "Opera"
            }; //判断是否Opera浏览器
            if (userAgent.indexOf("Firefox") > -1) {
                return "FF";
            } //判断是否Firefox浏览器
            if (userAgent.indexOf("Chrome") > -1){
                return "Chrome";
            }
            if (userAgent.indexOf("Safari") > -1) {
                return "Safari";
            } //判断是否Safari浏览器
            if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera) {
                return "IE";
            }; //判断是否IE浏览器
        }

    </script>
</head>
<body>
<!--http://localhost/123/123.MP4-->
<!--width="480" height="420"-->
<p>视频文件目录放在www(网站根目录)目录下</p>
<div style="width:200px;float:left;border:1px solid gray;min-height:200px;margin-right:20px;">
    <h4 style="text-align:center;">playlist</h4>
    <ol>
        <?php foreach($files as $v){?>
            <li style="cursor:pointer;"><?php echo $v;?></li>
        <?php }?>
    </ol>
</div>
<div style="float:left;border:0px solid gray;width:500px;height:290px;">
    <!--    <embed src="http://localhost/123/111.jpg" quality="high" width="100%" height="100%"-->
    <!--           align="middle" allowScriptAccess="sameDomain" allowFullScreen="true" autostart="true" >-->
    <!--    </embed>-->
    <video src="http://localhost/123/1234.MP4" controls="controls" width="100%" height="100%">
        your browser does not support the video tag
    </video>
</div>
<div style="clear:both;"></div>

</body>
</html>