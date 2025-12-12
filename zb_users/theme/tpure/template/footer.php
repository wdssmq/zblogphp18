{* Template Name:公共底部(勿选) *}
<div class="footer">
	<div class="fademask"></div>
	<div class="wrap">
		<h3>{$copyright}</h3>
		<h4>Powered By {$zblogphpabbrhtml}. Theme by <a href="https://www.toyean.com/" target="_blank" title="{$lang['tpure']['toyean']}">TOYEAN</a>.</h4>
		{$footer}
	</div>
</div>
<div class="edgebar">
{if $zbp->Config('tpure')->PostLANGON == '1' && $zbp->option['ZC_BLOG_LANGUAGEPACK'] != 'en'}
	<a href="javascript:$.translatePage();" target="_self" id="zh_language" data-title="{$lang['tpure']['admin']['convert']}" class="lang"></a>
	<script>var cookieDomain = "{$host}";</script>
	<script src="{$host}zb_users/theme/{$theme}/plugin/convert/zh_language.js"></script>
{/if}
{if $zbp->Config('tpure')->PostSETNIGHTON}
	<a href="javascript:;" target="_self" data-title="{$lang['tpure']['turn']}" class="setnight"></a>
{/if}
</div>
