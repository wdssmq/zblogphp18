<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'searchstr.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . (version_compare(PHP_VERSION, '7.4.0', '<') ? '7.3-' : '7.4+') . DIRECTORY_SEPARATOR . 'sendmail.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'ipLocation' . DIRECTORY_SEPARATOR . 'function.php';
#注册应用“tpure”
RegisterPlugin("tpure", "ActivePlugin_tpure");
//应用激活时执行的函数，在这个函数里挂接口
function ActivePlugin_tpure()
{
	global $zbp;
	//加载主题语言包
	$zbp->LoadLanguage('theme', 'tpure');
	//主题接口
	Add_Filter_Plugin('Filter_Plugin_Edit_Response5', 'tpure_Edit_Response');
	Add_Filter_Plugin('Filter_Plugin_Category_Edit_Response', 'tpure_CategoryEdit_Response');
	Add_Filter_Plugin('Filter_Plugin_Tag_Edit_Response', 'tpure_TagEdit_Response');
	Add_Filter_Plugin('Filter_Plugin_Member_Edit_Response', 'tpure_MemberEdit_Response');
	Add_Filter_Plugin('Filter_Plugin_Edit_Response5', 'tpure_SingleEdit_Response');
	Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'tpure_AddMenu');
	Add_Filter_Plugin('Filter_Plugin_Admin_Header', 'tpure_Header');
	Add_Filter_Plugin('Filter_Plugin_Zbp_Load', 'tpure_Refresh');
	Add_Filter_Plugin('Filter_Plugin_Admin_Js_Add', 'tpure_Admin_Js_Add');
	Add_Filter_Plugin('Filter_Plugin_ViewSearch_Template', 'tpure_SearchMain');
	Add_Filter_Plugin('Filter_Plugin_Cmd_Ajax','tpure_CmdAjax');
	Add_Filter_Plugin('Filter_Plugin_Cmd_Ajax','tpure_UploadAjax');
	Add_Filter_Plugin('Filter_Plugin_ViewList_Core', 'tpure_Exclude_Category');
	Add_Filter_Plugin('Filter_Plugin_PostModule_Succeed', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_DelComment_Succeed', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_CheckComment_Succeed', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Del', 'tpure_CreateModule');
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_ArchiveAutoCache');
	Add_Filter_Plugin('Filter_Plugin_PostArticle_Del', 'tpure_ArchiveAutoCache');
	Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError', 'tpure_ErrorCode');
	if($zbp->Config('tpure')->PostVIDEOON == '1'){
		Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ZBvideoLoad');
	}
	if($zbp->Config('tpure')->PostZBAUDIOON == '1'){
		Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ZBaudioLoad');
	}
	Add_Filter_Plugin('Filter_Plugin_Zbp_MakeTemplatetags','tpure_CustomCode');
	Add_Filter_Plugin('Filter_Plugin_ViewPost_Template','tpure_SingleCode');
	Add_Filter_Plugin('Filter_Plugin_LargeData_Article','tpure_LargeDataArticle');
	Add_Filter_Plugin('Filter_Plugin_ViewList_Template','tpure_DefaultTemplate');
	if($zbp->Config('tpure')->PostMAILON == '1'){
		Add_Filter_Plugin('Filter_Plugin_PostArticle_Core', 'tpure_ArticleCore');
		Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_ArticleSendmail');
		Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', 'tpure_CmtSendmail');
	}
	if ($zbp->Config('tpure')->PostLOGINON == '1') {
		Add_Filter_Plugin('Filter_Plugin_Login_Header', 'tpure_LoginHeader');
	}
	if($zbp->Config('tpure')->PostVIEWALLON == '1'){
		Add_Filter_Plugin('Filter_Plugin_Edit_Response3', 'tpure_ArticleViewall');
	}
	if ($zbp->Config('tpure')->PostTIMGBOXON == '1') {
		Add_Filter_Plugin('Filter_Plugin_Zbp_MakeTemplatetags','tpure_Timgbox');
	}
	if ($zbp->Config('tpure')->PostCATEPREVNEXTON == '1') {
		Add_Filter_Plugin('Filter_Plugin_Post_Prev', 'tpure_Post_Prev');
		Add_Filter_Plugin('Filter_Plugin_Post_Next', 'tpure_Post_Next');
	}
	if ($zbp->Config('tpure')->PostLAZYLOADON == '1') {
		Add_Filter_Plugin('Filter_Plugin_Zbp_BuildTemplate', 'tpure_ListIMGLazyLoad');
		Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ContentIMGLazyLoad');
	}
	if($zbp->Config('tpure')->PostCMTMAILNOTNULLON == '1'){
		Add_Filter_Plugin('Filter_Plugin_PostComment_Core','tpure_PostComment_Core');
	}
	// 外链处理
	Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ViewPost_Content');
	Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'tpure_Jump_Main');
	// 语言包
	Add_Filter_Plugin('Filter_Plugin_Html_Js_Add', 'tpure_Html_Js_Add');

	// 自定义侧栏模块名称
	$zbp->lang['msg']['theme_module'] = $zbp->lang['tpure']['admin']['thememodule'];
	$zbp->lang['msg']['sidebar'] = $zbp->lang['tpure']['index'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar2'] = $zbp->lang['tpure']['catalog'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar3'] = $zbp->lang['tpure']['article'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar4'] = $zbp->lang['tpure']['page'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar5'] = $zbp->lang['tpure']['search'].$zbp->lang['tpure']['page'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar6'] = $zbp->lang['tpure']['tagscloud'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar7'] = $zbp->lang['tpure']['archive'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar8'] = $zbp->lang['tpure']['member'].$zbp->lang['tpure']['sidebar'];
	$zbp->lang['msg']['sidebar9'] = $zbp->lang['tpure']['readers'].$zbp->lang['tpure']['sidebar'];
	$zbp->option['ZC_VERIFYCODE_STRING'] = $zbp->Config('tpure')->VerifyCode;
}

//语言包
//挂接口：Add_Filter_Plugin('Filter_Plugin_Html_Js_Add', 'tpure_Html_Js_Add');
function tpure_Html_Js_Add()
{
	global $zbp, $lang;
	echo 'window.tpure = window.tpure || {};
		Object.assign(window.tpure, {
			lang:{
				schnull: "'.$lang['tpure']['schnull'].'",
				openmore: "'.$lang['tpure']['openmore'].'",
				backtotop: "'.$lang['tpure']['admin']['backtotop'].'",
				lazynumtxt: "'.$lang['tpure']['lazynumtxt'].'",
				pageloading: "'.$lang['tpure']['pageloading'].'",
				pagetrigger: "'.$lang['tpure']['pagetrigger'].'",
				readmore: "'.$lang['tpure']['readmore'].'",
				viewallon: "'.$lang['tpure']['admin']['viewallon'].'",
				turnon: "'.$lang['tpure']['turnon'].'",
				turnonconsole: "'.$lang['tpure']['turnonconsole'].'",
				turnonautoconsole: "'.$lang['tpure']['turnonconsole'].'",
				turnoff: "'.$lang['tpure']['turnoff'].'",
				turnoffconsole: "'.$lang['tpure']['turnoffconsole'].'",
				turnoffautoconsole: "'.$lang['tpure']['turnoffconsole'].'",

			}
		});
	';
}

//时间因子
function tpure_OGTime($pageType = 'index', $id = null)
{
	global $zbp;
	$w = array();
	$w['post_status'] = '0';
	$w['order_custom'] = array('log_PostTime' => 'DESC');
	if ($id) {
		switch ($pageType) {
			case 'index':
				break;
			case 'category':
				$w['cate'] = $id;
				break;
			case 'tag':
				$w['where_custom'] = array(array('search', 'log_Tag', $id));
				break;
			case 'author':
				$w['auth'] = $id;
				break;
		}
	}
	$list = GetList($w);
	return isset($list[0]) ? $list[0] : null;
}

//自动替换文章内外链
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ViewPost_Content');
function tpure_ViewPost_Content(&$template)
{
	global $zbp;
	//文章外链
	if($zbp->Config('tpure')->PostARTICLELINKON){
		$article = $template->GetTags('article');
		$content = $article->Content;
		$article->Content = tpure_link_Convert($content);
		$template->SetTags('article', $article);
	}

	//评论HomePage外链
	if($zbp->Config('tpure')->PostCMTLINKON){
		foreach($zbp->comments as $k => $v){
			$homepage = trim($v->HomePage, ' ');
			$host = $_SERVER['SERVER_NAME'];
			if(strpos($homepage, 'script') !== false){//说明是js
				continue;
			}
			if(strpos($homepage, '/') == 0){//说明是本网站网页
				continue;
			}
			if(strpos($homepage, $host) !== false){
				continue;
			}
			if(!$homepage){//说明空网页
				continue;
			}
			$zbp->comments[$k]->HomePage = $zbp->host.'?go_url=' . urlencode($homepage) . '&hash=' . md5(md5($zbp->guid) . md5($homepage));;
		}

		//评论内容外链
		$comments = $template->GetTags('comments');
		foreach ($comments as $key => $comment){
			$comment->Content = tpure_link_Convert($comment->Content,'cmt');
			foreach ($comment->Comments as $key => $comment){
				$comment->Content = tpure_link_Convert($comment->Content,'cmt');
			}
		}
		$template->SetTags('comments', $comments);
	}
}

/**
 * 外链转内链
 * @param string $content
 * @param boolean $type 为 true 则连非 a 部分一起转，其余值只转 <a>
 * @return string
 */
function tpure_link_Convert($content, $type = false)
{
	global $zbp;
	$parts = preg_split('/(<a\s+[^>]*>.*?<\/a>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach ($parts as $key => $part) {
		// 处理非a标签部分
		if ($key % 2 == 0) {
			if ($type) {
				$reg1 = '/(https?:\/\/[^\s<>"\'()]+[^\s<>"\'()])/i';
				$parts[$key] = preg_replace_callback($reg1, function($matches) use ($zbp){
					$url = $matches[0];
					$host = $zbp->host;
					if(stripos($url, 'javascript:') !== false ||
					stripos($url, 'vbscript:') !== false ||
					stripos($url, 'data:') !== false){
						return $url;
					}
					if(strpos($url, '/') === 0){
						return $url;
					}
					if(strpos($url, $host) !== false){
						return $url;
					}
					if(empty($url)){
						return $url;
					}
					return $host . '?go_url=' . urlencode($url);
				}, $part);
			}
		} else {
			// 处理a标签部分
			$parts[$key] = preg_replace_callback('/<a\s+[^>]*>.*?<\/a>/is', function($matches) use ($zbp) {
				$aTag = $matches[0];
				$host = $zbp->host;
				// 检查a标签中是否包含图片
				if (preg_match('/<img[^>]*>/i', $aTag)) {
					return $aTag; // 如果包含图片，则不处理
				}
				// 提取a标签的href属性
				if (preg_match('/href\s*=\s*["\']([^"\']+)["\']/i', $aTag, $hrefMatches)) {
					$url = $hrefMatches[1];
					if(stripos($url, 'javascript:') !== false ||
						stripos($url, 'vbscript:') !== false ||
						stripos($url, 'data:') !== false){
						return $aTag;
					}
					// 检查是否是相对路径
					if(strpos($url, '/') === 0){
						return $aTag;
					}
					// 检查是否是本站链接
					if(strpos($url, $host) !== false){
						return $aTag;
					}
					// 检查是否为空
					if(empty($url)){
						return $aTag;
					}
					// 替换为处理后的链接
					$newUrl = $host . '?go_url=' . urlencode($url) . '&amp;hash=' . md5(md5($zbp->guid) . md5($url));
					return preg_replace('/href\s*=\s*["\']([^"\']+)["\']/i', 'href="' . $newUrl . '"', $aTag);
				}
				return $aTag; // 如果没有href属性，则不处理
			}, $part);
		}
	}
	// 重新组合内容
	return implode('', $parts);
}

//外链跳转安全中心页面
//挂接口：Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'tpure_Jump_Main');
function tpure_Jump_Main()
{
	global $zbp;
	if(strpos($zbp->currenturl, '?go_url') !== false){
		$jumpFile = $zbp->path . 'zb_users/theme/'.$zbp->theme.'/template/jump.php';
		if(file_exists($jumpFile)){
			include $jumpFile;
		}else{
			die("Jump file not found.");
		}
		exit;
	}
}

//评论邮箱必填
//挂接口：Add_Filter_Plugin('Filter_Plugin_PostComment_Core','tpure_PostComment_Core');
function tpure_PostComment_Core(&$cmt) {
	global $zbp, $lang;
	$email=GetVars("email","POST");
	if(!$email){
		$cmt->IsThrow = true;
		$zbp->lang['error'][14] = $lang['tpure']['admin']['cmtmailnotnull'];
		$zbp->ShowError(14, __FILE__, __LINE__);
	}
}

//upload事件
//挂接口：Add_Filter_Plugin('Filter_Plugin_Cmd_Ajax','tpure_UploadAjax');
function tpure_UploadAjax($src){
	global $zbp;
	if ($src == 'tpure_upload'){

		if (!$zbp->CheckRights('UploadPst')) {
			$zbp->ShowError(6);
		}

		Add_Filter_Plugin('Filter_Plugin_Upload_SaveFile','tpure_Upload_SaveFile_Ajax');
		$_POST['auto_rename'] = 1;
		PostUpload();
		echo json_encode(array('url' => $GLOBALS['tmp_ul']->Url));
		exit;
	}
}

function tpure_Upload_SaveFile_Ajax($tmp, $ul){
	$GLOBALS['tmp_ul'] = $ul;
}

//花辰月夕ajax搜索
//挂接口：Add_Filter_Plugin('Filter_Plugin_Cmd_Ajax','tpure_CmdAjax');
function tpure_CmdAjax($src)
{
	$param = explode('.',$src);
	unset($param[0]);
	if (strpos($src ,'search') === 0){
		$fun = tpure_ajaxSearch();
		if ($fun(array_values($param))){
			tpure_json(1);
		}else{
			tpure_json(0,13);
		}
	}
}

function tpure_json($code, $msg = '', $data = '')
{
	global $zbp;
	$a = array();
	if (is_numeric($msg) && isset($a[$msg])){
		$msg = $a[$msg];
	}
	if (is_array($code)){
		$json = $code;
	}else{
		$json = array(
			'code' => $code,
			'msg' => $msg,
			'data' => $data,
		);
	}
	$rt = RunTime(false);
	$json['runtime'] = "time:{$rt['time']}ms query:{$rt['query']} memory:{$rt['memory']}kb error:{$rt['error']}";
	echo json_encode($json);
	exit;
}

//首页异步搜索
function tpure_ajaxSearch()
{
	global $zbp;
	$q = htmlspecialchars(GetVars('q','POST'), ENT_QUOTES, 'UTF-8');
	$qc = '<mark>' . $q . '</mark>';
	$w = array(
		array('search','log_Title','log_Content',$q),
		array('=','log_Status',0),
		);
	$articles = $zbp->GetArticleList('*',$w,array('log_PostTime'=>'DESC'),6);
	$res = array('post' => array());
	foreach($articles as $k => $article){
		if ($k == 5) break;
		$res['post'][] = array(
			'title' => str_ireplace($q, $qc, $article->Title),
			'img' => tpure_Thumb($article),
			'url' => $article->Url,
			'intro' => tpure_GetIntro($article, $q)
			);
	}
	$res['more'] = count($articles) > 5;
	exit(json_encode($res));
}

//主题设置页导航
function tpure_SubMenu($id)
{
	global $zbp;
	$arySubMenu = array(
		0 => array($zbp->lang['tpure']['admin']['baseset'], 'base', 'left', false),
		1 => array($zbp->lang['tpure']['admin']['seoset'], 'seo', 'left', false),
		2 => array($zbp->lang['tpure']['admin']['colorset'], 'color', 'left', false),
		3 => array($zbp->lang['tpure']['admin']['sideset'], 'side', 'left', false),
		4 => array($zbp->lang['tpure']['admin']['slideset'], 'slide', 'left', false),
		5 => array($zbp->lang['tpure']['admin']['mailset'], 'mail', 'left', false),
		6 => array($zbp->lang['tpure']['admin']['configset'], 'config', 'left', false),
	);
	foreach ($arySubMenu as $k => $v) {
		echo '<li><a href="?act=' . $v[1] . '" ' . ($v[3] == true ? 'target="_blank"' : '') . ' class="' . ($id == $v[1] ? 'on' : '') . '">' . $v[0] . '</a></li>';
	}
}

//后台右上角添加主题设置入口；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'tpure_AddMenu');
function tpure_AddMenu(&$m)
{
	global $zbp;
	$m[] = MakeTopMenu("root", $zbp->lang['tpure']['themeset'], $zbp->host . "zb_users/theme/".$zbp->theme."/main.php?act=base", "", "topmenu_tpure", "icon-grid-1x2-fill");
}

//后台管理页面顶部的背景图片；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Admin_Header', 'tpure_Header');
function tpure_Header()
{
	global $zbp,$bloghost;
	if($zbp->Config('tpure')->PostAJAXPOSTON == '0'){$ajaxpost = 0;}else{$ajaxpost = 1;}
	echo '<style>.header{background:url(' . $bloghost . 'zb_users/theme/'.$zbp->theme.'/style/images/banner.jpg) no-repeat center center;background-size:cover;}</style>';
	echo '<script>window.theme = {ajaxpost:'.$ajaxpost.'}</script>';
}

