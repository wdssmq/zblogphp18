{* Template Name:搜索页文章列表 *}
<article class="post-card">
	<h2 class="post-title"><a href="{$article.Url}">{$article.Title}</a></h2>
    <div class="post-meta">
        <span class="date">{$article.Time('Y-m-d')}</span>
    </div>
	<div class="post-excerpt">{$article.Intro}</div>
</article>