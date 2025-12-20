<?php
$url = GetVars('go_url', 'GET');
$goUrlTitle = $zbp->Config('tpure')->PostGOURLTITLE ? $zbp->Config('tpure')->PostGOURLTITLE : $zbp->lang['tpure']['go_url_title'];
$goUrlTip = $zbp->Config('tpure')->PostGOURLTIP ? $zbp->Config('tpure')->PostGOURLTIP : $zbp->lang['tpure']['go_url_tip'];
$hash = GetVars('hash', 'GET');
if (md5(md5($zbp->guid) . md5($url)) != $hash) {
	die;
}
?>
<!DOCTYPE html>
<html lang="zh-Hans">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $goUrlTitle?></title>
	<link rel="stylesheet" href="<?php echo $zbp->host;?>zb_users/theme/<?php echo $zbp->theme;?>/style/style.css">
	<?php if($zbp->Config('tpure')->PostCOLORON == '1'){
	echo '<link rel="stylesheet" rev="stylesheet" href="'.$zbp->host.'zb_users/theme/'.$zbp->theme.'/include/skin.css?v='.$zbp->Config('tpure')->PostCOLORTOKEN.'" type="text/css" media="all">';}?>
</head>
<body<?php if(GetVars('night','COOKIE')){echo ' class="night"';}?>>
<div class="linkbox">
	<div class="wrap">
		<div class="linklogo"><img src="<?php if(GetVars('night','COOKIE')){echo $zbp->Config('tpure')->PostNIGHTLOGO;}else{echo $zbp->Config('tpure')->PostLOGO;}?>" alt="<?php echo $zbp->name;?>"></div>
		<strong><?php echo $goUrlTitle?></strong>
		<p><?php echo $goUrlTip?></p>
		<p class="link"><?php echo $url;?></p>
		<p class="btn">
			<a href="javascript:;" rel="nofollow" onclick="tpure_jumplink()"><?php echo $zbp->lang['tpure']['go_url_btn'];?></a>
		</p>
	</div>
</div>
<script>function tpure_jumplink(){const linkElement=document.querySelector('.link');if(!linkElement){alert("<?php echo $zbp->lang['tpure']['unfound_url'];?>");return;}const targetUrl=linkElement.textContent.trim();if(!targetUrl.startsWith('http://')&&!targetUrl.startsWith('https://')){alert("<?php echo $zbp->lang['tpure']['url_error'];?>");return;}window.open(targetUrl,'_self');}</script>
</body>
</html>