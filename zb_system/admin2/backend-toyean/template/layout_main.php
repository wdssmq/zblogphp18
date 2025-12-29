<?php die(); ?>
      <div class="content">
        <div class="title">
          <h2>{$main->Header} <ul id="topmenu">{if $main.Action=='admin'}{ResponseAdmin_TopMenu()}{/if}{$main->SubMenu}</ul></h2>
          <p>欢迎回来，{$zbp->user->LevelName}！这里是您网站的概览信息</p>
        </div>
{php}$zbp->GetHint();{/php}
{php}HookFilterPlugin('Filter_Plugin_Admin_Hint');{/php}
        {$main.Content}
  </div>
