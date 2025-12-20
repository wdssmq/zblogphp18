{* Template Name:列表页普通文章 *}
<article class="post-card">
	<h2 class="post-title"><a href="{$article.Url}">{$article.Title}</a></h2>
    <div class="post-meta">
        <span class="date">{$article.Time('Y-m-d')}</span>
        <span class="author">{$article.Author.StaticName}</span>
        <span class="views">{$article.ViewNums} Views</span>
    </div>
	<div class="post-excerpt">{$article.Intro}</div>
    <a href="{$article.Url}" class="btn-readmore">Read More</a>
</article>