{* Template Name:标签云无侧栏模板 * Template Type:page *}
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
				<div class="sitemap">{$lang['tpure']['sitemap']}<a href="{$host}">{$zbp->Config('tpure')->PostSITEMAPTXT ? $zbp->Config('tpure')->PostSITEMAPTXT : $lang['tpure']['index']}</a> &gt;
					{if $type=='article'}{if is_object($article.Category) && $article.Category.ParentID}<a href="{$article.Category.Parent.Url}">{$article.Category.Parent.Name}</a> &gt; {/if} <a href="{$article.Category.Url}">{$article.Category.Name}</a>{if $zbp->Config('tpure')->PostSITEMAPSTYLE == '1'} &gt; {$lang['tpure']['text']}{elseif $zbp->Config('tpure')->PostSITEMAPSTYLE == '2'} &gt; {$article.Title}{/if}{elseif $type=='page'} &gt; {$article.Title}{/if}
				</div>
				{/if}
				<div{if $zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'} id="sticky"{/if}>
					<div class="content wide">
						<div class="block">
							<div class="post">
								<h1>{$article.Title}</h1>
								<div class="single{if $type == 'page' && $zbp->Config('tpure')->PostVIEWALLPAGEON && tpure_viewall($article->Metas->viewall)} viewall{/if}">
									{tpure_GetTagCloudList()}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{template:footer}
</body>
</html>