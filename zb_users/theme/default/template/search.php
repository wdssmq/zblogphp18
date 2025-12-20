{* Template Name:搜索页 *}
{template:header}
<div class="container layout-grid">
    <main class="site-main">
        <div class="post-card">
            <h2 class="post-title">{$article.Title}</h2>
        </div>
        {foreach $articles as $article}
            {template:post-search}
        {/foreach}
        {if count($articles)>0}
            <div class="pagebar">{template:pagebar}</div>
        {/if}
    </main>
    <aside class="sidebar">
        {template:sidebar}
    </aside>
</div>
{template:footer}