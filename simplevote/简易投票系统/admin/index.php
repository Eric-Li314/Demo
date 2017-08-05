<?php
	@session_start();
	if( !isset($_SESSION['admin']) || !isset($_SESSION['user']) || ( $_SESSION['user']!== true && $_SESSION['admin']!== true ) ){
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=login.html\">";
		exit();
	}
	if($_GET['do']=="logout"){
		 unset($_SESSION['admin']);
		 unset($_SESSION['user']); 
		 @session_destroy(); 
		 echo "<meta http-equiv=\"Refresh\" content=\"0;url=login.html\">";
		 exit();
	}
	
 ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>简易投票系统管理后台</title>

<link rel="stylesheet" href="css/index.css" type="text/css" media="screen" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tendina.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

</head>
<body>
    <!--顶部-->
    <div class="layout_top_header">
            <div style="float: left"><span style="font-size: 16px;line-height: 45px;padding-left: 20px;color: #8d8d8d">简易投票系统管理后台</h1></span></div>
            <div id="ad_setting" class="ad_setting">
                <a class="ad_setting_a" href="javascript:; ">
                    <i class="icon-user glyph-icon" style="font-size: 20px"></i>
                    <?php if($_SESSION['admin'] == true){?><span>管理员</span><?php }else{?><span>用户</span><?php }?>
                    <i class="icon-chevron-down glyph-icon"></i>
                </a>
                <ul class="dropdown-menu-uu" style="display: none" id="ad_setting_ul">
                     <?php if($_SESSION['admin'] == true){?><li class="ad_setting_ul_li"> <a href="Adminset.php" target="menuFrame"><i class="icon-cog glyph-icon"></i> 设置 </a> </li><?php }?>
                    <li class="ad_setting_ul_li"> <a href="javascript:document.location.href='?do=logout';" ><i class="icon-signout glyph-icon"></i> <span class="font-bold">退出</span> </a> </li>
                </ul>
            </div>
    </div>
    <!--顶部结束-->
    <!--菜单-->
    <div class="layout_left_menu">
        <ul id="menu">
		<?php 
			if($_SESSION['admin'] == true){
			?>
            <li class="childUlLi">
               <a href="main.html"  target="menuFrame"><i class="glyph-icon icon-home"></i>首页</a>
                <ul>
					<li><a href="Adminset.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>管理员设置</a></li>
					<li><a href="Voteset.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>投票设置</a></li>
                </ul>
            </li>
            <li class="childUlLi">
                <a href="user.html"  target="menuFrame"> <i class="glyph-icon icon-reorder"></i>成员管理</a>
                <ul>
                    <li><a href="Useradd.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>用户添加</a></li>
                    <li><a href="Usermanage.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>用户管理</a></li>
                </ul>
            </li>
            <li class="childUlLi">
                <a href="#"> <i class="glyph-icon icon-reorder"></i>投票管理</a>
                <ul>
                    <li><a href="Addsubject.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>添加投票题目</a></li>
                    <li><a href="Addvoteoption.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>添加投票选项</a></li>
					<li><a href="Subjectmanage.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>管理投票题目</a></li>
					<li><a href="Optionmanage.php" target="menuFrame"><i class="glyph-icon icon-chevron-right"></i>管理投票选项</a></li>
                </ul>
            </li>
            <li class="childUlLi">
                <a href="Votedata.php" target="menuFrame"> <i class="glyph-icon icon-location-arrow"></i>投票数据查看</a>
            </li>
			
			<?php }else{?>
            <li class="childUlLi">
                <a href="Votedata.php" target="menuFrame"> <i class="glyph-icon icon-location-arrow"></i>投票数据查看</a>
            </li>
			<?php } ?>
        </ul>
    </div>
    <!--菜单-->
    <div id="layout_right_content" class="layout_right_content">
        <div class="mian_content">
            <div id="page_content">
                <iframe id="menuFrame" name="menuFrame" src="Votedata.php" style="overflow:visible;"
                        scrolling="yes" frameborder="no" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
    <div class="layout_footer">
        <p>Copyright © 2014 - Horic</p>
    </div>
</body>
</html>