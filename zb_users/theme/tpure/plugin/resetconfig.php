<?php
require '../../../../zb_system/function/c_system_base.php';
$zbp->Load();
$action = 'root';

///////////////////////////////////
$appid='tpure';
///////////////////////////////////

if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin($appid)) {$zbp->ShowError(48);die();}

tpure_Config();
$zbp->SaveConfig('tpure');
tpure_DelModule();
tpure_CreateModule();
$zbp->SetHint('good',$zbp->lang['tpure']['reset_settings']);
Redirect('../main.php?act=config');