{* Template Name:文章页单页 *}
{template:header}
<div class="container layout-grid">
    <main class="site-main">
        {if $article.Type==ZC_POST_TYPE_ARTICLE}
            {template:post-single}
        {else}
            {template:post-page}
        {/if}
    </main>
    <aside class="sidebar">
        {template:sidebar}
    </aside>
</div>
{template:footer}