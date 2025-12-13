<div class="content">
	<div data-cateurl="{if $type=='article' && is_object($article.Category)}{if $article.Category.ParentID}{$article.Category.Parent.Url}{else}{$article.Category.Url}{/if}{/if}" class="block">
		<div class="post">
			<h1>{$article.Title}</h1>
			<div class="info">
				{php}
				$post_info = array(
					'user' => '<a href="'.$article->Author->Url.'" rel="nofollow">'.$article->Author->StaticName.'</a>',
					'date' => tpure_TimeAgo($article->Time(),$zbp->Config('tpure')->PostTIMESTYLE),
					'cate' => '<a href="'.$article->Category->Url.'">'.$article->Category->Name.'</a>',
					'view' => tpure_Myriabit((int) $article->ViewNums,2),
					'cmt' => $article->CommNums,
					'edit' => '<a href="'.$host.'zb_system/cmd.php?act=ArticleEdt&id='.$article->ID.'" target="_blank">'.$lang['tpure']['edit'].'</a>',
					'del' => '<a href="'.$host.'zb_system/cmd.php?act=ArticleDel&id='.$article->ID.'&csrfToken='.$zbp->GetToken().'" data-confirm="'.$lang['tpure']['delconfirm'].'">'.$lang['tpure']['del'].'</a>',
				);
				$article_info = json_decode($zbp->Config('tpure')->PostARTICLEINFO,true);
				if(count((array)$article_info)){
					foreach($article_info as $key => $info){
						if($info == '1'){
							if($user->Level == '1'){
								echo '<span class="'.$key.'">'.$post_info[$key].'</span>';
							}else{
								if($key == 'edit' || $key == 'del'){
									echo '';
								}else{
									echo '<span class="'.$key.'">'.$post_info[$key].'</span>';
								}
							}
						}
					}
				}else{
					echo '<span class="user"><a href="'.$article->Author->Url.'" rel="nofollow">'.$article->Author->StaticName.'</a></span>
					<span class="date">'.tpure_TimeAgo($article->Time(),$zbp->Config('tpure')->PostTIMESTYLE).'</span>
					<span class="view">'.tpure_Myriabit((int) $article->ViewNums,2).'</span>';
				}
				{/php}
				{if $zbp->Config('tpure')->PostTFONTSIZEON == '1'}
				<div class="ctrl"><a href="javascript:;" title="{$lang['tpure']['bigfont']}"></a><a href="javascript:;" title="{$lang['tpure']['smallfont']}"></a><a href="javascript:;" title="{$lang['tpure']['refont']}" class="hide"></a></div>
				{/if}
			</div>
			<div class="single{if $type == 'article' && $zbp->Config('tpure')->PostVIEWALLSINGLEON && tpure_viewall($article->Metas->viewall)} viewall{/if}{if $zbp->Config('tpure')->PostINDENTON == '1'} indent{/if}{if $zbp->Config('tpure')->PostTIMGBOXON == '1'} timgbox{/if}">
				{if $zbp->Config('tpure')->PostBLOCKQUOTEON == '1'}
				<blockquote class="abstract">
					<span>{$zbp->Config('tpure')->PostBLOCKQUOTELABEL}</span>{tpure_GetIntro($article)}
				</blockquote>
				{/if}
				{php}
					if(isset($zbaudio)){echo $zbaudio;}
					if(isset($zbvideo)){echo $zbvideo;}
				{/php}
				{$article.Content}
				</div>
				{if ($zbp->Config('tpure')->PostCOPYNOTICEON && !tpure_isMobile()) || ($zbp->Config('tpure')->PostCOPYNOTICEON && $zbp->Config('tpure')->PostCOPYNOTICEMOBILEON == '0' && tpure_isMobile())}
				<div class="copynotice">
					{if $zbp->Config('tpure')->PostQRON == '1'}<div data-qrurl="{$article.Url}" class="tpureqr"></div>{/if}
					<div class="copynoticetxt">
					{$zbp->Config('tpure')->PostCOPYNOTICE}
					{if $zbp->Config('tpure')->PostCOPYURLON == '1'}<p>{$lang['tpure']['copynoticetip']}<a href="{$article.Url}">{$article.Url}</a></p>{/if}
					</div>
				</div>
				{/if}
				{if count($article.Tags)>0 && $zbp->Config('tpure')->PostTAGSON == '1'}
				<div class="tags">
					{$lang['tpure']['tags']}
					{foreach $article.Tags as $tag}<a href='{$tag.Url}' title='{$tag.Name}'>{$tag.Name}</a>{/foreach}
				</div>
				{/if}
{if $type == 'article' && $zbp->Config('tpure')->PostSHAREARTICLEON == '1'}
		<div class="sharebox">
			<div class="label">{$lang['tpure']['sharelabel']}：</div>
			<div class="sharebtn">
				<div data-sites="{tpure_share()}" class="sharing"></div>
			</div>
		</div>
{/if}
		</div>
{if $type == 'article' && $zbp->Config('tpure')->PostPREVNEXTTYPE == '1'}
		<div class="pages">
			<a href="{$article.Category.Url}" class="backlist">{$lang['tpure']['backlist']}</a>
			<p>{if $article.Prev}{$lang['tpure']['prev']}<a href="{$article.Prev.Url}" class="single-prev">{$article.Prev.Title}</a>{else}<span>{$lang['tpure']['noprev']}</span>{/if}</p>
			<p>{if $article.Next}{$lang['tpure']['next']}<a href="{$article.Next.Url}" class="single-next">{$article.Next.Title}</a>{else}<span>{$lang['tpure']['nonext']}</span>{/if}</p>
		</div>
{elseif $type == 'article' && $zbp->Config('tpure')->PostPREVNEXTTYPE == '2' && $article.Prev}
	<div class="pages">
		<p>{if $article.Prev}{$lang['tpure']['prev']}<a href="{$article.Prev.Url}" class="single-prev">{$article.Prev.Title}</a>{else}<span>{$lang['tpure']['noprev']}</span>{/if}</p>
	</div>
{/if}
	</div>
{template:mutuality}
{if $type == 'article' && $zbp->Config('tpure')->PostPREVNEXTTYPE == '2' && $article.Next}
<div class="block">
		<div class="post singlenext">
			{if $article.Prev}<a href="{$article.Prev.Url}" class="single-prev"></a>{/if}
			<span class="label">{$lang['tpure']['read_next']}</span>
			<h3><a href="{$article.Next.Url}" class="single-next">{$article.Next.Title}</a></h3>
			<div class="info">
				{php}
				$post_info = array(
					'user' => '<a href="'.$article->Next->Author->Url.'" rel="nofollow">'.$article->Next->Author->StaticName.'</a>',
					'date' => tpure_TimeAgo($article->Next->Time(),$zbp->Config('tpure')->PostTIMESTYLE),
					'cate' => '<a href="'.$article->Next->Category->Url.'">'.$article->Next->Category->Name.'</a>',
					'view' => $article->Next->ViewNums >= 10000 ? round($article->Next->ViewNums / 10000,2).$lang['tpure']['viewunit']:$article->Next->ViewNums,
					'cmt' => $article->Next->CommNums,
					'edit' => '<a href="'.$host.'zb_system/cmd.php?act=ArticleEdt&id='.$article->Next->ID.'" target="_blank">'.$lang['tpure']['edit'].'</a>',
					'del' => '<a href="'.$host.'zb_system/cmd.php?act=ArticleDel&id='.$article->Next->ID.'&csrfToken='.$zbp->GetToken().'" data-confirm="'.$lang['tpure']['delconfirm'].'">'.$lang['tpure']['del'].'</a>',
				);
				$article_info = json_decode($zbp->Config('tpure')->PostARTICLEINFO,true);
				if(count((array)$article_info)){
					foreach($article_info as $key => $info){
						if($info == '1'){
							if($user->Level == '1'){
								echo '<span class="'.$key.'">'.$post_info[$key].'</span>';
							}else{
								if($key == 'edit' || $key == 'del'){
									echo '';
								}else{
									echo '<span class="'.$key.'">'.$post_info[$key].'</span>';
								}
							}
						}
					}
				}else{
					echo '<span class="user"><a href="'.$article->Next->Author->Url.'" rel="nofollow">'.$article->Next->Author->StaticName.'</a></span>
					<span class="date">'.tpure_TimeAgo($article->Next->Time(),$zbp->Config('tpure')->PostTIMESTYLE).'</span>
					<span class="view">'.$article->Next->ViewNums.'</span>';
				}
				{/php}
			</div>
			<div class="content{if $zbp->Config('tpure')->PostINDENTON == '1'} indent{/if}">
				{tpure_SingleNextContentStr($article.Next.Content)}
				<p class="mask">
					<a href="{$article.Next.Url}">{$lang['tpure']['readall']}</a>
				</p>
			</div>
		</div>
</div>
{/if}

{if !$article.IsLock && $zbp->Config('tpure')->PostARTICLECMTON=='1'}
	{if $zbp->Config('tpure')->PostCMTLOGINON=='1'}
		{if $user.ID > 0}
			{template:comments}
		{/if}
	{else}
		{template:comments}
	{/if}
{/if}
</div>
<div class="sidebar{if $zbp->Config('tpure')->PostFIXMENUON == '1'} fixed{/if}{if tpure_isMobile() && $zbp->Config('tpure')->PostSIDEMOBILEON == '1'} show{/if}{if $zbp->Config('tpure')->PostSIDEMOBILEON == '1'} sidemobile{/if}">
	{template:sidebar3}
</div>