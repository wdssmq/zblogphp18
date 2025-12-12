<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
$appid = 'tpure';
if (!$zbp->CheckRights($action)) {
	$zbp->ShowError(6);
	die();
}
if (!$zbp->CheckPlugin($appid)) {
	$zbp->ShowError(48);
	die();
}

$lang = &$zbp->lang;
if($zbp->Config('tpure')->PostADMINZHON == '1'){
	$zbp->LoadLanguage('theme', 'tpure', 'zh-cn');
}

//配置页标题
$blogtitle = $lang['tpure']['admin']['theme_name'] . 'v' . $zbp->themeapp->version . $lang['tpure']['admin']['setting'];
$act = $_GET['act'] == "base" ? 'base' : $_GET['act'];

require $zbp->path . 'zb_system/admin/admin_header.php';
require $zbp->path . 'zb_system/admin/admin_top.php';

//判断是否安装“UEditor”插件，配置页图片上传依赖此插件
$ueUrl = $zbp->host .'zb_users/plugin/AppCentre/main.php?id=228';
if($zbp->LoadApp('plugin', 'UEditor')->isloaded){
	echo '<script type="text/javascript" src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.config.php"></script>';
	echo '<script type="text/javascript" src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.all.min.js"></script>';
}else{
	$zbp->ShowHint('bad', $lang['tpure']['pleaseinstall'].' (<a href="'. $ueUrl .'">'. $lang['tpure']['ueditor'] .'</a>) '. $lang['tpure']['plugin'] .'！');
}
?>
<link rel="stylesheet" href="./script/admin.css?v=<?php echo $zbp->themeapp->version?>">
<script type="text/javascript" src="./script/custom.js?v=<?php echo $zbp->themeapp->version?>"></script>
<script>window.theme = {ajaxpost:<?php if($zbp->Config('tpure')->PostAJAXPOSTON == '0'){echo 0;}else{echo 1;}?>}</script>
<div class="twrapper">
<div class="theader">
	<div class="theadbg"><div class="tips"><?php echo $lang['tpure']['admin']['tips'];?><strong>Ctrl + S</strong> <?php echo $lang['tpure']['admin']['tipscon'];?></div></div>
	<div class="tuser">
		<div class="tuserimg"><img src="style/images/sethead.png"></div>
		<div class="tusername"><?php echo $lang['tpure']['admin']['theme_name'] . '<em>v' . $zbp->themeapp->version . '</em>' . $lang['tpure']['admin']['setting']; ?></div>
	</div>
	<div class="tmenu">
		<ul>
		<?php tpure_SubMenu($act); ?>
		</ul>
	</div>
