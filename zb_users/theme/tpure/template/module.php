<dl id="{$module.HtmlID}" class="sidebox{php}if(count($sidebar)>0){echo ' alone';}{/php}">
	{if (!$module.IsHideTitle)&&($module.Name)}<dt class="sidetitle">{$module.Name}</dt>{else}<dt></dt>{/if}
	<dd>
		{if $module.Type=='div'}
		<div>{$module.Content}</div>
		{/if}
		{if $module.Type=='ul'}
		<ul>{$module.Content}</ul>
		{/if}
	</dd>
</dl>