<div class="cmtsreply">
	<div class="cmtsreplyname">{if $comment.Author.HomePage}<a href="{$comment.Author.HomePage}" rel="nofollow" target="_blank">{$comment.Author.StaticName}</a>{else}{$comment.Author.StaticName}{/if}{if $zbp->Config('tpure')->PostCMTIPON == '1' && tpure_ipLocation($comment.IP)} <em>IP:{tpure_ipLocation($comment.IP)}</em>{/if} {$lang['tpure']['replytxt']}</div>
	<div class="cmtsreplycon">{$comment.Content}</div>
	{if $zbp->Config('tpure')->PostCMTTIMEON}<div class="cmtsreplydate">{tpure_TimeAgo($comment->Time(),$zbp->Config('tpure')->PostTIMESTYLE)}</div>{/if}
</div>
{foreach $comment.Comments as $comment}
	{template:commentreply}
{/foreach}