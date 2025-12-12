{* Template Name:列表页贴纸模板 * Template Type:list,author *}
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
				<div class="sitemap">{$lang['tpure']['sitemap']}<a href="{$host}">{$zbp->Config('tpure')->PostSITEMAPTXT ? $zbp->Config('tpure')->PostSITEMAPTXT : $lang['tpure']['index']}</a>
	{if $type=='category'}
	{tpure_navcate($category.ID)}
	{else}
	> {$title}
	{/if}
				</div>
				{/if}
				<div{if $zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'} id="sticky"{/if}>
					<div class="content listcon">
						{if $type == 'author'}
						<div class="block">
							<div class="auth">
								<div class="authimg">
									<img src="{tpure_MemberAvatar($author)}" alt="{$author.StaticName}">
									<em class="sex{if $author.Metas.membersex == '2'} female{else} male{/if}"></em>
								</div>
								<div class="authinfo">
									<h1>{$author.StaticName} {if $type == 'author'}<span class="level">{if $author.Level == '1'}{$lang['tpure']['user_level_name']['1']}{elseif $author.Level == '2'}{$lang['tpure']['user_level_name']['2']}{elseif $author.Level == '3'}{$lang['tpure']['user_level_name']['3']}{elseif $author.Level == '4'}{$lang['tpure']['user_level_name']['4']}{elseif $author.Level == '5'}{$lang['tpure']['user_level_name']['5']}{else}{$lang['tpure']['user_level_name']['6']}{/if}</span>{/if}</h1>
									<p{if $author.Intro} title="{$author.Intro}"{/if}>{$author.Intro ? $author.Intro : $lang['tpure']['intronull']}</p>
									<span class="cate"> {$author.Articles} {$lang['tpure']['articles']}</span>
									<span class="cmt"> {$author.Comments} {$lang['tpure']['comments']}</span>
								</div>
							</div>
						</div>
						{/if}
						<div class="block custom{if $zbp->Config('tpure')->PostBIGPOSTIMGON=='1'} large{/if} sticker">
							{if $type=='category'}
							<div class="listtitle">
								<h1>{$category.Name}</h1>
								{if $zbp->Config('tpure')->PostFILTERON == '1'}
								<form id="filternav">
									<ul class="filter">
										<li{if GetVars('order','GET') == 'newlist' || !GetVars('order','GET')} class="active"{/if} data-type="newlist">
											{$lang['tpure']['newfilter']}<i class="{if GetVars('sort','GET')}up{else}down{/if}"></i>
										</li>
										<li{if GetVars('order','GET') == 'viewlist'} class="active"{/if} data-type="viewlist">
											{$lang['tpure']['viewfilter']}<i class="{if GetVars('sort','GET')}up{else}down{/if}"></i>
										</li>
										<li{if GetVars('order','GET') == 'cmtlist'} class="active"{/if} data-type="cmtlist">
											{$lang['tpure']['cmtfilter']}<i class="{if GetVars('sort','GET')}up{else}down{/if}"></i>
										</li>
									</ul>
									{if $zbp->Config('system')->ZC_STATIC_MODE != 'REWRITE'}<input type="hidden" name="cate" value="{$category->ID}">{/if}
									<input type="hidden" name="order" value="{GetVars('order','GET')}">
									<input type="hidden" name="sort" value="{php}echo (int)GetVars('sort','GET'){/php}">
								</form>
								{/if}
								{if $type=='category' && $page == '1' && $category.Intro}
									<div class="listintro"><div class="listintrocon">{$category.Intro}</div></div>
								{elseif $type=='tag' && $page == '1' && $tag.Intro}
									<div class="listintro"><div class="listintrocon">{$tag.Intro}</div></div>
								{/if}
							</div>
		<script>
			!function(f){
		var a=f.find('li'),o=f.find('[name=order]'),s=f.find('[name=sort]');
		a.click(function(){
			var v=$(this).data('type');
			if(v===o.val()){
			s.val(s.val().toString()==='1'?0:1);
			}else{
			s.val(''===o.val() && !$(this).index() ? 1 : 0);
			o.val(v);
			}
			f.submit();
			return false;
		})
		}($('#filternav'));
		</script>
							{/if}
							{foreach $articles as $article}
								{if $article.IsTop}
								{template:post-istop}
								{else}
								{template:post-multi}
								{/if}
							{/foreach}
							{if count($articles) == 0}<div class="block"><div class="searchnull">{$lang['tpure']['searchnulltip']}{$lang['tpure']['searchnullcon']}</div></div>{/if}
						</div>
						{if $pagebar && $pagebar.PageAll > 1}
						<div class="pagebar">
							{template:pagebar}
						</div>
						{/if}
					</div>
					<div class="sidebar{if $zbp->Config('tpure')->PostFIXMENUON=='1'} fixed{/if}{if tpure_isMobile() && $zbp->Config('tpure')->PostSIDEMOBILEON=='1'} show{/if}">
						{if $type == 'author'}
						{template:sidebar8}
						{else}
						{template:sidebar2}
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{template:footer}
</body>
</html>