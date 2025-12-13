<?php die(); ?>{* Template Name:公共banner(勿选) * Template Type:none *}
{php}
$schbanner = $zbp->Config('tpure')->PostBANNER;
$banneron = $zbp->Config('tpure')->PostBANNERON;
$bannerallon = $zbp->Config('tpure')->PostBANNERALLON;
$bannerfont = $zbp->Config('tpure')->PostBANNERFONT;
$bannerformon = $zbp->Config('tpure')->PostBANNERSEARCHON;
$bannerformallon = $zbp->Config('tpure')->PostBANNERSEARCHALLON;
if($type == 'index'){
	$isbanner = $banneron;
	$banner = $schbanner;
	$bannerfont = $bannerfont;
	$bannerformon = $bannerformon;
}elseif($type == 'category'){
	$isbanner = $bannerallon;
	$banner = $category->Metas->schbanner ? $category->Metas->schbanner : $schbanner;
	$bannerfont = $category->Metas->schbannerfont ? $category->Metas->schbannerfont : $bannerfont;
	$bannerformon = $category->Metas->schbannerformon ? '1' : $bannerformallon;
}elseif($type == 'tag'){
	$isbanner = $bannerallon;
	$banner = $tag->Metas->schbanner ? $tag->Metas->schbanner : $schbanner;
	$bannerfont = $tag->Metas->schbannerfont ? $tag->Metas->schbannerfont : $bannerfont;
	$bannerformon = $tag->Metas->schbannerformon ? '1' : $bannerformallon;
}elseif($type == 'article' || $type == 'page'){
	$isbanner = $bannerallon;
	$banner = $article->Metas->schbanner ? $article->Metas->schbanner : $schbanner;
	$bannerfont = $article->Metas->schbannerfont ? $article->Metas->schbannerfont : $bannerfont;
	$bannerformon = $article->Metas->schbannerformon ? '1' : $bannerformallon;
}elseif($type == 'author'){
	$isbanner = $bannerallon;
	$banner = $author->Metas->schbanner ? $author->Metas->schbanner : $schbanner;
	$bannerfont = $author->Metas->schbannerfont ? $author->Metas->schbannerfont : $bannerfont;
	$bannerformon = $author->Metas->schbannerformon ? '1' : $bannerformallon;
}else{
	$isbanner = $bannerallon;
	$banner = $schbanner;
	$bannerformon = $bannerformallon;
}
{/php}
{if $isbanner}
	<div class="banner" data-type="display" data-speed="2" style="{if !tpure_isMobile()}height:{$zbp->Config('tpure')->PostBANNERPCHEIGHT}px;{else}height:{$zbp->Config('tpure')->PostBANNERMHEIGHT}px;{/if} background-image:url({$banner});">
		<div class="wrap">
			<div class="hellotip">
			{$bannerfont}
			{if $bannerformon == '1'}
				<div class="hellosch{if !$zbp->Config('tpure')->PostBANNERFONT} alone{/if}">
					<form name="search" method="post" action="{$host}zb_system/cmd.php?act=search">
						<input type="text" name="q" placeholder="{$zbp->Config('tpure')->PostSCHTXT}" class="helloschinput" autocomplete="off">
						<button type="submit" class="helloschbtn"></button>
					</form>
					<div class="schwords">
						<div class="schwordsinfo">
							{if $zbp->Config('tpure')->PostBANNERSEARCHLABEL}
								<h5>{$zbp->Config('tpure')->PostBANNERSEARCHLABEL}</h5>
							{/if}
							{$schwords = explode('|',$zbp->Config('tpure')->PostBANNERSEARCHWORDS)}
							{if is_array($schwords)}
								{foreach $schwords as $schval}
									<a href="{$host}search.php?q={$schval}"{if $zbp->Config('tpure')->PostBLANKSTYLE == 2} target="_blank"{/if}>{$schval}</a>
								{/foreach}
							{/if}
						</div>
						<div class="ajaxresult"></div>
					</div>
				</div>
			{/if}
			</div>
		</div>
	</div>
{/if}