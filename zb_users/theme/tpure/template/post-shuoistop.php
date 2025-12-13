{* Template Name:列表页说说文章 *}
{if $page != '1' && $zbp->Config('tpure')->PostISTOPINDEXON == '1'}
{else}
<div class="shuo item">
	<em class="istop">{$lang['tpure']['istop']}</em>
	<div class="shuotop">
		<div class="uimg">
			<a href="{$article.Author.Url}" target="_blank"><img src="{tpure_MemberAvatar($article.Author)}" alt="{$article.Author.StaticName}"></a>
		</div>
		<div class="uinfo">
			<a href="{$article.Author.Url}" target="_blank">{$article.Author.StaticName}</a>
			<p>{tpure_TimeAgo($article->Time(),$zbp->Config('tpure')->PostTIMESTYLE)}</p>
		</div>
	</div>
	<h2><a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{if $zbp->Config('tpure')->PostMEDIAICONSTYLE == '0'}{if $article.Metas.audio}<span class="zbaudio"></span>{/if}{if $article.Metas.video}<span class="video"></span>{/if}{/if}{$article.Title}{if $zbp->Config('tpure')->PostMEDIAICONSTYLE == '1'}{if $article.Metas.audio}<span class="zbaudio"></span>{/if}{if $article.Metas.video}<span class="video"></span>{/if}{/if}</a></h2>
	{if !$zbp->Config('tpure')->PostISTOPSIMPLEON}
	{$zbp->Config('tpure')->PostINTROSOURCE == '1' ? $introsource = $article->Content : $introsource = $article->Intro}
	<div class="intro">
		<a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{if $type == 'search'}{tpure_GetIntro($article, GetVars('q'))}{else}{tpure_GetIntro($article)}{/if}</a>
	</div>
	<div class="thumbs timgbox">
		{php}
			$allThumbs = tpure_Thumb($article, '0', true);
			if(count($allThumbs) <= 1) {
				$allThumbs = $allThumbs ? $allThumbs : [tpure_Thumb($article)];
			}
		{/php}

		{if !empty($allThumbs)}
			{foreach $allThumbs as $index => $thumb}
				{if $index >= 4}
					{php}break;{/php}
				{/if}
				<div class="thumbsbox">
					<span class="thumbsimg">
						<img src="{$thumb}" alt="">
						{if $index == 3 && count($allThumbs) > 4}
							<span class="extra">+{php}echo count($allThumbs)-4{/php}</span>
						{/if}
					</span>
				</div>
			{/foreach}
		{/if}
	</div>
	<div class="info">
		<div class="tags">
		{if count($article.Tags)>0 && $zbp->Config('tpure')->PostTAGSON == '1'}
			{foreach $article.Tags as $tag}<a href='{$tag.Url}' title='{$tag.Name}' class="tag">{$tag.Name}</a>{/foreach}
		{/if}
		</div>
		<span class="view">{php}echo (int) $article->ViewNums >= 10000 ? round($article->ViewNums/10000,2).$lang['tpure']['viewunit'] : $article->ViewNums;{/php}</span>
		<span class="cmt">{$article.CommNums}</span>
	</div>
	{/if}
</div>
{/if}