</div>
<div class="tmain <?php if($zbp->option['ZC_BLOG_LANGUAGEPACK'] == 'en' && $zbp->Config('tpure')->PostADMINZHON == '0'){echo 'en';}?>">
<?php
if ($act == 'base') {
	if (isset($_POST['PostLOGO'])) {
		CheckIsRefererValid();
		$zbp->Config('tpure')->PostLOGO = $_POST['PostLOGO'];				   //网站LOGO
		$zbp->Config('tpure')->PostNIGHTLOGO = $_POST['PostNIGHTLOGO'];					//网站夜间模式LOGO
		$zbp->Config('tpure')->PostLOGOON = $_POST['PostLOGOON'];					//图片LOGO开关
		$zbp->Config('tpure')->PostLOGOHOVERON = $_POST['PostLOGOHOVERON'];		 //LOGO划过动效开关
		$zbp->Config('tpure')->PostFAVICON = $_POST['PostFAVICON'];				//浏览器标签栏图标
		$zbp->Config('tpure')->PostFAVICONON = $_POST['PostFAVICONON'];				//浏览器标签栏图标开关
		$zbp->Config('tpure')->PostTHUMB = $_POST['PostTHUMB'];				//固定缩略图
		$zbp->Config('tpure')->PostTHUMBON = $_POST['PostTHUMBON'];			 //默认缩略图开关(无图默认)
		$zbp->Config('tpure')->PostRANDTHUMBON = $_POST['PostRANDTHUMBON'];			 //随机缩略图开关(无图默认)
		$zbp->Config('tpure')->PostIMGON = $_POST['PostIMGON'];			 //列表缩略图总开关(有则展示)
		$zbp->Config('tpure')->PostSIDEIMGON = $_POST['PostSIDEIMGON'];		 //侧栏主题模块缩略图
		$zbp->Config('tpure')->PostRANDTHUMBLENGTH = $_POST['PostRANDTHUMBLENGTH'];			//随机缩略图上限数量
		if($_POST['PostBANNERON'] == '1'){
			$zbp->Config('tpure')->PostSLIDEPLACE = '0';		//幻灯切换为首页列表顶部
		}
		$zbp->Config('tpure')->PostBANNERON = $_POST['PostBANNERON'];	 //首页banner总开关
		$zbp->Config('tpure')->PostBANNER = $_POST['PostBANNER'];			 //首页banner图片
		$zbp->Config('tpure')->PostBANNERDISPLAYON = $_POST['PostBANNERDISPLAYON'];		 //首页banner视差滚动效果开关
		$zbp->Config('tpure')->PostBANNERALLON = $_POST['PostBANNERALLON'];		 //banner全站展示开关
		$zbp->Config('tpure')->PostBANNERFONT = $_POST['PostBANNERFONT'];		 //首页banner文字内容
		$zbp->Config('tpure')->PostBANNERPCHEIGHT = $_POST['PostBANNERPCHEIGHT'];		 //首页banner电脑端高度
		$zbp->Config('tpure')->PostBANNERMHEIGHT = $_POST['PostBANNERMHEIGHT'];		 //首页banner移动端端高度
		$zbp->Config('tpure')->PostBANNERSEARCHWORDS = $_POST['PostBANNERSEARCHWORDS'];		   //Banner搜索推荐词
		$zbp->Config('tpure')->PostBANNERSEARCHLABEL = $_POST['PostBANNERSEARCHLABEL'];		   //Banner搜索推荐词提示：
		$zbp->Config('tpure')->PostBANNERSEARCHON = $_POST['PostBANNERSEARCHON'];		   //Banner搜索功能开关
		$zbp->Config('tpure')->PostBANNERSEARCHALLON = $_POST['PostBANNERSEARCHALLON'];		   //Banner全站搜索功能开关
		$zbp->Config('tpure')->PostSEARCHON = $_POST['PostSEARCHON'];		   //导航搜索功能开关
		$zbp->Config('tpure')->PostSCHTXT = $_POST['PostSCHTXT'];				//导航搜索默认文字
		$zbp->Config('tpure')->PostVIEWALLON = $_POST['PostVIEWALLON'];	//内容页查看全部开关
		$zbp->Config('tpure')->PostVIEWALLTYPE = $_POST['PostVIEWALLTYPE'];	//设备类型(PC|移动端|两者)
		$zbp->Config('tpure')->PostVIEWALLHEIGHT = $_POST['PostVIEWALLHEIGHT'];
		$zbp->Config('tpure')->PostVIEWALLSTYLE = isset($_POST['PostVIEWALLSTYLE']) ? $_POST['PostVIEWALLSTYLE'] : '1';
		$zbp->Config('tpure')->PostVIEWALLSINGLEON = $_POST['PostVIEWALLSINGLEON'];
		$zbp->Config('tpure')->PostVIEWALLPAGEON = $_POST['PostVIEWALLPAGEON'];
		$zbp->Config('tpure')->PostLISTINFO = json_encode($_POST['post_list_info']);		//列表辅助信息
		$zbp->Config('tpure')->PostARTICLEINFO = json_encode($_POST['post_article_info']);	//文章辅助信息
		$zbp->Config('tpure')->PostPAGEINFO = json_encode($_POST['post_page_info']);		//页面辅助信息
		$zbp->Config('tpure')->PostSINGLEKEY = $_POST['PostSINGLEKEY']; //上下篇左右键翻页
		$zbp->Config('tpure')->PostLISTKEY = $_POST['PostLISTKEY'];			//列表底部分页条左右键翻页
		$zbp->Config('tpure')->PostRELATEON = $_POST['PostRELATEON'];			//文章页相关文章开关
		$zbp->Config('tpure')->PostRELATETITLE = $_POST['PostRELATETITLE'];		 //文章页相关文章标题
		$zbp->Config('tpure')->PostRELATECATE = $_POST['PostRELATECATE'];			//文章页相关文章仅显示当前分类相关
		$zbp->Config('tpure')->PostRELATENUM = $_POST['PostRELATENUM'];		 //文章页相关文章展示个数
		$zbp->Config('tpure')->PostRELATESTYLE = $_POST['PostRELATESTYLE'];			//文章页相关文章样式(图文|精简)
		$zbp->Config('tpure')->PostRELATEDIALLEL = $_POST['PostRELATEDIALLEL'];	//文章页相关文章精简列数
		$zbp->Config('tpure')->PostARTICLECMTON = $_POST['PostARTICLECMTON'];	   //文章评论开关
		$zbp->Config('tpure')->PostPAGECMTON = $_POST['PostPAGECMTON'];		 //页面评论开关
		$zbp->Config('tpure')->PostCMTMAILON = $_POST['PostCMTMAILON'];	   //文章评论邮箱字段开关
		$zbp->Config('tpure')->PostCMTMAILNOTNULLON = $_POST['PostCMTMAILNOTNULLON']; //文章评论邮箱字段必填开关
		$zbp->Config('tpure')->PostCMTSITEON = $_POST['PostCMTSITEON'];	   //文章评论网址字段开关
		$zbp->Config('tpure')->PostCMTTIMEON = $_POST['PostCMTTIMEON']; //评论时间开关
		$zbp->Config('tpure')->PostCMTLOGINON = $_POST['PostCMTLOGINON'];	   //登录后评论开关
		$zbp->Config('tpure')->PostCMTIPON = $_POST['PostCMTIPON'];			 //评论者IP
		$zbp->Config('tpure')->VerifyCode = $_POST['VerifyCode'];			//自定义验证码出现的字符集
		$zbp->Config('tpure')->PostCMSON = $_POST['PostCMSON'];			//首页CMS模块开关
		$zbp->Config('tpure')->PostCMS = tpure_FormatID($_POST['PostCMS']);			//首页CMS模块分类ID
		$zbp->Config('tpure')->PostCMSLENGTH = $_POST['PostCMSLENGTH'];			//首页CMS模块分类列表文章数量
		$zbp->Config('tpure')->PostCMSCOLUMN = $_POST['PostCMSCOLUMN'];			//首页CMS模块列数
		$zbp->Config('tpure')->PostINDEXLISTON = $_POST['PostINDEXLISTON'];	   //首页列表开关
		$zbp->Config('tpure')->PostINDEXSTYLE = $_POST['PostINDEXSTYLE'];	   //首页列表样式
		$zbp->Config('tpure')->PostSEARCHSTYLE = $_POST['PostSEARCHSTYLE'];	   //搜索列表样式
		$zbp->Config('tpure')->PostAJAXON = $_POST['PostAJAXON'];			   //分页AJAX加载开关
		$zbp->Config('tpure')->PostLOADPAGENUM = $_POST['PostLOADPAGENUM']; //AJAX自动加载页数
		if(isset($_POST['PostFILTERCATEGORY'])){
			if(is_array($_POST['PostFILTERCATEGORY'])){
				$zbp->Config('tpure')->PostFILTERCATEGORY = implode(',', $_POST['PostFILTERCATEGORY']);
			} else {
				$zbp->Config('tpure')->PostFILTERCATEGORY = $_POST['PostFILTERCATEGORY'];
			}
		}else{
			$zbp->Config('tpure')->PostFILTERCATEGORY = '';
		}
		$zbp->Config('tpure')->PostISTOPSIMPLEON = $_POST['PostISTOPSIMPLEON'];			 //精简置顶开关
		$zbp->Config('tpure')->PostISTOPINDEXON = $_POST['PostISTOPINDEXON'];			 //仅第一页置顶
		$zbp->Config('tpure')->PostGREYON = $_POST['PostGREYON'];			   //整站变灰开关
		$zbp->Config('tpure')->PostGREYSTATE = $_POST['PostGREYSTATE'];			 //0.首页变灰，1.整站变灰
		$zbp->Config('tpure')->PostGREYDAY = $_POST['PostGREYDAY'];			 //设置指定日期网站变灰
		$zbp->Config('tpure')->PostSETNIGHTON = $_POST['PostSETNIGHTON'];   //网站开关灯
		$zbp->Config('tpure')->PostSETNIGHTAUTOON = $_POST['PostSETNIGHTAUTOON'];   //网站自动开关灯
		$zbp->Config('tpure')->PostSETNIGHTSTART = $_POST['PostSETNIGHTSTART']; //关灯开始时间
		$zbp->Config('tpure')->PostSETNIGHTOVER = $_POST['PostSETNIGHTOVER'];   //关灯结束时间
		$zbp->Config('tpure')->PostTIMESTYLE = $_POST['PostTIMESTYLE'];			//日期时间样式
		$zbp->Config('tpure')->PostCOPYNOTICEON = $_POST['PostCOPYNOTICEON'];			   //版权声明开关
		$zbp->Config('tpure')->PostCOPYNOTICEMOBILEON = $_POST['PostCOPYNOTICEMOBILEON'];				//版权声明移动端开关
		$zbp->Config('tpure')->PostCOPYURLON = $_POST['PostCOPYURLON'];	//版权声明链接地址
		$zbp->Config('tpure')->PostQRON = $_POST['PostQRON'];	//二维码开关
		$zbp->Config('tpure')->PostQRSIZE = $_POST['PostQRSIZE'];	//二维码尺寸
		$zbp->Config('tpure')->PostCOPYNOTICE = $_POST['PostCOPYNOTICE'];				//版权声明内容
		$zbp->Config('tpure')->PostSHAREARTICLEON = $_POST['PostSHAREARTICLEON'];				//文章分享按钮开关
		$zbp->Config('tpure')->PostSHAREPAGEON = $_POST['PostSHAREPAGEON'];				//独立页面分享按钮开关
		$zbp->Config('tpure')->PostSHARE = json_encode($_POST['post_share']);		//分享组件
		$zbp->Config('tpure')->PostARCHIVEINFOON = $_POST['PostARCHIVEINFOON']; //归档总数量
		$zbp->Config('tpure')->PostARCHIVEFOLDON = $_POST['PostARCHIVEFOLDON']; //自动折叠归档
		$zbp->Config('tpure')->PostAUTOARCHIVEON = $_POST['PostAUTOARCHIVEON'];	//自动文章归档
		$zbp->Config('tpure')->PostARCHIVEDATEON = $_POST['PostARCHIVEDATEON'];	//归档文章日期开关
		$zbp->Config('tpure')->PostARCHIVEDATETYPE = $_POST['PostARCHIVEDATETYPE'];	//归档文章日期类型
		$zbp->Config('tpure')->PostARCHIVEDATESORT = $_POST['PostARCHIVEDATESORT'];	//归档月份排序
		$zbp->Config('tpure')->PostFRIENDLINKON = $_POST['PostFRIENDLINKON'];		   //首页友情链接开关
		$zbp->Config('tpure')->PostFRIENDLINKMON = $_POST['PostFRIENDLINKMON'];		   //移动端友情链接开关
		$zbp->Config('tpure')->PostERRORTOPAGE = $_POST['PostERRORTOPAGE'];		   //网站无权限时自动跳转自定义页面
		$zbp->Config('tpure')->PostCLOSESITEBG = $_POST['PostCLOSESITEBG'];		   //网站关闭页面背景
		$zbp->Config('tpure')->PostCLOSESITEBGMASKON = $_POST['PostCLOSESITEBGMASKON'];   //网站关闭页面背景蒙版开关
		$zbp->Config('tpure')->PostCLOSESITETITLE = $_POST['PostCLOSESITETITLE'];		   //网站关闭页面标题
		$zbp->Config('tpure')->PostCLOSESITECON = $_POST['PostCLOSESITECON'];		   //网站关闭页面内容
		$zbp->Config('tpure')->PostSIGNON = $_POST['PostSIGNON'];		   //导航自定义登录按钮开关
		$zbp->Config('tpure')->PostSIGNBTNTEXT = $_POST['PostSIGNBTNTEXT'];		   //导航自定义登录按钮文字
		$zbp->Config('tpure')->PostSIGNBTNURL = $_POST['PostSIGNBTNURL'];		   //导航自定义登录按钮链接
		$zbp->Config('tpure')->PostSIGNUSERSTYLE = $_POST['PostSIGNUSERSTYLE'];		   //导航用户登录后样式[0:常规带下拉,1:精简仅头像]
		$zbp->Config('tpure')->PostSIGNUSERURL = $_POST['PostSIGNUSERURL'];		   //导航用户头像链接跳转
		$zbp->Config('tpure')->PostSIGNUSERMENU = $_POST['PostSIGNUSERMENU'];		   //导航用户下拉菜单
		$zbp->Config('tpure')->PostSITEMAPON = $_POST['PostSITEMAPON'];		   //面包屑开关
		$zbp->Config('tpure')->PostSITEMAPMON = $_POST['PostSITEMAPMON'];		   //移动端面包屑开关
		$zbp->Config('tpure')->PostSITEMAPSTYLE = $_POST['PostSITEMAPSTYLE'];		   //面包屑尾巴
		$zbp->Config('tpure')->PostSITEMAPTXT = $_POST['PostSITEMAPTXT'];		   //面包屑首页文字
		$zbp->Config('tpure')->PostZBAUDIOON = $_POST['PostZBAUDIOON'];		   //音频播放器开关
		$zbp->Config('tpure')->PostVIDEOON = $_POST['PostVIDEOON'];		   //视频播放器开关
		$zbp->Config('tpure')->PostMEDIAICONON = $_POST['PostMEDIAICONON'];		   //列表标题媒体图标开关
		$zbp->Config('tpure')->PostMEDIAICONSTYLE = $_POST['PostMEDIAICONSTYLE'];		   //列表标题媒体图标位置
		$zbp->Config('tpure')->PostREADERSNUM = $_POST['PostREADERSNUM'];		   //读者墙页面读者个数限制
		$zbp->Config('tpure')->PostREADERSURLON = $_POST['PostREADERSURLON'];		   //读者墙页面仅输出填写网址的读者
		$zbp->Config('tpure')->PostINTROSOURCE = $_POST['PostINTROSOURCE'];		   //摘要调用方式
		$zbp->Config('tpure')->PostINTRONUM = (int)($_POST['PostINTRONUM']);		   //摘要字数限制
		$zbp->Config('tpure')->PostBLOCKQUOTEON = $_POST['PostBLOCKQUOTEON'];		   //详情摘要开关
		$zbp->Config('tpure')->PostBLOCKQUOTELABEL = $_POST['PostBLOCKQUOTELABEL'];		   //详情摘要标签
		$zbp->Config('tpure')->PostBACKTOTOPON = $_POST['PostBACKTOTOPON'];	 //返回顶部开关
		$zbp->Config('tpure')->PostBACKTOTOPVALUE = $_POST['PostBACKTOTOPVALUE'];	 //返回顶部下拉距离
		$zbp->Config('tpure')->PostUNDEBUGON = $_POST['PostUNDEBUGON'];		   //内容保护总开关
		$zbp->Config('tpure')->PostUNDRAGON = $_POST['PostUNDRAGON'];		   //屏蔽拖拽动作开关
		$zbp->Config('tpure')->PostUNRIGHTMENUON = $_POST['PostUNRIGHTMENUON'];		   //屏蔽鼠标右键开关
		$zbp->Config('tpure')->PostUNKEYON = $_POST['PostUNKEYON'];		   //屏蔽调试快捷键开关
		$zbp->Config('tpure')->PostUNSELECTTEXTON = $_POST['PostUNSELECTTEXTON'];	//屏蔽文本选中开关
		$zbp->Config('tpure')->PostUNCOPYON = $_POST['PostUNCOPYON'];		   //屏蔽复制动作开关
		$zbp->Config('tpure')->PostDEBUGGERON = $_POST['PostDEBUGGERON'];		   //无限断点反调试Debugger开关
		$zbp->Config('tpure')->PostDEBUGCLEANON = $_POST['PostDEBUGCLEANON'];		   //调试清空页面开关
		$zbp->Config('tpure')->PostDEBUGHREFON = $_POST['PostDEBUGHREFON'];		   //调试跳转页面开关
		$zbp->Config('tpure')->PostDEBUGHREF = $_POST['PostDEBUGHREF'];		   //调试跳转页面链接地址
		$zbp->Config('tpure')->PostPREVNEXTTYPE = $_POST['PostPREVNEXTTYPE'];		   //文章上下页开关
		$zbp->Config('tpure')->PostCATEPREVNEXTON = $_POST['PostCATEPREVNEXTON'];		   //文章上下页仅限本分类开关
		$zbp->Config('tpure')->PostNEXTCONTENTLIMIT = $_POST['PostNEXTCONTENTLIMIT'];		   //阅读下一篇正文截取的段落数量
		$zbp->Config('tpure')->PostLOGINON = $_POST['PostLOGINON'];				//主题自带登录样式开关
		$zbp->Config('tpure')->PostLOGINBG = $_POST['PostLOGINBG'];				//主题自带登录页背景图片
		$zbp->Config('tpure')->PostARTICLELINKON = $_POST['PostARTICLELINKON'];			 //文章外链转内链开关
		$zbp->Config('tpure')->PostCMTLINKON = $_POST['PostCMTLINKON'];			 //评论外链转内链开关
		$zbp->Config('tpure')->PostGOURLTITLE = $_POST['PostGOURLTITLE'];			 //文章外链转内链标题
		$zbp->Config('tpure')->PostGOURLTIP = $_POST['PostGOURLTIP'];			 //文章外链转内链提示
		$zbp->Config('tpure')->PostBLANKSTYLE = $_POST['PostBLANKSTYLE'];			 //链接打开方式
		$zbp->Config('tpure')->PostFILTERON = $_POST['PostFILTERON'];		//列表排序功能开关
		$zbp->Config('tpure')->PostMOREBTNON = $_POST['PostMOREBTNON'];			 //列表查看全文按钮开关
		$zbp->Config('tpure')->PostBIGPOSTIMGON = $_POST['PostBIGPOSTIMGON'];				//放大列表缩略图开关
		$zbp->Config('tpure')->PostFIXMENUON = $_POST['PostFIXMENUON'];				//导航悬浮开关
		$zbp->Config('tpure')->PostTIMGBOXON = $_POST['PostTIMGBOXON'];				//图片灯箱开关
		$zbp->Config('tpure')->PostLAZYLOADON = $_POST['PostLAZYLOADON'];		   //全局图片延时加载开关
		$zbp->Config('tpure')->PostLAZYLINEON = $_POST['PostLAZYLINEON'];		   //顶部滚动进度条开关
		$zbp->Config('tpure')->PostLAZYNUMON = $_POST['PostLAZYNUMON'];		   //底部滚动进度数开关
		$zbp->Config('tpure')->PostINDENTON = $_POST['PostINDENTON'];		   //首行缩进开关
		$zbp->Config('tpure')->PostTAGSON = $_POST['PostTAGSON'];		   //文章标签开关
		$zbp->Config('tpure')->PostTFONTSIZEON = $_POST['PostTFONTSIZEON'];		   //正文字号控件开关
		$zbp->Config('tpure')->PostREMOVEPON = $_POST['PostREMOVEPON'];			//隐藏文章空段落开关
		$zbp->Config('tpure')->PostCONVERTON = $_POST['PostCONVERTON'];		   //繁简体转换功能开关
		$zbp->Config('tpure')->PostMYRIABITON = $_POST['PostMYRIABITON'];		   //数以万计开关
		$zbp->Config('tpure')->PostADMINZHON = $_POST['PostADMINZHON'];		   //设置保持中文
		$zbp->SaveConfig('tpure');
		tpure_ArchiveAutoCache();
		tpure_delArchive();
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<script type="text/javascript">
	var editor = new baidu.editor.ui.Editor({ toolbars:[['source','insertimage','Paragraph','FontFamily','FontSize','Bold','Italic','ForeColor', "backcolor", "link",'justifyleft','justifycenter','justifyright']],initialFrameHeight:100 });
	var closesite = new baidu.editor.ui.Editor({ toolbars:[['source','insertimage','Paragraph','FontFamily','FontSize','Bold','Italic','ForeColor', "backcolor", "link",'justifyleft','justifycenter','justifyright']],initialFrameHeight:100 });
	editor.render("PostCOPYNOTICE");
	closesite.render("PostCLOSESITECON");
</script>
<dl>
	<form method="post" class="setting">
		<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
		<dt><?php echo $lang['tpure']['admin']['baseset'];?></dt>
		<dd>
			<label for="PostLOGO"><?php echo $lang['tpure']['admin']['imglogo'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
						<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
						<th width=20%><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
					<tr>
						<td style="position:relative;"><b><?php echo $lang['tpure']['admin']['light'];?></b><?php if ($zbp->Config('tpure')->PostLOGO) { ?><img src="<?php echo $zbp->Config('tpure')->PostLOGO; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/logo.svg" width="120" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostLOGO" name="PostLOGO" value="<?php if ($zbp->Config('tpure')->PostLOGO) {
		echo $zbp->Config('tpure')->PostLOGO;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/logo.svg';
	} ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
						<td rowspan="2"><br><?php echo $lang['tpure']['admin']['opened'];?><input type="text" id="PostLOGOON" name="PostLOGOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLOGOON; ?>"><br><hr><?php echo $lang['tpure']['admin']['open_animation'];?><input type="text" id="PostLOGOHOVERON" name="PostLOGOHOVERON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLOGOHOVERON; ?>"><br><br></td>
					</tr>
					<tr>
						<td style="background:#202020; position:relative;"><b><?php echo $lang['tpure']['admin']['dark'];?></b><?php if ($zbp->Config('tpure')->PostNIGHTLOGO) { ?><img src="<?php echo $zbp->Config('tpure')->PostNIGHTLOGO; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/nightlogo.svg" width="120" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostNIGHTLOGO" name="PostNIGHTLOGO" value="<?php if ($zbp->Config('tpure')->PostNIGHTLOGO) {
		echo $zbp->Config('tpure')->PostNIGHTLOGO;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/nightlogo.svg';
	} ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['imglogo_desc'];?></span>
		</dd>
		<dd>
			<label for="PostFAVICON"><?php echo $lang['tpure']['admin']['favicon'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
						<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
						<th width="20%"><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
					<tr>
						<td><?php if ($zbp->Config('tpure')->PostFAVICON) { ?><img src="<?php echo $zbp->Config('tpure')->PostFAVICON; ?>" width="16" class="thumbimg"><?php } else { ?><img src="style/images/favicon.ico" width="16" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostFAVICON" name="PostFAVICON" value="<?php if ($zbp->Config('tpure')->PostFAVICON) {
		echo $zbp->Config('tpure')->PostFAVICON;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/favicon.ico';
	} ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
						<td><?php echo $lang['tpure']['admin']['opened'];?><input type="text" id="PostFAVICONON" name="PostFAVICONON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFAVICONON; ?>"></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['favicon_desc'];?></span>
		</dd>
		<dd>
			<label for="PostTHUMB"><?php echo $lang['tpure']['admin']['thumbset'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['default_thumb'];?></th>
						<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
						<th width="20%"><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
					<tr>
						<td><?php if ($zbp->Config('tpure')->PostTHUMB) { ?><img src="<?php echo $zbp->Config('tpure')->PostTHUMB; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/thumb.png" width="120" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostTHUMB" name="PostTHUMB" value="<?php if ($zbp->Config('tpure')->PostTHUMB) {
		echo $zbp->Config('tpure')->PostTHUMB;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/thumb.png';
	} ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
						<td><?php echo $lang['tpure']['admin']['noimg_default'];?><input type="text" id="PostTHUMBON" name="PostTHUMBON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostTHUMBON; ?>"><br><?php echo $lang['tpure']['admin']['noimg_rand'];?><input type="text" id="PostRANDTHUMBON" name="PostRANDTHUMBON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostRANDTHUMBON; ?>"><br><?php echo $lang['tpure']['admin']['hasimg'];?><input type="text" id="PostIMGON" name="PostIMGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostIMGON; ?>"><br><?php echo $lang['tpure']['admin']['sideimg'];?><input type="text" id="PostSIDEIMGON" name="PostSIDEIMGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSIDEIMGON; ?>"><br></td>
					</tr>
					<tr class="bannerset">
						<th colspan="4"><?php echo $lang['tpure']['admin']['randimgnum'];?></th>
					</tr>
					<tr class="bannerset">
						<td colspan="4"><input type="number" id="PostRANDTHUMBLENGTH" name="PostRANDTHUMBLENGTH" placeholder="10" value="<?php echo $zbp->Config('tpure')->PostRANDTHUMBLENGTH; ?>" min="1" step="1" style="width:100%;box-sizing:border-box;"></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['thumbset_desc'];?></span>
		</dd>
		<dd>
			<label for="PostBANNER"><?php echo $lang['tpure']['admin']['bannerset'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
						<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
						<th width="20%"><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
					<tr>
						<td><img src="<?php echo $zbp->Config('tpure')->PostBANNER; ?>" width="120" class="thumbimg"></td>
						<td><input type="text" id="PostBANNER" name="PostBANNER" value="<?php echo $zbp->Config('tpure')->PostBANNER; ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="上传"></td>
						<td><?php echo $lang['tpure']['admin']['opened'];?><input type="text" id="PostBANNERON" name="PostBANNERON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBANNERON; ?>"><div class="dependbanner"<?php echo $zbp->Config('tpure')->PostBANNERON == 1 ? '' : ' style="display:none"'; ?>><?php echo $lang['tpure']['admin']['bannerscroll'];?><input type="text" id="PostBANNERDISPLAYON" name="PostBANNERDISPLAYON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBANNERDISPLAYON; ?>"><br><?php echo $lang['tpure']['admin']['bannerallshow'];?><input type="text" id="PostBANNERALLON" name="PostBANNERALLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBANNERALLON; ?>"></div></td>
					</tr>
					<tr class="bannerset"<?php echo $zbp->Config('tpure')->PostBANNERON == 1 ? '' : ' style="display:none"'; ?>>
						<th colspan="2"><?php echo $lang['tpure']['admin']['bannerfont'];?></th>
						<th><?php echo $lang['tpure']['admin']['bannerpcheight'];?></th>
						<th><?php echo $lang['tpure']['admin']['bannermheight'];?></th>
					</tr>
					<tr class="bannerset"<?php echo $zbp->Config('tpure')->PostBANNERON == 1 ? '' : ' style="display:none"'; ?>>
						<td colspan="2"><input type="text" id="PostBANNERFONT" name="PostBANNERFONT" value="<?php echo $zbp->Config('tpure')->PostBANNERFONT; ?>" style="width:390px;"></td>
						<td><input type="number" id="PostBANNERPCHEIGHT" name="PostBANNERPCHEIGHT" value="<?php echo $zbp->Config('tpure')->PostBANNERPCHEIGHT; ?>" style="width:80px;"></td>
						<td><input type="number" id="PostBANNERMHEIGHT" name="PostBANNERMHEIGHT" value="<?php echo $zbp->Config('tpure')->PostBANNERMHEIGHT; ?>" style="width:80px;"></td>
					</tr>
					<tr class="bannerset"<?php echo $zbp->Config('tpure')->PostBANNERON == 1 ? '' : ' style="display:none"'; ?>>
						<th colspan="2"><?php echo $lang['tpure']['admin']['bannerschwords'];?></th>
						<th><?php echo $lang['tpure']['admin']['bannerschtitle'];?></th>
						<th><?php echo $lang['tpure']['admin']['bannerschon'];?></th>
					</tr>
					<tr class="bannerset"<?php echo $zbp->Config('tpure')->PostBANNERON == 1 ? '' : ' style="display:none"'; ?>>
						<td colspan="2"><input type="text" id="PostBANNERSEARCHWORDS" name="PostBANNERSEARCHWORDS" value="<?php echo $zbp->Config('tpure')->PostBANNERSEARCHWORDS; ?>" class="urltext" style="width:390px;"></td>
						<td><input type="text" id="PostBANNERSEARCHLABEL" name="PostBANNERSEARCHLABEL" value="<?php echo $zbp->Config('tpure')->PostBANNERSEARCHLABEL; ?>" style="width:80px;"></td>
						<td><?php echo $lang['tpure']['admin']['bannerindex'];?><input type="text" id="PostBANNERSEARCHON" name="PostBANNERSEARCHON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBANNERSEARCHON; ?>"><br><p id="bannerschallon"><?php echo $lang['tpure']['admin']['bannerall'];?><input type="text" id="PostBANNERSEARCHALLON" name="PostBANNERSEARCHALLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBANNERSEARCHALLON; ?>"></p></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bannerset_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['schset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['schon'];?></label>
			<input type="text" name="PostSEARCHON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSEARCHON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['schon_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSCHTXT"><?php echo $lang['tpure']['admin']['schtxt'];?></label>
			<input type="text" id="PostSCHTXT" name="PostSCHTXT" value="<?php echo $zbp->Config('tpure')->PostSCHTXT; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['schtxt_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['viewalltitle'];?></dt>
		<dd data-stretch="viewall" class="half">
			<label><?php echo $lang['tpure']['admin']['viewallon'];?></label>
			<input type="text" id="PostVIEWALLON" name="PostVIEWALLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostVIEWALLON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewallon_desc'];?></span>
		</dd>
		<div class="viewallinfo"<?php echo $zbp->Config('tpure')->PostVIEWALLON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['viewalltype'];?></label>
			<select name="PostVIEWALLTYPE">
				<option value="pc" <?php echo $zbp->Config('tpure')->PostVIEWALLTYPE == 'pc' ? 'selected="selected"' : ''; ?>><?php echo $lang['tpure']['admin']['viewallpc'];?></option>
				<option value="mobile" <?php echo $zbp->Config('tpure')->PostVIEWALLTYPE == 'mobile' ? 'selected="selected"' : ''; ?>><?php echo $lang['tpure']['admin']['viewallm'];?></option>
				<option value="both" <?php echo $zbp->Config('tpure')->PostVIEWALLTYPE == 'both' ? 'selected="selected"' : ''; ?>><?php echo $lang['tpure']['admin']['viewallpcm'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewalltype_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostVIEWALLHEIGHT"><?php echo $lang['tpure']['admin']['viewallheight'];?></label>
			<input type="number" id="PostVIEWALLHEIGHT" name="PostVIEWALLHEIGHT" value="<?php echo $zbp->Config('tpure')->PostVIEWALLHEIGHT; ?>" min="1" step="1" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewallheight_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['viewallstyle'];?></label>
			<div class="layoutset">
				<input type="radio" id="viewallstyle1" name="PostVIEWALLSTYLE" value="1" <?php echo $zbp->Config('tpure')->PostVIEWALLSTYLE == '1' ? 'checked="checked"' : ''; ?> class="hideradio">
				<label for="viewallstyle1"<?php echo $zbp->Config('tpure')->PostVIEWALLSTYLE == '1' ? ' class="on"' : ''; ?>><img src="style/images/viewallstyle1.png" alt=""></label>
				<input type="radio" id="viewallstyle0" name="PostVIEWALLSTYLE" value="0" <?php echo $zbp->Config('tpure')->PostVIEWALLSTYLE == '0' ? 'checked="checked"' : ''; ?> class="hideradio">
				<label for="viewallstyle0"<?php echo $zbp->Config('tpure')->PostVIEWALLSTYLE == '0' ? ' class="on"' : ''; ?>><img src="style/images/viewallstyle0.png" alt=""></label>
			</div>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewallstyle_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['viewallsingleon'];?></label>
			<input type="text" id="PostVIEWALLSINGLEON" name="PostVIEWALLSINGLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostVIEWALLSINGLEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewallsingleon_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['viewallpageon'];?></label>
			<input type="text" id="PostVIEWALLPAGEON" name="PostVIEWALLPAGEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostVIEWALLPAGEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['viewallpageon_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['listinfoset'];?> <span><?php echo $lang['tpure']['admin']['listinfosetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$post_info = array(
			'user' => $lang['tpure']['admin']['listinfouser'],
			'date' => $lang['tpure']['admin']['listinfodate'],
			'cate' => $lang['tpure']['admin']['listinfocate'],
			'view' => $lang['tpure']['admin']['listinfoview'],
			'cmt' => $lang['tpure']['admin']['listinfocmt'],
			'edit' => $lang['tpure']['admin']['listinfoedit'],
			'del' => $lang['tpure']['admin']['listinfodel'],
		);
	$list_info = json_decode($zbp->Config('tpure')->PostLISTINFO, true);
	if (count((array)$list_info) == 7) {
		foreach ($list_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $post_info[$key] . '<input name="post_list_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfouser'].'<input name="post_list_info[user]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodate'].'<input name="post_list_info[date]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfocate'].'<input name="post_list_info[cate]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoview'].'<input name="post_list_info[view]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfocmt'].'<input name="post_list_info[cmt]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoedit'].'<input name="post_list_info[edit]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodel'].'<input name="post_list_info[del]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['listinfoset_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['articleinfoset'];?> <span><?php echo $lang['tpure']['admin']['articleinfosetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$article_info = json_decode($zbp->Config('tpure')->PostARTICLEINFO, true);
	if (count((array)$article_info) == 7) {
		foreach ($article_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $post_info[$key] . '<input name="post_article_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfouser'].'<input name="post_article_info[user]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodate'].'<input name="post_article_info[date]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfocate'].'<input name="post_article_info[cate]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoview'].'<input name="post_article_info[view]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfocmt'].'<input name="post_article_info[cmt]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoedit'].'<input name="post_article_info[edit]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodel'].'<input name="post_article_info[del]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['articleinfoset_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['pageinfoset'];?> <span><?php echo $lang['tpure']['admin']['pageinfosetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$page_info = json_decode($zbp->Config('tpure')->PostPAGEINFO, true);
	if (count((array)$page_info) == 6) {
		foreach ($page_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $post_info[$key] . '<input name="post_page_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfouser'].'<input name="post_page_info[user]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodate'].'<input name="post_page_info[date]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoview'].'<input name="post_page_info[view]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfocmt'].'<input name="post_page_info[cmt]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfoedit'].'<input name="post_page_info[edit]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['listinfodel'].'<input name="post_page_info[del]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['pageinfoset_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['keyset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['singlekey'];?></label>
			<input type="text" id="PostSINGLEKEY" name="PostSINGLEKEY" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSINGLEKEY; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['singlekey_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['listkey'];?></label>
			<input type="text" id="PostLISTKEY" name="PostLISTKEY" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLISTKEY; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['listkey_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['relateset'];?></dt>
		<dd data-stretch="relate" class="half">
			<label><?php echo $lang['tpure']['admin']['relate'];?></label>
			<input type="text" id="PostRELATEON" name="PostRELATEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostRELATEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relate_desc'];?></span>
		</dd>
		<div class="relateinfo"<?php echo $zbp->Config('tpure')->PostRELATEON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['relatetitle'];?></label>
			<input type="text" id="PostRELATETITLE" name="PostRELATETITLE" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostRELATETITLE; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relatetitle_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['relatecate'];?></label>
			<input type="text" id="PostRELATECATE" name="PostRELATECATE" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostRELATECATE; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relatecate_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostRELATENUM"><?php echo $lang['tpure']['admin']['relatenum'];?></label>
			<input type="number" id="PostRELATENUM" name="PostRELATENUM" value="<?php echo $zbp->Config('tpure')->PostRELATENUM; ?>" min="1" step="1" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relatenum_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostRELATESTYLE"><?php echo $lang['tpure']['admin']['relatestyle'];?></label>
			<select size="1" name="PostRELATESTYLE" id="PostRELATESTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostRELATESTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['relatestyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostRELATESTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['relatestyle1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relatestyle_desc'];?></span>
		</dd>
		<div class="relatestyleinfo"<?php echo $zbp->Config('tpure')->PostRELATESTYLE == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostRELATEDIALLEL"><?php echo $lang['tpure']['admin']['relatediallel'];?></label>
			<select size="1" name="PostRELATEDIALLEL" id="PostRELATEDIALLEL">
				<option value="0"<?php if($zbp->Config('tpure')->PostRELATEDIALLEL == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['relatediallel0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostRELATEDIALLEL == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['relatediallel1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['relatediallel_desc'];?></span>
		</dd>
		</div>
		</div>
		<dt><?php echo $lang['tpure']['admin']['cmtset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['articlecmt'];?></label>
			<input type="text" id="PostARTICLECMTON" name="PostARTICLECMTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostARTICLECMTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['articlecmt_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['pagecmt'];?></label>
			<input type="text" id="PostPAGECMTON" name="PostPAGECMTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostPAGECMTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['pagecmt_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtmail'];?></label>
			<input type="text" id="PostCMTMAILON" name="PostCMTMAILON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTMAILON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtmail_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtmailnotnull'];?></label>
			<input type="text" id="PostCMTMAILNOTNULLON" name="PostCMTMAILNOTNULLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTMAILNOTNULLON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtmailnotnull_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtsite'];?></label>
			<input type="text" id="PostCMTSITEON" name="PostCMTSITEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTSITEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtsite_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmttime'];?></label>
			<input type="text" id="PostCMTTIMEON" name="PostCMTTIMEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTTIMEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmttime_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtlogin'];?></label>
			<input type="text" id="PostCMTLOGINON" name="PostCMTLOGINON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTLOGINON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtlogin_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtip'];?></label>
			<?php
				$filePath = $zbp->path.'zb_users/theme/tpure/plugin/ipLocation/qqwry.dat';
				if(!file_exists($filePath)){
					echo '<a href="https://www.toyean.com/ipdb.html" target="_blank" class="downbtn">'.$lang['tpure']['admin']['cmtipqqwry'].'</a><input type="hidden" name="PostCMTIPON" value="0">';
				}else{
					echo '<input type="text" id="PostCMTIPON" name="PostCMTIPON" class="checkbox" value="'.$zbp->Config('tpure')->PostCMTIPON.'">';
				}
			?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtip_desc'];?></span>
		</dd>
		<dd>
			<label for="VerifyCode"><?php echo $lang['tpure']['admin']['verifycode'];?></label>
			<input type="text" id="VerifyCode" name="VerifyCode" value="<?php echo $zbp->Config('tpure')->VerifyCode; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['verifycode_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['cmsset'];?></dt>
		<dd data-stretch="cms" class="half">
			<label><?php echo $lang['tpure']['admin']['cmscate'];?></label>
			<input type="text" id="PostCMSON" name="PostCMSON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMSON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cms_desc'];?></span>
		</dd>
		<div class="cmsinfo"<?php echo $zbp->Config('tpure')->PostCMSON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostCMS"><?php echo $lang['tpure']['admin']['cmscate'];?></label>
			<input type="text" id="PostCMS" name="PostCMS" value="<?php echo $zbp->Config('tpure')->PostCMS; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmscate_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostCMSLENGTH"><?php echo $lang['tpure']['admin']['cmslength'];?></label>
			<input type="text" id="PostCMSLENGTH" name="PostCMSLENGTH" value="<?php echo $zbp->Config('tpure')->PostCMSLENGTH; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmslength_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostCMSCOLUMN"><?php echo $lang['tpure']['admin']['cmscolumn'];?></label>
			<select size="1" name="PostCMSCOLUMN">
				<option value="0"<?php if($zbp->Config('tpure')->PostCMSCOLUMN == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['cmscolumn0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostCMSCOLUMN == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['cmscolumn1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmscolumn_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['indexlistset'];?> <span><?php echo $lang['tpure']['admin']['indexlistsetinfo'];?></span></dt>
		<dd class="half" data-stretch="indexlist">
			<label><?php echo $lang['tpure']['admin']['indexlist'];?></label>
			<input type="text" id="PostINDEXLISTON" name="PostINDEXLISTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostINDEXLISTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['indexlist_desc'];?></span>
		</dd>
		<div class="indexlistinfo"<?php echo $zbp->Config('tpure')->PostINDEXLISTON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostINDEXSTYLE"><?php echo $lang['tpure']['admin']['indexstyle'];?></label>
			<select size="1" name="PostINDEXSTYLE" id="PostINDEXSTYLE">
				<option value="100"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '100'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle100'];?></option>
				<option value="0"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle1'];?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle2'];?></option>
				<option value="3"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '3'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle3'];?></option>
				<option value="4"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '4'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle4'];?></option>
				<option value="5"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '5'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle5'];?></option>
				<option value="6"<?php if($zbp->Config('tpure')->PostINDEXSTYLE == '6'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['indexstyle6'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['indexstyle_desc'];?></span>
		</dd>
		</div>
		<dd>
			<label for="PostSEARCHSTYLE"><?php echo $lang['tpure']['admin']['searchstyle'];?></label>
			<select size="1" name="PostSEARCHSTYLE" id="PostSEARCHSTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle1'];?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle2'];?></option>
				<option value="3"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '3'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle3'];?></option>
				<option value="4"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '4'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle4'];?></option>
				<option value="5"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '5'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle5'];?></option>
				<option value="6"<?php if($zbp->Config('tpure')->PostSEARCHSTYLE == '6'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['searchstyle6'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['searchstyle_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['ajaxset'];?> <span><?php echo $lang['tpure']['admin']['ajaxsetinfo'];?></span></dt>
		<dd data-stretch="ajax" class="half">
			<label><?php echo $lang['tpure']['admin']['ajax'];?></label>
			<input type="text" id="PostAJAXON" name="PostAJAXON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostAJAXON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ajax_desc'];?></span>
		</dd>
		<div class="ajaxinfo"<?php echo $zbp->Config('tpure')->PostAJAXON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostLOADPAGENUM"><?php echo $lang['tpure']['admin']['loadpagenum'];?></label>
			<input type="number" id="PostLOADPAGENUM" name="PostLOADPAGENUM" value="<?php echo $zbp->Config('tpure')->PostLOADPAGENUM;?>" min="1" step="1" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['loadpagenum_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['filtercateset'];?></dt>
		<dd>
			<label for="PostFILTERCATEGORY"><?php echo $lang['tpure']['admin']['filtercate'];?></label>
			<select name="PostFILTERCATEGORY[]" id="PostFILTERCATEGORY" multiple><?php echo tpure_Exclude_CategorySelect($zbp->Config('tpure')->PostFILTERCATEGORY); ?></select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['filtercate_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['istopset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['istopsimple'];?></label>
			<input type="text" id="PostISTOPSIMPLEON" name="PostISTOPSIMPLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostISTOPSIMPLEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['istopsimple_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['istopindex'];?></label>
			<input type="text" id="PostISTOPINDEXON" name="PostISTOPINDEXON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostISTOPINDEXON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['istopindex_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['greyset'];?></dt>
		<dd data-stretch="grey">
			<label><?php echo $lang['tpure']['admin']['grey'];?></label>
			<input type="text" id="PostGREYON" name="PostGREYON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostGREYON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['grey_desc'];?></span>
		</dd>
		<div class="greyinfo"<?php echo $zbp->Config('tpure')->PostGREYON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostGREYSTATE"><?php echo $lang['tpure']['admin']['greystate'];?></label>
			<select size="1" name="PostGREYSTATE" id="PostGREYSTATE">
				<option value="0"<?php if($zbp->Config('tpure')->PostGREYSTATE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['greystate0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostGREYSTATE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['greystate1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['greystate_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostGREYDAY"><?php echo $lang['tpure']['admin']['greyday'];?></label>
			<input type="text" id="PostGREYDAY" name="PostGREYDAY" placeholder="选择日期 (非必填)" value="<?php echo $zbp->Config('tpure')->PostGREYDAY; ?>" class="selectdate settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['greyday_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['nightset'];?></dt>
		<dd data-stretch="night" class="half">
			<label><?php echo $lang['tpure']['admin']['setnight'];?></label>
			<input type="text" id="PostSETNIGHTON" name="PostSETNIGHTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSETNIGHTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['setnight_desc'];?></span>
		</dd>
		<div class="nightinfo"<?php echo $zbp->Config('tpure')->PostSETNIGHTON == 1 ? '' : ' style="display:none"'; ?>>
		<dd data-stretch="setnightauto" class="half">
			<label><?php echo $lang['tpure']['admin']['setnightauto'];?></label>
			<input type="text" id="PostSETNIGHTAUTOON" name="PostSETNIGHTAUTOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSETNIGHTAUTOON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['setnightauto_desc'];?></span>
		</dd>
		<div class="setnightautoinfo"<?php echo $zbp->Config('tpure')->PostSETNIGHTAUTOON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostSETNIGHTSTART"><?php echo $lang['tpure']['admin']['setnightstart'];?></label>
			<select size="1" name="PostSETNIGHTSTART" id="PostSETNIGHTSTART">
				<?php
				$nightstr = '';
				$nightstart = $zbp->Config('tpure')->PostSETNIGHTSTART;
				for($i=1; $i<24; $i++){
					$nightstartselect = $nightstart == $i ? 'selected="selected"' : '';
					$nightstr .= '<option value="'.$i.'" '.$nightstartselect.'>'.$i.':00:00</option>';
				}
				echo $nightstr;
				?>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['setnightstart_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSETNIGHTOVER"><?php echo $lang['tpure']['admin']['setnightover'];?></label>
			<select size="1" name="PostSETNIGHTOVER" id="PostSETNIGHTOVER">
				<?php
				$nightstr = '';
				$nightstart = $zbp->Config('tpure')->PostSETNIGHTOVER;
				for($i=1; $i<24; $i++){
					$nightstartselect = $nightstart == $i ? 'selected="selected"' : '';
					$nightstr .= '<option value="'.$i.'" '.$nightstartselect.'>'.$i.':00:00</option>';
				}
				echo $nightstr;
				?>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['setnightover_desc'];?></span>
		</dd>
		</div>
		</div>
		<dt><?php echo $lang['tpure']['admin']['timeset'];?></dt>
		<dd>
			<label for="PostTIMESTYLE"><?php echo $lang['tpure']['admin']['timestyle'];?></label>
			<select size="1" name="PostTIMESTYLE" id="PostTIMESTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['timestyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '1'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),1);?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '2'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),2);?></option>
				<option value="3"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '3'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),3);?></option>
				<option value="4"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '4'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),4);?></option>
				<option value="5"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '5'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),5);?></option>
				<option value="6"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '6'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),6);?></option>
				<option value="7"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '7'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),7);?></option>
				<option value="8"<?php if($zbp->Config('tpure')->PostTIMESTYLE == '7'){echo ' selected="selected"';}?>><?php echo tpure_TimeAgo(date('Y-m-d H:i:s',time()),8);?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['timestyle_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['copynoticeset'];?></dt>
		<dd data-stretch="copynotice" class="half">
			<label><?php echo $lang['tpure']['admin']['copynoticeon'];?></label>
			<input type="text" id="PostCOPYNOTICEON" name="PostCOPYNOTICEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCOPYNOTICEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['copynoticeon_desc'];?></span>
		</dd>
		<div class="copynoticeinfo"<?php echo $zbp->Config('tpure')->PostCOPYNOTICEON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['copynoticem'];?></label>
			<input type="text" id="PostCOPYNOTICEMOBILEON" name="PostCOPYNOTICEMOBILEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCOPYNOTICEMOBILEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['copynoticem_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['copyurl'];?></label>
			<input type="text" id="PostCOPYURLON" name="PostCOPYURLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCOPYURLON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['copyurl_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['qr'];?></label>
			<input type="text" id="PostQRON" name="PostQRON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostQRON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['qr_desc'];?></span>
		</dd>
		<dd>
			<label for="PostQRSIZE"><?php echo $lang['tpure']['admin']['qrsize'];?></label>
			<input type="number" id="PostQRSIZE" name="PostQRSIZE" value="<?php echo $zbp->Config('tpure')->PostQRSIZE; ?>" min="70" step="10" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['qrsize_desc'];?></span>
		</dd>
		<dd>
			<label for="PostCOPYNOTICE"><?php echo $lang['tpure']['admin']['copynotice'];?><br></label>
			<textarea name="PostCOPYNOTICE" id="PostCOPYNOTICE" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostCOPYNOTICE;?></textarea>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['copynotice_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['shareset'];?> <span><?php echo $lang['tpure']['admin']['sharesetinfo'];?></span></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['sharearticle'];?></label>
			<input type="text" id="PostSHAREARTICLEON" name="PostSHAREARTICLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSHAREARTICLEON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sharearticle_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['sharepage'];?></label>
			<input type="text" id="PostSHAREPAGEON" name="PostSHAREPAGEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSHAREPAGEON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sharepage_desc'];?></span>
		</dd>
		<dd class="postshare ckbox">
		<?php
		$share_info = array(
			'weibo' => $lang['tpure']['admin']['weibo'],
			'wechat' => $lang['tpure']['admin']['wechat'],
			'qq' => $lang['tpure']['admin']['qq'],
			'qzone' => $lang['tpure']['admin']['qzone'],
			'douban' => $lang['tpure']['admin']['douban'],
			'linkedin' => $lang['tpure']['admin']['linkedin'],
			'diandian' => $lang['tpure']['admin']['diandian'],
			'facebook' => $lang['tpure']['admin']['facebook'],
			'twitter' => $lang['tpure']['admin']['twitter'],
			'google' => $lang['tpure']['admin']['google'],
		);
		$post_share = json_decode($zbp->Config('tpure')->PostSHARE, true);
	if (count((array)$post_share) == 10) {
		foreach ($post_share as $key => $info) {
			if(isset($share_info[$key])){
				echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $share_info[$key] . '<input name="post_share[' . $key . ']" value="' . $info . '"></div>';
			}
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['weibo'].'<input name="post_share[weibo]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['wechat'].'<input name="post_share[wechat]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['qq'].'<input name="post_share[qq]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['qzone'].'<input name="post_share[qzone]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['douban'].'<input name="post_share[douban]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['linkedin'].'<input name="post_share[linkedin]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['diandian'].'<input name="post_share[diandian]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['facebook'].'<input name="post_share[facebook]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['twitter'].'<input name="post_share[twitter]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['google'].'<input name="post_share[google]" value="1"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['share_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['archiveset'];?> <span></span></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['archiveinfo'];?></label>
			<input type="text" id="PostARCHIVEINFOON" name="PostARCHIVEINFOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostARCHIVEINFOON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['archiveinfo_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['archivefold'];?></label>
			<input type="text" id="PostARCHIVEFOLDON" name="PostARCHIVEFOLDON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostARCHIVEFOLDON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['archivefold'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['autoarchive'];?></label>
			<input type="text" id="PostAUTOARCHIVEON" name="PostAUTOARCHIVEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostAUTOARCHIVEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['autoarchive'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['archivedate'];?></label>
			<input type="text" id="PostARCHIVEDATEON" name="PostARCHIVEDATEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostARCHIVEDATEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['archivedate_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostARCHIVEDATETYPE"><?php echo $lang['tpure']['admin']['archivedatetype'];?></label>
			<select size="1" name="PostARCHIVEDATETYPE" id="PostARCHIVEDATETYPE">
				<option value="0"<?php if($zbp->Config('tpure')->PostARCHIVEDATETYPE == '0'){echo ' selected="selected"';}?>>[<?php echo date($lang['tpure']['admin']['archivedatetype0']);?>]</option>
				<option value="1"<?php if($zbp->Config('tpure')->PostARCHIVEDATETYPE == '1'){echo ' selected="selected"';}?>>[<?php echo date($lang['tpure']['admin']['archivedatetype1']);?>]</option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['archivedatetype_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostARCHIVEDATESORT"><?php echo $lang['tpure']['admin']['archivedatesort'];?></label>
			<select size="1" name="PostARCHIVEDATESORT" id="PostARCHIVEDATESORT">
				<option value="DESC"<?php if($zbp->Config('tpure')->PostARCHIVEDATESORT == 'DESC'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['archivedatesortdesc'];?></option>
				<option value="ASC"<?php if($zbp->Config('tpure')->PostARCHIVEDATESORT == 'ASC'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['archivedatesortasc'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['archivedatesort_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['friendset'];?></dt>
		<dd data-stretch="friendlink" class="half">
			<label><?php echo $lang['tpure']['admin']['friendlink'];?></label>
			<input type="text" id="PostFRIENDLINKON" name="PostFRIENDLINKON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFRIENDLINKON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['friendlink_desc'];?></span>
		</dd>
		<div class="friendlinkinfo"<?php echo $zbp->Config('tpure')->PostFRIENDLINKON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['friendlinkm'];?></label>
			<input type="text" id="PostFRIENDLINKMON" name="PostFRIENDLINKMON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFRIENDLINKMON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['friendlinkm_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['errorset'];?></dt>
		<dd>
			<label for="PostERRORTOPAGE"><?php echo $lang['tpure']['admin']['errortopage'];?></label>
			<input type="text" id="PostERRORTOPAGE" name="PostERRORTOPAGE" value="<?php echo $zbp->Config('tpure')->PostERRORTOPAGE; ?>" placeholder="http(s)://" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['errortopage_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['closesiteset'];?> <span><?php echo $lang['tpure']['admin']['closesitesetinfo'];?></span></dt>
		<dd>
			<label for="PostCLOSESITEBG"><?php echo $lang['tpure']['admin']['closesitebg'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
						<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
						<th width=20%><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
					<tr>
						<td><?php if ($zbp->Config('tpure')->PostCLOSESITEBG) { ?><img src="<?php echo $zbp->Config('tpure')->PostCLOSESITEBG; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/banner.jpg" width="120" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostCLOSESITEBG" name="PostCLOSESITEBG" value="<?php if ($zbp->Config('tpure')->PostCLOSESITEBG) { echo $zbp->Config('tpure')->PostCLOSESITEBG; } else { echo $zbp->host . 'zb_users/theme/tpure/style/images/banner.jpg'; } ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
						<td><br><?php echo $lang['tpure']['admin']['closesitebgmask'];?><input type="text" id="PostCLOSESITEBGMASKON" name="PostCLOSESITEBGMASKON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCLOSESITEBGMASKON; ?>"><br><br></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['closesitebg_desc'];?></span>
		</dd>
		<dd>
			<label for="PostCLOSESITETITLE"><?php echo $lang['tpure']['admin']['closesitetitle'];?></label>
			<input type="text" id="PostCLOSESITETITLE" name="PostCLOSESITETITLE" value="<?php echo $zbp->Config('tpure')->PostCLOSESITETITLE; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['closesitetitle_desc'];?></span>
		</dd>
		<dd>
			<label for="PostCLOSESITECON"><?php echo $lang['tpure']['admin']['closesitecon'];?><br></label>
			<textarea name="PostCLOSESITECON" id="PostCLOSESITECON" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostCLOSESITECON;?></textarea>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['closesitecon_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['signset'];?> <span><?php echo $lang['tpure']['admin']['signsetinfo'];?></span></dt>
		<dd data-stretch="sign">
			<label><?php echo $lang['tpure']['admin']['signon'];?></label>
			<input type="text" id="PostSIGNON" name="PostSIGNON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSIGNON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signon_desc'];?></span>
		</dd>
		<div class="signinfo"<?php echo $zbp->Config('tpure')->PostSIGNON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label for="PostSIGNBTNTEXT"><?php echo $lang['tpure']['admin']['signbtntext'];?></label>
			<input type="text" id="PostSIGNBTNTEXT" name="PostSIGNBTNTEXT" value="<?php echo $zbp->Config('tpure')->PostSIGNBTNTEXT; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signbtntext_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSIGNBTNURL"><?php echo $lang['tpure']['admin']['signbtnurl'];?></label>
			<input type="text" id="PostSIGNBTNURL" name="PostSIGNBTNURL" value="<?php echo $zbp->Config('tpure')->PostSIGNBTNURL; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signbtnurl_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSIGNUSERSTYLE"><?php echo $lang['tpure']['admin']['signuserstyle'];?></label>
			<select size="1" name="PostSIGNUSERSTYLE" id="PostSIGNUSERSTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostSIGNUSERSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['signuserstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostSIGNUSERSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['signuserstyle1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signuserstyle_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSIGNUSERURL"><?php echo $lang['tpure']['admin']['signuserurl'];?></label>
			<input type="text" id="PostSIGNUSERURL" name="PostSIGNUSERURL" value="<?php echo $zbp->Config('tpure')->PostSIGNUSERURL; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signuserurl_desc'];?></span>
		</dd>
		<dd>
			<label for="PostSIGNUSERMENU"><?php echo $lang['tpure']['admin']['signusermenu'];?><br><a href="https://www.toyean.com/help.html" target="_blank" class="tips"><?php echo $lang['tpure']['admin']['signusermenubtn'];?></a></label>
			<textarea name="PostSIGNUSERMENU" id="PostSIGNUSERMENU" cols="30" rows="5" class="setinput"><?php echo $zbp->Config('tpure')->PostSIGNUSERMENU;?></textarea>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['signusermenu_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['sitemapset'];?></dt>
		<dd data-stretch="sitemap" class="half">
			<label><?php echo $lang['tpure']['admin']['sitemap'];?></label>
			<input type="text" id="PostSITEMAPON" name="PostSITEMAPON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSITEMAPON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sitemap_desc'];?></span>
		</dd>
		<div class="sitemapinfo"<?php echo $zbp->Config('tpure')->PostSITEMAPON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['sitemapm'];?></label>
			<input type="text" id="PostSITEMAPMON" name="PostSITEMAPMON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSITEMAPMON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sitemapm_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['sitemapstyle'];?></label>
			<select size="1" name="PostSITEMAPSTYLE" id="PostSITEMAPSTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostSITEMAPSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['sitemapstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostSITEMAPSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['sitemapstyle1'];?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostSITEMAPSTYLE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['sitemapstyle2'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sitemapstyle_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostSITEMAPTXT"><?php echo $lang['tpure']['admin']['sitemaptxt'];?></label>
			<input type="text" id="PostSITEMAPTXT" name="PostSITEMAPTXT" value="<?php echo $zbp->Config('tpure')->PostSITEMAPTXT; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sitemaptxt_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['mediaset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['zbaudio'];?></label>
			<input type="text" id="PostZBAUDIOON" name="PostZBAUDIOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostZBAUDIOON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['zbaudio_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['zbvideo'];?></label>
			<input type="text" id="PostVIDEOON" name="PostVIDEOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostVIDEOON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['zbvideo_desc'];?></span>
		</dd>
		<dd data-stretch="mediaicon" class="half">
			<label><?php echo $lang['tpure']['admin']['mediaicon'];?></label>
			<input type="text" id="PostMEDIAICONON" name="PostMEDIAICONON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostMEDIAICONON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['mediaicon_desc'];?></span>
		</dd>
		<div class="mediaiconinfo"<?php echo $zbp->Config('tpure')->PostMEDIAICONON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['mediaiconstyle'];?></label>
			<select size="1" name="PostMEDIAICONSTYLE" id="PostMEDIAICONSTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostMEDIAICONSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['mediaiconstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostMEDIAICONSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['mediaiconstyle1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['mediaiconstyle_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['readersset'];?> <span><?php echo $lang['tpure']['admin']['readersset'];?></span></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['readersnum'];?></label>
			<input type="number" id="PostREADERSNUM" name="PostREADERSNUM" value="<?php echo $zbp->Config('tpure')->PostREADERSNUM; ?>" min="1" step="1" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['readersnum_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['readersurl'];?></label>
			<input type="text" id="PostREADERSURLON" name="PostREADERSURLON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostREADERSURLON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['readersurl_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['introset'];?></dt>
		<dd class="half">
			<label for="PostINTROSOURCE"><?php echo $lang['tpure']['admin']['introsource'];?></label>
			<select size="1" name="PostINTROSOURCE" id="PostINTROSOURCE">
				<option value="0"<?php if($zbp->Config('tpure')->PostINTROSOURCE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['introsource0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostINTROSOURCE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['introsource1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['introsource_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostINTRONUM"><?php echo $lang['tpure']['admin']['intronum'];?></label>
			<input type="number" id="PostINTRONUM" name="PostINTRONUM" value="<?php echo $zbp->Config('tpure')->PostINTRONUM; ?>" step="10" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['intronum_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['blockquote'];?></label>
			<input type="text" id="PostBLOCKQUOTEON" name="PostBLOCKQUOTEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBLOCKQUOTEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['blockquote_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostBLOCKQUOTELABEL"><?php echo $lang['tpure']['admin']['blockquotelabel'];?></label>
			<input type="text" id="PostBLOCKQUOTELABEL" name="PostBLOCKQUOTELABEL" placeholder="<?php echo $lang['tpure']['admin']['introplaceholder'];?>" value="<?php echo $zbp->Config('tpure')->PostBLOCKQUOTELABEL; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['blockquotelabel_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['backtotopset'];?></dt>
		<dd data-stretch="backtotop" class="half">
			<label><?php echo $lang['tpure']['admin']['backtotop'];?></label>
			<input type="text" id="PostBACKTOTOPON" name="PostBACKTOTOPON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBACKTOTOPON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['backtotop_desc'];?></span>
		</dd>
		<div class="backtotopinfo"<?php echo $zbp->Config('tpure')->PostBACKTOTOPON == 1 ? '' : ' style="display:none"'; ?>>
			<dd class="half">
				<label for="PostBACKTOTOPVALUE"><?php echo $lang['tpure']['admin']['backtotopvalue'];?></label>
				<input type="number" id="PostBACKTOTOPVALUE" name="PostBACKTOTOPVALUE" value="<?php echo $zbp->Config('tpure')->PostBACKTOTOPVALUE; ?>" class="settext">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['backtotopvalue_desc'];?></em></span>
			</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['undebugset'];?> <span><?php echo $lang['tpure']['admin']['undebugsetinfo'];?></span></dt>
		<dd data-stretch="undebug" class="half">
			<label><?php echo $lang['tpure']['admin']['undebug'];?></label>
			<input type="text" id="PostUNDEBUGON" name="PostUNDEBUGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNDEBUGON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['undebug_desc'];?></span>
		</dd>
		<div class="undebuginfo"<?php echo $zbp->Config('tpure')->PostUNDEBUGON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['undrag'];?></label>
			<input type="text" id="PostUNDRAGON" name="PostUNDRAGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNDRAGON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['undrag_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['unrightmenu'];?></label>
			<input type="text" id="PostUNRIGHTMENUON" name="PostUNRIGHTMENUON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNRIGHTMENUON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['unrightmenu_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['unkey'];?></label>
			<input type="text" id="PostUNKEYON" name="PostUNKEYON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNKEYON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['unkey_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['unselecttext'];?></label>
			<input type="text" id="PostUNSELECTTEXTON" name="PostUNSELECTTEXTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNSELECTTEXTON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['unselecttext_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['uncopy'];?></label>
			<input type="text" id="PostUNCOPYON" name="PostUNCOPYON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostUNCOPYON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['uncopy_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['debugger'];?></label>
			<input type="text" id="PostDEBUGGERON" name="PostDEBUGGERON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostDEBUGGERON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['debugger_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['debugclean'];?></label>
			<input type="text" id="PostDEBUGCLEANON" name="PostDEBUGCLEANON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostDEBUGCLEANON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['debugclean'];?></span>
		</dd>
		<dd data-stretch="href" class="half">
			<label><?php echo $lang['tpure']['admin']['debughrefon'];?></label>
			<input type="text" id="PostDEBUGHREFON" name="PostDEBUGHREFON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostDEBUGHREFON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['debughrefon_desc'];?></span>
		</dd>
		<div class="hrefinfo"<?php echo $zbp->Config('tpure')->PostDEBUGHREFON == 1 ? '' : ' style="display:none"'; ?>>
			<dd class="half">
				<label><?php echo $lang['tpure']['admin']['debughref'];?></label>
				<input type="text" id="PostDEBUGHREF" name="PostDEBUGHREF" value="<?php echo $zbp->Config('tpure')->PostDEBUGHREF; ?>" class="settext">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['debughref_desc'];?></span>
			</dd>
		</div>
		</div>
		<dt><?php echo $lang['tpure']['admin']['prevnexttypeset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['prevnexttype'];?></label>
			<select size="1" name="PostPREVNEXTTYPE" id="PostPREVNEXTTYPE">
				<option value="0"<?php if($zbp->Config('tpure')->PostPREVNEXTTYPE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['prevnexttype0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostPREVNEXTTYPE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['prevnexttype1'];?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostPREVNEXTTYPE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['prevnexttype2'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['prevnexttype_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cateprevnext'];?></label>
			<input type="text" id="PostCATEPREVNEXTON" name="PostCATEPREVNEXTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCATEPREVNEXTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cateprevnext_desc'];?></span>
		</dd>
		<div class="nextcontentlimit" <?php echo $zbp->Config('tpure')->PostPREVNEXTTYPE == 2 ? '' : ' style="display:none"'; ?>>
		<dd>
			<label><?php echo $lang['tpure']['admin']['nextcontentlimit'];?></label>
			<input type="number" id="PostNEXTCONTENTLIMIT" name="PostNEXTCONTENTLIMIT" class="settext" value="<?php echo $zbp->Config('tpure')->PostNEXTCONTENTLIMIT;?>" min="1" step="1">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['nextcontentlimit_desc'];?></span>
		</dd>
		</div>
		<dt><?php echo $lang['tpure']['admin']['loginset'];?></dt>
		<dd>
			<label><?php echo $lang['tpure']['admin']['loginon'];?></label>
			<input type="text" id="PostLOGINON" name="PostLOGINON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLOGINON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['loginon_desc'];?></span>
		</dd>
		<dd>
			<label for="PostLOGINBG"><?php echo $lang['tpure']['admin']['loginbg'];?></label>
			<table>
				<tbody>
					<tr>
						<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
						<th width="50%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
						<th width="25%"><?php echo $lang['tpure']['admin']['upload'];?></th>
					</tr>
					<tr>
						<td><?php if ($zbp->Config('tpure')->PostLOGINBG) { ?><img src="<?php echo $zbp->Config('tpure')->PostLOGINBG; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/favicon.ico" width="120" class="thumbimg"><?php } ?></td>
						<td><input type="text" id="PostLOGINBG" name="PostLOGINBG" value="<?php if ($zbp->Config('tpure')->PostLOGINBG) {
		echo $zbp->Config('tpure')->PostLOGINBG;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/banner.jpg';
	} ?>" class="urltext thumbsrc"></td>
						<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
					</tr>
				</tbody>
			</table>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['loginbg_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['articlelinkset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['articlelink'];?></label>
			<input type="text" id="PostARTICLELINKON" name="PostARTICLELINKON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostARTICLELINKON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['articlelink_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['cmtlink'];?></label>
			<input type="text" id="PostCMTLINKON" name="PostCMTLINKON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTLINKON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtlink_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostGOURLTITLE"><?php echo $lang['tpure']['admin']['gourltitle'];?></label>
			<input type="text" id="PostGOURLTITLE" name="PostGOURLTITLE" placeholder="<?php echo $lang['tpure']['admin']['gourltitledefault'];?>" value="<?php echo $zbp->Config('tpure')->PostGOURLTITLE; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['gourltitle_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="PostGOURLTIP"><?php echo $lang['tpure']['admin']['gourltip'];?></label>
			<input type="text" id="PostGOURLTIP" name="PostGOURLTIP" placeholder="<?php echo $lang['tpure']['admin']['gourltipdefault'];?>" value="<?php echo $zbp->Config('tpure')->PostGOURLTIP; ?>" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['gourltip_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['otherset'];?></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['blankstyle'];?></label>
			<select size="1" name="PostBLANKSTYLE" id="PostBLANKSTYLE">
				<option value="0"<?php if($zbp->Config('tpure')->PostBLANKSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['blankstyle0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->PostBLANKSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['blankstyle1'];?></option>
				<option value="2"<?php if($zbp->Config('tpure')->PostBLANKSTYLE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['blankstyle2'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['blankstyle_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['filter'];?></label>
			<input type="text" id="PostFILTERON" name="PostFILTERON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFILTERON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['filter'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['morebtn'];?></label>
			<input type="text" id="PostMOREBTNON" name="PostMOREBTNON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostMOREBTNON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['morebtn_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['bigpostimg'];?></label>
			<input type="text" id="PostBIGPOSTIMGON" name="PostBIGPOSTIMGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBIGPOSTIMGON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bigpostimg_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['fixmenu'];?></label>
			<input type="text" id="PostFIXMENUON" name="PostFIXMENUON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFIXMENUON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['fixmenu_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['timgbox'];?></label>
			<input type="text" id="PostTIMGBOXON" name="PostTIMGBOXON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostTIMGBOXON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['timgbox_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['lazyload'];?></label>
			<input type="text" id="PostLAZYLOADON" name="PostLAZYLOADON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLAZYLOADON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['lazyload_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['lazyline'];?></label>
			<input type="text" id="PostLAZYLINEON" name="PostLAZYLINEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLAZYLINEON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['lazyline'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['lazynum'];?></label>
			<input type="text" id="PostLAZYNUMON" name="PostLAZYNUMON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostLAZYNUMON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['lazynum_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['indent'];?></label>
			<input type="text" id="PostINDENTON" name="PostINDENTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostINDENTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['indent_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['tags'];?></label>
			<input type="text" id="PostTAGSON" name="PostTAGSON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostTAGSON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['tags'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['tfontsize'];?></label>
			<input type="text" id="PostTFONTSIZEON" name="PostTFONTSIZEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostTFONTSIZEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['tfontsize_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['removep'];?></label>
			<input type="text" id="PostREMOVEPON" name="PostREMOVEPON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostREMOVEPON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['removep_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['convert'];?></label>
			<input type="text" id="PostCONVERTON" name="PostCONVERTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCONVERTON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['convert_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['myriabit'];?></label>
			<input type="text" id="PostMYRIABITON" name="PostMYRIABITON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostMYRIABITON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['myriabit_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['adminzh'];?></label>
			<input type="text" id="PostADMINZHON" name="PostADMINZHON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostADMINZHON;?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['adminzh_desc'];?></span>
		</dd>
		<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
	</form>
</dl>

<?php
}
if ($act == 'seo') {
	if (isset($_POST['SEOON'])) {
		$zbp->Config('tpure')->SEOON = $_POST['SEOON'];					 //关键词设置
		$zbp->Config('tpure')->SEODIVIDE = $_POST['SEODIVIDE'];						//关键词分隔符设置
		$zbp->Config('tpure')->SEOTITLE = $_POST['SEOTITLE'];						//关键词设置
		$zbp->Config('tpure')->SEOKEYWORDS = $_POST['SEOKEYWORDS'];				//关键词设置
		$zbp->Config('tpure')->SEODESCRIPTION = $_POST['SEODESCRIPTION'];			//描述设置
		$zbp->Config('tpure')->SEOTITLEDECODEON = $_POST['SEOTITLEDECODEON'];		 //标题unicode转实体
		$zbp->Config('tpure')->SEORETITLEON = $_POST['SEORETITLEON'];		 //分页标题倒置
		$zbp->Config('tpure')->SEODESCRIPTIONDATA = $_POST['SEODESCRIPTIONDATA'];			//描述数据选择，[0:全文,1:摘要]
		$zbp->Config('tpure')->SEODESCRIPTIONNUM = $_POST['SEODESCRIPTIONNUM'];		 //描述字数限制

		$zbp->Config('tpure')->SEOCATALOGINFO = json_encode($_POST['catalog_info']);
		$zbp->Config('tpure')->SEOARTICLEINFO = json_encode($_POST['article_info']);
		$zbp->Config('tpure')->SEOPAGEINFO = json_encode($_POST['page_info']);
		$zbp->Config('tpure')->SEOTAGINFO = json_encode($_POST['tag_info']);
		$zbp->Config('tpure')->SEOUSERINFO = json_encode($_POST['user_info']);
		$zbp->Config('tpure')->SEODATEINFO = json_encode($_POST['date_info']);
		$zbp->Config('tpure')->SEOSEARCHINFO = json_encode($_POST['search_info']);
		$zbp->Config('tpure')->SEOOTHERINFO = json_encode($_POST['other_info']);

		$zbp->Config('tpure')->PostOGINDEXON = $_POST['PostOGINDEXON']; //首页时间因子
		$zbp->Config('tpure')->PostOGCATEGORYON = $_POST['PostOGCATEGORYON']; //分类页时间因子
		$zbp->Config('tpure')->PostOGTAGON = $_POST['PostOGTAGON']; //标签页时间因子
		$zbp->Config('tpure')->PostOGAUTHORON = $_POST['PostOGAUTHORON']; //作者页时间因子
		$zbp->Config('tpure')->PostOGARTICLEON = $_POST['PostOGARTICLEON']; //文章页时间因子
		$zbp->Config('tpure')->PostOGPAGEON = $_POST['PostOGPAGEON']; //单页时间因子

		$zbp->Config('tpure')->PostHEADERCODE = $_POST['PostHEADERCODE'];		   //页头自定义代码$header
		$zbp->Config('tpure')->PostFOOTERCODE = $_POST['PostFOOTERCODE'];		   //页尾自定义代码$footer
		$zbp->Config('tpure')->PostSINGLETOPCODE = $_POST['PostSINGLETOPCODE'];		 //文章正文顶部代码
		$zbp->Config('tpure')->PostSINGLEBTMCODE = $_POST['PostSINGLEBTMCODE'];			//文章正文底部代码
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<form name="seo" method="post" class="setting">
	<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
<dl>
	<dt><?php echo $lang['tpure']['admin']['seoset'];?></dt>
	<dd data-stretch="seo" class="half">
		<label><?php echo $lang['tpure']['admin']['seo'];?></label>
		<input type="text" id="SEOON" name="SEOON" class="checkbox" value="<?php echo $zbp->Config('tpure')->SEOON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seo_desc'];?></span>
	</dd>
	<div class="seoinfo"<?php echo $zbp->Config('tpure')->SEOON == 1 ? '' : ' style="display:none"'; ?>>
		<dd class="half"><label for="SEODIVIDE"><?php echo $lang['tpure']['admin']['seodivide'];?></label><input type="text" name="SEODIVIDE" id="SEODIVIDE" placeholder="<?php echo $lang['tpure']['admin']['seodivideplaceholder'];?>" class="settext" value="<?php echo $zbp->Config('tpure')->SEODIVIDE; ?>"><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seodivide_desc'];?></span></dd>
		<dd><label for="SEOTITLE"><?php echo $lang['tpure']['admin']['seotitle'];?></label><input type="text" name="SEOTITLE" id="SEOTITLE" class="settext" value="<?php echo $zbp->Config('tpure')->SEOTITLE; ?>"><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seotitle_desc'];?></span></dd>
		<dd><label for="SEOKEYWORDS"><?php echo $lang['tpure']['admin']['seokeywords'];?></label><input type="text" name="SEOKEYWORDS" id="SEOKEYWORDS" class="settext" value="<?php echo $zbp->Config('tpure')->SEOKEYWORDS; ?>"><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seokeywords_desc'];?></span></dd>
		<dd><label for="SEODESCRIPTION"><?php echo $lang['tpure']['admin']['seodescription'];?></label><textarea name="SEODESCRIPTION" id="SEODESCRIPTION" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->SEODESCRIPTION; ?></textarea><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seodescription_desc'];?></span></dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['seotitledecode'];?></label>
			<input type="text" id="SEOTITLEDECODEON" name="SEOTITLEDECODEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->SEOTITLEDECODEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seotitledecode_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['seoretitle'];?></label>
			<input type="text" id="SEORETITLEON" name="SEORETITLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->SEORETITLEON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seoretitle'];?></span>
		</dd>
		<dd class="half">
			<label for="SEODESCRIPTIONDATA"><?php echo $lang['tpure']['admin']['seodescriptiondata'];?></label>
			<select size="1" name="SEODESCRIPTIONDATA" id="SEODESCRIPTIONDATA">
				<option value="0"<?php if($zbp->Config('tpure')->SEODESCRIPTIONDATA == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['seodescriptiondata0'];?></option>
				<option value="1"<?php if($zbp->Config('tpure')->SEODESCRIPTIONDATA == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['seodescriptiondata1'];?></option>
			</select>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seodescriptiondata_desc'];?></span>
		</dd>
		<dd class="half">
			<label for="SEODESCRIPTIONNUM"><?php echo $lang['tpure']['admin']['seodescriptionnum'];?></label>
			<input type="number" id="SEODESCRIPTIONNUM" name="SEODESCRIPTIONNUM" value="<?php echo $zbp->Config('tpure')->SEODESCRIPTIONNUM;?>" min="1" step="1" class="settext">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seodescriptionnum_desc'];?></span>
		</dd>
<?php
$seo_info = array(
	'catalog' => $lang['tpure']['admin']['catalog'],
	'article' => $lang['tpure']['admin']['article'],
	'page' => $lang['tpure']['admin']['page'],
	'tag' => $lang['tpure']['admin']['tag'],
	'user' => $lang['tpure']['admin']['user'],
	'date' => $lang['tpure']['admin']['date'],
	'search' => $lang['tpure']['admin']['search'],
	'other' => $lang['tpure']['admin']['other'],
	'title' => $lang['tpure']['admin']['title'],
	'subtitle' => $lang['tpure']['admin']['subtitle'],
);
?>
		<dt><?php echo $lang['tpure']['admin']['seocatalogset'];?> <span><?php echo $lang['tpure']['admin']['seocatalogsetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$catalog_info = json_decode($zbp->Config('tpure')->SEOCATALOGINFO, true);
	if (count((array)$catalog_info)) {
		foreach ($catalog_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="catalog_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['catalog'].'<input name="catalog_info[catalog]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="catalog_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="catalog_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seocatalog_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seoarticleset'];?> <span><?php echo $lang['tpure']['admin']['seoarticlesetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$article_info = json_decode($zbp->Config('tpure')->SEOARTICLEINFO, true);
	if (count((array)$article_info)) {
		foreach ($article_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="article_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['article'].'<input name="article_info[article]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['catalog'].'<input name="article_info[catalog]" value="0"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="article_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="article_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seoarticle_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seopageset'];?> <span><?php echo $lang['tpure']['admin']['seopagesetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$page_info = json_decode($zbp->Config('tpure')->SEOPAGEINFO, true);
	if (count((array)$page_info)) {
		foreach ($page_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="page_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['page'].'<input name="page_info[page]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="page_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="page_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seopage_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seotagset'];?> <span><?php echo $lang['tpure']['admin']['seotagsetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$tag_info = json_decode($zbp->Config('tpure')->SEOTAGINFO, true);
	if (count((array)$tag_info)) {
		foreach ($tag_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="tag_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['tag'].'<input name="tag_info[tag]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="tag_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="tag_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seopage_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seouserset'];?> <span><?php echo $lang['tpure']['admin']['seousersetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$user_info = json_decode($zbp->Config('tpure')->SEOUSERINFO, true);
	if (count((array)$user_info)) {
		foreach ($user_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="user_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['user'].'<input name="user_info[user]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="user_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="user_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seouser_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seodateset'];?> <span><?php echo $lang['tpure']['admin']['seodatesetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$date_info = json_decode($zbp->Config('tpure')->SEODATEINFO, true);
	if (count((array)$date_info)) {
		foreach ($date_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="date_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['date'].'<input name="date_info[date]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="date_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="date_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seodate_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seosearchset'];?> <span><?php echo $lang['tpure']['admin']['seosearchsetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$search_info = json_decode($zbp->Config('tpure')->SEOSEARCHINFO, true);
	if (count((array)$search_info)) {
		foreach ($search_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="search_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['search'].'<input name="search_info[search]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="search_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="search_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seosearch_desc'];?></span>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['seootherset'];?> <span><?php echo $lang['tpure']['admin']['seoothersetinfo'];?></span></dt>
		<dd class="ckbox">
		<?php
		$other_info = json_decode($zbp->Config('tpure')->SEOOTHERINFO, true);
	if (count((array)$other_info)) {
		foreach ($other_info as $key => $info) {
			echo '<div class="checkui' . ($info == 1 ? ' on' : '') . '">' . $seo_info[$key] . '<input name="other_info[' . $key . ']" value="' . $info . '"></div>';
		}
	}else{
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['other'].'<input name="other_info[other]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['title'].'<input name="other_info[title]" value="1"></div>';
		echo '<div class="checkui ui-sortable-handle">'.$lang['tpure']['admin']['subtitle'].'<input name="other_info[subtitle]" value="0"></div>';
	} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['seoother_desc'];?></span>
		</dd>
	</div>
	<dt><?php echo $lang['tpure']['admin']['ogset'];?> <span><?php echo $lang['tpure']['admin']['ogsetinfo'];?></span></dt>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogindex'];?></label>
		<input type="text" id="PostOGINDEXON" name="PostOGINDEXON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGINDEXON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogindex_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogcatalog'];?></label>
		<input type="text" id="PostOGCATEGORYON" name="PostOGCATEGORYON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGCATEGORYON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogcatalog_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogtag'];?></label>
		<input type="text" id="PostOGTAGON" name="PostOGTAGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGTAGON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogtag_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogauthor'];?></label>
		<input type="text" id="PostOGAUTHORON" name="PostOGAUTHORON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGAUTHORON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogauthor_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogarticle'];?></label>
		<input type="text" id="PostOGARTICLEON" name="PostOGARTICLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGARTICLEON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogarticle_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['ogpage'];?></label>
		<input type="text" id="PostOGPAGEON" name="PostOGPAGEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostOGPAGEON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ogpage_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['customcodeset'];?> <span><?php echo $lang['tpure']['admin']['customcodesetinfo'];?></span></dt>
	<dd>
		<label for="PostHEADERCODE"><?php echo $lang['tpure']['admin']['headercode'];?></label><textarea name="PostHEADERCODE" id="PostHEADERCODE" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostHEADERCODE; ?></textarea><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['headercode_desc'];?></span>
	</dd>
	<dd>
		<label for="PostFOOTERCODE"><?php echo $lang['tpure']['admin']['footercode'];?></label><textarea name="PostFOOTERCODE" id="PostFOOTERCODE" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostFOOTERCODE; ?></textarea><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['footercode_desc'];?></span>
	</dd>
	<dd>
		<label for="PostSINGLETOPCODE"><?php echo $lang['tpure']['admin']['singletopcode'];?></label><textarea name="PostSINGLETOPCODE" id="PostSINGLETOPCODE" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostSINGLETOPCODE; ?></textarea><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['singletopcode_desc'];?></span>
	</dd>
	<dd>
		<label for="PostSINGLEBTMCODE"><?php echo $lang['tpure']['admin']['singlebtmcode'];?></label><textarea name="PostSINGLEBTMCODE" id="PostSINGLEBTMCODE" cols="30" rows="3" class="setinput"><?php echo $zbp->Config('tpure')->PostSINGLEBTMCODE; ?></textarea><i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['singlebtmcode_desc'];?></span>
	</dd>
	<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
</dl>
</form>

<?php
}
if ($act == 'color') {
	if (isset($_POST['PostCOLORON'])) {
		$zbp->Config('tpure')->PostCOLORON = $_POST['PostCOLORON'];				//自定义配色开关
		$zbp->Config('tpure')->PostFONT = $_POST['PostFONT'];	   //自定义字体
		$zbp->Config('tpure')->PostCOLOR = $_POST['PostCOLOR'];					//主色调
		$zbp->Config('tpure')->PostSIDELAYOUT = isset($_POST['PostSIDELAYOUT']) ? $_POST['PostSIDELAYOUT'] : 'r';   //侧栏位置
		$zbp->Config('tpure')->PostBGCOLOR = $_POST['PostBGCOLOR'];		 //页面背景色
		$zbp->Config('tpure')->PostBGIMG = $_POST['PostBGIMG'];		 //页面背景图片
		$zbp->Config('tpure')->PostBGIMGON = $_POST['PostBGIMGON'];		 //页面背景开关
		$zbp->Config('tpure')->PostBGIMGSTYLE = $_POST['PostBGIMGSTYLE'];		   //页面背景样式
		$zbp->Config('tpure')->PostHEADBGCOLOR = $_POST['PostHEADBGCOLOR'];		 //页头背景色
		$zbp->Config('tpure')->PostFOOTBGCOLOR = $_POST['PostFOOTBGCOLOR'];		 //页尾背景色
		$zbp->Config('tpure')->PostFOOTFONTCOLOR = $_POST['PostFOOTFONTCOLOR'];			//页尾文字颜色
		$zbp->Config('tpure')->PostBANNERMASKBG = $_POST['PostBANNERMASKBG'];			//banner遮罩颜色
		$zbp->Config('tpure')->PostBANNERMASKOPACITY = $_POST['PostBANNERMASKOPACITY'];			//banner遮罩透明度
		$zbp->Config('tpure')->PostCUSTOMCSS = $_POST['PostCUSTOMCSS'];			//自定义CSS
		$zbp->Config('tpure')->PostCOLORTOKEN = date('ymdHis');
		$tpure_color = tpure_color();
		@file_put_contents($zbp->path . 'zb_users/theme/tpure/include/skin.css', $tpure_color);
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<script type="text/javascript" src="./plugin/jscolor/jscolor.js"></script>
<link rel="stylesheet" type="text/css" href="./plugin/codemirror/codemirror.css">
<link rel="stylesheet" type="text/css" href="./plugin/codemirror/default.css">
<script type="text/javascript" src="./plugin/codemirror/codemirror.js"></script>
<script type="text/javascript" src="./plugin/codemirror/active-line.js"></script>
<script type="text/javascript" src="./plugin/codemirror/placeholder.js"></script>
<script type="text/javascript" src="./plugin/codemirror/matchbrackets.js"></script>
<script type="text/javascript" src="./plugin/codemirror/css.js"></script>
<form name="color" method="post" class="setting">
	<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
<dl>
	<dt><?php echo $lang['tpure']['admin']['colorset'];?></dt>
	<dd data-stretch="color">
		<label><?php echo $lang['tpure']['admin']['color'];?></label>
		<input type="text" id="PostCOLORON" name="PostCOLORON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCOLORON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['color_desc'];?></span>
	</dd>
	<div class="colorinfo"<?php echo $zbp->Config('tpure')->PostCOLORON == 1 ? '' : ' style="display:none"'; ?>>
	<dd>
		<label for="PostFONT"><?php echo $lang['tpure']['admin']['font'];?><br><a href="https://www.toyean.com/help.html" target="_blank" class="tips"><?php echo $lang['tpure']['admin']['fontsyntax'];?></a></label>
		<textarea name="PostFONT" cols="30" rows="3" placeholder="<?php echo $lang['tpure']['admin']['fonttip'];?>" id="PostFONT" class="setinput"><?php echo $zbp->Config('tpure')->PostFONT; ?></textarea>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['font_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostCOLOR"><?php echo $lang['tpure']['admin']['color'];?></label>
		<input type="text" name="PostCOLOR" id="PostCOLOR" class="color settext" value="<?php echo $zbp->Config('tpure')->PostCOLOR; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['color_desc'];?></span>
	</dd>
	<dd class="half">
		<label for=""><?php echo $lang['tpure']['admin']['sidelayout'];?></label>
		<div class="layoutset">
			<input type="radio" id="sideleft" name="PostSIDELAYOUT" value="l" <?php echo $zbp->Config('tpure')->PostSIDELAYOUT == 'l' ? 'checked="checked"' : ''; ?> class="hideradio">
			<label for="sideleft"<?php echo $zbp->Config('tpure')->PostSIDELAYOUT == 'l' ? ' class="on"' : ''; ?>><img src="style/images/sideleft.png" alt="<?php echo $lang['tpure']['admin']['sidelayoutl'];?>"></label>
			<input type="radio" id="sideright" name="PostSIDELAYOUT" value="r" <?php echo $zbp->Config('tpure')->PostSIDELAYOUT == 'r' ? 'checked="checked"' : ''; ?> class="hideradio">
			<label for="sideright"<?php echo $zbp->Config('tpure')->PostSIDELAYOUT == 'r' ? ' class="on"' : ''; ?>><img src="style/images/sideright.png" alt="<?php echo $lang['tpure']['admin']['sidelayoutr'];?>"></label>
		</div>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sidelayout_desc'];?></span>
	</dd>
	<dd>
		<label for="PostBGCOLOR"><?php echo $lang['tpure']['admin']['bgcolor'];?></label>
		<input type="text" name="PostBGCOLOR" id="PostBGCOLOR" class="color settext" value="<?php echo $zbp->Config('tpure')->PostBGCOLOR; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bgcolor_desc'];?></span>
	</dd>
	<dd>
		<label for="PostBGIMG"><?php echo $lang['tpure']['admin']['bgimgset'];?></label>
		<table>
			<tbody>
				<tr>
					<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?></th>
					<th width="35%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
					<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
					<th width=20%><?php echo $lang['tpure']['admin']['set'];?></th>
				</tr>
				<tr>
					<td><?php if ($zbp->Config('tpure')->PostBGIMG) { ?><img src="<?php echo $zbp->Config('tpure')->PostBGIMG; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/background.jpg" width="120" class="thumbimg"><?php } ?></td>
					<td><input type="text" id="PostBGIMG" name="PostBGIMG" value="<?php if ($zbp->Config('tpure')->PostBGIMG) {
		echo $zbp->Config('tpure')->PostBGIMG;
	} else {
		echo $zbp->host . 'zb_users/theme/tpure/style/images/background.jpg';
	} ?>" class="urltext thumbsrc"></td>
					<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
					<td><?php echo $lang['tpure']['admin']['bgimgon'];?> <input type="text" id="PostBGIMGON" name="PostBGIMGON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostBGIMGON; ?>"><br>
		<select size="1" name="PostBGIMGSTYLE" id="PostBGIMGSTYLE" style="width:130px;">
			<option value="1"<?php if($zbp->Config('tpure')->PostBGIMGSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['bgimgstyle1'];?></option>
			<option value="2"<?php if($zbp->Config('tpure')->PostBGIMGSTYLE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['bgimgstyle2'];?></option>
		</select></td>
				</tr>
			</tbody>
		</table>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bgimg_desc'];?></span>
	</dd>
	<dd>
		<label for="PostHEADBGCOLOR"><?php echo $lang['tpure']['admin']['headbgcolor'];?></label>
		<input type="text" name="PostHEADBGCOLOR" id="PostHEADBGCOLOR" class="color settext" value="<?php echo $zbp->Config('tpure')->PostHEADBGCOLOR; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['headbgcolor_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostFOOTBGCOLOR"><?php echo $lang['tpure']['admin']['footbgcolor'];?></label>
		<input type="text" name="PostFOOTBGCOLOR" id="PostFOOTBGCOLOR" class="color settext" value="<?php echo $zbp->Config('tpure')->PostFOOTBGCOLOR ? $zbp->Config('tpure')->PostFOOTBGCOLOR : 'e4e8eb'; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['footbgcolor_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostFOOTFONTCOLOR"><?php echo $lang['tpure']['admin']['footfontcolor'];?></label>
		<input type="text" name="PostFOOTFONTCOLOR" id="PostFOOTFONTCOLOR" class="color settext" value="<?php echo $zbp->Config('tpure')->PostFOOTFONTCOLOR ? $zbp->Config('tpure')->PostFOOTFONTCOLOR : '999999'; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['footfontcolor_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostBANNERMASKBG"><?php echo $lang['tpure']['admin']['bannermaskbg'];?></label>
		<input type="text" name="PostBANNERMASKBG" id="PostBANNERMASKBG" class="color settext" value="<?php echo $zbp->Config('tpure')->PostBANNERMASKBG ? $zbp->Config('tpure')->PostBANNERMASKBG : '000000'; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bannermaskbg_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['bannermaskopacity'];?></label>
		<div class="range">
		<input type="range" name="PostBANNERMASKOPACITY" id="PostBANNERMASKOPACITY" class="setrange" min="0" max="100" step="1" data-thumbwidth="20" value="<?php echo $zbp->Config('tpure')->PostBANNERMASKOPACITY ? $zbp->Config('tpure')->PostBANNERMASKOPACITY : '0'; ?>">
		<output></output>
		</div>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['bannermaskopacity_desc'];?></span>
	</dd>
	<script>
  $(function(){
	$('input[type="range"]').on('input', function(){
	var control = $(this),
		controlMin = control.attr('min'),
		controlMax = control.attr('max'),
		controlVal = control.val(),
		controlThumbWidth = control.data('thumbwidth');

	var range = controlMax - controlMin;

	var position = ((controlVal - controlMin) / range) * 100;
	var positionOffset = Math.round(controlThumbWidth * position / 100) - (controlThumbWidth / 2);
	var output = control.next('output');

	output.css('left', 'calc(' + position + '% - ' + positionOffset + 'px)')
		.text(controlVal);
	});
  } );
  </script>
	<dd>
		<label for="PostCUSTOMCSS"><?php echo $lang['tpure']['admin']['customcss'];?></label>
		<div class="codearea">
			<textarea name="PostCUSTOMCSS" id="PostCUSTOMCSS" cols="30" rows="5" placeholder="<?php echo $lang['tpure']['admin']['customcsstip'];?>" class="setinput"><?php echo $zbp->Config('tpure')->PostCUSTOMCSS; ?></textarea>
		</div>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['customcss_desc'];?></span>
	</dd>
	</div>
	<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
</dl>
</form>
<?php
}
if ($act == 'side') {
	if (isset($_POST['PostFIXSIDEBARON'])) {
		$zbp->Config('tpure')->PostFIXSIDEBARON = $_POST['PostFIXSIDEBARON'];	//侧栏悬浮开关
		$zbp->Config('tpure')->PostFIXSIDEBARSTYLE = $_POST['PostFIXSIDEBARSTYLE']; //侧栏悬浮样式
		$zbp->Config('tpure')->PostSIDEMOBILEON = $_POST['PostSIDEMOBILEON'];	//移动端侧栏开关
		$zbp->Config('tpure')->PostSIDECMTDAY = $_POST['PostSIDECMTDAY'];			//侧栏热评文章模块指定天数
		$zbp->Config('tpure')->PostSIDEVIEWDAY = $_POST['PostSIDEVIEWDAY'];			//侧栏热门文章模块指定天数
		$zbp->Config('tpure')->PostSIDERECID = tpure_FormatID($_POST['PostSIDERECID']);			//侧栏热推文章模块指定ID
		if(isset($_POST['PostSIDECATEID'])){
			if(is_array($_POST['PostSIDECATEID'])){
				$zbp->Config('tpure')->PostSIDECATEID = implode(',', $_POST['PostSIDECATEID']);
			} else {
				$zbp->Config('tpure')->PostSIDECATEID = $_POST['PostSIDECATEID'];
			}
		}else{
			$zbp->Config('tpure')->PostSIDECATEID = '';
		}
		$zbp->Config('tpure')->PostSIDEUSERBG = $_POST['PostSIDEUSERBG'];			//侧栏站长简介模块背景图片
		$zbp->Config('tpure')->PostSIDEUSERIMG = $_POST['PostSIDEUSERIMG'];			//侧栏站长简介模块头像
		$zbp->Config('tpure')->PostSIDEUSERNAME = $_POST['PostSIDEUSERNAME'];		//侧栏站长简介模块站长名称
		$zbp->Config('tpure')->PostSIDEUSERINTRO = $_POST['PostSIDEUSERINTRO'];		//侧栏站长简介模块站长简介
		$zbp->Config('tpure')->PostSIDEUSERWECHAT = $_POST['PostSIDEUSERWECHAT'];	//侧栏站长简介模块微信二维码
		$zbp->Config('tpure')->PostSIDEUSERQQ = $_POST['PostSIDEUSERQQ'];			//侧栏站长简介模块QQ号码
		$zbp->Config('tpure')->PostSIDEUSEREMAIL = $_POST['PostSIDEUSEREMAIL'];		//侧栏站长简介模块邮箱地址
		$zbp->Config('tpure')->PostSIDEUSERWEIBO = $_POST['PostSIDEUSERWEIBO'];		//侧栏站长简介模块微博URL
		$zbp->Config('tpure')->PostSIDEUSERGROUP = $_POST['PostSIDEUSERGROUP'];		//侧栏站长简介模块QQ群链接
		$zbp->Config('tpure')->PostSIDEUSERDOUYIN = $_POST['PostSIDEUSERDOUYIN'];	//侧栏站长简介模块抖音链接
		$zbp->Config('tpure')->PostSIDEUSERKUAISHOU = $_POST['PostSIDEUSERKUAISHOU'];		//侧栏站长简介模块快手链接
		$zbp->Config('tpure')->PostSIDEUSERTOUTIAO = $_POST['PostSIDEUSERTOUTIAO'];		//侧栏站长简介模块头条链接
		$zbp->Config('tpure')->PostSIDEUSERBILIBILI = $_POST['PostSIDEUSERBILIBILI'];		//侧栏站长简介模块哔哩哔哩链接
		$zbp->Config('tpure')->PostSIDEUSERXIAOHONGSHU = $_POST['PostSIDEUSERXIAOHONGSHU'];	//侧栏站长简介模块小红书链接
		$zbp->Config('tpure')->PostSIDEUSERZHIHU = $_POST['PostSIDEUSERZHIHU'];			//侧栏站长简介模块知乎链接
		$zbp->Config('tpure')->PostSIDEUSERGITHUB = $_POST['PostSIDEUSERGITHUB'];			//侧栏站长简介模块Github链接
		$zbp->Config('tpure')->PostSIDEUSERGITEE = $_POST['PostSIDEUSERGITEE'];			//侧栏站长简介模块Gitee链接
		$zbp->Config('tpure')->PostSIDEUSERMALL = $_POST['PostSIDEUSERMALL'];			//侧栏站长简介模块商城链接
		$zbp->Config('tpure')->PostSIDEUSERFACEBOOK = $_POST['PostSIDEUSERFACEBOOK'];			//侧栏站长简介模块Facebook链接
		$zbp->Config('tpure')->PostSIDEUSERX = $_POST['PostSIDEUSERX'];			//侧栏站长简介模块X链接
		$zbp->Config('tpure')->PostSIDEUSERINSTAGRAM = $_POST['PostSIDEUSERINSTAGRAM'];		//侧栏站长简介模块Instagram链接
		$zbp->Config('tpure')->PostSIDEUSERYOUTUBE = $_POST['PostSIDEUSERYOUTUBE'];			//侧栏站长简介模块Youtube链接
		$zbp->Config('tpure')->PostSIDEUSERLINKEDIN = $_POST['PostSIDEUSERLINKEDIN'];			//侧栏站长简介模块Linkedin链接
		$zbp->Config('tpure')->PostSIDEUSERDISCORD = $_POST['PostSIDEUSERDISCORD'];			//侧栏站长简介模块Discord链接
		$zbp->Config('tpure')->PostSIDEUSERLINK = $_POST['PostSIDEUSERLINK'];			//侧栏站长简介模块自定义链接
		$zbp->Config('tpure')->PostSIDEUSER = json_encode($_POST['sideuser']);		//侧栏站长简介模块图标顺序
		$zbp->Config('tpure')->PostSIDEUSERCOUNT = $_POST['PostSIDEUSERCOUNT'];			//侧栏站长简介模块底部统计信息
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<form name="side" method="post" class="setting">
	<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
<dl>
	<dt><?php echo $lang['tpure']['admin']['fixsidebarset'];?></dt>
	<dd data-stretch="fixsidebar" class="half">
		<label><?php echo $lang['tpure']['admin']['fixsidebar'];?></label>
		<input type="text" id="PostFIXSIDEBARON" name="PostFIXSIDEBARON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostFIXSIDEBARON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['fixsidebar_desc'];?></span>
	</dd>
	<div class="fixsidebarinfo"<?php echo $zbp->Config('tpure')->PostFIXSIDEBARON == 1 ? '' : ' style="display:none"'; ?>>
	<dd class="half">
		<label for="PostFIXSIDEBARSTYLE"><?php echo $lang['tpure']['admin']['fixsidebarstyle'];?></label>
		<select size="1" name="PostFIXSIDEBARSTYLE" id="PostFIXSIDEBARSTYLE">
			<option value="0"<?php if($zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['fixsidebarstyle0'];?></option>
			<option value="1"<?php if($zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['fixsidebarstyle1'];?></option>
		</select>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['fixsidebarstyle_desc'];?></span>
	</dd>
	</div>
	<dt><?php echo $lang['tpure']['admin']['sidemobileset'];?></dt>
	<dd>
		<label><?php echo $lang['tpure']['admin']['sidemobile'];?></label>
		<input type="text" id="PostSIDEMOBILEON" name="PostSIDEMOBILEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSIDEMOBILEON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sidemobile_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['sidecmtdayset'];?></dt>
	<dd>
		<label for="PostSIDECMTDAY"><?php echo $lang['tpure']['admin']['sidecmtday'];?></label>
		<input type="number" id="PostSIDECMTDAY" name="PostSIDECMTDAY" value="<?php echo $zbp->Config('tpure')->PostSIDECMTDAY; ?>" min="1" step="1" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sidecmtday_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['sideviewdayset'];?></dt>
	<dd>
		<label for="PostSIDEVIEWDAY"><?php echo $lang['tpure']['admin']['sideviewday'];?></label>
		<input type="number" id="PostSIDEVIEWDAY" name="PostSIDEVIEWDAY" value="<?php echo $zbp->Config('tpure')->PostSIDEVIEWDAY; ?>" min="1" step="1" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideviewday_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['siderecset'];?></dt>
	<dd>
		<label for="PostSIDERECID"><?php echo $lang['tpure']['admin']['siderecid'];?></label>
		<input type="text" id="PostSIDERECID" name="PostSIDERECID" value="<?php echo $zbp->Config('tpure')->PostSIDERECID; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['siderecid_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['sidecateset'];?></dt>
	<dd>
		<label for="PostSIDECATEID"><?php echo $lang['tpure']['admin']['sidecateid'];?></label>
		<select name="PostSIDECATEID[]" id="PostSIDECATEID" multiple><?php echo tpure_Exclude_CategorySelect($zbp->Config('tpure')->PostSIDECATEID); ?></select>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sidecateid_desc'];?></span>
	</dd>
	<dt><?php echo $lang['tpure']['admin']['sideuserset'];?></dt>
	<dd>
		<label for="PostSIDEUSERBG"><?php echo $lang['tpure']['admin']['sideuserbg'];?></label>
		<table>
			<tbody>
				<tr>
					<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?>(375x100px)</th>
					<th width="55%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
					<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
				</tr>
				<tr>
					<td><?php if ($zbp->Config('tpure')->PostSIDEUSERBG) { ?><img src="<?php echo $zbp->Config('tpure')->PostSIDEUSERBG; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/banner.jpg" width="120" class="thumbimg"><?php } ?></td>
					<td><input type="text" id="PostSIDEUSERBG" name="PostSIDEUSERBG" value="<?php if ($zbp->Config('tpure')->PostSIDEUSERBG) {
	echo $zbp->Config('tpure')->PostSIDEUSERBG;
} else {
	echo $zbp->host . 'zb_users/theme/tpure/style/images/banner.jpg';
} ?>" class="urltext thumbsrc"></td>
					<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
				</tr>
			</tbody>
		</table>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserbg_desc'];?></span>
	</dd>
	<dd>
		<label for="PostSIDEUSERIMG"><?php echo $lang['tpure']['admin']['sideuserimg'];?></label>
		<table>
			<tbody>
				<tr>
					<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?>(80x80px)</th>
					<th width="55%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
					<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
				</tr>
				<tr>
					<td><?php if ($zbp->Config('tpure')->PostSIDEUSERIMG) { ?><img src="<?php echo $zbp->Config('tpure')->PostSIDEUSERIMG; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/sethead.png" width="120" class="thumbimg"><?php } ?></td>
					<td><input type="text" id="PostSIDEUSERIMG" name="PostSIDEUSERIMG" value="<?php if ($zbp->Config('tpure')->PostSIDEUSERIMG) {
	echo $zbp->Config('tpure')->PostSIDEUSERIMG;
} else {
	echo $zbp->host . 'zb_users/theme/tpure/style/images/sethead.png';
} ?>" class="urltext thumbsrc"></td>
					<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
				</tr>
			</tbody>
		</table>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserimg_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERNAME"><?php echo $lang['tpure']['admin']['sideusername'];?></label>
		<input type="text" id="PostSIDEUSERNAME" name="PostSIDEUSERNAME" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERNAME; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusername_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERINTRO"><?php echo $lang['tpure']['admin']['sideuserintro'];?></label>
		<input type="text" id="PostSIDEUSERINTRO" name="PostSIDEUSERINTRO" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERINTRO; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserintro_desc'];?></span>
	</dd>
	<dd>
		<label for="PostSIDEUSERWECHAT"><?php echo $lang['tpure']['admin']['sideuserwechat'];?></label>
		<table>
			<tbody>
				<tr>
					<th width="25%"><?php echo $lang['tpure']['admin']['thumb'];?>(120x120px)</th>
					<th width="55%"><?php echo $lang['tpure']['admin']['imgurl'];?></th>
					<th width="15%"><?php echo $lang['tpure']['admin']['upload'];?></th>
				</tr>
				<tr>
					<td><?php if ($zbp->Config('tpure')->PostSIDEUSERWECHAT) { ?><img src="<?php echo $zbp->Config('tpure')->PostSIDEUSERWECHAT; ?>" width="120" class="thumbimg"><?php } else { ?><img src="style/images/qr.png" width="120" class="thumbimg"><?php } ?></td>
					<td><input type="text" data-key="wechat" id="PostSIDEUSERWECHAT" name="PostSIDEUSERWECHAT" value="<?php if ($zbp->Config('tpure')->PostSIDEUSERWECHAT) {
	echo $zbp->Config('tpure')->PostSIDEUSERWECHAT;
} else {
	echo $zbp->host . 'zb_users/theme/tpure/style/images/qr.png';
} ?>" class="urltext thumbsrc sideuser-input"></td>
					<td><input type="button" class="uploadimg format" value="<?php echo $lang['tpure']['admin']['upload'];?>"></td>
				</tr>
			</tbody>
		</table>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserwechat_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERQQ"><?php echo $lang['tpure']['admin']['sideuserqq'];?></label>
		<input type="text" data-key="qq" id="PostSIDEUSERQQ" name="PostSIDEUSERQQ" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERQQ; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserqq_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSEREMAIL"><?php echo $lang['tpure']['admin']['sideuseremail'];?></label>
		<input type="text" data-key="email" id="PostSIDEUSEREMAIL" name="PostSIDEUSEREMAIL" value="<?php echo $zbp->Config('tpure')->PostSIDEUSEREMAIL; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuseremail_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERWEIBO"><?php echo $lang['tpure']['admin']['sideuserweibo'];?></label>
		<input type="text" data-key="weibo" id="PostSIDEUSERWEIBO" name="PostSIDEUSERWEIBO" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERWEIBO; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserweibo_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERGROUP"><?php echo $lang['tpure']['admin']['sideusergroup'];?></label>
		<input type="text" data-key="group" id="PostSIDEUSERGROUP" name="PostSIDEUSERGROUP" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERGROUP; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusergroup_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERDOUYIN"><?php echo $lang['tpure']['admin']['sideuserdouyin'];?></label>
		<input type="text" data-key="douyin" id="PostSIDEUSERDOUYIN" name="PostSIDEUSERDOUYIN" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERDOUYIN; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserdouyin_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERKUAISHOU"><?php echo $lang['tpure']['admin']['sideuserkuaishou'];?></label>
		<input type="text" data-key="kuaishou" id="PostSIDEUSERKUAISHOU" name="PostSIDEUSERKUAISHOU" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERKUAISHOU; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserkuaishou_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERTOUTIAO"><?php echo $lang['tpure']['admin']['sideusertoutiao'];?></label>
		<input type="text" data-key="toutiao" id="PostSIDEUSERTOUTIAO" name="PostSIDEUSERTOUTIAO" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERTOUTIAO; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusertoutiao_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERBILIBILI"><?php echo $lang['tpure']['admin']['sideuserbilibili'];?></label>
		<input type="text" data-key="bilibili" id="PostSIDEUSERBILIBILI" name="PostSIDEUSERBILIBILI" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERBILIBILI; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserbilibili_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERXIAOHONGSHU"><?php echo $lang['tpure']['admin']['sideuserxiaohongshu'];?></label>
		<input type="text" data-key="xiaohongshu" id="PostSIDEUSERXIAOHONGSHU" name="PostSIDEUSERXIAOHONGSHU" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERXIAOHONGSHU; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserxiaohongshu_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERZHIHU"><?php echo $lang['tpure']['admin']['sideuserzhihu'];?></label>
		<input type="text" data-key="zhihu" id="PostSIDEUSERZHIHU" name="PostSIDEUSERZHIHU" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERZHIHU; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserzhihu_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERGITHUB"><?php echo $lang['tpure']['admin']['sideusergithub'];?></label>
		<input type="text" data-key="github" id="PostSIDEUSERGITHUB" name="PostSIDEUSERGITHUB" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERGITHUB; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusergithub_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERGITEE"><?php echo $lang['tpure']['admin']['sideusergitee'];?></label>
		<input type="text" data-key="gitee" id="PostSIDEUSERGITEE" name="PostSIDEUSERGITEE" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERGITEE; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusergitee_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERMALL"><?php echo $lang['tpure']['admin']['sideusermall'];?></label>
		<input type="text" data-key="mall" id="PostSIDEUSERMALL" name="PostSIDEUSERMALL" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERMALL; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusermall_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERFACEBOOK"><?php echo $lang['tpure']['admin']['sideuserfacebook'];?></label>
		<input type="text" data-key="facebook" id="PostSIDEUSERFACEBOOK" name="PostSIDEUSERFACEBOOK" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERFACEBOOK; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserfacebook_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERX"><?php echo $lang['tpure']['admin']['sideuserx'];?></label>
		<input type="text" data-key="x" id="PostSIDEUSERX" name="PostSIDEUSERX" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERX; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserx_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERINSTAGRAM"><?php echo $lang['tpure']['admin']['sideuserinstagram'];?></label>
		<input type="text" data-key="instagram" id="PostSIDEUSERINSTAGRAM" name="PostSIDEUSERINSTAGRAM" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERINSTAGRAM; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserinstagram_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERYOUTUBE"><?php echo $lang['tpure']['admin']['sideuseryoutube'];?></label>
		<input type="text" data-key="youtube" id="PostSIDEUSERYOUTUBE" name="PostSIDEUSERYOUTUBE" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERYOUTUBE; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuseryoutube_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERLINKEDIN"><?php echo $lang['tpure']['admin']['sideuserlinkedin'];?></label>
		<input type="text" data-key="linkedin" id="PostSIDEUSERLINKEDIN" name="PostSIDEUSERLINKEDIN" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERLINKEDIN; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserlinkedin_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERDISCORD"><?php echo $lang['tpure']['admin']['sideuserdiscord'];?></label>
		<input type="text" data-key="discord" id="PostSIDEUSERDISCORD" name="PostSIDEUSERDISCORD" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERDISCORD; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserdiscord_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="PostSIDEUSERLINK"><?php echo $lang['tpure']['admin']['sideuserlink'];?></label>
		<input type="text" data-key="link" id="PostSIDEUSERLINK" name="PostSIDEUSERLINK" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERLINK; ?>" class="settext sideuser-input">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserlink_desc'];?></span>
	</dd>
<?php
$sideuser_info = array(
	'wechat' => $lang['tpure']['sidewechat'],
	'qq' => $lang['tpure']['sideqq'],
	'email' => $lang['tpure']['sideemail'],
	'weibo' => $lang['tpure']['sideweibo'],
	'group' => $lang['tpure']['sidegroup'],
	'douyin' => $lang['tpure']['sidedouyin'],
	'kuaishou' => $lang['tpure']['sidekuaishou'],
	'toutiao' => $lang['tpure']['sidetoutiao'],
	'bilibili' => $lang['tpure']['sidebilibili'],
	'xiaohongshu' => $lang['tpure']['sidexiaohongshu'],
	'zhihu' => $lang['tpure']['sidezhihu'],
	'github' => $lang['tpure']['sidegithub'],
	'gitee' => $lang['tpure']['sidegitee'],
	'mall' => $lang['tpure']['sidemall'],
	'facebook' => $lang['tpure']['sidefacebook'],
	'x' => $lang['tpure']['sidex'],
	'instagram' => $lang['tpure']['sideinstagram'],
	'youtube' => $lang['tpure']['sideyoutube'],
	'linkedin' => $lang['tpure']['sidelinkedin'],
	'discord' => $lang['tpure']['sidediscord'],
	'link' => $lang['tpure']['sidelink'],
);
?>
		<dt><?php echo $lang['tpure']['admin']['sideuserorderset'];?> <span>(<?php echo $lang['tpure']['admin']['sideuserordersetinfo'];?></span></dt>
		<dd class="ckbox sideuser">
		<?php
		$sideuser = json_decode($zbp->Config('tpure')->PostSIDEUSER, true);
		$default_sideuser = array(
			'wechat' => 1, 'qq' => 1, 'email' => 1, 'weibo' => 1, 'group' => 0, 'douyin' => 1, 'kuaishou' => 1, 'toutiao' => 0, 'bilibili' => 0, 'xiaohongshu' => 1, 'zhihu' => 0, 'github' => 0, 'gitee' => 0, 'mall' => 0, 'facebook' => 0, 'x' => 0, 'instagram' => 0, 'youtube' => 0, 'linkedin' => 0, 'discord' => 0, 'link' => 0,
		);
		if(!is_array($sideuser) || !$sideuser){
			/* 默认第一次加载时的状态 */
			$sideuser = $default_sideuser;
		}else{
			$sideuser = array_merge($default_sideuser, $sideuser);
		}

		/* 按 $sideuser 顺序输出 */
		foreach ($sideuser as $key => $val) {
			$name = isset($sideuser_info[$key]) ? $sideuser_info[$key] : $key;
			$cls  = $val == 1 ? ' on' : '';
			echo '<div class="checkui'.$cls.'" data-key="'.$key.'">'
			. $name
			. '<input name="sideuser['.$key.']" value="'.$val.'">'
			. '</div>';
		} ?>
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideuserorder_desc'];?></span>
		</dd>
	<dd>
		<label><?php echo $lang['tpure']['admin']['sideusercount'];?></label>
		<input type="text" id="PostSIDEUSERCOUNT" name="PostSIDEUSERCOUNT" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSIDEUSERCOUNT; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['sideusercount_desc'];?></span>
	</dd>
	<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
</dl>
</form>

<?php
}
if ($act == 'slide'){
	if($_POST && isset($_POST['img'])){
		if(!$_POST["img"] || !$_POST["title"] || !$_POST["url"] || !$_POST["color"]){
			$zbp->SetHint('bad',$lang['tpure']['admin']['slidenotnull']);
			Redirect('./main.php?act=slide');
			exit();
		}
		if (isset($_GET['type'])) {
			// PC端添加
			if ($_GET['type'] == 'add') {
				$slidedata = $zbp->Config('tpure')->HasKey('PostSLIDEDATA') ? json_decode($zbp->Config('tpure')->PostSLIDEDATA, true) : [];
				$slidedata[] = $_POST;
				foreach ($slidedata as $key => $row){
					$order[$key] = $row['order'];
				}
				if(is_array($order)){
					array_multisort($order, SORT_ASC, $slidedata);
				}
				$zbp->Config('tpure')->PostSLIDEDATA = json_encode($slidedata);
				$zbp->SaveConfig('tpure');
				header("Refresh:0");
			}
			// PC端编辑
			elseif ($_GET['type'] == 'edit') {
				$slidedata = json_decode($zbp->Config('tpure')->PostSLIDEDATA, true);
				$editid = $_POST['editid'];
				unset($_POST['editid']);
				$slidedata[$editid] = $_POST;
				foreach ($slidedata as $key => $row){
					$order[$key] = $row['order'];
				}
				array_multisort($order, SORT_ASC, $slidedata);
				$zbp->Config('tpure')->PostSLIDEDATA = json_encode($slidedata);
				$zbp->SaveConfig('tpure');
				$zbp->ShowHint($lang['tpure']['admin']['slideeditok']);
			}
			//移动端添加
			elseif ($_GET['type'] == 'madd') {
				$slidemdata = $zbp->Config('tpure')->HasKey('PostSLIDEMDATA') ? json_decode($zbp->Config('tpure')->PostSLIDEMDATA, true) : [];
				$slidemdata[] = $_POST;
				foreach ($slidemdata as $key => $row){
					$order[$key] = $row['order'];
				}
				if(is_array($order)){
					array_multisort($order, SORT_ASC, $slidemdata);
				}
				$zbp->Config('tpure')->PostSLIDEMDATA = json_encode($slidemdata);
				$zbp->SaveConfig('tpure');
				header("Refresh:0");
			}
			//移动端编辑
			elseif ($_GET['type'] == 'medit') {
				$slidemdata = json_decode($zbp->Config('tpure')->PostSLIDEMDATA, true);
				$editid = $_POST['editid'];
				unset($_POST['editid']);
				$slidemdata[$editid] = $_POST;
				foreach ($slidemdata as $key => $row){
					$order[$key] = $row['order'];
				}
				array_multisort($order, SORT_ASC, $slidemdata);
				$zbp->Config('tpure')->PostSLIDEMDATA = json_encode($slidemdata);
				$zbp->SaveConfig('tpure');
				$zbp->ShowHint($lang['tpure']['admin']['slideeditok']);
			}
		}
	}elseif($_GET && isset($_GET['type'])){
		// PC端删除
		if ($_GET['type'] == 'del') {
			$slidedata = json_decode($zbp->Config('tpure')->PostSLIDEDATA, true);
			$editid = $_GET['id'];
			unset($slidedata[$editid]);
			$zbp->Config('tpure')->PostSLIDEDATA = json_encode($slidedata);
			$zbp->SaveConfig('tpure');
			$zbp->ShowHint($lang['tpure']['admin']['slidedelok']);
		}
		// 移动端删除
		elseif ($_GET['type'] == 'mdel') {
			$slidemdata = json_decode($zbp->Config('tpure')->PostSLIDEMDATA, true);
			$editid = $_GET['id'];
			unset($slidemdata[$editid]);
			$zbp->Config('tpure')->PostSLIDEMDATA = json_encode($slidemdata);
			$zbp->SaveConfig('tpure');
			$zbp->ShowHint($lang['tpure']['admin']['slidedelok']);
		}
	}
	if(isset($_POST['PostSLIDEON'])){
		$zbp->Config('tpure')->PostSLIDEON = $_POST['PostSLIDEON'];						//幻灯开关
		if($_POST['PostSLIDEPLACE'] == '1' || $_POST['PostSLIDEPLACE'] == '2'){
			$zbp->Config('tpure')->PostBANNERON = '0';		//关闭首页Banner开关
		}
		$zbp->Config('tpure')->PostSLIDEPLACE = $_POST['PostSLIDEPLACE'];			   //幻灯位置{0:'首页列表顶部',1:'替换首页Banner'}
		$zbp->Config('tpure')->PostSLIDETITLEON = $_POST['PostSLIDETITLEON'];		//首页列表顶部幻灯标题开关
		$zbp->Config('tpure')->PostSLIDEDISPLAY = $_POST['PostSLIDEDISPLAY'];		//幻灯视差滚动
		$zbp->Config('tpure')->PostSLIDETIME = $_POST['PostSLIDETIME'];					//自动切换时间:默认2500毫秒
		$zbp->Config('tpure')->PostSLIDEPAGETYPE = $_POST['PostSLIDEPAGETYPE'];	//幻灯分页类型{0:'鼠标点击切换',1:'鼠标划过切换'}
		$zbp->Config('tpure')->PostSLIDEPAGEON = $_POST['PostSLIDEPAGEON'];		//幻灯分页指示
		$zbp->Config('tpure')->PostSLIDEBTNON = $_POST['PostSLIDEBTNON'];			//幻灯左右箭头
		$zbp->Config('tpure')->PostSLIDEEFFECTON = $_POST['PostSLIDEEFFECTON'];	//幻灯左右滚动
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	}
?>
	<script type="text/javascript" src="./plugin/jscolor/jscolor.js"></script>
	<dl>
		<dt><?php echo $lang['tpure']['admin']['slidepcset'];?> <span><?php echo $lang['tpure']['admin']['slidepcsetinfo'];?></span></dt>
		<dd>
			<table width="100%" border="0" class="slidetable">
				<thead>
					<tr>
						<th scope="col" width="9%" height="32" nowrap="nowrap"><?php echo $lang['tpure']['admin']['id'];?></th>
						<th scope="col" width="58%"><?php echo $lang['tpure']['admin']['slideinfo'];?></th>
						<th scope="col" width="10%"><?php echo $lang['tpure']['admin']['order'];?></th>
						<th scope="col" width="9%"><?php echo $lang['tpure']['admin']['show'];?></th>
						<th scope="col" width="14%"><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5" style="padding:0;">
							<form action="?act=slide&type=add" method="post">
							<table class="slidetable" style="border:0;">
								<tr>
									<td align="center" width="9%">0</td>
									<td width="58%">
										<div class="slideleft">
											<span class="slideimg dftimg">
												<span><input type="hidden" name="img" value="" class="thumbsrc"><button type="button" value="" class="uploadimg uploadico"><?php echo $lang['tpure']['admin']['uploadimg'];?></button></span>
												<img src="style/images/uploadimg.png" class="thumbimg">
											</span>
										</div>
										<span class="slideset"><input type="text" name="title" value="" placeholder="<?php echo $lang['tpure']['admin']['slidetitletip'];?>" required="required" class="slidetext"><input type="text" name="url" value="" placeholder="<?php echo $lang['tpure']['admin']['slideurltip'];?>" required="required" class="slidetext slidetexttitle"><input type="text" name="color" value="" placeholder="<?php echo $lang['tpure']['admin']['slidebgcolortip'];?>" required="required" class="color slidetext slidetexttitle"></span>
										</td>
									<td width="10%"><input type="text" name="order" value="99" class="slidetext slideorder"></td>
									<td width="9%"><input type="text" class="checkbox" name="isused" value="1"></td>
									<td width="14%"><input type="hidden" name="editid" value=""><input name="add" type="submit" class="format" value="<?php echo $lang['tpure']['admin']['add'];?>"></td>
								</tr>
							</table>
							</form>
						</td>
					</tr>
<?php
	$slidedata = json_decode($zbp->Config('tpure')->PostSLIDEDATA,true);
	if(is_array($slidedata)){
	foreach ($slidedata as $key => $value) {
?>
					<tr>
						<td colspan="5" style="padding:0;">
							<form action="?act=slide&type=edit" class="setting slideitem" method="post" name="slide">
								<table class="slidetable" style="border:0; border-top:1px solid #ddd;">
								<tr>
								<td align="center" width="9%"><?php echo $value['order']; ?></td>
								<td width="58%">
									<div class="slideleft">
										<span class="slideimg" style="background-color:#<?php echo $value['color']; ?>">
											<span><input type="hidden" name="img" value="<?php echo $value['img']; ?>" class="thumbsrc"><button type="button" value="" class="uploadimg uploadico"><?php echo $lang['tpure']['admin']['uploadimg'];?></button></span>
											<img src="<?php echo $value['img']; ?>" class="thumbimg">
										</span>
									</div>
									<span class="slideset"><input type="text" name="title" value="<?php echo $value['title']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slidetitletip'];?>" required="required" class="slidetext"><input type="text" name="url" value="<?php echo $value['url']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slideurltip'];?>" required="required" class="slidetext slidetexttitle"><input type="text" name="color" value="<?php echo $value['color']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slidebgcolortip'];?>" required="required" class="color slidetext slidetexttitle"></span>
								</td>
								<td width="10%"><input type="text" name="order" value="<?php echo $value['order']; ?>" class="slidetext slideorder"></td>
								<td width="9%"><input type="text" class="checkbox" name="isused" value="<?php echo $value['isused']; ?>"></td>
								<td width="14%" nowrap="nowrap">
									<input type="hidden" name="editid" value="<?php echo $key; ?>">
									<input name="edit" type="submit" value="" class="setokicon">
									<input name="del" type="button" class="setdelicon" value="" onclick="if(confirm('<?php echo $lang['tpure']['admin']['confirmdel'];?>')){location.href='?act=slide&type=del&id=<?php echo $key; ?>'}">
								</td>
								</tr>
								</table>
							</form>
						</td>
					</tr>
<?php }} ?>
				</tbody>
			</table>
		</dd>
		<dt><?php echo $lang['tpure']['admin']['slidemset'];?> <span><?php echo $lang['tpure']['admin']['slidemsetinfo'];?></span></dt>
		<dd>
			<table width="100%" border="0" class="slidetable">
				<thead>
					<tr>
						<th scope="col" width="9%" height="32" nowrap="nowrap"><?php echo $lang['tpure']['admin']['id'];?></th>
						<th scope="col" width="58%"><?php echo $lang['tpure']['admin']['slideinfo'];?></th>
						<th scope="col" width="10%"><?php echo $lang['tpure']['admin']['order'];?></th>
						<th scope="col" width="9%"><?php echo $lang['tpure']['admin']['show'];?></th>
						<th scope="col" width="14%"><?php echo $lang['tpure']['admin']['set'];?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5" style="padding:0;">
							<form action="?act=slide&type=madd" method="post">
							<table class="slidetable" style="border:0;">
								<tr>
									<td align="center" width="9%">0</td>
									<td width="58%">
										<div class="slideleft">
											<span class="slideimg dftimg">
												<span>
													<input type="hidden" name="img" value="" class="thumbsrc">
													<button type="button" value="" class="uploadimg uploadico"><?php echo $lang['tpure']['admin']['uploadimg'];?></button>
												</span>
												<img src="style/images/uploadimg.png" class="thumbimg">
											</span>
										</div>
										<span class="slideset">
											<input type="text" name="title" value="" placeholder="<?php echo $lang['tpure']['admin']['slidetitletip'];?>" required="required" class="slidetext">
											<input type="text" name="url" value="" placeholder="<?php echo $lang['tpure']['admin']['slideurltip'];?>" required="required" class="slidetext slidetexttitle">
											<input type="text" name="color" value="" placeholder="<?php echo $lang['tpure']['admin']['slidebgcolortip'];?>" required="required" class="color slidetext slidetexttitle">
										</span>
									</td>
									<td width="10%">
										<input type="text" name="order" value="99" class="slidetext slideorder">
									</td>
									<td width="9%">
										<input type="text" class="checkbox" name="isused" value="1">
									</td>
									<td width="14%">
										<input type="hidden" name="editid" value="">
										<input name="madd" type="submit" class="format" value="<?php echo $lang['tpure']['admin']['add'];?>">
									</td>
								</tr>
							</table>
							</form>
						</td>
					</tr>
<?php
	$slidemdata = json_decode($zbp->Config('tpure')->PostSLIDEMDATA,true);
	if(is_array($slidemdata)){
	foreach ($slidemdata as $key => $value) {
?>
					<tr>
						<td colspan="5" style="padding:0;">
							<form action="?act=slide&type=medit" class="setting slideitem" method="post" name="slide">
								<table class="slidetable" style="border:0; border-top:1px solid #ddd;">
									<tr>
										<td align="center" width="9%"><?php echo $value['order']; ?></td>
										<td width="58%">
											<div class="slideleft">
												<span class="slideimg" style="background-color:#<?php echo $value['color']; ?>">
													<span>
														<input type="hidden" name="img" value="<?php echo $value['img']; ?>" class="thumbsrc">
														<button type="button" value="" class="uploadimg uploadico"><?php echo $lang['tpure']['admin']['uploadimg'];?></button>
													</span>
													<img src="<?php echo $value['img']; ?>" class="thumbimg">
												</span>
											</div>
											<span class="slideset">
												<input type="text" name="title" value="<?php echo $value['title']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slidetitletip'];?>" required="required" class="slidetext">
												<input type="text" name="url" value="<?php echo $value['url']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slideurltip'];?>" required="required" class="slidetext slidetexttitle">
												<input type="text" name="color" value="<?php echo $value['color']; ?>" placeholder="<?php echo $lang['tpure']['admin']['slidebgcolortip'];?>" required="required" class="color slidetext slidetexttitle">
											</span>
										</td>
										<td width="10%">
											<input type="text" name="order" value="<?php echo $value['order']; ?>" class="slidetext slideorder">
										</td>
										<td width="9%">
											<input type="text" class="checkbox" name="isused" value="<?php echo $value['isused']; ?>">
										</td>
										<td width="14%" nowrap="nowrap">
											<input type="hidden" name="editid" value="<?php echo $key; ?>">
											<input name="medit" type="submit" value="" class="setokicon">
											<input name="mdel" type="button" class="setdelicon" value="" onclick="if(confirm('<?php echo $lang['tpure']['admin']['confirmdel'];?>')){location.href='?act=slide&type=mdel&id=<?php echo $key; ?>'}">
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
<?php }} ?>
				</tbody>
			</table>
		</dd>
		<form name="slide" method="post" class="setting">
			<dt><?php echo $lang['tpure']['admin']['slideoptionset'];?></dt>
			<dd data-stretch="slide">
				<label><?php echo $lang['tpure']['admin']['slide'];?></label>
				<input type="text" id="PostSLIDEON" name="PostSLIDEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDEON;?>">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slide_desc'];?></span>
			</dd>
			<div class="slideinfo"<?php echo $zbp->Config('tpure')->PostSLIDEON == 1 ? '' : ' style="display:none"'; ?>>
			<dd class="half">
				<label for="PostSLIDEPLACE"><?php echo $lang['tpure']['admin']['slideplace'];?></label>
				<select size="1" name="PostSLIDEPLACE" id="PostSLIDEPLACE">
					<option value="0"<?php if($zbp->Config('tpure')->PostSLIDEPLACE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['slideplace0'];?></option>
					<option value="1"<?php if($zbp->Config('tpure')->PostSLIDEPLACE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['slideplace1'];?></option>
					<option value="2"<?php if($zbp->Config('tpure')->PostSLIDEPLACE == '2'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['slideplace2'];?></option>
				</select>
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slideplace_desc'];?></span>
			</dd>
			<div class="slideplaceinfo"<?php echo $zbp->Config('tpure')->PostSLIDEPLACE == 0 ? '' : ' style="display:none"'; ?>>
				<dd class="half right">
					<label><?php echo $lang['tpure']['admin']['slidetitle'];?></label>
					<input type="text" id="PostSLIDETITLEON" name="PostSLIDETITLEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDETITLEON;?>">
					<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidetitle_desc'];?></span>
				</dd>
			</div>
			<div class="slidedisplayinfo"<?php echo $zbp->Config('tpure')->PostSLIDEPLACE == 1 ? '' : ' style="display:none"'; ?>>
				<dd class="half right">
					<label><?php echo $lang['tpure']['admin']['slidedisplay'];?></label>
					<input type="text" id="PostSLIDEDISPLAY" name="PostSLIDEDISPLAY" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDEDISPLAY;?>">
					<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidedisplay_desc'];?></span>
				</dd>
			</div>
			<dd class="half">
				<label for="PostSLIDETIME"><?php echo $lang['tpure']['admin']['slidetime'];?></label>
				<input type="number" id="PostSLIDETIME" name="PostSLIDETIME" value="<?php echo $zbp->Config('tpure')->PostSLIDETIME;?>" min="1000" step="10" class="settext">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidetime_desc'];?></span>
			</dd>
			<dd class="half">
				<label for="PostSLIDEPAGETYPE"><?php echo $lang['tpure']['admin']['slidepagetype'];?></label>
				<select size="1" name="PostSLIDEPAGETYPE" id="PostSLIDEPAGETYPE">
					<option value="0"<?php if($zbp->Config('tpure')->PostSLIDEPAGETYPE == '0'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['slidepagetype0'];?></option>
					<option value="1"<?php if($zbp->Config('tpure')->PostSLIDEPAGETYPE == '1'){echo ' selected="selected"';}?>><?php echo $lang['tpure']['admin']['slidepagetype1'];?></option>
				</select>
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidepagetype_desc'];?></span>
			</dd>
			<dd class="half">
				<label><?php echo $lang['tpure']['admin']['slidepage'];?></label>
				<input type="text" id="PostSLIDEPAGEON" name="PostSLIDEPAGEON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDEPAGEON;?>">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidepage_desc'];?></span>
			</dd>

			<dd class="half">
				<label><?php echo $lang['tpure']['admin']['slidebtn'];?></label>
				<input type="text" id="PostSLIDEBTNON" name="PostSLIDEBTNON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDEBTNON;?>">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slidebtn_desc'];?></span>
			</dd>
			<dd>
				<label><?php echo $lang['tpure']['admin']['slideeffect'];?></label>
				<input type="text" id="PostSLIDEEFFECTON" name="PostSLIDEEFFECTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSLIDEEFFECTON;?>">
				<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['slideeffect_desc'];?></span>
			</dd>
			</div>
			<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
			</form>
		</dl>

<?php
}
if ($act == 'mail') {
	if (isset($_POST['PostMAILON'])) {
		$zbp->Config('tpure')->PostMAILON = $_POST['PostMAILON'];   //邮件通知开关
		$zbp->Config('tpure')->SMTP_SSL = $_POST['SMTP_SSL'];		 //使用SSL
		$zbp->Config('tpure')->SMTP_HOST = $_POST['SMTP_HOST']; //SMTP服务器地址
		$zbp->Config('tpure')->SMTP_PORT = $_POST['SMTP_PORT'];		   //SMTP服务器端口(25, 465, 587)
		$zbp->Config('tpure')->FROM_EMAIL = $_POST['FROM_EMAIL'];		 //发信邮箱
		$zbp->Config('tpure')->SMTP_PASS = $_POST['SMTP_PASS'];		 //发信邮箱密码
		$zbp->Config('tpure')->FROM_NAME = $_POST['FROM_NAME'];		 //发件人名称
		$zbp->Config('tpure')->MAIL_TO = $_POST['MAIL_TO'];		 //收信邮箱
		$zbp->Config('tpure')->PostNEWARTICLEMAILSENDON = $_POST['PostNEWARTICLEMAILSENDON'];		   //新文章通知开关
		$zbp->Config('tpure')->PostEDITARTICLEMAILSENDON = $_POST['PostEDITARTICLEMAILSENDON'];		   //编辑文章通知开关
		$zbp->Config('tpure')->PostCMTMAILSENDON = $_POST['PostCMTMAILSENDON'];		   //评论通知开关
		$zbp->Config('tpure')->PostREPLYMAILSENDON = $_POST['PostREPLYMAILSENDON'];		 //回复通知开关
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<form name="side" method="post" class="setting">
	<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
<dl>
	<dt><?php echo $lang['tpure']['admin']['mailset'];?><div class="mailinfo"<?php echo $zbp->Config('tpure')->PostMAILON == 1 ? '' : ' style="display:none"'; ?>> <input type="button" id="testmail" value="<?php echo $lang['tpure']['admin']['sendtestmail'];?>"> <span id="testmailresult"></span></div></dt>
	<dd data-stretch="mail" class="half">
		<label><?php echo $lang['tpure']['admin']['mailon'];?></label>
		<input type="text" id="PostMAILON" name="PostMAILON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostMAILON; ?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['mailon_desc'];?></span>
	</dd>
	<div class="mailinfo"<?php echo $zbp->Config('tpure')->PostMAILON == 1 ? '' : ' style="display:none"'; ?>>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['smtpssl'];?></label>
		<input type="text" id="SMTP_SSL" name="SMTP_SSL" class="checkbox" value="<?php echo $zbp->Config('tpure')->SMTP_SSL;?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['smtpssl_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="SMTP_HOST"><?php echo $lang['tpure']['admin']['smtphost'];?></label>
		<input type="text" id="SMTP_HOST" name="SMTP_HOST" placeholder="默认为smtp.163.com" value="<?php echo $zbp->Config('tpure')->SMTP_HOST; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['smtphost_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="SMTP_PORT"><?php echo $lang['tpure']['admin']['smtpport'];?></label>
		<input type="number" id="SMTP_PORT" name="SMTP_PORT" value="<?php echo $zbp->Config('tpure')->SMTP_PORT; ?>" min="1" step="1" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['smtpport_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="FROM_EMAIL"><?php echo $lang['tpure']['admin']['frommail'];?></label>
		<input type="text" id="FROM_EMAIL" name="FROM_EMAIL" value="<?php echo $zbp->Config('tpure')->FROM_EMAIL; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['frommail_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="SMTP_PASS"><?php echo $lang['tpure']['admin']['smtppass'];?></label>
		<input type="password" id="SMTP_PASS" name="SMTP_PASS" value="<?php echo $zbp->Config('tpure')->SMTP_PASS; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['smtppass_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="FROM_NAME"><?php echo $lang['tpure']['admin']['fromname'];?></label>
		<input type="text" id="FROM_NAME" name="FROM_NAME" value="<?php echo $zbp->Config('tpure')->FROM_NAME; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['fromname_desc'];?></span>
	</dd>
	<dd class="half">
		<label for="MAIL_TO"><?php echo $lang['tpure']['admin']['mailto'];?></label>
		<input type="text" id="MAIL_TO" name="MAIL_TO" value="<?php echo $zbp->Config('tpure')->MAIL_TO; ?>" class="settext">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['mailto_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['newarticlemailsend'];?></label>
		<input type="text" id="PostNEWARTICLEMAILSENDON" name="PostNEWARTICLEMAILSENDON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostNEWARTICLEMAILSENDON;?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['newarticlemailsend_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['editarticlemailsend'];?></label>
		<input type="text" id="PostEDITARTICLEMAILSENDON" name="PostEDITARTICLEMAILSENDON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostEDITARTICLEMAILSENDON;?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['editarticlemailsend_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['cmtmailsend'];?></label>
		<input type="text" id="PostCMTMAILSENDON" name="PostCMTMAILSENDON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostCMTMAILSENDON;?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['cmtmailsend_desc'];?></span>
	</dd>
	<dd class="half">
		<label><?php echo $lang['tpure']['admin']['replymailsend'];?></label>
		<input type="text" id="PostREPLYMAILSENDON" name="PostREPLYMAILSENDON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostREPLYMAILSENDON;?>">
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['replymailsend_desc'];?></span>
	</dd>
	</div>
	<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
</dl>
</form>

<?php
}
if ($act == 'config') {
	if (isset($_POST['PostAJAXPOSTON'])) {
		$zbp->Config('tpure')->PostAJAXPOSTON = $_POST['PostAJAXPOSTON'];
		$zbp->Config('tpure')->PostSAVECONFIG = $_POST['PostSAVECONFIG'];		   //保留配置开关
		$zbp->SaveConfig('tpure');
		$zbp->BuildTemplate();
		tpure_CreateModule();
		$zbp->ShowHint('good');
	} ?>
<dl>
	<form enctype="multipart/form-data" method="post" action="plugin/import.php" class="dtform">
	<dt><?php echo $lang['tpure']['admin']['configset'];?> <a href="plugin/export.php" target="_blank"><?php echo $lang['tpure']['admin']['exportconfig'];?></a> <a href="https://www.toyean.com/readset/" target="_blank"><?php echo $lang['tpure']['admin']['readconfig'];?></a></dt>
	<dd>
		<label for=""><?php echo $lang['tpure']['admin']['importconfig'];?></label>
		<table width="100%" border="0">
			<thead>
			<tr>
				<th><?php echo $lang['tpure']['admin']['selectconfig'];?>（<?php echo $zbp->themeapp->id?>.config）</th>
				<th><?php echo $lang['tpure']['admin']['import'];?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><input name="configjson" type="file" id="datafile"></td>
				<td><input type="Submit" id="importdata" class="format" value="<?php echo $lang['tpure']['admin']['importconfig'];?>"></td>
			</tr>
			</tbody>
		</table>
		<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['egg'];?></span>
	</dd>
	</form>
	<form method="post" class="setting">
		<input type="hidden" name="csrfToken" value="<?php echo $zbp->GetCSRFToken() ?>">
		<dt><?php echo $lang['tpure']['admin']['themeconfig'];?> <a href="plugin/resetconfig.php" data-confirm="<?php echo $lang['tpure']['admin']['confirmconfig'];?>"><?php echo $lang['tpure']['admin']['resetconfig'];?></a></dt>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['ajaxpost'];?></label>
			<input type="text" id="PostAJAXPOSTON" name="PostAJAXPOSTON" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostAJAXPOSTON; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['ajaxpost_desc'];?></span>
		</dd>
		<dd class="half">
			<label><?php echo $lang['tpure']['admin']['saveconfig'];?></label>
			<input type="text" id="PostSAVECONFIG" name="PostSAVECONFIG" class="checkbox" value="<?php echo $zbp->Config('tpure')->PostSAVECONFIG; ?>">
			<i class="help"></i><span class="helpcon"><?php echo $lang['tpure']['admin']['saveconfig_desc'];?></span>
		</dd>
		<dd class="setok"><input type="submit" value="<?php echo $lang['tpure']['admin']['saveset'];?>" class="setbtn"></dd>
	</form>
</dl>
<?php } ?>
</div>
</div>
<div class="tfooter">
	<ul>
		<li><a href="https://www.toyean.com/advice.html" target="_blank"><?php echo $lang['tpure']['admin']['advice'];?></a></li>
		<li><a href="https://www.toyean.com/help.html" target="_blank"><?php echo $lang['tpure']['admin']['help'];?></a></li>
		<li><a href="./style/fonts/demo_index.html" target="_blank"><?php echo $lang['tpure']['admin']['iconfont'];?></a></li>
		<li><a href="../../plugin/AppCentre/main.php?auth=e9210072-2342-4f96-91e7-7a6f35a7901e" target="_blank"><?php echo $lang['tpure']['admin']['moreapp'];?></a></li>
		<li><a href="https://jq.qq.com/?_wv=1027&k=44zyTKi" target="_blank"><?php echo $lang['tpure']['admin']['qqgroup'];?></a></li>
	</ul>
	<p>Copyright &copy; 2010-<script>document.write(new Date().getFullYear());</script> <a href="https://www.toyean.com/" target="_blank"><?php echo $lang['tpure']['toyean'];?></a> all rights reserved.</p>
</div>

<script type="text/javascript">ActiveTopMenu("topmenu_tpure");</script>
<?php
require $zbp->path . 'zb_system/admin/admin_footer.php';
RunTime();
?>