//主题自带的登陆页面样式；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Login_Header', 'tpure_LoginHeader');
function tpure_LoginHeader()
{
	global $zbp;
	$logo = $zbp->Config('tpure')->PostLOGO && $zbp->Config('tpure')->PostLOGOON == 1 ? $zbp->Config('tpure')->PostLOGO : $zbp->lang['tpure']['welcome'].$zbp->lang['tpure']['login'];
	$banner = $zbp->Config('tpure')->PostLOGINBG ? $zbp->Config('tpure')->PostLOGINBG : $zbp->host . 'zb_users/theme/'.$zbp->theme.'/style/images/banner.jpg';
	echo <<<CSSJS
	<style>
		input:-webkit-autofill { -webkit-text-fill-color:#000 !important; background-color:transparent; background-image:none; transition:background-color 50000s ease-in-out 0s; }
		.bg { height:100%; background:url({$banner}) no-repeat center top; background-size:cover; }
		.logo { width:100%; height:auto; margin:0; padding:20px 0 10px; text-align:center; border-bottom:1px solid #eee; }
		.logo img { width:auto; height:50px; margin:auto; background:none; display:block; }
		#wrapper { width:440px; min-height:400px; height:auto; border-radius:8px; background:#fff; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); }
		.login { width:auto; height:auto; padding:30px 40px 20px; }
		.login input[type="text"], .login input[type="password"] { width:100%; height:42px; float:none; padding:0 14px; font-size:16px; line-height:42px; border:1px solid #e4e8eb; outline:0; border-radius:3px; box-sizing:border-box; }
		.login input[type="password"] { font-size:24px; letter-spacing:5px; }
		.login input[type="text"]:focus, .login input[type="password"]:focus { color:#0188fb; background-color:#fff; border-color:#aab7c1; outline:0; box-shadow:0 0 0 0.2rem rgba(31,73,119,0.1); }
		.login dl { height:auto; }
		.login dd { margin-bottom:14px; }
		.login dd.submit, .login dd.password, .login dd.username, .login dd.validcode { width:auto; float:none; overflow:visible; }
		.login dd.validcode { height:auto; position:relative; }
		.login dd.validcode label { margin-bottom:4px; }
		.login dd.validcode img { height:38px; position:absolute; top:auto; right:2px; bottom:2px; }
		.login dd.checkbox { width:170px; float:none; margin:0 0 10px; }
		.login dd.checkbox input[type="checkbox"] { width:16px; height:16px; margin-right:6px; }
		.login label { width:auto; margin-bottom:5px; padding:0; font-size:16px; text-align:left; }
		.logintitle { padding:0 70px; font-size:24px; color:#0188fb; line-height:40px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; position:relative; display:block; }
		.logintitle:before,.logintitle:after { content:""; width:40px; height:0; border-top:1px solid #ddd; position:absolute; top:20px; right:30px; }
		.logintitle:before { right:auto; left:30px; }
		.button { width:100%; height:42px; float:none; font-size:16px; line-height:42px; border-radius:3px; outline:0; box-shadow:1px 3px 5px 0 rgba(72,108,255,0.3); background:#0188fb; }
		.button:hover { background:#0188fb; }
		@media only screen and (max-width: 768px){
			.login { padding:30px 30px 10px; }
			.login dd { float:left; margin-bottom:14px; padding:0; }
			.login dd.validcode label { margin-bottom:5px; }
			.login dd.checkbox { width:auto; padding:0; }
			.login dd.submit { margin-right:0; }
		}
		@media only screen and (max-width: 520px){
			#wrapper { width:96%; margin:0 auto; }
			.login dd.username label, .login dd.password label { width:100%; }
		}
		</style>
		<script>
		$(function(){
		function check_is_img(url) {
			return (url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null)
		}
		if(check_is_img("{$logo}")){
			$(".logo").find("img").replaceWith('<img src="{$logo}"/>').end().wrapInner("<a href='"+bloghost+"'/>");
		}else{
			$(".logo").find("img").replaceWith('<span class="logintitle">{$logo}<span>').end().wrapInner("<a href='"+bloghost+"'/>");
		}
		});
	</script>
CSSJS;
}

//开启“开发模式”后，修改主题源码保存将实时刷新，无需手动重建缓存；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Zbp_Load', 'tpure_Refresh');
function tpure_Refresh()
{
	global $zbp;
	// if ($zbp->option['ZC_DEBUG_MODE']) {
	//	 $zbp->BuildTemplate();
	// }
	if ($zbp->ismanage){
		return;
	}
	if (defined("ZBP_IN_CMD")) {
		return;
	}
	$zbp->lang['msg']['first_button'] = $zbp->lang['tpure']['index'];
	$zbp->lang['msg']['prev_button'] = $zbp->lang['tpure']['prevpage'];
	$zbp->lang['msg']['next_button'] = $zbp->lang['tpure']['nextpage'];
	$zbp->lang['msg']['last_button'] = $zbp->lang['tpure']['endpage'];
	$zbp->option['ZC_SEARCH_TYPE'] = 'list';
	//$zbp->option['ZC_PAGEBAR_COUNT'] = 3;
	//$zbp->option['ZC_SEARCH_COUNT'] = 10;
}

//后台js
//挂接口：Add_Filter_Plugin('Filter_Plugin_Admin_Js_Add', 'tpure_Admin_Js_Add');
function tpure_Admin_Js_Add()
{
	global $zbp, $lang;
	echo 'var themehost = "'.$zbp->host.'zb_users/theme/'.$zbp->theme.'/";';
	echo 'var uploadimgtype = ".jpg,.jpeg,.png,.gif,.svg,.webp,.ico";';
	echo 'var uploadfiletype = ".mp3,.mp4";';
	echo '
		window.tpure = {
			lang:{
				select: "'.$lang['tpure']['select'].'",
				selectall: "'.$lang['tpure']['selectall'].'",
				uploadfileok: "'.$lang['tpure']['uploadfileok'].'",
				uploadfileerror: "'.$lang['tpure']['uploadfileerror'].'",
				filefillin: "'.$lang['tpure']['filefillin'].'",
				corresponding: "'.$lang['tpure']['corresponding'].'",
				saveok: "'.$lang['tpure']['saveok'].'",
				saveerror: "'.$lang['tpure']['saveerror'].'",
				saving: "'.$lang['tpure']['saving'].'",
				confirmsendemail: "'.$lang['tpure']['confirmsendemail'].'",
				emailsaving: "'.$lang['tpure']['emailsaving'].'",
				emailerror: "'.$lang['tpure']['emailerror'].'",
				selectimportconfig: "'.$lang['tpure']['selectimportconfig'].'",
				configinvalid: "'.$lang['tpure']['configinvalid'].'",
				sunday: "'.$lang['tpure']['sunday'].'",
				monday: "'.$lang['tpure']['monday'].'",
				tuesday: "'.$lang['tpure']['tuesday'].'",
				wednesday: "'.$lang['tpure']['wednesday'].'",
				thursday: "'.$lang['tpure']['thursday'].'",
				friday: "'.$lang['tpure']['friday'].'",
				saturday: "'.$lang['tpure']['saturday'].'",
				january: "'.$lang['tpure']['january'].'",
				february: "'.$lang['tpure']['february'].'",
				march: "'.$lang['tpure']['march'].'",
				april: "'.$lang['tpure']['april'].'",
				may: "'.$lang['tpure']['may'].'",
				june: "'.$lang['tpure']['june'].'",
				july: "'.$lang['tpure']['july'].'",
				august: "'.$lang['tpure']['august'].'",
				september: "'.$lang['tpure']['september'].'",
				october: "'.$lang['tpure']['october'].'",
				november: "'.$lang['tpure']['november'].'",
				december: "'.$lang['tpure']['december'].'",
			}
		}
	';
}

//分类列表页面包屑分类获取
function tpure_navcate($id)
{
	global $lang;
	$html = '';
	$navcate = new Category;
	$navcate->LoadInfoByID($id);
	$html = ' &gt; <a href="' .$navcate->Url.'" title="' .$lang['tpure']['view'] . ' '. $navcate->Name .' '. $lang['tpure']['allarticle']. '">' .$navcate->Name. '</a> '.$html;
	if(($navcate->ParentID)>0){tpure_navcate($navcate->ParentID);}
	echo $html;
}

//后台登陆过期时自动跳转到登录页，且网站关站时使用个性公告页面；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError', 'tpure_ErrorCode');
function tpure_ErrorCode($errorCode)
{
	global $zbp;
	// header_remove();
	// die();
	if($errorCode == 6){
		if($zbp->Config('tpure')->PostERRORTOPAGE){
			Redirect($zbp->Config('tpure')->PostERRORTOPAGE);
		}else{
			Redirect($zbp->host.'zb_system/login.php');
		}
		die();
	}elseif($errorCode == 82){
		echo tpure_CloseSite();
		die();
	}
}

//文章添加音频时在正文上方添加播放器
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ZBaudioLoad');
function tpure_ZBaudioLoad(&$template)
{
	global $zbp;
	$article = $template->GetTags('article');
	if(!isset($article->Metas->audio)){
		return;
	}
	$zbaudio_player = '<link rel="stylesheet" href="'. $zbp->host .'zb_users/theme/tpure/plugin/zbaudio/style.css"><script src="'. $zbp->host .'zb_users/theme/tpure/plugin/zbaudio/audio.js"></script><p><span class="zbaudio"><span class="zbaudio_img"></span><span class="zbaudio_info"><strong></strong><em class="zbaudio_singer"></em><span class="zbaudio_area"><span class="zbaudio_item"><span class="zbaudio_progress"><span class="zbaudio_now"><span class="zbaudio_bar"></span></span><span class="zbaudio_cache"></span></span><span class="zbaudio_time"><em class="zbaudio_current">00:00</em><em class="zbaudio_total"></em></span></span><span class="zbaudio_play"><em data-action="play" data-on="play" data-off="pause"></em></span></span></span></span></p>';
	$zbaudio_config = '<script>var setConfig = {song:[{cover:"'. $article->Metas->audioimg .'",src:"'. $article->Metas->audio .'",title:"'. htmlspecialchars($article->Metas->audiotitle, ENT_QUOTES) .'",singer:"'. $article->Metas->audiosinger .'"}],error:function(meg){console.log(meg);}};var zbaudio = audioPlay(setConfig);if(zbaudio){zbaudio.loadFile('. ($article->Metas->audioautoplay ? 'true' : 'false') .');}</script>';
	$template->SetTags('zbaudio', $zbaudio_player . $zbaudio_config);
}

//文章添加视频时在正文上方添加播放器
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ZBvideoLoad');
function tpure_ZBvideoLoad(&$template)
{
	global $zbp;
	$article = $template->GetTags('article');
	if(!isset($article->Metas->video)){
		return;
	}
	$video = $article->Metas->video;
	$videostr = '<p id="zbvideo" class="videobox">';
	if (preg_match('/\.(mp4|m3u8|flv)$/i', $video)) {
		$path = parse_url($video, PHP_URL_PATH);
		$ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		$type = ($ext === 'm3u8' || $ext === 'flv') ? 'hls' : 'auto';
		$pic = isset($article->Metas->videopic) ? $article->Metas->videopic : '';
		$autoplay = $article->Metas->videoautoplay == '1' ? 'true' : 'false';
		$loop	 = $article->Metas->videoloop == '1' ? 'true' : 'false';
		$videostr .= '<script>';
		$videostr .= 'window.tpure.zbvideo = "' . $video . '";';
		$videostr .= 'window.tpure.videoautoplay = "' . $autoplay . '";';
		$videostr .= 'window.tpure.videoloop = "' . $loop . '";';
		$videostr .= 'window.tpure.videopic = "' . $pic . '";';
		$videostr .= 'window.tpure.videotype = "' . $type . '";';
		$videostr .= '</script>';
	}
	//iframe / embed 直接输出
	elseif (stripos($video, '<iframe') !== false || stripos($video, '<embed') !== false) {
		$videostr .= $video;
	}
	//其他网址默认用 iframe 套一层
	else {
		$videostr .= '<iframe src="' . $video . '" frameborder="0" allowfullscreen="true"></iframe>';
	}
	$videostr .= '</p>';
	if ($article->Metas->video) {
		if (!$article->Metas->zbvideoindex) {
			$template->SetTags('zbvideo', $videostr);
		} else {
			$content = tpure_ZBvideo_paragraph($videostr, $article->Metas->zbvideoindex, $article->Content);
			$article->Content = $content;
		}
	}
}

//视频插入到指定段落
function tpure_ZBvideo_paragraph($insertion, $paragraph_id, $content){
	$closing_p = '</p>';
	$paragraphs = explode($closing_p, $content);
	// 重新构建段落，确保每个段落都有正确的结束标签
	foreach ($paragraphs as $index => $paragraph){
		if(trim($paragraph)){
			$paragraphs[$index] .= $closing_p;
		}
	}
	// 检查paragraph_id是否超出段落数量
	if ($paragraph_id > count($paragraphs)) {
		// 如果超出，将视频内容添加到文章末尾
		$paragraphs[count($paragraphs) - 1] .= $insertion;
	} else {
		// 如果没有超出，将视频内容插入到指定段落
		foreach ($paragraphs as $index => $paragraph){
			if($paragraph_id == $index + 1 ){
				$paragraphs[$index] .= $insertion;
			}
		}
	}
	return implode('', $paragraphs);
}

//网站首尾添加通用代码
//挂接口：Add_Filter_Plugin('Filter_Plugin_Zbp_MakeTemplatetags','tpure_CustomCode');
function tpure_CustomCode()
{
	global $zbp;
	$headercode = $zbp->Config('tpure')->PostHEADERCODE;
	$footercode = $zbp->Config('tpure')->PostFOOTERCODE;
	$zbp->header .= $headercode . "\r\n";
	$zbp->footer .= $footercode . "\r\n";
}

//文章顶部与底部添加通用代码
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewPost_Template','tpure_SingleCode');
function tpure_SingleCode(&$template)
{
	global $zbp;
	$article = $template->GetTags('article');
	if($zbp->Config('tpure')->PostSINGLETOPCODE){
		$article->Content = $zbp->Config('tpure')->PostSINGLETOPCODE . $article->Content;
	}
	if($zbp->Config('tpure')->PostSINGLEBTMCODE){
		$article->Content .= $zbp->Config('tpure')->PostSINGLEBTMCODE;
	}
}

//网站关站页面
function tpure_CloseSite()
{
	global $zbp;
	$logo = $zbp->Config('tpure')->PostLOGO && $zbp->Config('tpure')->PostLOGOON == 1 ? "<img src=".$zbp->Config('tpure')->PostLOGO.">" : $zbp->name;
	$bg = $zbp->Config('tpure')->PostCLOSESITEBG ? ' style="background-image:url('.$zbp->Config('tpure')->PostCLOSESITEBG.');"' : '';
	$bgmask = $zbp->Config('tpure')->PostCLOSESITEBGMASKON ? ' bgmask' : '';
	$title = $zbp->Config('tpure')->PostCLOSESITETITLE ? $zbp->Config('tpure')->PostCLOSESITETITLE : $zbp->lang['tpure']['closesitetitle'];
	$content = $zbp->Config('tpure')->PostCLOSESITECON ? $zbp->Config('tpure')->PostCLOSESITECON : $zbp->lang['tpure']['closesitecon'];
	$skin = $zbp->Config('tpure')->PostCOLORON == 1 ? "<link rel=\"stylesheet\" href=\"".$zbp->host."zb_users/theme/tpure/include/skin.css \">" : '';
	$str = '';
	$str .= '<!DOCTYPE html><html xml:lang="zh-Hans" lang="zh-Hans"><head><meta charset="utf-8"><meta name="renderer" content="webkit"><meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"><title>'.$title.'</title><link rel="stylesheet" href="'.$zbp->host.'zb_users/theme/tpure/style/style.css">'.$skin.'</head><body class="closepage">';
	if($bg){
		$str .= '<div class="closesitebg'.$bgmask.'"'.$bg.'></div>';
	}
	$str .='<div class="closesite"><div class="closelogo">'.$logo.'</div><h1>'.$title.'</h1><div class="closecon">'.$content.'</div></div></body></html>';
	return $str;
}


//文章页实现同一分类上下篇；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Post_Prev', 'tpure_Post_Prev');
function tpure_Post_Prev(&$thispage)
{
	global $zbp;
	$prev=$thispage;
	$articles = $zbp->GetPostList(
		array('*'),
		array(array('=', 'log_Type', 0), array('=', 'log_CateID', $prev->Category->ID),array('=', 'log_Status', 0), array('<', 'log_PostTime', $prev->PostTime)),
		array('log_PostTime' => 'DESC'),
		array(1),
		null
	);
	if (count($articles) == 1) {
		return $articles[0];
	}else{
		return null;
	}
}

//文章页实现同一分类上下篇；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Post_Next', 'tpure_Post_Next');
function tpure_Post_Next(&$thispage)
{
	global $zbp;
	$prev=$thispage;
	$articles = $zbp->GetPostList(
		array('*'),
		array(array('=', 'log_Type', 0), array('=', 'log_CateID', $prev->Category->ID),array('=', 'log_Status', 0), array('>', 'log_PostTime', $prev->PostTime)),
		array('log_PostTime' => 'ASC'),
		array(1),
		null
	);
	if (count($articles) == 1) {
		return $articles[0];
	}else{
		return null;
	}
}

//判断参数内日期是否是今天，用于页面指定日期变灰，示例：tpure_IsToday('2020-12-30')
function tpure_IsToday($date)
{
	$greyday = $date;
	$formatday = substr($greyday,0,10);
	$today = date('Y-m-d');
	if($formatday==$today){
		return true;
	}else{
		return false;
	}
}

//列表页按类型自动选择catalog模板并可设置其他模板；
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewList_Template','tpure_DefaultTemplate');
function tpure_DefaultTemplate(&$template)
{
	global $zbp;
	// 定义特殊模板类型
	$specialTemplates = ['forum', 'album', 'sticker', 'hotspot', 'shuoshuo', 'waterfall'];
	// 获取模板类型和页码
	$type = $template->GetTags('type');
	$page = $template->GetTags('page');
	// 处理首页非第一页的情况
	if ($type == 'index' && $page != '1') {
		$templateMap = [
			'1' => 'forum',
			'2' => 'album',
			'3' => 'sticker',
			'4' => 'hotspot',
			'5' => 'shuoshuo',
			'6' => 'waterfall'
		];

		$style = $zbp->Config('tpure')->PostINDEXSTYLE;
		$template->SetTemplate(isset($templateMap[$style]) ? $templateMap[$style] : 'catalog');
	}
	// 处理分类、标签和日期页面
	if ($type == 'category' || $type == 'tag' || $type == 'date') {
		$currentTemplate = '';
		if ($type == 'category') {
			$currentTemplate = $template->GetTags('category')->Template;
		} elseif ($type == 'tag') {
			$currentTemplate = $template->GetTags('tag')->Template;
		}

		if (!in_array($currentTemplate, $specialTemplates)) {
			$template->SetTemplate('catalog');
		}
	}
	// 处理作者页面
	if ($type == 'author') {
		$authorTemplate = $template->GetTags('author')->Template;
		if (!in_array($authorTemplate, array_merge(['catalog'], $specialTemplates))) {
			$template->SetTemplate('author');
		}
	}
}

//搜索功能函数
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewSearch_Template', 'tpure_SearchMain');
function tpure_SearchMain(&$template)
{
	global $zbp;
	$articles = $template->GetTags('articles');
	$q = $template->GetTags('search');
	$qc = '<mark>' . $q . '</mark>';
	foreach ($articles as $key => $article) {
		$a = $zbp->GetPostByID($article->ID);
		$article->Intro = tpure_GetIntro($a, $q);
		$article->Title = str_ireplace($q, $qc, $article->Title);
	}
}

//自定义模板样式名称
function tpure_JudgeListTemplate($listtype)
{
	global $zbp;
	$listtype = $zbp->Config('tpure')->PostSEARCHSTYLE;
	switch($listtype)
	{
		case 1:
			$template = 'forum';
			break;
		case 2:
			$template = 'album';
			break;
		case 3:
			$template = 'sticker';
			break;
		case 4:
			$template = 'hotspot';
			break;
		case 5:
			$template = 'shuo';
			break;
		case 6:
			$template = 'waterfall';
			break;
		default:
			$template = '';
	}
	return $template;
}

//转换实体符号
function tpure_DecodeStr($string)
{
	$str = strip_tags($string); // 去除HTML标签，保留空格和换行
	$str = htmlspecialchars_decode($str);
	$str = html_entity_decode($str); // 转换实体编码
	$str = trim($str); // 去除字符串两侧的空格和换行
	$str = preg_replace('/[\n\r]+/', '', $str); // 去除字符串中的多余空格和换行
	return $str;
}

//阅读下一篇文章提取前N个段落
function tpure_SingleNextContentStr($Content, $limit = null)
{
	global $zbp;
	preg_match_all('/<p\b[^>]*>/i', $Content, $matches, PREG_OFFSET_CAPTURE);
	$pCount = count($matches[0]);
	$limit = $zbp->Config('tpure')->PostNEXTCONTENTLIMIT ? $zbp->Config('tpure')->PostNEXTCONTENTLIMIT : 4;
	if ($pCount < $limit) {
		return $Content;
	}
	$targetPos = $matches[0][$limit - 1][1];
	return substr($Content, 0, $targetPos);
}

//字符数超出限制使用半省略号结尾，未超出则输出完整字符串，默认200字符
function tpure_TrimString($string, $length = 200)
{
	// 去除HTML标签
	$string = TransferHTML(tpure_DecodeStr($string),'[nohtml]');
	// 判断字符串长度是否超过指定长度
	if (mb_strlen($string, 'utf-8') > $length) {
		// 超过，截取前 $length 个字符并加上省略号
		return mb_substr($string, 0, $length) . '…';
	} else {
		// 未超过，直接输出原字符串
		return $string;
	}
}

//格式化多个使用逗号分隔的ID
function tpure_FormatID($ids)
{
	$filter = str_replace('，', ',', $ids);
	$filter = preg_replace('/,+/', ',', $filter);
	return trim($filter, ',');
}

//数以万计
function tpure_Myriabit($number, $decimals = 2)
{
	global $zbp,$lang;
	if(!$zbp->Config('tpure')->PostMYRIABITON){
		return (string) $number;
	}
	if (!is_numeric($number) || $number == 0) {
		return (string) $number;
	}
	$abs = abs($number);
	if ($abs < 10000) {
		return (string) $number;
	}
	$divided = round($abs / 10000, $decimals);
	if (intval($divided) == $divided) {
		$divided = intval($divided);
	}
	$unit = isset($lang['tpure']['viewunit']) ? $lang['tpure']['viewunit'] : $lang['tpure']['viewunit'];
	return ($number < 0 ? '-' : '') . $divided . $unit;
}

//首页过滤指定分类文章并重建分页；
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewList_Core', 'tpure_Exclude_Category');
function tpure_Exclude_Category($type, $page, $category, $author, $datetime, $tag, &$w, $pagebar)
{
	global $zbp;
	$filter = tpure_FormatID($zbp->Config('tpure')->PostFILTERCATEGORY);
	if ($type == 'index' && $filter) {
		$w[] = array('NOT IN', 'log_CateID', explode(',',$filter));
		$pagebar->Count = null;
	}
}

//主题设置页面获取分类的下拉控件
function tpure_Exclude_CategorySelect($default)
{
	global $zbp;
	foreach ($GLOBALS['hooks']['Filter_Plugin_OutputOptionItemsOfCategories'] as $fpname => &$fpsignal) {
		$fpreturn = $fpname($default);
		if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
			$fpsignal = PLUGIN_EXITSIGNAL_NONE;
			return $fpreturn;
		}
	}
	$s = '';
	// 处理默认值，确保它是一个数组
	$defaultArray = array();
	if (!empty($default)) {
		if (is_array($default)) {
			// 如果已经是数组，直接使用
			$defaultArray = $default;
		} elseif (is_string($default)) {
			// 如果是字符串，去除空格后按逗号分割
			$defaultArray = explode(',', str_replace(' ', '', $default));
		}
		// 可以添加其他类型的处理，如果需要的话
	}
	foreach ($zbp->categoriesbyorder as $id => $cate) {
		// 检查当前分类ID是否在默认值数组中
		$selected = in_array($cate->ID, $defaultArray) ? 'selected="selected"' : '';
		$s .= '<option ' . $selected . ' value="' . $cate->ID . '">' . $cate->SymbolName . '</option>';
	}
	return $s;
}

//个性化日期函数
function tpure_TimeAgo($ptime, $type = null)
{
	global $zbp;
	$ptime = strtotime($ptime);
	switch($type){
		case 1:
				return date('Y-m-d', $ptime);
		case 2:
			return date('Y-m-d H:i', $ptime);
		case 3:
			return date('Y-m-d H:i:s', $ptime);
		case 4:
			return date('Y年m月d日', $ptime);
		case 5:
			return date('Y年m月d日 H:i', $ptime);
		case 6:
			return date('Y年m月d日 H:i:s', $ptime);
		case 7:
			return date('F j, Y', $ptime);
		case 8:
			return date('d M Y', $ptime);
		default:
			$etime = time() - $ptime;
			if ($etime < 1) {
				return $zbp->lang['tpure']['justago'];
			}
			$interval = array(
				12 * 30 * 24 * 60 * 60 => $zbp->lang['tpure']['yearsago'].'<span class="datetime"> (' . date('Y-m-d', $ptime) . ')</span>',
				30 * 24 * 60 * 60 => $zbp->lang['tpure']['monthago'].'<span class="datetime"> (' . date('m-d', $ptime) . ')</span>',
				7 * 24 * 60 * 60 => $zbp->lang['tpure']['weeksago'].'<span class="datetime"> (' . date('m-d', $ptime) . ')</span>',
				24 * 60 * 60 => $zbp->lang['tpure']['daysago'],
				60 * 60 => $zbp->lang['tpure']['monthsago'],
				60 => $zbp->lang['tpure']['minutesago'],
				1 => $zbp->lang['tpure']['secondsago'],
			);
			foreach ($interval as $secs => $str) {
				$d = $etime / $secs;
				if ($d >= 1) {
					$r = round($d);
					return $r . $str;
				}
			}
	}
}

//自定义色彩设置，色彩设置保存时执行
function tpure_color()
{
	global $zbp;
	$skin = '';
	$color = $zbp->Config('tpure')->PostCOLOR;
	list($r, $g, $b) = array_map('hexdec', str_split($zbp->Config('tpure')->PostCOLOR, 2));
	$skin .= "a, a:hover,.menu li a:hover,.menu li.on a,.menu li .subnav a:hover:after,.menu li .subnav a.on,.menu li.subcate:hover a,.menu li.subcate:hover .arrow::before,.menu li.subcate:hover>a::after,.menu li.subcate.on>a::after,.menu li.subcate:hover .subnav a:hover,.menu li.subcate:hover .subnav a.on,.menu li.subcate:hover .subnav a.on:after,.sch-m input,.sch-m input:focus,.sch-m button:after,.schfixed input:focus,.schclose,.schform input,.schform button:after,.cmstitle h4 .cmscate:hover,.cmstitle h4 .more:hover,.cmstitle h4 .more:hover::after,.cmslist li a:hover,.post h2 a:hover,.post h2 .istop:before,.post .user a:hover,.post .date a:hover,.post .cate a:hover,.post .views a:hover,.post .cmtnum a:hover,.post .edit a:hover,.post .del a:hover,.post .readmore a:hover,.post .readmore a:hover:after,.post .tags a:hover,.pages a:hover,a.backlist:hover,.cmtsfoot .reply:hover,.cmtsfoot .reply:hover:before,.cmtarea textarea:focus,.cmtform input:focus,.night .cmtform input:focus,.cmtsubmit button:hover,.cmtsubmit button:hover:before,.sidebox dd a:hover,#divTags ul li a:hover,#divCalendar td a,#divCalendar #today,#divContorPanel .cp-login a:hover,#divContorPanel .cp-vrs a:hover,#divContorPanel .cp-login a:hover:before,#divContorPanel .cp-vrs a:hover:before,.footer a:hover,.goback:hover,.goback:hover:after,.relateinfo h3 a:hover,.teles, .telesmore,.relate,.sitemap a:hover,.night .post h2 a:hover,.night .relateinfo h3 a:hover,.night #cancel-reply,.night #cancel-reply:before,.night .pages a:hover,.night .errorpage .errschtxt:focus,.errschtxt:focus,.night .errorpage .goback:hover,.night .relatelist a:hover,.night .sidebox dd .sidecmtarticle a:hover,.sidebox dd .sidelink a:hover,.night .sidebox dd .sidelink a:hover,.night .sidebox dd .sideitem .itemtitle:hover,.sidebox dd .noimg .sidelink a:hover,.archivedate.on,.archivelist h3 a:hover,.night .archivelist h3 a:hover,.copynoticetxt a:hover,.friendlink li a:hover,.sign span a,.signusermenu a:hover,.filter li.active,.filter li.active i::before,.night .filter li.active,.filter li:hover,.post mark,.sidebox dd .sidecmtarticle a:hover,.night .sidebox dd .avatartitle:hover,.night .sidebox dd .sidecmtcon a:hover,.block.forum .item h2.top a::before,.block.forum .item h2.top a,.block.forum .item h2 a:hover,.block.forum .item:hover h2 a, .block.forum .item:hover h2 a::before,.night .block.forum .item h2.top a,.night .block.forum .item h2 a:hover,.block.album .albumcon a:hover,.night .block.album .albumcon a:hover,.block.sticker .post .istop::before, .block.hotspot .post .istop::before, .block.album .albumimg a .istop::before, .block.shuo .post .istop::before, .block.waterfall .post .istop::before,.post.istop .istop::before,.block.waterfall .waterfallimg a .istop::before,.block.hotspot .post h2 .istop::before,.block.shuo .istop::before,.shuo h2 a:hover,.night .block.shuo .shuo h2 a:hover,.schitemcon mark,.schwords a:hover,.gourl,.gourl::after,.singlenext .content p.mask a,#cancel-reply,#cancel-reply::before,.night .schmore a:hover,.linkbox .wrap p.link,.linkbox .wrap a,.night .linkbox .wrap p.link { color:#{$color}; }.single p.ue-upload a,.singlenext h3 a:hover,.zbaudio_play em.pause::before,.night .zbaudio_play em.pause::before { color:#{$color}!important; }@media screen and (max-width:1080px){.menu ul li.subcate.slidedown > a:after {color:#{$color}}}"; //color
	$skin .= ".menu li:before,.schfixed button,.cmstitle h4 .cmscate::before,.post h2 em,.pagebar .now-page,.cmtpagebar .now-page,.pagebar a:hover,.cmtpagebar a:hover,a.backtotop:hover,.night .errorpage .errschbtn,.tagscloud li:hover,.night .tagscloud li:hover,.sign span a:hover,.night .signusermenu a:hover,.authinfo h1 span,.filternav li.active::after,.block.album .albumimg a em,.block.forum .item h2.top em,.gourl:hover,.night .gourl:hover,.night .singlenext .content p.mask a:hover,.linkbox .wrap a:hover,.night .linkbox .wrap p a {background:#{$color};} .zbaudio_now,.zbaudio_bar::before,#cancel-reply:hover {background:#{$color}!important;}.gourl{background:rgba({$r},{$g},{$b},.05);}.linkbox .wrap a{background:rgba({$r},{$g},{$b},.05);}"; //background
	$skin .= ".menuico span,.lazyline,a.setnight:hover,a.lang:hover,.night a.backtotop:hover,.swiper-pagination-bullet-active,.maincon .swiper-button-prev:hover::after,.maincon .swiper-button-next:hover::after {background-color:#{$color}}"; //background-color
	$skin .= ".menu li .subnav,.schfixed,.sideuserlink p a.wechat span {border-top-color:#{$color}}"; //border-top-color
	$skin .= ".menu li.subcate .subnav a {color:#333}";
	$skin .= ".menu li .subnav:before,.sch-m input,.schfixed:before,.schform input,.single h1:after,.single h2:after,.single h3:after,.single h4:after,.single h5:after,.single h6:after,.contitle h1,.contitle h2 {border-bottom-color:#{$color}}"; //border-bottom-color
	$skin .= ".post .readmore a:hover,.post .tags a:hover,.telesmore i,.pagebar .now-page,.pagebar a:hover,a.backlist:hover,#divTags ul li a:hover,#divCalendar td a,#divContorPanel .cp-login a:hover,#divContorPanel .cp-vrs a:hover,.goback:hover,.night .post .readmore a:hover,.night #divContorPanel .cp-login a:hover, .night #divContorPanel .cp-vrs a:hover,.night #cancel-reply,.night .pages a:hover,.cmtpagebar .now-page,.cmtpagebar a:hover,.cmtsubmit button:hover,.night .cmtsubmit button:hover,.night .errorpage .errschbtn,.night .errorpage .goback:hover,.closesite h1,.signuser.normal:hover,.sign span a,.searchnull a,.gourl,.singlenext .content p.mask a:hover,.night .singlenext .content p.mask a,#cancel-reply,.linkbox .wrap a {border-color:#{$color}}"; //border-color
	$bgcolor = $zbp->Config('tpure')->PostBGCOLOR;
	$skin .= ".wrapper,.main,.maincon,.closepage { background:#{$bgcolor}; }";
	$sidelayout = $zbp->Config('tpure')->PostSIDELAYOUT;
	if ($sidelayout == 'l') {
		$skin .= ".sidebar { float:left; } .content { float:right; }@media screen and (max-width:1200px){.content { float:none; margin:0; }}";
	}
	$font = $zbp->Config('tpure')->PostFONT;
	if ($font) {
		$skin .= "body,input,textarea {font-family:{$font}}";
	}
	if($zbp->Config('tpure')->PostBGIMGSTYLE == '2'){
		$bgimgstyle = "background-attachment:fixed; background-position:center top; background-size:cover;";
	}else{
		$bgimgstyle = "background-attachment:fixed; background-position:center; background-repeat:repeat;";
	}
	if($zbp->Config('tpure')->PostBGIMGON){
		$skin .= ".maincon,.main { background-image:url(".$zbp->Config('tpure')->PostBGIMG.");".$bgimgstyle." }";
	}
	$headbgcolor = $zbp->Config('tpure')->PostHEADBGCOLOR;
	$footbgcolor = $zbp->Config('tpure')->PostFOOTBGCOLOR;
	$footfontcolor = $zbp->Config('tpure')->PostFOOTFONTCOLOR;
	if($headbgcolor){
		$skin .= ".header { background-color:#{$headbgcolor};}";
	}
	if($footbgcolor && $footfontcolor){
		$skin .= ".footer { color:#{$footfontcolor}; background-color:#{$footbgcolor}; } .footer a { color:#{$footfontcolor}; }";
	}
	$bannermaskbg = $zbp->Config('tpure')->PostBANNERMASKBG;
	$bannermaskopacity = $zbp->Config('tpure')->PostBANNERMASKOPACITY / 100;
	if($bannermaskbg && $bannermaskopacity){
		$skin .= ".banner::before { background-color:#{$bannermaskbg}; opacity:{$bannermaskopacity}; }";
	}
	$customcss = $zbp->Config('tpure')->PostCUSTOMCSS;
	$skin .= "{$customcss}";

	return $skin;
}

//“阅读更多”功能判断设备类型
function tpure_viewall($meta = '')
{
	global $zbp;
	//meta控制
	if ($meta === '1' || !$zbp->Config('tpure')->PostVIEWALLON) {
		return '';
	}
	$cfg = strtolower($zbp->Config('tpure')->PostVIEWALLTYPE);
	$isMobile = tpure_isMobile();
	switch ($cfg) {
		case 'pc':
			$hit = !$isMobile;
			break;
		case 'mobile':
			$hit = $isMobile;
			break;
		case 'both':
			$hit = true;
			break;
		default:
			$hit = false;
	}
	return $hit ? true : false;
}

//文章或页面自动展示全文开关(开启)
//挂接口：Add_Filter_Plugin('Filter_Plugin_Edit_Response3', 'tpure_ArticleViewall');
function tpure_ArticleViewall()
{
	global $article, $lang;
	echo '<div class="editmod">
			<label class="editinputname">'.$lang['tpure']['admin']['autoviewall'].'</label>
			<input type="text" name="meta_viewall" value="'.$article->Metas->viewall.'" class="checkbox">
		</div>';
}

//文章编辑页面插入自定义表单；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Edit_Response5', 'tpure_Edit_Response');
function tpure_Edit_Response()
{
	global $zbp,$article;
	tpure_CustomMeta_Response($article);
}

//文章自定义Meta字段
function tpure_CustomMeta_Response(&$object)
{
	global $zbp, $lang; ?>
	<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/admin.css">
	<script src="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/custom.js"></script>
	<?php
		echo '<label for="proimg">'.$lang['tpure']['admin']['proimg'].'</label><p><span><input type="text" name="meta_proimg" id="proimg" placeholder="'.$lang['tpure']['admin']['proimgtip'].'" value="' . htmlspecialchars($object->Metas->proimg) . '" class="metasrc"/></span><span><input type="button" class="uploadimg button" value="'.$lang['tpure']['admin']['uploadimg'].'"></span></p>';
		if($zbp->Config('tpure')->PostZBAUDIOON == '1'){
		if(htmlspecialchars($object->Metas->audioimg)){
			$audioimg = htmlspecialchars($object->Metas->audioimg);
		}else{
			$audioimg = $zbp->host.'zb_users/theme/tpure/style/images/selectimg.png';
		}
		echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['audioset'].' +++++</div>
<div class="introcon media">
	<div class="mediacover"><p>
	<span>
	<input type="hidden" name="meta_audioimg" value="' . htmlspecialchars($object->Metas->audioimg) . '" class="checkhas thumbsrc"></span>
	<span><input type="button" value="" class="uploadimg uploadico">
	</span>
	<span><img src="' . $audioimg . '" class="thumbimg"></span></p>

	</div>
	<div class="mediainfo">
		<div class="mediaform">
			<p>
				<span><input type="text" name="meta_audio" value="' . htmlspecialchars($object->Metas->audio) . '" placeholder="'.$lang['tpure']['admin']['audiosettip'].'" class="checkhas metasrc"/></span>
				<span><input type="button" class="uploadfile button" value="'.$lang['tpure']['admin']['uploadmp3'].'"></span>
			</p>
			<p>
			<input type="text" name="meta_audiotitle" value="' . htmlspecialchars($object->Metas->audiotitle) . '" placeholder="'.$lang['tpure']['admin']['audiotitle'].'" class="checkhas metahalf"/>
			<input type="text" name="meta_audiosinger" value="' . htmlspecialchars($object->Metas->audiosinger) . '" placeholder="'.$lang['tpure']['admin']['audiosinger'].'" class="checkhas metahalf"/>
			</p>
			<div class="mediaautoplay">'.$lang['tpure']['admin']['autoplay'].'<input type="text" name="meta_audioautoplay" class="checkbox" value="' . $object->Metas->audioautoplay . '"></div>
		</div>
	</div>
</div>
			</div>';
		}
		if($zbp->Config('tpure')->PostVIDEOON == '1'){
		echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['videoset'].' +++++</div>
<div class="introcon">
<p class="videobox"><label for="video">'.$lang['tpure']['admin']['autoplay'].'<input type="text" name="meta_videoautoplay" class="checkhas checkbox" value="' . $object->Metas->videoautoplay . '">　|　'.$lang['tpure']['admin']['loopplay'].'<input type="text" name="meta_videoloop" class="checkhas checkbox" value="' . $object->Metas->videoloop . '"> | '.$lang['tpure']['admin']['videoinsertleft'].' <input type="number" name="meta_zbvideoindex" value="'.($object->Metas->zbvideoindex ? $object->Metas->zbvideoindex : "0").'" style="width:80px;"> '.$lang['tpure']['admin']['videoinsertright'].'</label><span><input type="text" name="meta_video" id="video" placeholder="'.$lang['tpure']['admin']['uploadvideotip'].'" value="' . htmlspecialchars($object->Metas->video) . '" class="checkhas metasrc"></span><span><input type="button" class="uploadfile button" value="'.$lang['tpure']['admin']['uploadvideo'].'"></span></p><p><span><input type="text" name="meta_videopic" placeholder="'.$lang['tpure']['admin']['uploadvideopictip'].'" value="' . htmlspecialchars($object->Metas->videopic) . '" class="checkhas metasrc"></span><span><input type="button" class="uploadimg button" value="'.$lang['tpure']['admin']['uploadpic'].'"></span></p>
</div>
			</div>';
		}
		if($zbp->Config('tpure')->PostBANNERON){
			if(htmlspecialchars($object->Metas->schbanner)){
				$bannerimg = htmlspecialchars($object->Metas->schbanner);
			}else{
				$bannerimg = $zbp->host.'zb_users/theme/tpure/style/images/selectimg.png';
			}
			echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['bannerset'].' +++++</div>
<div class="introcon">
	<div class="mediacover"><p>
	<span>
	<input type="hidden" name="meta_schbanner" value="' . htmlspecialchars($object->Metas->schbanner) . '" class="checkhas thumbsrc"></span>
	<span><input type="button" value="" class="uploadimg uploadico">
	</span>
	<span><img src="' . $bannerimg . '" class="thumbimg"></span></p>

	</div>
	<div class="mediainfo">
		<div class="mediaform">
			<p>
				<span><textarea name="meta_schbannerfont" placeholder="'.$lang['tpure']['admin']['bannersettip'].'" class="checkhas metasrc" style="height:75px;">' . htmlspecialchars($object->Metas->schbannerfont) . '</textarea></span>
			</p>
			<div class="mediaautoplay">'.$lang['tpure']['admin']['bannerviewsch'].'<input type="text" name="meta_schbannerformon" class="checkhas checkbox" value="' . $object->Metas->schbannerformon . '"></div>
		</div>
	</div>
</div>
			</div>';
		}
}

//文章页面自定义Meta字段；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Edit_Response5', 'tpure_SingleEdit_Response');
function tpure_SingleEdit_Response()
{
	global $zbp, $article, $lang;
	if ($zbp->Config('tpure')->SEOON == '1') {
	echo '<div class="introbox">
		<div class="togglelabel">+++++ '.$lang['tpure']['admin']['articleseoset'].' +++++</div>
<div class="introcon">
		<p>
			<label>'.$lang['tpure']['admin']['seotitle'].'</label>
			<input type="text" name="meta_singletitle" value="' . htmlspecialchars($article->Metas->singletitle) . '" class="checkhas metasrc">
		</p>
		<p>
			<label>'.$lang['tpure']['admin']['seokeywords'].'</label>
			<input type="text" name="meta_singlekeywords" value="' . htmlspecialchars($article->Metas->singlekeywords) . '" class="checkhas metasrc">
		</p>
		<p>
			<span class="title">'.$lang['tpure']['admin']['seodescription'].'</span><br>
			<textarea cols="3" rows="3" name="meta_singledescription" class="checkhas metaintro">' . htmlspecialchars($article->Metas->singledescription) . '</textarea>
		</p>
</div>
	</div>';
	}
}

//分类自定义Meta字段；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Category_Edit_Response', 'tpure_CategoryEdit_Response');
function tpure_CategoryEdit_Response()
{
	global $zbp, $lang, $cate; ?>
	<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/admin.css">
	<script src="<?php echo $zbp->host; ?>zb_users/plugin/UEditor/ueditor.config.php"></script>
	<script src="<?php echo $zbp->host; ?>zb_users/plugin/UEditor/ueditor.all.min.js"></script>
	<script src="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/custom.js"></script>
	<script>
		var edtIntro = new baidu.editor.ui.Editor({ toolbars:[["source","Paragraph","FontFamily","FontSize","Bold","Italic","ForeColor","backcolor", "link","justifyleft","justifycenter","justifyright",'inserttable','insertimage','insertvideo']],initialFrameHeight:100 });
		edtIntro.render("edtIntro");
	</script>
	<?php
	if ($zbp->Config('tpure')->SEOON == '1') {
	echo '<div class="introbox">
		<div class="togglelabel">+++++ '.$lang['tpure']['admin']['catalogseoset'].' +++++</div>
<div class="introcon">
		<p>
			<span class="title">'.$lang['tpure']['admin']['seotitle'].'</span><br>
			<input type="text" name="meta_catetitle" value="' . htmlspecialchars($cate->Metas->catetitle) . '" class="checkhas metasrc">
		</p>
		<p>
			<span class="title">'.$lang['tpure']['admin']['seokeywords'].'</span><br>
			<input type="text" name="meta_catekeywords" value="' . htmlspecialchars($cate->Metas->catekeywords) . '" class="checkhas metasrc">
		</p>
		<p>
			<span class="title">'.$lang['tpure']['admin']['seodescription'].'</span><br>
			<textarea cols="3" rows="3" name="meta_catedescription" class="checkhas metaintro">' . htmlspecialchars($cate->Metas->catedescription) . '</textarea>
		</p>
</div>
	</div>';
	}
	if($zbp->Config('tpure')->PostBANNERON){
			if(htmlspecialchars($cate->Metas->schbanner)){
				$bannerimg = htmlspecialchars($cate->Metas->schbanner);
			}else{
				$bannerimg = $zbp->host.'zb_users/theme/tpure/style/images/selectimg.png';
			}
			echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['bannerset'].' +++++</div>
<div class="introcon">
	<div class="mediacover"><p>
	<span>
	<input type="hidden" name="meta_schbanner" value="' . htmlspecialchars($cate->Metas->schbanner) . '" class="checkhas thumbsrc"></span>
	<span><input type="button" value="" class="uploadimg uploadico">
	</span>
	<span><img src="' . $bannerimg . '" class="thumbimg"></span></p>

	</div>
	<div class="mediainfo">
		<div class="mediaform">
			<p>
				<span><textarea name="meta_schbannerfont" placeholder="'.$lang['tpure']['admin']['bannersettip'].'" class="checkhas metasrc" style="height:75px;">' . htmlspecialchars($cate->Metas->schbannerfont) . '</textarea></span>
			</p>
			<div class="mediaautoplay">'.$lang['tpure']['admin']['bannerviewsch'].'<input type="text" name="meta_schbannerformon" class="checkhas checkbox" value="' . $cate->Metas->schbannerformon . '"></div>
		</div>
	</div>
</div>
			</div>';
	}
}

//标签自定义Meta字段；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Tag_Edit_Response', 'tpure_TagEdit_Response');
function tpure_TagEdit_Response()
{
	global $zbp, $lang, $tag;
	if ($zbp->CheckPlugin('UEditor')) {
		echo '<script src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.config.php"></script>';
		echo '<script src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.all.min.js"></script>';
	}?>
	<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/admin.css">
	<script src="<?php echo $zbp->host; ?>zb_users/theme/tpure/script/custom.js"></script>
	<script>
		var edtIntro = new baidu.editor.ui.Editor({ toolbars:[["source","Paragraph","FontFamily","FontSize","Bold","Italic","ForeColor","backcolor", "link","justifyleft","justifycenter","justifyright",'inserttable','insertimage','insertvideo']],initialFrameHeight:100 });
		edtIntro.render("edtIntro");
	</script>
	<?php
	if ($zbp->Config('tpure')->SEOON == '1') {
	echo '<div class="introbox">
		<div class="togglelabel">+++++ '.$lang['tpure']['admin']['tagseoset'].' +++++</div>
<div class="introcon">
		<p>
			<span class="title">'.$lang['tpure']['admin']['seotitle'].'</span><br>
			<input type="text" name="meta_tagtitle" value="' . htmlspecialchars($tag->Metas->tagtitle) . '" class="checkhas metasrc">
		</p>
		<p>
			<span class="title">'.$lang['tpure']['admin']['seokeywords'].'</span><br>
			<input type="text" name="meta_tagkeywords" value="' . htmlspecialchars($tag->Metas->tagkeywords) . '" class="checkhas metasrc">
		</p>
		<p>
			<span class="title">'.$lang['tpure']['admin']['seodescription'].'</span><br>
			<textarea cols="3" rows="3" name="meta_tagdescription" class="checkhas metaintro">' . htmlspecialchars($tag->Metas->tagdescription) . '</textarea>
		</p>
</div>
	</div>';
	}
	if($zbp->Config('tpure')->PostBANNERON){
			if(htmlspecialchars($tag->Metas->schbanner)){
				$bannerimg = htmlspecialchars($tag->Metas->schbanner);
			}else{
				$bannerimg = $zbp->host.'zb_users/theme/tpure/style/images/selectimg.png';
			}
			echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['bannerset'].' +++++</div>
<div class="introcon">
	<div class="mediacover"><p>
	<span>
	<input type="hidden" name="meta_schbanner" value="' . htmlspecialchars($tag->Metas->schbanner) . '" class="checkhas thumbsrc"></span>
	<span><input type="button" value="" class="uploadimg uploadico">
	</span>
	<span><img src="' . $bannerimg . '" class="thumbimg"></span></p>

	</div>
	<div class="mediainfo">
		<div class="mediaform">
			<p>
				<span><textarea name="meta_schbannerfont" placeholder="'.$lang['tpure']['admin']['bannersettip'].'" class="checkhas metasrc" style="height:75px;">' . htmlspecialchars($tag->Metas->schbannerfont) . '</textarea></span>
			</p>
			<div class="mediaautoplay">'.$lang['tpure']['admin']['bannerviewsch'].'<input type="text" name="meta_schbannerformon" class="checkhas checkbox" value="' . $tag->Metas->schbannerformon . '"></div>
		</div>
	</div>
</div>
			</div>';
	}
}

//用户上传头像、性别、banner背景图
//挂接口：Add_Filter_Plugin('Filter_Plugin_Member_Edit_Response', 'tpure_MemberEdit_Response');
function tpure_MemberEdit_Response()
{
	global $zbp, $lang, $member;
	if ($zbp->CheckPlugin('UEditor')) {
		echo '<script src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.config.php"></script>';
		echo '<script src="' . $zbp->host . 'zb_users/plugin/UEditor/ueditor.all.min.js"></script>';
	}
	?>
	<link rel="stylesheet" href="<?php echo $zbp->host;?>zb_users/theme/tpure/script/admin.css">
	<script type="text/javascript" src="<?php echo $zbp->host;?>zb_users/theme/tpure/script/custom.js"></script>
	<script>
		var edtIntro = new baidu.editor.ui.Editor({ toolbars:[["source","Paragraph","FontFamily","FontSize","Bold","Italic","ForeColor","backcolor", "link","justifyleft","justifycenter","justifyright",'inserttable','insertimage','insertvideo']],initialFrameHeight:100 });
		edtIntro.render("edtIntro");
	</script>
	<?php
	echo '<p style="width:600px;">
		<span class="title">头像</span><br>
		<span><input type="text" name="meta_memberimg" value="' . htmlspecialchars($member->Metas->memberimg) . '" class="metasrc"></span>
		<span><input type="button" class="uploadimg button" value="上传头像"></span>
	</p>
	<p>
		<span class="title">性别</span><br>
		<select class="edit" size="1" name="meta_membersex">
			<option value="1" '.($member->Metas->membersex == '1' ? 'selected="selected"' : '').'>男</option>
			<option value="2" '.($member->Metas->membersex == '2' ? 'selected="selected"' : '').'>女</option>
		</select>
	</p>';
	if ($zbp->Config('tpure')->SEOON == '1') {
		echo '<div class="introbox">
			<div class="togglelabel">+++++ '.$lang['tpure']['admin']['memberseoset'].' +++++</div>
<div class="introcon">
			<p>
				<span class="title">'.$lang['tpure']['admin']['seotitle'].'</span><br>
				<input type="text" name="meta_membertitle" value="' . htmlspecialchars($member->Metas->membertitle) . '" class="checkhas metasrc">
			</p>
			<p>
				<span class="title">'.$lang['tpure']['admin']['seokeywords'].'</span><br>
				<input type="text" name="meta_memberkeywords" value="' . htmlspecialchars($member->Metas->memberkeywords) . '" class="checkhas metasrc">
			</p>
			<p>
				<span class="title">'.$lang['tpure']['admin']['seodescription'].'</span><br>
				<textarea cols="3" rows="3" name="meta_memberdescription" class="checkhas metaintro">' . htmlspecialchars($member->Metas->memberdescription) . '</textarea>
			</p>
</div>
		</div>';
	}
	if($zbp->Config('tpure')->PostBANNERON){
			if(htmlspecialchars($member->Metas->schbanner)){
				$bannerimg = htmlspecialchars($member->Metas->schbanner);
			}else{
				$bannerimg = $zbp->host.'zb_users/theme/tpure/style/images/selectimg.png';
			}
			echo '<div class="introbox"><div class="togglelabel">+++++ '.$lang['tpure']['admin']['bannerset'].' +++++</div>
<div class="introcon">
	<div class="mediacover"><p>
	<span>
	<input type="hidden" name="meta_schbanner" value="' . htmlspecialchars($member->Metas->schbanner) . '" class="checkhas thumbsrc"></span>
	<span><input type="button" value="" class="uploadimg uploadico">
	</span>
	<span><img src="' . $bannerimg . '" class="thumbimg"></span></p>

	</div>
	<div class="mediainfo">
		<div class="mediaform">
			<p>
				<span><textarea name="meta_schbannerfont" placeholder="'.$lang['tpure']['admin']['bannersettip'].'" class="checkhas metasrc" style="height:75px;">' . htmlspecialchars($member->Metas->schbannerfont) . '</textarea></span>
			</p>
			<div class="mediaautoplay">'.$lang['tpure']['admin']['bannerviewsch'].'<input type="text" name="meta_schbannerformon" class="checkhas checkbox" value="' . $member->Metas->schbannerformon . '"></div>
		</div>
	</div>
</div>
			</div>';
	}
}

//文章图片灯箱引入样式及js；
//挂接口：Add_Filter_Plugin('Filter_Plugin_Zbp_MakeTemplatetags','tpure_Timgbox');
function tpure_Timgbox()
{
	global $zbp;
	$zbp->header .= '	<link href="'.$zbp->host.'zb_users/theme/'.$zbp->theme.'/plugin/timgbox/timgbox.css" rel="stylesheet" type="text/css">' . "\r\n";
	$zbp->header .= '	<script src="'.$zbp->host.'zb_users/theme/'.$zbp->theme.'/plugin/timgbox/timgbox.js"></script>' . "\r\n";
}

//主题自带模块(热门阅读/热评文章/最新文章/推荐阅读/最新评论/站长简介)
//编辑模块成功时执行接口：Add_Filter_Plugin('Filter_Plugin_PostModule_Succeed', 'tpure_CreateModule');
//评论成功时执行接口：Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', 'tpure_CreateModule');
//评论删除成功时执行接口：Add_Filter_Plugin('Filter_Plugin_DelComment_Succeed', 'tpure_CreateModule');
//审核评论成功时执行接口：Add_Filter_Plugin('Filter_Plugin_CheckComment_Succeed', 'tpure_CreateModule');
//文章提交成功时执行接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_CreateModule');
//删除文章时执行接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Del', 'tpure_CreateModule');
function tpure_CreateModule()
{
	global $zbp, $lang;
	//刷新浏览总量
	$all_views = ($zbp->option['ZC_LARGE_DATA'] == true || $zbp->option['ZC_VIEWNUMS_TURNOFF'] == true) ? 0 : GetValueInArrayByCurrent($zbp->db->Query('SELECT SUM(log_ViewNums) AS num FROM ' . $GLOBALS['table']['Post']), 'num');
	$zbp->cache->all_view_nums = $all_views;
	$zbp->SaveCache();

	$module_list = array(
		array("tpure_hotviewarticle", "tpure_HotViewArticle", "ul", $lang['tpure']['admin']['hotviewarticle'],"0"),
		array("tpure_hotcmtarticle", "tpure_HotCmtArticle", "ul", $lang['tpure']['admin']['hotcmtarticle'],"0"),
		array("tpure_newarticle", "tpure_NewArticle", "ul", $lang['tpure']['admin']['newarticle'],"0"),
		array("tpure_recarticle", "tpure_RecArticle", "ul", $lang['tpure']['admin']['recarticle'],"0"),
		array("tpure_avatarcomment", "tpure_AvatarComment", "ul", $lang['tpure']['admin']['avatarcomment'],"0"),
		array("tpure_newcomment", "tpure_NewComment", "ul", $lang['tpure']['admin']['newcomment'],"0"),
		array("tpure_user", "tpure_User", "div", $lang['tpure']['admin']['webmaster'],"1"),
		array("tpure_readers", "tpure_Readers", "ul", $lang['tpure']['readers'],"0"),
		array("tpure_catearticle", "tpure_CateArticle", "ul", $lang['tpure']['admin']['catearticle'], "0"),
	);
	$module_filenames = array();
	foreach ($module_list as $item) {
		array_push($module_filenames, $item[0]);
	}
	$modules = $zbp->GetModuleList(array("*"), array(
		array("IN", "mod_FileName", $module_filenames),
	));
	$has_modules = array();
	foreach ($modules as $item) {
		$item->Content = tpure_SideContent($item);
		$item->Save();
		//$zbp->AddBuildModule($item->FileName);
		array_push($has_modules, $item->FileName);
	}
	foreach ($module_filenames as $k => $item) {
		if (!array_search($item, $has_modules)) {
			$module = $module_list[$k];
			$t = new Module();
			$t->Name = $module[3];
			$t->IsHideTitle = $module[4];
			$t->FileName = $module[0];
			$t->Source = "theme_tpure";
			$t->SidebarID = 0;
			$t->Content = tpure_SideContent($t);
			$t->HtmlID = $module[1];
			$t->Type = $module[2];
			$t->Save();
		}
	}
}

//卸载主题时判断是否删除自定义模块
function tpure_DelModule()
{
	global $zbp;
	$modules = array('tpure_hotviewarticle', 'tpure_hotcmtarticle', 'tpure_newarticle', 'tpure_recarticle', 'tpure_avatarcomment', 'tpure_newcomment', 'tpure_user', 'tpure_readers', 'tpure_catearticle');
	$w = array();
	$w[] = array('IN', 'mod_FileName', $modules);
	$modules = $zbp->GetModuleList(array('*'),$w);
	foreach ($modules as $item) {
		$item->Del();
	}
}

//模块内容
function tpure_SideContent(&$module)
{
	global $zbp, $lang;
	$str = "";
	if($zbp->Config('tpure')->PostBLANKSTYLE == 2){
		$blankstyle = ' target="_blank"';
	}else{
		$blankstyle = '';
	}
	switch ($module->FileName) {
		case 'tpure_hotviewarticle':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$hotArtList = tpure_GetHotArticleList($num);
			foreach ($hotArtList as $item) {
				$str .= '<li class="sideitem">';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){
					$str .= '<div class="sideimg">
						<a href="'.$item->Url.'"'. $blankstyle .'>
							<img src="'.tpure_Thumb($item).'" alt="'.$item->Title.'">
						</a>
					</div>';
				}
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '<div class="hasimg">'; }
				$str .= '<a href="'.$item->Url.'"'. $blankstyle .' title="'.$item->Title.'" class="itemtitle">'.$item->Title.'</a>';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '</div>'; }
				$str .= '<p class="sideinfo"><span class="view">'.tpure_Myriabit($item->ViewNums).' '.$zbp->lang['tpure']['viewnum'].'</span>'.$item->Category->Name.'</p>
			</li>';
			}
		break;
		case 'tpure_hotcmtarticle':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$hotArtList = tpure_GetHotArticleList($num, "cmt");
			foreach ($hotArtList as $item) {
				$str .= '<li class="sideitem">';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){
					$str .= '<div class="sideimg">
						<a href="'.$item->Url.'"'. $blankstyle .'>
							<img src="'.tpure_Thumb($item).'" alt="'.$item->Title.'">
						</a>
					</div>';
				}
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '<div class="hasimg">'; }
				$str .= '<a href="'.$item->Url.'"'. $blankstyle .' title="'.$item->Title.'" class="itemtitle">'.$item->Title.'</a>';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '</div>'; }
				$str .= '<p class="sideinfo"><span class="cmt">'.$item->CommNums.' '.$zbp->lang['tpure']['cmtnum'].'</span>'.$item->Category->Name.'</p>
			</li>';
			}
		break;
		case 'tpure_newarticle':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$hotArtList = GetList($num);
			foreach ($hotArtList as $item) {
				$str .= '<li class="sideitem">';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){
					$str .= '<div class="sideimg">
						<a href="'.$item->Url.'"'. $blankstyle .'>
							<img src="'.tpure_Thumb($item).'" alt="'.$item->Title.'">
						</a>
					</div>';
				}
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '<div class="hasimg">'; }
				$str .= '<a href="'.$item->Url.'"'. $blankstyle .' title="'.$item->Title.'" class="itemtitle">'.$item->Title.'</a>';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '</div>'; }
				$str .= '<p class="sideinfo"><em class="view">'.tpure_TimeAgo($item->Time(),$zbp->Config('tpure')->PostTIMESTYLE).'</em></p>
			</li>';
			}
		break;
		case 'tpure_recarticle':
			$recArtList = tpure_GetRecArticle();
			foreach ($recArtList as $item) {
				$image = tpure_Thumb($item);
				$str .= '<li class="sideitem';if(tpure_Thumb($item) == '' || $zbp->Config('tpure')->PostSIDEIMGON == '0'){$str .= ' noimg';}$str .= '">';
				if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){
					if($zbp->Config('tpure')->PostRANDTHUMBON == '1'){$IsThumb='2';}else{$IsThumb='1';}
				$str .= '<div class="sideitemimg">
					<a href="'.$item->Url.'"'. $blankstyle .'>
						<img src="'.tpure_Thumb($item,$IsThumb).'" alt="'.$item->Title.'">
					</a>
				</div>';
				}
				$str .= '<div class="sidelink">
					<a href="'.$item->Url.'"'. $blankstyle .' title="'.$item->Title.'">'.$item->Title.'</a>
					<p class="sideinfo"><em class="date">'.tpure_TimeAgo($item->Time(),$zbp->Config('tpure')->PostTIMESTYLE).'</em>'.$item->Category->Name.'</p>
				</div>
			</li>';
			}
		break;
		case 'tpure_avatarcomment':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$newCmtList = tpure_GetNewComment($num);
			foreach ($newCmtList as $item) {
				$str .= '<li class="sideitem">
					<div class="avatarcmt">
						<div class="avatarimg"><span><img src="'.tpure_MemberAvatar($item->Author,$item->Author->Email).'" alt="'.$item->Author->StaticName.'"></span></div>
						<div class="avatarinfo">
							<p><em class="avatarname">'.$item->Author->StaticName.'</em><span>'.$lang['tpure']['admin']['cmtarticle'].'</span></p>
							<p><a href="'.$item->Post->Url.'"'. $blankstyle .' title="'.$item->Post->Title.'" class="avatartitle">'.$item->Post->Title.'</a></p>
						</div>
						<div class="avatarcon"><i>'.$item->Content.'</i></div>
					</div>
				</li>';
			}
		break;
		case 'tpure_newcomment':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$newCmtList = tpure_GetNewComment($num);
			foreach ($newCmtList as $item) {
				$str .= '<li class="sideitem">
				<div class="sidecmtinfo"><em>'.$item->Author->StaticName.'</em>';
				if($zbp->Config('tpure')->PostCMTTIMEON){
					$str .= tpure_TimeAgo($item->Time(),$zbp->Config('tpure')->PostTIMESTYLE);
				}
				$str .= '</div><div class="sidecmtcon"><a href="'.$item->Post->Url.'#cmt'.$item->ID.'"'. $blankstyle .' title="'.$item->Content.'">'.$item->Content.'</a></div>
				<div class="sidecmtarticle"><a href="'.$item->Post->Url.'"'. $blankstyle .' title="'.$item->Post->Title.'">'.$item->Post->Title.'</a></div>
			</li>';
			}
		break;
		case 'tpure_catearticle':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 5;
			$newCmtList = tpure_GetCateIDArticle($num, $zbp->Config('tpure')->PostSIDECATEID);
			foreach ($newCmtList as $item) {
				$str .= '<li class="sideitem">';
					if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){
						$str .= '<div class="sideimg">
							<a href="'.$item->Url.'"'. $blankstyle .'>
								<img src="'.tpure_Thumb($item).'" alt="'.$item->Title.'">
							</a>
						</div>';
					}
					if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '<div class="hasimg">'; }
					$str .= '<a href="'.$item->Url.'"'. $blankstyle .' title="'.$item->Title.'" class="itemtitle">'.$item->Title.'</a>';
					if(tpure_Thumb($item) != '' && $zbp->Config('tpure')->PostSIDEIMGON == '1'){ $str .= '</div>'; }
					$str .= '<p class="sideinfo"><em class="view">'.tpure_TimeAgo($item->Time(),$zbp->Config('tpure')->PostTIMESTYLE).'</em></p>
				</li>';
			}
		break;
		case 'tpure_user':
			if($zbp->Config('tpure')->PostSIDEUSERBG){$sideuserbg = $zbp->Config('tpure')->PostSIDEUSERBG;}else{$sideuserbg = $zbp->host.'zb_users/theme/tpure/style/images/banner.jpg';}
			if($zbp->Config('tpure')->PostSIDEUSERIMG){$sideuserimg = $zbp->Config('tpure')->PostSIDEUSERIMG;}else{$sideuserimg = $zbp->host.'zb_users/avatar/0.png';}
			if($zbp->Config('tpure')->PostSIDEUSERNAME){$sideusername = $zbp->Config('tpure')->PostSIDEUSERNAME;}else{$sideusername = $zbp->name;}
			if($zbp->Config('tpure')->PostSIDEUSERINTRO){$sideuserintro = $zbp->Config('tpure')->PostSIDEUSERINTRO;}else{$sideuserintro = $zbp->name;}
			$sideuserwechat = '<p><a href="javascript:;" title="'.$zbp->lang['tpure']['sidewechat'].'" class="wechat"><span><img src="'.$zbp->Config('tpure')->PostSIDEUSERWECHAT.'" alt="'.$zbp->lang['tpure']['sidewechat'].'"></span></a></p>';
			$sideuserqq = '<p><a href="https://wpa.qq.com/msgrd?v=3&uin='.$zbp->Config('tpure')->PostSIDEUSERQQ.'&site=qq&menu=yes" target="_blank" title="'.$zbp->lang['tpure']['sideqq'].'" class="qq"></a></p>';
			$sideuseremail = '<p><a href="mailto:'.$zbp->Config('tpure')->PostSIDEUSEREMAIL.'" target="_blank" title="'.$zbp->lang['tpure']['sideemail'].'" class="email"></a></p>';
			$sideuserweibo = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERWEIBO.'" target="_blank" title="'.$zbp->lang['tpure']['sideweibo'].'" class="weibo"></a></p>';
			$sideusergroup = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERGROUP.'" target="_blank" title="'.$zbp->lang['tpure']['sidegroup'].'" class="group"></a></p>';
			$sideuserdouyin = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERDOUYIN.'" target="_blank" title="'.$zbp->lang['tpure']['sidedouyin'].'" class="douyin"></a></p>';
			$sideuserkuaishou = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERKUAISHOU.'" target="_blank" title="'.$zbp->lang['tpure']['sidekuaishou'].'" class="kuaishou"></a></p>';
			$sideusertoutiao = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERTOUTIAO.'" target="_blank" title="'.$zbp->lang['tpure']['sidetoutiao'].'" class="toutiao"></a></p>';
			$sideuserbilibili = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERBILIBILI.'" target="_blank" title="'.$zbp->lang['tpure']['sidebilibili'].'" class="bilibili"></a></p>';
			$sideuserxiaohongshu = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERXIAOHONGSHU.'" target="_blank" title="'.$zbp->lang['tpure']['sidexiaohongshu'].'" class="xiaohongshu"></a></p>';
			$sideuserzhihu = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERZHIHU.'" target="_blank" title="'.$zbp->lang['tpure']['sidezhihu'].'" class="zhihu"></a></p>';
			$sideusergithub = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERGITHUB.'" target="_blank" title="'.$zbp->lang['tpure']['sidegithub'].'" class="github"></a></p>';
			$sideusergitee = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERGITEE.'" target="_blank" title="'.$zbp->lang['tpure']['sidegitee'].'" class="gitee"></a></p>';
			$sideusermall = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERMALL.'" target="_blank" title="'.$zbp->lang['tpure']['sidemall'].'" class="mall"></a></p>';
			$sideuserfacebook = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERFACEBOOK.'" target="_blank" title="'.$zbp->lang['tpure']['sidefacebook'].'" class="facebook"></a></p>';
			$sideuserx = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERX.'" target="_blank" title="'.$zbp->lang['tpure']['sidex'].'" class="x"></a></p>';
			$sideuserinstagram = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERINSTAGRAM.'" target="_blank" title="'.$zbp->lang['tpure']['sideinstagram'].'" class="instagram"></a></p>';
			$sideuseryoutube = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERYOUTUBE.'" target="_blank" title="'.$zbp->lang['tpure']['sideyoutube'].'" class="youtube"></a></p>';
			$sideuserlinkedin = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERLINKEDIN.'" target="_blank" title="'.$zbp->lang['tpure']['sidelinkedin'].'" class="linkedin"></a></p>';
			$sideuserdiscord = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERDISCORD.'" target="_blank" title="'.$zbp->lang['tpure']['sidediscord'].'" class="discord"></a></p>';
			$sideuserlink = '<p><a href="'.$zbp->Config('tpure')->PostSIDEUSERLINK.'" target="_blank" class="link"></a></p>';
			$sideuser = (array)json_decode($zbp->Config('tpure')->PostSIDEUSER, true);
			$str .= '<div class="sideuser">
			<div class="sideuserhead" style="background-image:url('.$sideuserbg.');"></div>
			<div class="sideusercon">
			<div class="avatar"><img src="'.$sideuserimg.'" alt="'.$sideusername.'"></div>
			<h4>'.$sideusername.'</h4>
			<p>'.$sideuserintro.'</p>
			<div class="sideuserlink">';
				foreach ($sideuser as $key => $val) {
					if ($val == '1') {
						$var = 'sideuser'.$key;
						$str .= isset($$var) ? $$var : '';
					}
				}
			$str .= '</div>';
			if($zbp->Config('tpure')->PostSIDEUSERCOUNT == '1'){
			$str .= '<div class="sideuserfoot">
				<p><strong>'.tpure_Myriabit($zbp->cache->all_article_nums).'</strong><span>'.$zbp->lang['tpure']['sidearticle'].'</span></p>
				<p><strong>'.tpure_Myriabit($zbp->cache->all_comment_nums).'</strong><span>'.$zbp->lang['tpure']['sidecmt'].'</span></p>
				<p><strong>'.tpure_Myriabit($zbp->cache->all_view_nums).'</strong><span>'.$zbp->lang['tpure']['sideview'].'</span></p>
			</div>';
			}
			$str .= '</div>
			</div>';
		break;
		case 'tpure_readers':
			$num = $module->MaxLi > 0 ? $module->MaxLi : 8;
			$Readers = tpure_Readers($num);
			foreach ($Readers as $item) {
				$str .= '<li class="readeritem">';
				if($item['url']){ $str .= '<a href="'. $item['url'] .'" target="_blank" rel="nofollow">';}
				$str .= '<span class="readerimg"><img src="'. tpure_MemberAvatar($item['member'],$item['email']) .'" alt="'. $item['name'] .'"></span>';
				$str .= '<span class="readername">'. $item['name'] .'</span><span class="readernum">'. $item['count'] .'</span>';
				if($item['url']){ $str .= '</a>';}
			$str .= '</li>';
			}
		break;
	}
	return $str;
}

