{* Template Name:首页模板(勿选) * Template Type:index *}
<!DOCTYPE html>
<html xml:lang="{$lang['lang_bcp47']}" lang="{$lang['lang_bcp47']}">
<head>
{template:header}
</head>
<body class="{$type}{if GetVars('night','COOKIE')} night{/if}" data-lang="{$zbp->Config('system')->ZC_BLOG_LANGUAGEPACK}">
<div class="wrapper">
	{template:navbar}
	<div class="main{if $zbp->Config('tpure')->PostFIXMENUON == '1'} fixed{/if}">
	{if $type == 'index' && $page == '1' && $zbp->Config('tpure')->PostSLIDEON == '1' && $zbp->Config('tpure')->PostSLIDEPLACE != '0'}
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
				<div{if $zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'} id="sticky"{/if}>
					<div class="content listcon">
						{php}$slidedata = json_decode($zbp->Config('tpure')->PostSLIDEDATA,true);{/php}
						{if $type == 'index' && $page == '1' && $zbp->Config('tpure')->PostSLIDEON == '1' && $zbp->Config('tpure')->PostSLIDEPLACE == '0' && count((array)$slidedata)>0}
						<div class="slideblock">
						<div class="slide swiper-container{if $zbp->Config('tpure')->PostSLIDETITLEON == '1'} hastitle{/if}">
							<div class="swiper-wrapper">
								{if isset($slidedata)}
								{foreach $slidedata as $value}
									{if $value['isused']}
										<a href="{$value['url']}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if} class="swiper-slide" style="background-color:#{$value['color']};"><img src="{$value['img']}" alt="{$value['title']}"><span>{$value['title']}</span></a>
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
						</div>
						{/if}


						{php}$flids = explode(',',$zbp->Config('tpure')->PostCMS);{/php}
						{if $zbp->Config('tpure')->PostCMSON == '1'}
						<div class="cmsblock{if $zbp->Config('tpure')->PostCMSCOLUMN == '0'} alone{/if}">
						{foreach $flids as $flid}
						{if isset($categorys[$flid])}
							<div class="cmslist">
								<div class="cmstitle"><h4><a href="{$categorys[$flid].Url}" target="_blank" class="cmscate">{$categorys[$flid].Name}</a><a href="{$categorys[$flid].Url}" target="_blank" class="more">{$lang['tpure']['more']}</a></h4></div>
								<div class="cmscon">
									<ul>
									{if count(GetList($zbp->Config('tpure')->PostCMSLENGTH,$flid)) == '0'}
									<li class="cmstip">{$lang['tpure']['searchnulltip']}{$lang['tpure']['searchnullcon']}</li>
									{else}
									{foreach GetList($zbp->Config('tpure')->PostCMSLENGTH,$flid) as $key=>$article}
										{if $key==0}
											<li class="cmstop">
												{if tpure_Thumb($article,1)}<a href="{$article.Url}" target="_blank" class="cmsimg{if $article->Metas->video} v{/if}"><i><img src="{tpure_Thumb($article,1)}" alt="{$article.Title}"></i></a>{/if}
												<div class="cmsinfo">
													<div class="cmstoptitle"><a href="{$article.Url}" target="_blank" title="{$article.Title}">{$article.Title}</a></div>
													<div class="cmsintro">{tpure_GetIntro($article)}</div>
												</div>
												<div class="clear"></div>
											</li>
										{else}
											<li class="cmsitem"><div class="cmsposttitle"><a href="{$article.Url}" target="_blank" title="{$article.Title}">{$article.Title}</a></div><span class="cmsposttime">{tpure_TimeAgo($article.Time(),$zbp->Config('tpure')->PostTIMESTYLE)}</span></li>
										{/if}
									{/foreach}
									{/if}
									</ul>
								</div>
							</div>
						{/if}
						{/foreach}
						</div>
						{/if}
						{if $zbp->Config('tpure')->PostINDEXLISTON == '1' && count($articles) > 0}
						<div class="block custom{if $zbp->Config('tpure')->PostBIGPOSTIMGON == '1'} large{/if}{if $zbp->Config('tpure')->PostINDEXSTYLE == '1'} forum{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '2'} album{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '3'} sticker{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '4'} hotspot{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '5'} shuo{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '6'} waterfall{/if}">
							{if $zbp->Config('tpure')->PostINDEXSTYLE == '1'}
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-forumistop}
								{else}
								{template:post-forummulti}
								{/if}
							{/foreach}
							{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '2'}
							<div class="albumlist">
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-albumistop}
								{else}
								{template:post-albummulti}
								{/if}
							{/foreach}
							</div>
							{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '4'}
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-hotspotistop}
								{else}
								{template:post-hotspotmulti}
								{/if}
							{/foreach}
							{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '5'}
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-shuoistop}
								{else}
								{template:post-shuomulti}
								{/if}
							{/foreach}
							{elseif $zbp->Config('tpure')->PostINDEXSTYLE == '6'}
							<div id="waterfalllist" class="waterfalllist">
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-waterfallistop}
								{else}
								{template:post-waterfallmulti}
								{/if}
							{/foreach}
							</div>
							{else}
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-istop}
								{else}
								{template:post-multi}
								{/if}
							{/foreach}
							{/if}

						</div>
						{if $pagebar && $pagebar.PageAll > 1}
						<div class="pagebar">
							{template:pagebar}
						</div>
						{/if}
						{/if}

						{if $type == 'index' && $page == '1' && $zbp->Config('tpure')->PostFRIENDLINKON == '1' && !tpure_isMobile()}
							<div class="friendlink">
								<span>{$lang['tpure']['friendlink']}</span>
								<ul>{module:link}</ul>
							</div>
							{elseif tpure_isMobile() && $zbp->Config('tpure')->PostFRIENDLINKMON == '1'}
							<div class="friendlink">
								<span>{$lang['tpure']['friendlink']}</span>
								<ul>{module:link}</ul>
							</div>
						{/if}
					</div>
					<div class="sidebar{if $zbp->Config('tpure')->PostFIXMENUON == '1'} fixed{/if}{if tpure_isMobile() && $zbp->Config('tpure')->PostSIDEMOBILEON=='1'} show{/if}">
						{template:sidebar}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{template:footer}
</body>
</html>