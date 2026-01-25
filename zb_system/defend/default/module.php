{* Template Name:单个模块 *}
<dl class="function" id="{$module.HtmlID}">
{if (!$module.IsHideTitle)&&($module.Name)}<dt class="function_t">{$module.Name}</dt>{else}<dt style="display:none;"></dt>{/if}
<dd class="function_c">

{if $module.Type=='div'}
<div>{$module.Content}</div>
{/if}

{if $module.Type=='ul'}
<ul>

{foreach $module.Links as $link}
<li><a href="{$link.href}">{$link.content}</a></li>
{/foreach}

</ul>
{/if}

</dd>
</dl>