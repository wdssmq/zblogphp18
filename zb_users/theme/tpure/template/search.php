{* Template Name:搜索页模板 * Template Type:search *}
<!DOCTYPE html>
<html xml:lang="{$lang['lang_bcp47']}" lang="{$lang['lang_bcp47']}">
<head>
{template:header}
</head>
<body class="{$type}{if GetVars('night','COOKIE') } night{/if}">
<div class="wrapper">
	{template:navbar}
	<div class="main{if $zbp->Config('tpure')->PostFIXMENUON=='1'} fixed{/if}">
		{if $zbp->Config('tpure')->PostSLIDEON == '1' && $zbp->Config('tpure')->PostSLIDEPLACE == '2'}
			{php}
			$slideKey = tpure_isMobile() ? 'PostSLIDEMDATA' : 'PostSLIDEDATA';
			$slidedata = json_decode($zbp->Config('tpure')->$slideKey,true);
			if (!is_array($slidedata)) {
				$slidedata = [];
			}
			$isused = array_filter($slidedata, function($item) {
				return $item['isused'] == 1;
			});
			{/php}
			<div class="slide topslide swiper-container{if $zbp->Config('tpure')->PostSLIDEDISPLAY=='1'} display{/if}">
				<div class="swiper-wrapper">
					{if isset($slidedata)}
					{foreach $slidedata as $value}
						{if $value['isused']}
							<a href="{$value['url']}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if} class="swiper-slide" style="background-color:#{$value['color']};"><img src="{$value['img']}" alt="{$value['title']}"></a>
						{/if}
					{/foreach}
					{/if}
				</div>
				{if count((array)$slidedata) > 1}
					{if $zbp->Config('tpure')->PostSLIDEPAGEON == '1'}
					<div class="swiper-pagination"></div>
					{/if}
					{if $zbp->Config('tpure')->PostSLIDEBTNON == '1'}
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
					{/if}
				{/if}
			</div>
		{else}
			{template:schbanner}
		{/if}
		<div class="maincon">
			<div class="wrap">
				{if tpure_isMobile() ? $zbp->Config('tpure')->PostSITEMAPMON == '1' : $zbp->Config('tpure')->PostSITEMAPON == '1'}
				<div class="sitemap">{$lang['tpure']['sitemap']}<a href="{$host}">{$zbp->Config('tpure')->PostSITEMAPTXT ? $zbp->Config('tpure')->PostSITEMAPTXT : $lang['tpure']['index']}</a> > {$title}
				</div>
				{/if}
				<div{if $zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'} id="sticky"{/if}>
					<div class="content listcon">
						<div class="block custom{if $zbp->Config('tpure')->PostBIGPOSTIMGON=='1'} large{/if}{if tpure_JudgeListTemplate($zbp->Config('tpure')->PostSEARCHSTYLE)} {tpure_JudgeListTemplate($zbp->Config('tpure')->PostSEARCHSTYLE)}{/if}">
							{if count((array)$articles)}
								{if $zbp->Config('tpure')->PostSEARCHSTYLE == '1'}
									{foreach $articles as $article}
									{template:post-forummulti}
									{/foreach}
								{elseif $zbp->Config('tpure')->PostSEARCHSTYLE == '2'}
									<div class="albumlist">
									{foreach $articles as $article}
									{template:post-albummulti}
									{/foreach}
									</div>
								{elseif $zbp->Config('tpure')->PostSEARCHSTYLE == '4'}
									{foreach $articles as $article}
									{template:post-hotspotmulti}
									{/foreach}
								{elseif $zbp->Config('tpure')->PostSEARCHSTYLE == '5'}
									{foreach $articles as $article}
									{template:post-shuomulti}
									{/foreach}
								{elseif $zbp->Config('tpure')->PostSEARCHSTYLE == '6'}
									<div id="waterfalllist" class="waterfalllist">
									{foreach $articles as $article}
									{template:post-waterfallmulti}
									{/foreach}
									</div>
								{else}
									{foreach $articles as $article}
									{template:post-multi}
									{/foreach}
								{/if}
							{else}
								<div class="searchnull">{$lang['tpure']['searchnulltip']} <a href="https://www.baidu.com/s?wd={htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8')}" target="_blank" rel="nofollow">{htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8')}</a> {$lang['tpure']['searchnullcon']}</div>
							{/if}
						</div>
						{if $pagebar && $pagebar.PageAll > 1}
						<div class="pagebar">
							{template:pagebar}
						</div>
						{/if}
					</div>
					<div class="sidebar{if $zbp->Config('tpure')->PostFIXMENUON=='1'} fixed{/if}{if tpure_isMobile() && $zbp->Config('tpure')->PostSIDEMOBILEON=='1'} show{/if}">
						{template:sidebar5}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{template:footer}
</body>
</html>