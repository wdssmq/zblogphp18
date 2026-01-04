<?php exit; ?>

<style>
    .ac-color-span {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #ccc;
        margin-left: 10px;
        vertical-align: middle;
    }
</style>

<form action="{php}<?php echo BuildSafeURL('main.php?act=save'); ?>{/php}" method="post">
    <table width="100%" class="tableBorder table_striped">
        <tr>
            <th width="10%">项目</th>
            <th>内容</th>
            <th width="45%">说明</th>
        </tr>
        <tr>
            <td>标准色</td>
            <td>{php}<?php zbpform::text('NormalColor', $cfg_colors->NormalColor, '90%'); ?>{/php} <span class="ac-color-span" style="background-color: {$cfg_colors->NormalColor};"></span></td>
            <td></td>
        </tr>
        <tr>
            <td>深色</td>
            <td>{php}<?php zbpform::text('BoldColor', $cfg_colors->BoldColor, '90%'); ?>{/php} <span class="ac-color-span" style="background-color: {$cfg_colors->BoldColor};"></span></td>
            <td></td>
        </tr>
        <tr>
            <td>浅色</td>
            <td>{php}<?php zbpform::text('LightColor', $cfg_colors->LightColor, '90%'); ?>{/php} <span class="ac-color-span" style="background-color: {$cfg_colors->LightColor};"></span></td>
            <td></td>
        </tr>
        <tr>
            <td>高光色</td>
            <td>{php}<?php zbpform::text('HighColor', $cfg_colors->HighColor, '90%'); ?>{/php} <span class="ac-color-span" style="background-color: {$cfg_colors->HighColor};"></span></td>
            <td></td>
        </tr>
        <tr>
            <td>反色</td>
            <td>{php}<?php zbpform::text('AntiColor', $cfg_colors->AntiColor, '90%'); ?>{/php} <span class="ac-color-span" style="background-color: {$cfg_colors->AntiColor};"></span></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><input type="submit" value="提交" /></td>
        </tr>
    </table>
</form>
