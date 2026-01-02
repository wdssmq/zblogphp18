<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin_function.php';
require '../../../zb_system/admin2/function/admin2_function.php';

$zbp->ismanage = true;
$zbp->Load();

$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
if (!$zbp->CheckPlugin('AdminColor_2026')) {
    $zbp->ShowError(48);
    die();
}

$blogtitle = '后台配色器_2026';
$content = $zbp->template_admin->Output("plugin_AdminColor_2026_Content");
$ActionInfo = (object) [
    'Title' => $blogtitle,
    'Header' => $blogtitle,
    'HeaderIcon' => 'icon-brush-fill',
    'SubMenu' => '',
    'ActiveTopMenu' => '',
    'ActiveLeftMenu' => '',
    'Action' => $zbp->action,
    'Content' => $content,
];

$zbp->template_admin->SetTags('title', $ActionInfo->Title);
$zbp->template_admin->SetTags('main', $ActionInfo);
$zbp->template_admin->Display('index');

RunTime();
