{* Template Name:瀑布流列表单条置顶文章 *}
{if $page != '1' && $zbp->Config('tpure')->PostISTOPINDEXON == '1'}
{else}
<div class="item waterfall-item">
	{if $zbp->Config('tpure')->PostIMGON && tpure_Thumb($article,1)}
	<div class="waterfallimg{if $article->Metas->video} v{/if}">
		<a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{if $type != 'category'}<span>{$article.Category.Name}</span>{/if}<img src="{tpure_Thumb($article,1)}" alt="{$article.Title}"><em class="istop">{$lang['tpure']['istop']}</em></a>
	</div>
	{/if}
	<div class="waterfallcon">
		<span>{$article.Title}</span>
	</div>
	<div class="waterfallinfo"><span class="infouser"><a href="{$article.Author.Url}" target="_blank"><img src="{tpure_MemberAvatar($article.Author)}" alt="{$article.Author.StaticName}">{$article.Author.StaticName}</a></span><span class="infoviews">{tpure_Myriabit($article.ViewNums)}</span></div>
</div>
{/if}