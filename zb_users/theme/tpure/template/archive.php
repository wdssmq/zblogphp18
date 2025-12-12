{* Template Name:文章归档模板 * Template Type:page *}
<!DOCTYPE html>
<html xml:lang="{$lang['lang_bcp47']}" lang="{$lang['lang_bcp47']}">
<head>
{template:header}
</head>
<body class="{$type}{if GetVars('night','COOKIE') } night{/if}">
<div class="wrapper">
	{template:navbar}
	<div class="main{if $zbp->Config('tpure')->PostFIXMENUON == '1'} fixed{/if}">
		{template:schbanner}
		<div class="maincon">
			<div class="wrap">
				{if tpure_isMobile() ? $zbp->Config('tpure')->PostSITEMAPMON == '1' : $zbp->Config('tpure')->PostSITEMAPON == '1'}
				<div class="sitemap">{$lang['tpure']['sitemap']}<a href="{$host}">{$zbp->Config('tpure')->PostSITEMAPTXT ? $zbp->Config('tpure')->PostSITEMAPTXT : $lang['tpure']['index']}</a> &gt;
					{if $type == 'article'}{if is_object($article.Category) && $article.Category.ParentID}<a href="{$article.Category.Parent.Url}">{$article.Category.Parent.Name}</a> &gt;{/if} <a href="{$article.Category.Url}">{$article.Category.Name}</a> &gt; {/if}{$article.Title}
				</div>
				{/if}
				<div{if $zbp->Config('tpure')->PostFIXSIDEBARSTYLE == '0'} id="sticky"{/if}>
					<div class="content">
						<div class="block{if $zbp->Config('tpure')->PostARCHIVEFOLDON == '1'} fold{/if}">
							<div class="post">
								<h1>{$article.Title}</h1>
								<div class="single{if $type == 'page' && $zbp->Config('tpure')->PostVIEWALLPAGEON && tpure_viewall($article->Metas->viewall)} viewall{/if}">
									{if $zbp->Config('tpure')->PostARCHIVEINFOON == '1'}<div class="listintro"><div class="listintrocon">{$lang['tpure']['bynow']}{tpure_TimeAgo(date('Y-m-d',time()),4)}，{$lang['tpure']['postall']}{$zbp->cache->all_article_nums}{$lang['tpure']['articles']}。<a href="javascript:;" data-foldtext="{$lang['tpure']['foldoff']}" class="archivefold{if $zbp->Config('tpure')->PostARCHIVEFOLDON == '1'} on{/if}">{$lang['tpure']['foldon']}</a></div></div>{/if}
									{tpure_GetArchives()}
								</div>
							</div>
						</div>
					</div>
					<div class="sidebar{if $zbp->Config('tpure')->PostFIXMENUON == '1'} fixed{/if}{if tpure_isMobile() && $zbp->Config('tpure')->PostSIDEMOBILEON=='1'} show{/if}">
						{template:sidebar7}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{template:footer}
</body>
</html>