//获取指定分类下的文章
function tpure_GetCateIDArticle($num = 5, $cateid = null)
{
	global $zbp;
	$w = array();
	$w[] = array("=", "log_Type", "0");
	$w[] = array("=", "log_Status", "0");
	if($cateid){
		$ids = explode(",", $cateid);
		$w[] = array("IN", "log_CateID", $ids);
	}
	$order = array("log_PostTime" => "DESC");
	$articles = $zbp->GetArticleList(array('*'), $w, $order, array($num));
	return $articles;
}

//获取热门文章列表
function tpure_GetHotArticleList($num = 5, $type = "view")
{
	global $zbp;
	if ($type == "cmt") {
		$time = $zbp->Config('tpure')->PostSIDECMTDAY;
	} else {
		$time = $zbp->Config('tpure')->PostSIDEVIEWDAY;
	}
	if (empty($time)) {
		$time = 90 * 10;
	}
	$time = time() - $time * 24 * 60 * 60;
	$w = array();
	$w[] = array("=", "log_Type", "0");
	$w[] = array("=", "log_Status", "0");
	$w[] = array(">", "log_PostTime", $time);
	if ($type == "view") {
		$order = array("log_ViewNums" => "DESC");
	} else {
		$order = array("log_CommNums" => "DESC");
	}
	$articles = $zbp->GetArticleList(array('*'), $w, $order, array($num));
	return $articles;
}

