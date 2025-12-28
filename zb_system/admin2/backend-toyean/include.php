<?php

//自定义函数

function backend_toyean_MakeTopMenu($requireAction, $strName, $strUrl, $strTarget, $strLiId, $strIconClass = "")
{
    global $zbp;

    static $AdminTopMenuCount = 0;
    if ($zbp->CheckRights($requireAction) == false) {
        return '';
    }

    $tmp = null;
    if ($strTarget == "") {
        $strTarget = "_self";
    }
    $AdminTopMenuCount = ($AdminTopMenuCount + 1);
    if ($strLiId == "") {
        $strLiId = "topmenu" . $AdminTopMenuCount;
    }
    $strIconElem = $strIconClass !== "" ? "<i class=\"" . $strIconClass . "\"></i><span>" : "<span>";
    $tmp = "<li id=\"" . $strLiId . "\"><a href=\"" . $strUrl . "\" target=\"" . $strTarget . "\" title=\"" . htmlspecialchars($strName) . "\">" . $strIconElem . $strName . "</span></a></li>";

    return $tmp;
}

//覆盖ResponseAdmin_TopMenu
function ResponseAdmin_TopMenu()
{
    global $zbp;
    global $topmenus;

    //$topmenus[] = MakeTopMenu("admin", $zbp->lang['msg']['dashboard'], $zbp->cmdurl . "?act=admin", "", "", "icon-house-door-fill");
    $topmenus[] = MakeTopMenu("SettingMng", @$zbp->lang['msg']['web_settings'], $zbp->cmdurl . "?act=SettingMng", "", "", "icon-gear-fill");

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_TopMenu'] as $fpname => &$fpsignal) {
        $fpname($topmenus);
    }

    $topmenus[] = '<li><a href="" class="rebuild">清空缓存、重建编译</a></li>';

    foreach ($topmenus as $m) {
        echo $m;
    }
}



function backend_toyean_MakeLeftMenu($requireAction, $strName, $strUrl, $strLiId, $strAId, $strImgUrl, $strIconClass = "")
{
    global $zbp;

    static $AdminLeftMenuCount = 0;
    if ($zbp->CheckRights($requireAction) == false) {
        return '';
    }

    $AdminLeftMenuCount = ($AdminLeftMenuCount + 1);
    $tmp = null;

    if ($strIconClass != "") {
        $tmp = "<dd id=\"" . $strLiId . "\"><a id=\"" . $strAId . "\" href=\"" . $strUrl . "\" title=\"" . strip_tags($strName) . "\"><span><i class=\"" . $strIconClass . "\"></i>" . $strName . "</span></a></dd>";
    } elseif ($strImgUrl != "") {
        $tmp = "<dd id=\"" . $strLiId . "\"><a id=\"" . $strAId . "\" href=\"" . $strUrl . "\" title=\"" . strip_tags($strName) . "\"><span class=\"bgicon\" style=\"background-image:url('" . $strImgUrl . "')\">" . $strName . "</span></a></dd>";
    } else {
        $tmp = "<dd id=\"" . $strLiId . "\"><a id=\"" . $strAId . "\" href=\"" . $strUrl . "\" title=\"" . strip_tags($strName) . "\"><span><i class=\"icon-window-fill\"></i>" . $strName . "</span></a></dd>";
    }

    return $tmp;
}


//覆盖ResponseAdmin_LeftMenu
function ResponseAdmin_LeftMenu()
{
    global $zbp;
    global $leftmenus;

    $leftmenus[] = '<dt>概览</dt>';

//<dd><a href="index.html" class="on" data-title="仪表盘"><i class="ico ico-home"></i>仪表盘</a></dd>

    $leftmenus['nav_new'] = backend_toyean_MakeLeftMenu("ArticleEdt", $zbp->lang['msg']['new_article'], $zbp->cmdurl . "?act=ArticleEdt", "nav_new", "aArticleEdt", "", "icon-pencil-square-fill");

    $leftmenus[] = '<dt>内容管理</dt>';

    $leftmenus['nav_new'] = backend_toyean_MakeLeftMenu("ArticleEdt", $zbp->lang['msg']['new_article'], $zbp->cmdurl . "?act=ArticleEdt", "nav_new", "aArticleEdt", "", "icon-pencil-square-fill");
    $leftmenus['nav_article'] = backend_toyean_MakeLeftMenu("ArticleMng", $zbp->lang['msg']['article_manage'], $zbp->cmdurl . "?act=ArticleMng", "nav_article", "aArticleMng", "", "icon-stickies");
    $leftmenus['nav_page'] = backend_toyean_MakeLeftMenu("PageMng", $zbp->lang['msg']['page_manage'], $zbp->cmdurl . "?act=PageMng", "nav_page", "aPageMng", "", "icon-stickies-fill");

    //$leftmenus[] = "<li class='split'><hr/></li>";



    $leftmenus['nav_category'] = backend_toyean_MakeLeftMenu("CategoryMng", $zbp->lang['msg']['category_manage'], $zbp->cmdurl . "?act=CategoryMng", "nav_category", "aCategoryMng", "", "icon-folder-fill");
    $leftmenus['nav_tags'] = backend_toyean_MakeLeftMenu("TagMng", $zbp->lang['msg']['tag_manage'], $zbp->cmdurl . "?act=TagMng", "nav_tags", "aTagMng", "", "icon-tags-fill");
    $leftmenus['nav_comment1'] = backend_toyean_MakeLeftMenu("CommentMng", $zbp->lang['msg']['comment_manage'], $zbp->cmdurl . "?act=CommentMng", "nav_comment", "aCommentMng", "", "icon-chat-text-fill");
    $leftmenus['nav_upload'] = backend_toyean_MakeLeftMenu("UploadMng", $zbp->lang['msg']['upload_manage'], $zbp->cmdurl . "?act=UploadMng", "nav_upload", "aUploadMng", "", "icon-inboxes-fill");

    $leftmenus[] = '<dt>系统管理</dt>';

    $leftmenus['nav_member'] = backend_toyean_MakeLeftMenu("MemberMng", $zbp->lang['msg']['member_manage'], $zbp->cmdurl . "?act=MemberMng", "nav_member", "aMemberMng", "", "icon-people-fill");

    //$leftmenus[] = "<li class='split'><hr/></li>";

    $leftmenus['nav_theme'] = backend_toyean_MakeLeftMenu("ThemeMng", $zbp->lang['msg']['theme_manage'], $zbp->cmdurl . "?act=ThemeMng", "nav_theme", "aThemeMng", "", "icon-grid-1x2-fill");
    $leftmenus['nav_module'] = backend_toyean_MakeLeftMenu("ModuleMng", $zbp->lang['msg']['module_manage'], $zbp->cmdurl . "?act=ModuleMng", "nav_module", "aModuleMng", "", "icon-grid-3x3-gap-fill");
    $leftmenus['nav_plugin'] = backend_toyean_MakeLeftMenu("PluginMng", $zbp->lang['msg']['plugin_manage'], $zbp->cmdurl . "?act=PluginMng", "nav_plugin", "aPluginMng", "", "icon-puzzle-fill");
    $leftmenus[] = '<dt>其它</dt>';

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_LeftMenu'] as $fpname => &$fpsignal) {
        $fpname($leftmenus);
    }

    foreach ($leftmenus as $m) {
        $m = str_replace('<li', '<dd', $m);
        $m = str_replace('</li>', '</dd>', $m);
        echo $m;
    }
}