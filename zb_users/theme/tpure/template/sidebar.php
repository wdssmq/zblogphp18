{* Template Name:侧栏模板 * Template Type:none *}
{php}if(count($sidebar) == 0){echo '<div class="none">';}{/php}
{foreach $sidebar as $module}
{template:module}
{/foreach}
{php}if(count($sidebar) == 0){echo '</div>';}{/php}