//推荐阅读模块
function tpure_GetRecArticle()
{
	global $zbp;
	$w = array();
	$w[] = array("=", "log_Type", "0");
	$w[] = array("=", "log_Status", "0");
	$ids = $zbp->Config('tpure')->PostSIDERECID;
	$ids = explode(",", $ids);
	$w[] = array("IN", "log_ID", $ids);
	$list = $zbp->GetArticleList(array('*'), $w);
	$articles = array();
	foreach ($ids as $item) {
		$articles[] = $zbp->GetPostByID($item);
	}
	return $articles;
}

//获取最新评论
function tpure_GetNewComment($num = 5)
{
	global $zbp;
	$w = array();
	$w[] = array("=", "comm_IsChecking", "0");
	$comments = $zbp->GetCommentList(array('*'), $w, array("comm_PostTime" => "DESC"), array($num));
	foreach ($comments as &$comment) {
		if ($comment->ParentID > 0) {
			$comment->Parent = $zbp->GetCommentByID($comment->ParentID);
			$comment->Parent->Content = TransferHTML($comment->Parent->Content, '[nohtml]');
		}
		$comment->Content = TransferHTML($comment->Content, '[nohtml]');
	}
	return $comments;
}

//统一摘要
function tpure_GetIntro($object, $keywords = null)
{
	global $zbp;
	$introsource = $zbp->Config('tpure')->PostINTROSOURCE == '1' ? $object->Content : $object->Intro;
	if($zbp->Config('tpure')->PostINTRONUM){
		$text = trim(TransferHTML($introsource, '[nohtml]'));
		if($keywords){
			$text = tpure_SubStrStartUTF8($text, $keywords, $zbp->Config('tpure')->PostINTRONUM);
		}else{
			$text = SubStrUTF8($text, $zbp->Config('tpure')->PostINTRONUM);
		}
		$text = preg_replace('/\s+|　/', ' ', $text);
		$intro = trim($text) . '…';
		if ($keywords !== null && $keywords !== '') {
			$kw = preg_quote($keywords, '/');
			$intro = preg_replace('/' . $kw . '/i', '<mark>$0</mark>', $intro);
		}
	}else{
		$intro = $introsource;
	}
	return $intro;
}

