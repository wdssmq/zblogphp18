{* Template Name:页面页页面内容 *}
<article class="post-single">
	<h1 class="post-title">{$article.Title}</h1>
	<div class="post-body">{$article.Content}</div>
</article>

{if !$article.IsLock}
{template:comments}
{/if}