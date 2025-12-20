{* Template Name:列表页普通文章 *}
<div class="post item">
	<h2><a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{if $zbp->Config('tpure')->PostMEDIAICONSTYLE == '0'}{if $article.Metas.audio}<span class="zbaudioicon"></span>{/if}{if $article.Metas.video}<span class="video"></span>{/if}{/if}{$article.Title}{if $zbp->Config('tpure')->PostMEDIAICONSTYLE == '1'}{if $article.Metas.audio}<span class="zbaudioicon"></span>{/if}{if $article.Metas.video}<span class="video"></span>{/if}{/if}</a></h2>
	<div class="info">
		{php}
		$post_info = array(
			'user'=>'<a href="'.$article->Author->Url.'" rel="nofollow">'.$article->Author->StaticName.'</a>',
			'date'=>tpure_TimeAgo($article->Time(),$zbp->Config('tpure')->PostTIMESTYLE),
			'cate'=>'<a href="'.$article->Category->Url.'">'.$article->Category->Name.'</a>',
			'view'=>tpure_Myriabit($article->ViewNums),
			'cmt'=>tpure_Myriabit($article->CommNums),
			'edit'=>'<a href="'.$host.'zb_system/cmd.php?act=ArticleEdt&id='.$article->ID.'" target="_blank">'.$lang['tpure']['edit'].'</a>',
			'del'=>'<a href="'.$host.'zb_system/cmd.php?act=ArticleDel&id='.$article->ID.'&csrfToken='.$zbp->GetToken().'" data-confirm="'.$lang['tpure']['delconfirm'].'">'.$lang['tpure']['del'].'</a>',
		);
		$list_info = json_decode($zbp->Config('tpure')->PostLISTINFO,true);
		if(count((array)$list_info)){
			foreach($list_info as $key => $info){
				if($info == '1'){
					if($user->Level == '1' && isset($post_info[$key])){
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
			<span class="view">'.tpure_Myriabit($article->ViewNums).'</span>';
		}
		{/php}
	</div>
	{if $article.Metas.audio && $zbp->Config('tpure')->PostAUDIOINTROON}<p><span data-audioid="{$article.ID}" class="zbaudio"><span class="zbaudio_img"></span><span class="zbaudio_info"><strong></strong><em class="zbaudio_singer"></em><span class="zbaudio_area"><span class="zbaudio_item"><span class="zbaudio_progress"><span class="zbaudio_now"><span class="zbaudio_bar"></span></span><span class="zbaudio_cache"></span></span><span class="zbaudio_time"><em class="zbaudio_current">00:00</em><em class="zbaudio_total"></em></span></span><span class="zbaudio_play"><em data-action="play" data-on="play" data-off="pause"></em></span></span></span></span></p><script>$(function(){$('[data-audioid="{$article.ID}"]').zbaudio({song: [{cover:"{$article.Metas.audioimg}", src:"{$article.Metas.audio}", title:"{htmlspecialchars($article.Metas.audiotitle, ENT_QUOTES)}", singer:"{$article.Metas.audiosinger}"}]});});</script>{else}
	{if tpure_Thumb($article) != ''}<div class="postimg{if $article->Metas->video} v{/if}"><a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}><img src="{tpure_Thumb($article)}" alt="{$article.Title}"></a></div>{/if}
	<div class="intro{if tpure_Thumb($article) != ''} isimg{/if}">
		{if tpure_isMobile()}<a href="{$article.Url}">{/if}{if $type == 'search'}{tpure_GetIntro($article, GetVars('q'))}{else}{tpure_GetIntro($article)}{/if}{if tpure_isMobile()}</a>{/if}
	</div>
	{if $zbp->Config('tpure')->PostMOREBTNON}<div class="readmore"><a href="{$article.Url}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{$lang['tpure']['viewmore']}</a></div>{/if}
	{/if}
</div>