//获取站内所有标签(标签云)
function tpure_GetTagCloudList()
{
	global $zbp;
	$filterNum = 0;
	$result = $zbp->GetTagList(array('*'), array(array('>', 'tag_Count', $filterNum),), array('tag_Count' => 'DESC'));
	$str = '<ul class="tagscloud">';
		foreach($result as $tag){
			$str .= "<li><a href=\"{$tag->Url}\" title=\"{$tag->Name}\">{$tag->Name}</a><span>({$tag->Count})</span></li>";
		}
	$str .= '</ul>';
	$tagsnull = '<div class="tagsnull">'.$zbp->lang['tpure']['tagsnull'].'</div>';
	return count($result) ? $str : $tagsnull;
}

//获取文章归档列表(文章过多时不建议开启)
function tpure_GetArchiveList()
{
	global $zbp;
	$result = $zbp->GetArticleList(array('*'), array(
		array('=', 'log_Status', '0'),
	), array('log_PostTime' => 'ASC'), array(1));
	if (count($result) == 0) {
		return false;
	}
	$months = array();
	$beignYear = (int) $result[0]->Time('Y');
	$beignMonth = (int) $result[0]->Time('m');
	$nowYear = (int) date('Y');
	$nowMonth = (int) date('m');
	$n = (int) date('Y') - $beignYear + 1;
	for ($i = 0; $i < $n; $i++) {
		$key = $beignYear + $i;
		$j_start = 1;
		if ($key == $beignYear) {
			$j_start = $beignMonth;
		}
		$z = 13;
		if ($key == $nowYear) {
			$z = $nowMonth + 1;
		}
		for ($j = $j_start; $j < $z; $j++) {
			$key = $key . $j;
			$months[$key] = mktime(0, 0, 0, $j, 1, $beignYear + $i);
		}
	}
	$list = array();
	foreach ($months as $k => $v) {
		$start = (int) $v - 1;
		$end = (int) strtotime('+1 month', $v) + 1;
		$result2 = $zbp->GetArticleList(array('*'), array(
			array('=', 'log_Status', '0'),
			array('>', 'log_PostTime', $start),
			array('<', 'log_PostTime', $end),
		), array('log_PostTime' => 'DESC'));
		if (count($result2) > 0) {
			$list[$k] = array(
				'timestamp' => $v,
				'articles' => $result2,
			);
		}
	}
	return $list;
}

