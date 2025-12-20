{* Template Name:文章页文章内容 *}
<article class="post-single">
	<h1 class="post-title">{$article.Title}</h1>
    <div class="post-meta">
        <span class="date">{$article.Time('Y-m-d')}</span>
        <span class="category">{$article.Category.Name}</span>
        <span class="views">{$article.ViewNums} Views</span>
    </div>
	<div class="post-body">{$article.Content}</div>
	<div class="post-tags">
        {foreach $article.Tags as $tag}
            <a href='{$tag.Url}' title='{$tag.Name}'>#{$tag.Name}</a>
        {/foreach}
	</div>
</article>

{if !$article.IsLock}
{template:comments}
{/if}