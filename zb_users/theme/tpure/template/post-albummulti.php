<div class="item">
	{if $zbp->Config('tpure')->PostIMGON}
	<div class="albumimg{if $article->Metas->video} v{/if}">
		<a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{if $type != 'category'}<span>{$article.Category.Name}</span>{/if}<img src="{if tpure_Thumb($article,1)}{tpure_Thumb($article,1)}{else}{$host}zb_users/theme/{$theme}/style/images/dot.jpg{/if}" alt="{$article.Title}"></a>
	</div>
	{/if}
	<div class="albumcon">
		<a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{$article.Title}</a>
		<p>{if $type == 'search'}{tpure_GetIntro($article, GetVars('q'))}{else}{tpure_GetIntro($article)}{/if}</p>
	</div>
	<div class="albuminfo"><span>{tpure_TimeAgo($article->Time(),$zbp->Config('tpure')->PostTIMESTYLE)}</span></div>
</div>