//创建文章归档HTML
function tpure_CreateArchiveHTML()
{
	global $zbp;
	$archives = tpure_GetArchiveList();
	$zbp->Config('tpure')->PostBLANKSTYLE == 2?$target = ' target="_blank"':$target = '';
	$str = null;
	if ($archives) {
		if ($zbp->Config('tpure')->PostARCHIVEDATESORT == 'DESC') {
			$archives = array_reverse($archives);
		}
		foreach ($archives as $monthItem) {
			$str .= '<div class="archiveitem">';
			$str .= '<div class="archivedate">'.date('Y年m月', $monthItem['timestamp']).'</div>';
			$str .= '<ul class="archivelist">';
			foreach ($monthItem['articles'] as $item) {
				$str .= '<li>';
				if($zbp->Config('tpure')->PostARCHIVEDATEON == '1'){
					$str .= '<span class="archivetime">';
					if($zbp->Config('tpure')->PostARCHIVEDATETYPE == '0'){
						$str .= '['.$item->Time('m/d').']';
					}else{
						$str .= '['.$item->Time('m月d日').']';
					}
				}
				$str .= '</span>';
				$str .= ' <h3><a href="'.$item->Url.'"'.$target.' title="'.$item->Title.'">'.$item->Title.'</a></h3></li>';
			}
			$str .= '</ul>';
			$str .= '</div>';
		}
	} else {
		$str = '<div class="archivenull">'.$zbp->lang['tpure']['archivenull'].'</div>';
	}
	return $str;
}

//创建文章归档缓存文件(缓存路径：zb_users/theme/tpure/archive.html)
function tpure_CreateArchiveCache($str = false)
{
	global $zbp;
	$path = $zbp->usersdir . 'cache/theme/tpure/';
	if (!file_exists($path)) {
		@mkdir($path, 0755, true);
	}
	if (!file_exists($path)) {
		return false;
	}
	if (!$str) {
		$str = tpure_CreateArchiveHTML();
	}
	$filePath = $path . 'archive.html';
	$file = fopen($filePath, "w");
	fwrite($file, $str);
	fclose($file);
	if (!file_exists($filePath)) {
		return false;
	}
	return true;
}

//获取文章归档缓存文件
function tpure_GetArchives()
{
	global $zbp;
	$filePath = $zbp->usersdir . 'cache/theme/tpure/archive.html';
	if (!file_exists($filePath)) {
		$str = tpure_CreateArchiveHTML();
		$status = tpure_CreateArchiveCache($str);
		if (!$status) {
			return $str;
		} else {
			$str = file_get_contents($filePath);
			return $str;
		}
	} else {
		$str = file_get_contents($filePath);
		return $str;
	}
}

//自动更新文章归档缓存
//文章提交成功时更新归档缓存；挂接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_ArchiveAutoCache');
//文章删除成功时更新归档缓存；挂接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Del', 'tpure_ArchiveAutoCache');
function tpure_ArchiveAutoCache()
{
	global $zbp;
	if ($zbp->Config('tpure')->PostAUTOARCHIVEON) {
		tpure_CreateArchiveCache();
	}
}

//删除文章归档缓存
function tpure_delArchive()
{
	global $zbp;
	$dir = $zbp->usersdir . 'cache/theme/' . $zbp->theme . '/';
	if (file_exists($dir)) {
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."archive.html";
				if(!is_dir($fullpath)) {
					@unlink($fullpath);
				}else{
					@deldir($fullpath);
				}
			}
		}
		closedir($dh);
	}
}

//列表排序(可风)
//挂接口：Add_Filter_Plugin('Filter_Plugin_LargeData_Article','tpure_LargeDataArticle');
function tpure_LargeDataArticle($select, $w, &$order, $limit, $option, $type='')
{
	global $zbp;
	switch($type){
		case 'category':
			$pagebar = $option['pagebar'];
			$sort = GetVars('sort','GET') ? 'ASC' : 'DESC';
			switch($o = htmlspecialchars(GetVars('order','GET'), ENT_QUOTES, 'UTF-8')){
				case 'viewlist':
					$order = array('log_ViewNums' => $sort);
					break;
				case 'cmtlist':
					$order = array('log_CommNums' => $sort);
					break;
				case 'newlist':
				default:
					$order = array('log_PostTime' => $sort);
					$sort == 'DESC' && $o = null;
					break;
			}
			if ($o){
				$pagebar->UrlRule->__construct($zbp->option['ZC_CATEGORY_REGEX'] .($zbp->Config('system')->ZC_STATIC_MODE != 'REWRITE' ? '&' : '?'). 'order={%order%}&sort={%sort%}');
				$pagebar->UrlRule->Rules['{%order%}'] = $o;
				$pagebar->UrlRule->Rules['{%sort%}'] = (int)GetVars('sort','GET');
			}
			break;
	}
}

//读者墙(可风)
function tpure_readers($limit = 100)
{
	global $zbp;
	$list = array();
	if($zbp->Config('tpure')->PostREADERSURLON == '1'){
		$where = array(array('<>','comm_IsChecking','1'),array('<>','comm_HomePage',''));
	}else{
		$where = array('<>','comm_IsChecking','1');
	}
	$sql = $zbp->db->sql->get()->select($zbp->table['Comment'])->column('comm_Name,comm_Email,comm_AuthorID,comm_HomePage,count(*)')->where($where)->groupby('comm_Name,comm_Email,comm_AuthorID,comm_HomePage')->orderBy(array('count(*)' => 'DESC'))->limit($limit)->sql;
	foreach($zbp->db->Query($sql) as $value){
		$value = array_values($value);
		$list[] = array(
			'name' => $value[0],
			'email' => $value[1],
			'member' => $zbp->GetMemberByID($value[2]),
			'url' => str_ireplace('{#ZC_BLOG_HOST#}',$zbp->host,$value[3]),
			'count' => $value[4],
		);
	}
	return $list;
}

//新文章判断
//挂接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Core', 'tpure_ArticleCore');
function tpure_ArticleCore($article)
{
	if($article->ID > 0){
		$GLOBALS['is_new_article'] = false;
	}else{
		$GLOBALS['is_new_article'] = true;
	}
}

//新文章通知
//挂接口：Add_Filter_Plugin('Filter_Plugin_PostArticle_Succeed', 'tpure_ArticleSendmail');
function tpure_ArticleSendmail($article)
{
	global $zbp, $lang;
	$mailto = $zbp->Config('tpure')->MAIL_TO;
	if($zbp->Config('tpure')->PostLOGOON){
		$logo = '<img src="'.$zbp->Config('tpure')->PostLOGO.'" style="height:40px;line-height:0;border:none;display:block;">';
	}else{
		$logo = '<span style="font-size:22px; color:#666;">'.$zbp->name.'</span>';
	}
	if($zbp->user->StaticName == $article->Author->StaticName){
		$staticname = $lang['tpure']['admin']['ta'];
	}else{
		$staticname = $article->Author->StaticName;
	}
	if($GLOBALS['is_new_article'] === true){
		if($zbp->Config('tpure')->PostNEWARTICLEMAILSENDON){
			if($mailto){
				$subject = $zbp->user->StaticName . $lang['tpure']['admin']['postnewarticle'] . ' 《'.$article->Title.'》';
				$content = '<table width="700" align="center" cellpadding="0" cellspacing="0" style="margin-top:30px; border:1px solid rgb(230,230,230);"><tbody><tr><td><table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td width="30"></td><td width="640" style="padding:20px 0 10px;"><a href="'.$zbp->host.'" target="_blank" style="text-decoration:none; display:inline-block; vertical-align:top;">'.$logo.'</a></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table><tbody><tr><td width="30"></td><td width="640"><p style="margin:0; padding:30px 0 0px; font-size:18px; color:#151515; font-family:microsoft yahei; font-weight:bold; border-top:1px solid #eee;">'.$lang['tpure']['admin']['mailstart'].'</p><p style="margin:14px 0; font-size:16px; color:#151515; font-family:microsoft yahei; line-height:1.8;">'.$zbp->user->StaticName.$lang['tpure']['admin']['on'].' [ '.$zbp->name.' ] '.$lang['tpure']['admin']['released'].$staticname.$lang['tpure']['admin']['thenewarticle'].'<em style="font-weight:bold; font-style:normal;">《'.$article->Title.'》</em>：</p></td><td width="30"></td></tr><tr><td width="30"></td><td width="640"><p style="margin:0 0 20px; padding:15px 20px; font-size:16px; color:#7d8795; font-family:microsoft yahei; word-break:break-word; line-height:22px; border:1px solid #e6e6e6; background-color:#f5f5f5;">'.tpure_GetIntro($article).'</p><p style="margin:0 0 30px; text-align:center;"><a href="'.$article->Url.'" target="_blank" style="margin:0 auto; padding:12px 25px; font-size:16px; color:#fff; font-family:microsoft yahei; font-weight:bold; text-decoration:none; text-transform:capitalize; border:0; border-radius:50px; cursor:pointer; box-shadow:0 1px 2px rgba(0, 0, 0, 0.1); background-color:#206ffd; background-image:linear-gradient(to top, #206dfd 0%, #2992ff 100%); display: inline-block;">'.$lang['tpure']['admin']['visitarticle'].'</a></p></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table align="center" cellspacing="0" class="dao-content-footer" style=" background-color:rgb(245,245,245); line-height: 28px; padding: 13px 23px; color: #7d8795; font-weight:500; border-top:1px solid #e6e6e6;" width="100%" bgcolor="#e6e6e6"><tbody><tr><td style="font-family:microsoft yahei; font-size:14px; vertical-align:top; text-align:center;" valign="top">'.$zbp->name.' - '.$zbp->subname.'</td></tr></tbody></table></td></tr></tbody></table>';
				tpure_SendEmail($mailto,$subject,$content);
			}
		}
	}else{
		if($zbp->Config('tpure')->PostEDITARTICLEMAILSENDON){
			if($mailto){
				$subject = $zbp->user->StaticName . $lang['tpure']['admin']['editarticle'] .' 《'.$article->Title.'》';
				$content = '<table width="700" align="center" cellpadding="0" cellspacing="0" style="margin-top:30px; border:1px solid rgb(230,230,230);"><tbody><tr><td><table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td width="30"></td><td width="640" style="padding:20px 0 10px;"><a href="'.$zbp->host.'" target="_blank" style="text-decoration:none; display:inline-block; vertical-align:top;">'.$logo.'</a></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table><tbody><tr><td width="30"></td><td width="640"><p style="margin:0; padding:30px 0 0px; font-size:18px; color:#151515; font-family:microsoft yahei; font-weight:bold; border-top:1px solid #eee;">'.$lang['tpure']['admin']['mailstart'].'</p><p style="margin:14px 0; font-size:16px; color:#151515; font-family:microsoft yahei; line-height:1.8;">'.$zbp->user->StaticName.$lang['tpure']['admin']['on'].' [ '.$zbp->name.' ] '.$lang['tpure']['admin']['editit'].$staticname.$lang['tpure']['admin']['thearticle'].'<em style="font-weight:bold; font-style:normal;">《'.$article->Title.'》</em>：</p></td><td width="30"></td></tr><tr><td width="30"></td><td width="640"><p style="margin:0 0 20px; padding:15px 20px; font-size:16px; color:#7d8795; font-family:microsoft yahei; word-break:break-word; line-height:22px; border:1px solid #e6e6e6; background-color:#f5f5f5;">'.tpure_GetIntro($article).'</p><p style="margin:0 0 30px; text-align:center;"><a href="'.$article->Url.'" target="_blank" style="margin:0 auto; padding:12px 25px; font-size:16px; color:#fff; font-family:microsoft yahei; font-weight:bold; text-decoration:none; text-transform:capitalize; border:0; border-radius:50px; cursor:pointer; box-shadow:0 1px 2px rgba(0, 0, 0, 0.1); background-color:#206ffd; background-image:linear-gradient(to top, #206dfd 0%, #2992ff 100%); display: inline-block;">'.$lang['tpure']['admin']['visitarticle'].'</a></p></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table align="center" cellspacing="0" class="dao-content-footer" style=" background-color:rgb(245,245,245); line-height: 28px; padding: 13px 23px; color: #7d8795; font-weight:500; border-top:1px solid #e6e6e6;" width="100%" bgcolor="#e6e6e6"><tbody><tr><td style="font-family:microsoft yahei; font-size:14px; vertical-align:top; text-align:center;" valign="top">'.$zbp->name.' - '.$zbp->subname.'</td></tr></tbody></table></td></tr></tbody></table>';
				tpure_SendEmail($mailto,$subject,$content);
			}
		}
	}
}

//新评论邮件通知
//挂接口：Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', 'tpure_CmtSendmail');
function tpure_CmtSendmail($cmt)
{
	global $zbp, $lang;
	$logid=$cmt->LogID;
	$log=new Post();
	$log->LoadinfoByID($logid);
	$log_author = $zbp->GetPostByID($logid)->Author;
	if($zbp->Config('tpure')->PostLOGOON){
		$logo = '<img src="'.$zbp->Config('tpure')->PostLOGO.'" style="height:40px;line-height:0;border:none;display:block;">';
	}else{
		$logo = '<span style="font-size:22px; color:#666;">'.$zbp->name.'</span>';
	}
	if($zbp->Config('tpure')->PostCMTMAILSENDON){
		if($log_author->Email && $log_author->Email != 'null@null.com'){
			$subject = $lang['tpure']['admin']['log'].'《'.$log->Title.'》'.$lang['tpure']['admin']['getnewcmt'];
			$content = '<table width="700" align="center" cellpadding="0" cellspacing="0" style="margin-top:30px; border:1px solid rgb(230,230,230);"><tbody><tr><td><table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td width="30"></td><td width="640" style="padding:20px 0 10px;"><a href="'.$zbp->host.'" target="_blank" style="text-decoration:none; display:inline-block; vertical-align:top;">'.$logo.'</a></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table><tbody><tr><td width="30"></td><td width="640"><p style="margin:0; padding:30px 0 0px; font-size:18px; color:#151515; font-family:microsoft yahei; font-weight:bold; border-top:1px solid #eee;">'.$log_author->StaticName.'，'.$lang['tpure']['admin']['hi'].'</p><p style="margin:14px 0; font-size:16px; color:#151515; font-family:microsoft yahei; line-height:1.8;">'.$lang['tpure']['admin']['youhave'].' [ '.$zbp->name.' ] '.$lang['tpure']['admin']['thearticle'].'<em style="font-weight:bold; font-style:normal;">《'.$log->Title.'》</em>'.$lang['tpure']['admin']['getnewcmt'].'</p></td><td width="30"></td></tr><tr><td width="30"></td><td width="640"><p style="margin:0 0 20px; padding:15px 20px; font-size:16px; color:#7d8795; font-family:microsoft yahei; word-break:break-word; line-height:22px; border:1px solid #e6e6e6; background-color:#f5f5f5;">'.$cmt->Content.'</p><p style="margin:0 0 30px; text-align:center;"><a href="'.$log->Url.'" target="_blank" style="margin:0 auto; padding:12px 25px; font-size:16px; color:#fff; font-family:microsoft yahei; font-weight:bold; text-decoration:none; text-transform:capitalize; border:0; border-radius:50px; cursor:pointer; box-shadow:0 1px 2px rgba(0, 0, 0, 0.1); background-color:#206ffd; background-image:linear-gradient(to top, #206dfd 0%, #2992ff 100%); display: inline-block;">'.$lang['tpure']['admin']['visitcmt'].'</a></p></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table align="center" cellspacing="0" class="dao-content-footer" style=" background-color:rgb(245,245,245); line-height: 28px; padding: 13px 23px; color: #7d8795; font-weight:500; border-top:1px solid #e6e6e6;" width="100%" bgcolor="#e6e6e6"><tbody><tr><td style="font-family:microsoft yahei; font-size:14px; vertical-align:top; text-align:center;" valign="top">'.$zbp->name.' - '.$zbp->subname.'</td></tr></tbody></table></td></tr></tbody></table>';
			tpure_SendEmail($log_author->Email,$subject,$content);
		}
	}
	if($zbp->Config('tpure')->PostREPLYMAILSENDON && $cmt->ParentID>0){
		$parentcmt = $zbp->GetCommentByID($cmt->ParentID);
		$mailto=$parentcmt->Email;
		if($mailto && $mailto != 'null@null.com'){
			$subject = $lang['tpure']['admin']['youhave']." 【".$zbp->name."】 ".$lang['tpure']['admin']['newreply'];
			$content='<table width="700" align="center" cellpadding="0" cellspacing="0" style="margin-top:30px; border:1px solid rgb(230,230,230);"><tbody><tr><td><table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td width="30"></td><td width="640" style="padding:20px 0 10px;"><a href="'.$zbp->host.'" target="_blank" style="text-decoration:none; display:inline-block; vertical-align:top;">'.$logo.'</a></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table><tbody><tr><td width="30"></td><td width="640"><p style="margin:0; padding:30px 0 0px; font-size:18px; color:#151515; font-family:microsoft yahei; font-weight:bold; border-top:1px solid #eee;">'.$parentcmt->Name.'，'.$lang['tpure']['admin']['hi'].'</p><p style="margin:14px 0; font-size:16px; color:#151515; font-family:microsoft yahei; line-height:1.8;">'.$lang['tpure']['admin']['youhave'].' [ '.$zbp->name.' ] '.$lang['tpure']['admin']['thearticle'].'<em style="font-weight:bold; font-style:normal;">《'.$log->Title.'》</em>'.$lang['tpure']['admin']['postcmt'].'</p></td><td width="30"></td></tr><tr><td width="30"></td><td width="640"><p style="margin:0 0 20px; padding:15px 20px; font-size:16px; color:#7d8795; font-family:microsoft yahei; word-break:break-word; line-height:22px; border:1px solid #e6e6e6; background-color:#f5f5f5;">'.$parentcmt->Content.'</p><p style="margin:14px 0; font-size:16px; color:#151515; font-family:microsoft yahei;">'.$lang['tpure']['member'].' <em style="font-weight:bold; font-style:normal;">'.$cmt->Name.'</em> '.$lang['tpure']['admin']['giveyoureply'].'</p><p style="margin:0 0 20px; padding:15px 20px; font-size:16px; color:#7d8795; font-family:microsoft yahei; word-break:break-word; line-height:22px; border:1px solid #e6e6e6; background-color:#f5f5f5;">'.$cmt->Content.'</p><p style="margin:0 0 30px; text-align:center;"><a href="'.$log->Url.'" target="_blank" style="margin:0 auto; padding:12px 25px; font-size:16px; color:#fff; font-family:microsoft yahei; font-weight:bold; text-decoration:none; text-transform:capitalize; border:0; border-radius:50px; cursor:pointer; box-shadow:0 1px 2px rgba(0, 0, 0, 0.1); background-color:#206ffd; background-image:linear-gradient(to top, #206dfd 0%, #2992ff 100%); display: inline-block;">'.$lang['tpure']['admin']['visitreply'].'</a></p></td><td width="30"></td></tr></tbody></table></td></tr><tr><td><table align="center" cellspacing="0" class="dao-content-footer" style=" background-color:rgb(245,245,245); line-height: 28px; padding: 13px 23px; color: #7d8795; font-weight:500; border-top:1px solid #e6e6e6;" width="100%" bgcolor="#e6e6e6"><tbody><tr><td style="font-family:microsoft yahei; font-size:14px; vertical-align:top; text-align:center;" valign="top">'.$zbp->name.' - '.$zbp->subname.'</td></tr></tbody></table></td></tr></tbody></table>';
			tpure_SendEmail($mailto,$subject,$content);
		}
	}
}

// 头像优先级
// 挂接口：Add_Filter_Plugin('Filter_Plugin_Member_Avatar', 'tpure_MemberAvatar');
function tpure_MemberAvatar($member, $email = null)
{
	global $zbp;
	// 先拿到系统头像，包括其他插件返回的
	$avatar = $member->Avatar;
	// 判断是否包含 zb_users/avatar/0.png
	if (strpos($avatar, "zb_users/avatar/0.png") === false) {
		return $avatar;
	}
	$targetEmail = isset($email) ? $email : $member->Email;
	// 判断是否指定了头像
	if ($member->Metas->memberimg) {
		$avatar = $member->Metas->memberimg;
	} elseif ($targetEmail){
		preg_match_all('/((\d)*)@qq.com/', $targetEmail, $vai);
		// 如果匹配到 QQ 号
		if (isset($vai[1][0])) {
		$qq = $vai[1][0];
		$avatar = "https://q2.qlogo.cn/headimg_dl?dst_uin={$qq}&spec=100";
		}
	}
	return $avatar;
}

//判断移动端
function tpure_isMobile()
{
	global $zbp;
	if(isset($_GET['must_use_mobile']))
	{
		return true;
	}
	$is_mobile = false;
	$regex = '/android|adr|iphone|ipad|linux|windows\sphone|kindle|gt\-p|gt\-n|rim\stablet|opera|meego|Mobile|Silk|BlackBerry|opera\smini/i';
	if (preg_match($regex, GetVars('HTTP_USER_AGENT', 'SERVER')))
	{
		$is_mobile = true;
	}
	return $is_mobile;
}

//主题缩略图
function tpure_Thumb($Source, $IsThumb = '0', $allThumbs = false)
{
	global $zbp;
	$ThumbSrc = '';
	$randlength = $zbp->Config('tpure')->PostRANDTHUMBLENGTH ? $zbp->Config('tpure')->PostRANDTHUMBLENGTH : 10;
	$randnum = mt_rand(1, $randlength);
	$pattern = "/<img[^>]+src=\"(?<url>[^\"]+)\"[^>]*>/";
	$content = $Source->Content;
	preg_match_all($pattern, $content, $matchContent);
	if ($allThumbs) {
		return $matchContent[1];
	}
	if ($zbp->Config('tpure')->PostIMGON == '1') {
		if (isset($Source->Metas->proimg)) {
			$temp = $Source->Metas->proimg;
		} elseif (isset($Source->Metas->videopic)) {
			$temp = $Source->Metas->videopic;
		// } elseif ($Source->ImageCount >= 1 && (count($thumbs = $Source->Thumbs($thumbwidth, $thumbheight, 1)) > 0)) {
		// 裁切缩略图
		// 	$temp = $thumbs[0];
		} elseif (isset($matchContent[1][0])){
			$temp = $matchContent[1][0];
            if (stripos($temp, '/lazyload.png') !== false) {
                preg_match('/title=\"(?<url>[^\"]+)\"/', $matchContent[0][0], $matches);
                if (isset($matches[1])){
                    $temp = $matches[1];
                }
            }
		} else {
			if ($zbp->Config('tpure')->PostTHUMBON == '1') {
				$temp = $zbp->Config('tpure')->PostTHUMB;
			} elseif ($zbp->Config('tpure')->PostRANDTHUMBON == '1') {
				$temp = $zbp->host . "zb_users/theme/" . $zbp->theme . "/include/thumb/" . $randnum . ".jpg";
			} elseif ($IsThumb == '1') {
				$temp = $zbp->Config('tpure')->PostTHUMB;
			} else {
				$temp = '';
			}
		}
	} else {
		$temp = '';
	}
	$ThumbSrc = $temp;
	return $ThumbSrc;
}

//lazyload：列表缩略图延迟加载
//挂接口：Add_Filter_Plugin('Filter_Plugin_Zbp_BuildTemplate', 'tpure_ListIMGLazyLoad');
function tpure_ListIMGLazyLoad(&$template)
{
	global $zbp;
	$templateArr = explode(',', 'post-multi,post-istop,post-albummulti,post-albumistop,post-hotspotmulti,post-hotspotistop,post-shuomulti,post-shuoistop,post-waterfallmulti,post-waterfallistop');
	$templateArr = array_unique($templateArr);
	foreach ($templateArr as $key => $value) {
		if (isset($template[$value])) {
			$template[$value] = tpure_LazyLoadReplace($template[$value]);
		}
	}
}

//lazyload：匹配图片更新内容
function tpure_LazyLoadReplace($content)
{
	global $zbp;
	$placeIMG = $zbp->host . 'zb_users/theme/tpure/style/images/lazyload.png';
	$pattern = '/<img\b([^>]*?)src=(["\'])([^"\']+?)\2([^>]*?)\/?>/i';
	$content = preg_replace_callback($pattern, function ($m) use ($placeIMG) {
		$head = $m[1];
		$tail = $m[4];
		$oldClass = '';
		if (preg_match('/\bclass=(["\'])(.*?)\1/i', $head.$tail, $c)) {
			$oldClass = $c[2];
		}
		$newClass = trim($oldClass . ' lazyload');
		$attrs = preg_replace('/\bclass=["\'].*?["\']/i', '', $head.$tail);
		$attrs = rtrim($attrs, ' /');
		$attrs = ltrim($attrs) . ' class="' . $newClass . '"';
		return '<img ' . trim($attrs)
			. ' src="' . $placeIMG . '"'
			. ' data-original="' . $m[3] . '">';
	}, $content);
	return $content;
}

//lazyload：文章正文替换匹配后的图片延迟加载格式
//挂接口：Add_Filter_Plugin('Filter_Plugin_ViewPost_Template', 'tpure_ContentIMGLazyLoad');
function tpure_ContentIMGLazyLoad(&$template)
{
	global $zbp;
	$article = $template->GetTags('article');
	$article->Content = tpure_LazyLoadReplace($article->Content);
}

//页面分享组件
function tpure_share(){
	global $zbp;
	$post_share = json_decode($zbp->Config('tpure')->PostSHARE,true);
	$shareitems = [];
	if(count((array)$post_share)){
		foreach ($post_share as $key => $value) {
			if ($value == 1) {
				$shareitems[] = $key;
			}
		}
		return implode(",", $shareitems);
	}else{
		return 'weibo,wechat,qq,qzone,douban,linkedin,diandian';
	}
}

//主题默认配置
function tpure_Config()
{
	global $zbp;
	$array = array(
		'PostLOGO' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/logo.svg',
		'PostNIGHTLOGO' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/nightlogo.svg',
		'PostLOGOON' => '1',
		'PostLOGOHOVERON' => '1',
		'PostFAVICON' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/favicon.ico',
		'PostFAVICONON' => '1',
		'PostTHUMB' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/thumb.png',
		'PostTHUMBON' => '0',
		'PostRANDTHUMBON' => '0',
		'PostIMGON' => '1',
		'PostSIDEIMGON' => '1',
		'PostRANDTHUMBLENGTH' => '10',
		'PostBANNERON' => '1',
		'PostBANNER' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/banner.jpg',
		'PostBANNERDISPLAYON' => '1',
		'PostBANNERALLON' => '0',
		'PostBANNERFONT' => $zbp->subname,
		'PostBANNERPCHEIGHT' => '360',
		'PostBANNERMHEIGHT' => '200',
		'PostBANNERSEARCHWORDS' => '热搜词1|热搜词2|热搜词3',
		'PostBANNERSEARCHLABEL' => '大家都在搜：',
		'PostBANNERSEARCHON' => '1',
		'PostBANNERSEARCHALLON' => '0',
		'PostSEARCHON' => '1',
		'PostSCHTXT' => '搜索…',
		'PostVIEWALLON' => '1',
		'PostVIEWALLTYPE' => 'both',
		'PostVIEWALLHEIGHT' => '1000',
		'PostVIEWALLSTYLE' => '1',
		'PostVIEWALLSINGLEON' => '1',
		'PostVIEWALLPAGEON' => '1',
		'PostLISTINFO' => '{"user":"1","date":"1","cate":"0","view":"1","cmt":"0","edit":"1","del":"1"}',
		'PostARTICLEINFO' => '{"user":"1","date":"1","cate":"1","view":"1","cmt":"0","edit":"1","del":"1"}',
		'PostPAGEINFO' => '{"user":"1","date":"0","view":"0","cmt":"0","edit":"1","del":"1"}',
		'PostSINGLEKEY' => '1',
		'PostLISTKEY' => '1',
		'PostRELATEON' => '1',
		'PostRELATETITLE' => '1',
		'PostRELATECATE' => '1',
		'PostRELATENUM' => '',
		'PostRELATESTYLE' => '0',
		'PostRELATEDIALLEL' => '1',
		'PostARTICLECMTON' => '1',
		'PostPAGECMTON' => '1',
		'PostCMTMAILON' => '1',
		'PostCMTMAILNOTNULLON' => '1',
		'PostCMTSITEON' => '1',
		'PostCMTTIMEON' => '1',
		'PostCMTLOGINON' => '0',
		'PostCMTIPON' => '1',
		'VerifyCode' => 'ACDEFHKMNPRSTUVWXY34578',
		'PostCMSON' => '1',
		'PostCMS' => '1',
		'PostCMSLENGTH' => '5',
		'PostCMSCOLUMN' => '1',
		'PostINDEXLISTON' => '1',
		'PostINDEXSTYLE' => '0',
		'PostSEARCHSTYLE' => '0',
		'PostAJAXON' => '1',
		'PostLOADPAGENUM' => '3',
		'PostFILTERCATEGORY' => '',
		'PostISTOPSIMPLEON' => '0',
		'PostISTOPINDEXON' => '1',
		'PostGREYON' => '0',
		'PostGREYSTATE' => '0',
		'PostGREYDAY' => '',
		'PostSETNIGHTON' => '1',
		'PostSETNIGHTAUTOON' => '0',
		'PostSETNIGHTSTART' => '22',
		'PostSETNIGHTOVER' => '6',
		'PostTIMESTYLE' => '0',
		'PostCOPYNOTICEON' => '1',
		'PostCOPYNOTICEMOBILEON' => '0',
		'PostCOPYURLON' => '1',
		'PostQRON' => '1',
		'PostQRSIZE' => '70',
		'PostCOPYNOTICE' => '<p>扫描二维码推送至手机访问。</p><p>版权声明：本文由<strong>'.$zbp->name.'</strong>发布，如需转载请注明出处。</p>',
		'PostSHAREARTICLEON' => '1',
		'PostSHAREPAGEON' => '1',
		'PostSHARE' => '{"weibo":"1","wechat":"1","qq":"1","qzone":"1","douban":"1","linkedin":"0","diandian":"0","facebook":"0","twitter":"0","google":"0"}',
		'PostARCHIVEINFOON' => '1',
		'PostARCHIVEFOLDON' => '0',
		'PostAUTOARCHIVEON' => '0',
		'PostARCHIVEDATEON' => '1',
		'PostARCHIVEDATETYPE' => '0',
		'PostARCHIVEDATESORT' => 'DESC',
		'PostFRIENDLINKON' => '1',
		'PostFRIENDLINKMON' => '0',
		'PostERRORTOPAGE' => '',
		'PostCLOSESITEBG' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/banner.jpg',
		'PostCLOSESITEBGMASKON' => '1',
		'PostCLOSESITETITLE' => '网站维护中，暂时无法访问！',
		'PostCLOSESITECON' => '<p>感谢您一直以来对我们的支持与信赖。</p><p>为了提供更好的服务质量，我们正在进行网站的技术升级及系统维护工作。</p><p>期间将暂停访问。对您造成的不便我们深感歉意。</p><p>我们期待更完善的内容与您相遇，为您提供更优质的体验与服务。</p>',
		'PostSIGNON' => '1',
		'PostSIGNBTNTEXT' => '登录/注册',
		'PostSIGNBTNURL' => '{#ZC_BLOG_HOST#}zb_system/login.php',
		'PostSIGNUSERSTYLE' => '0',
		'PostSIGNUSERURL' => '{#ZC_BLOG_HOST#}zb_system/login.php',
		'PostSIGNUSERMENU' => '<a href="{#ZC_BLOG_HOST#}zb_system/cmd.php?act=ArticleEdt" target="_blank">新建文章</a>
		<a href="{#ZC_BLOG_HOST#}zb_system/cmd.php?act=ArticleMng" target="_blank">文章管理</a>
		<a href="{#ZC_BLOG_HOST#}zb_system/cmd.php?act=CategoryMng" target="_blank">分类管理</a>
		<a href="{#ZC_BLOG_HOST#}zb_system/cmd.php?act=CommentMng" target="_blank">评论管理</a>
		<a href="{#ZC_BLOG_HOST#}zb_system/cmd.php?act=ModuleMng" target="_blank">模块管理</a>
		<a href="{#ZC_BLOG_HOST#}zb_users/theme/tpure/main.php?act=base" target="_blank">主题设置</a>',
		'PostSITEMAPON' => '1',
		'PostSITEMAPMON' => '0',
		'PostSITEMAPSTYLE' => '0',
		'PostSITEMAPTXT' => '首页',
		'PostZBAUDIOON' => '1',
		'PostVIDEOON' => '1',
		'PostMEDIAICONON' => '1',
		'PostMEDIAICONSTYLE' => '0',
		'PostREADERSNUM' => '100',
		'PostREADERSURLON' => '0',
		'PostINTROSOURCE' => '0',
		'PostINTRONUM' => '150',
		'PostBLOCKQUOTEON' => '1',
		'PostBLOCKQUOTELABEL' => '摘要：',
		'PostBACKTOTOPON' => '1',
		'PostBACKTOTOPVALUE' => '500',
		'PostUNDEBUGON' => '0',
		'PostUNDRAGON' => '1',
		'PostUNRIGHTMENUON' => '1',
		'PostUNKEYON' => '1',
		'PostUNSELECTTEXTON' => '1',
		'PostUNCOPYON' => '1',
		'PostDEBUGGERON' => '1',
		'PostDEBUGCLEANON' => '1',
		'PostDEBUGHREFON' => '0',
		'PostDEBUGHREF' => '',
		'PostPREVNEXTTYPE' => '1',
		'PostCATEPREVNEXTON' => '1',
		'PostNEXTCONTENTLIMIT' => '3',
		'PostLOGINON' => '1',
		'PostLOGINBG' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/banner.jpg',
		'PostARTICLELINKON' => '1',
		'PostCMTLINKON' => '1',
		'PostGOURLTITLE' => '您即将离开本站',
		'PostGOURLTIP' => '请注意您的账号和财产安全',
		'PostBLANKSTYLE' => '2',
		'PostFILTERON' => '1',
		'PostMOREBTNON' => '0',
		'PostBIGPOSTIMGON' => '0',
		'PostFIXMENUON' => '1',
		'PostTIMGBOXON' => '1',
		'PostLAZYLOADON' => '1',
		'PostLAZYLINEON' => '0',
		'PostLAZYNUMON' => '1',
		'PostINDENTON' => '0',
		'PostTAGSON' => '1',
		'PostTFONTSIZEON' => '1',
		'PostREMOVEPON' => '1',
		'PostCONVERTON' => '1',
		'PostMYRIABITON' => '1',
		'PostADMINZHON' => '0',

		'SEOON' => '1',
		'SEODIVIDE' => ' - ',
		'SEOTITLE' => $zbp->name . ' - ' . $zbp->title,
		'SEOKEYWORDS' => '关键词1,关键词2,关键词3',
		'SEODESCRIPTION' => '此处为网站描述内容',
		'SEOTITLEDECODEON' => '0',
		'SEORETITLEON' => '0',
		'SEODESCRIPTIONDATA' => '0',
		'SEODESCRIPTIONNUM' => '200',
		'SEOCATALOGINFO' => '{"catalog":"1","title":"1","subtitle":"0"}',
		'SEOARTICLEINFO' => '{"article":"1","catalog":"1","title":"1","subtitle":"0"}',
		'SEOPAGEINFO' => '{"page":"1","title":"1","subtitle":"0"}',
		'SEOTAGINFO' => '{"tag":"1","title":"1","subtitle":"0"}',
		'SEOUSERINFO' => '{"user":"1","title":"1","subtitle":"0"}',
		'SEODATEINFO' => '{"date":"1","title":"1","subtitle":"0"}',
		'SEOSEARCHINFO' => '{"search":"1","title":"1","subtitle":"0"}',
		'SEOOTHERINFO' => '{"other":"1","title":"1","subtitle":"0"}',
		'PostOGINDEXON' => '0',
		'PostOGCATEGORYON' => '0',
		'PostOGTAGON' => '0',
		'PostOGAUTHORON' => '0',
		'PostOGARTICLEON' => '0',
		'PostOGPAGEON' => '0',
		'PostHEADERCODE' => '',
		'PostFOOTERCODE' => '',
		'PostSINGLETOPCODE' => '',
		'PostSINGLEBTMCODE' => '',

		'PostCOLORON' => '0',
		'PostFONT' => 'Penrose, "PingFang SC", "Hiragino Sans GB", Tahoma, Arial, "Lantinghei SC", "Microsoft YaHei", "simsun", sans-serif',
		'PostCOLOR' => '0188fb',
		'PostSIDELAYOUT' => 'r',
		'PostBGCOLOR' => 'f1f1f1',
		'PostBGIMG' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/background.jpg',
		'PostBGIMGON' => '0',
		'PostBGIMGSTYLE' => '2',
		'PostHEADBGCOLOR' => 'ffffff',
		'PostFOOTBGCOLOR' => 'e4e8eb',
		'PostFOOTFONTCOLOR' => '999999',
		'PostBANNERMASKBG' => '000000',
		'PostBANNERMASKOPACITY' => '10',
		'PostCUSTOMCSS' => '',

		'PostFIXSIDEBARON' => '1',
		'PostFIXSIDEBARSTYLE' => '0',
		'PostSIDEMOBILEON' => '0',
		'PostSIDECMTDAY' => '365',
		'PostSIDEVIEWDAY' => '365',
		'PostSIDERECID' => '',
		'PostSIDECATEID' => '',
		'PostSIDEUSERBG' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/banner.jpg',
		'PostSIDEUSERIMG' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/sethead.png',
		'PostSIDEUSERNAME' => $zbp->name,
		'PostSIDEUSERINTRO' => $zbp->title,
		'PostSIDEUSERWECHAT' => '{#ZC_BLOG_HOST#}zb_users/theme/tpure/style/images/qr.png',
		'PostSIDEUSERQQ' => '#',
		'PostSIDEUSEREMAIL' => '#',
		'PostSIDEUSERWEIBO' => '#',
		'PostSIDEUSERGROUP' => '#',
		'PostSIDEUSERDOUYIN' => '#',
		'PostSIDEUSERKUAISHOU' => '#',
		'PostSIDEUSERTOUTIAO' => '#',
		'PostSIDEUSERBILIBILI' => '#',
		'PostSIDEUSERXIAOHONGSHU' => '#',
		'PostSIDEUSERZHIHU' => '#',
		'PostSIDEUSERGITHUB' => '#',
		'PostSIDEUSERGITEE' => '#',
		'PostSIDEUSERMALL' => '#',
		'PostSIDEUSERFACEBOOK' => '#',
		'PostSIDEUSERX' => '#',
		'PostSIDEUSERINSTAGRAM' => '#',
		'PostSIDEUSERYOUTUBE' => '#',
		'PostSIDEUSERLINKEDIN' => '#',
		'PostSIDEUSERDISCORD' => '#',
		'PostSIDEUSERLINK' => '#',
		'PostSIDEUSER' => '{"wechat":"1","qq":"1","email":"1","weibo":"1","group":"1","douyin":"1","kuaishou":"1","toutiao":"1","bilibili":"1","xiaohongshu":"1","zhihu":"1","github":"1","gitee":"1","mall":"1","facebook":"1","x":"1","instagram":"1","youtube":"1","linkedin":"1","discord":"1","link":"1"}',
		'PostSIDEUSERCOUNT' => '1',

		'PostSLIDEDATA' => '[{"order":"1","img":"'.$zbp->host.'zb_users/theme/tpure/style/images/slide01.png","title":"幻灯标题","url":"'.$zbp->host.'","isused":"1","color":"ffffff"},{"order":"2","img":"'.$zbp->host.'zb_users/theme/tpure/style/images/slide02.png","title":"幻灯标题","url":"'.$zbp->host.'","isused":"1","color":"ffffff"}]',
		'PostSLIDEMDATA' => '[{"order":"1","img":"'.$zbp->host.'zb_users/theme/tpure/style/images/slide01.png","title":"幻灯标题","url":"'.$zbp->host.'","isused":"1","color":"ffffff"},{"order":"2","img":"'.$zbp->host.'zb_users/theme/tpure/style/images/slide02.png","title":"幻灯标题","url":"'.$zbp->host.'","isused":"1","color":"ffffff"}]',
		'PostSLIDEON' => '1',
		'PostSLIDEPLACE' => '0',
		'PostSLIDETITLEON' => '1',
		'PostSLIDEDISPLAY' => '1',
		'PostSLIDETIME' => '2500',
		'PostSLIDEPAGETYPE' => '1',
		'PostSLIDEPAGEON' => '1',
		'PostSLIDEBTNON' => '1',
		'PostSLIDEEFFECTON' => '0',

		'PostMAILON' => '0',
		'SMTP_SSL' => '0',
		'SMTP_HOST' => 'smtp.163.com',
		'SMTP_PORT' => '25',
		'FROM_EMAIL' => '',
		'SMTP_PASS' => '',
		'FROM_NAME' => '',
		'MAIL_TO' => '',
		'PostNEWARTICLEMAILSENDON' => '0',
		'PostEDITARTICLEMAILSENDON' => '0',
		'PostCMTMAILSENDON' => '0',
		'PostREPLYMAILSENDON' => '0',

		'PostAJAXPOSTON' => '1',
		'PostSAVECONFIG' => '1',
	);
	foreach ($array as $value => $intro) {
		$zbp->Config('tpure')->$value = $intro;
	}
}

//主题启用时的默认配置项
function InstallPlugin_tpure()
{
	global $zbp;
	if (!$zbp->Config('tpure')->HasKey('Version')) {
		tpure_Config();
	}
	$zbp->Config('tpure')->Version = '6.1';
	$zbp->SaveConfig('tpure');
	tpure_CreateModule();
	//创建索引
	//$zbp->db->query('create index idx_zbp_post_cate_type_status_id on '.$zbp->table['Post'].'(log_CateID, log_Type, log_Status, log_ID)');
}

//应用升级时执行
function UpdatePlugin_tpure()
{
	global $zbp;
	$version = $zbp->Config('tpure')->Version;
	if($version !== 6.1){
		$zbp->Config('tpure')->Version = 6.1;
		$zbp->Config('tpure')->PostINDEXLISTON = '1';
		$zbp->SaveConfig('tpure');
	}
	if(!$zbp->Config('tpure')->Haskey("Version")){
		$zbp->Config('tpure')->Version = '6.1';
		$zbp->SaveConfig('tpure');
	}
}

//旧版兼容
function tpure_Updated()
{
	UpdatePlugin_tpure();
}

//卸载主题时判断是否删除已保存的配置信息
function UninstallPlugin_tpure()
{
	global $zbp;
	if ($zbp->Config('tpure')->PostSAVECONFIG == 0) {
		$zbp->DelConfig('tpure');
	}
	//删除主题在模块管理中创建的模块
	tpure_DelModule();
}