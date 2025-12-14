<?php

function zbp_admin2_SiteInfo()
{
    global $zbp;
    $data = zbp_admin2_statistic_data();
    foreach ($data as $item => $content) {
        $zbp->template_admin->SetTags($item, $content);
    }

    $rlt = $zbp->template_admin->Output("SiteInfo");

    // thanks
    $s = file_get_contents($zbp->path . "zb_system/defend/thanks.html");
    $s = str_replace('Z-BlogPHP网站和程序开发', $zbp->lang['msg']['develop_intro'], $s);
    $s = str_replace('程序', $zbp->lang['msg']['program'], $s);
    $s = str_replace('界面', $zbp->lang['msg']['interface'], $s);
    $s = str_replace('支持', $zbp->lang['msg']['support'], $s);
    $s = str_replace('感谢', $zbp->lang['msg']['thanks'], $s);
    $s = str_replace('相关链接', $zbp->lang['msg']['website'], $s);

    $rlt .= $s;

    return $rlt;
}

function zbp_admin2_ArticleMng()
{
    global $zbp;

    $search = GetVars('search', '', '');
    $order_get = GetVars('order', 'GET');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=ArticleMng{&status=%status%}{&istop=%istop%}{&category=%category%}{&search=%search%}{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    if (GetVars('search') !== GetVars('search', 'GET')) {
        $p->PageNow = 1;
    }
    $p->PageBarCount = $zbp->pagebarcount;

    $p->UrlRule->Rules['{%category%}'] = GetVars('category');
    $p->UrlRule->Rules['{%search%}'] = rawurlencode($search);
    $p->UrlRule->Rules['{%status%}'] = GetVars('status');
    $p->UrlRule->Rules['{%istop%}'] = (bool) GetVars('istop');
    $p->UrlRule->Rules['{%order%}'] = $order_get;

    $w = [];
    $w[] = ['=', 'log_Type', 0];

    if (!$zbp->CheckRights('ArticleAll')) {
        $w[] = ['=', 'log_AuthorID', $zbp->user->ID];
    }
    if (GetVars('search')) {
        $w[] = ['search', 'log_Content', 'log_Intro', 'log_Title', $search];
    }
    if (GetVars('istop')) {
        $w[] = ['<>', 'log_Istop', '0'];
    }
    if (GetVars('status') !== null && GetVars('status') !== '') {
        $w[] = ['=', 'log_Status', (int) GetVars('status')];
    }
    if (GetVars('category')) {
        $w[] = ['=', 'log_CateID', GetVars('category')];
    }

    $s = '';

    if ($order_get === 'id_desc') {
        $or = ['log_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['log_ID' => 'ASC'];
    } elseif ($order_get === 'cateid_desc') {
        $or = ['log_CateID' => 'DESC'];
    } elseif ($order_get === 'cateid_asc') {
        $or = ['log_CateID' => 'ASC'];
    } elseif ($order_get === 'authorid_desc') {
        $or = ['log_AuthorID' => 'DESC'];
    } elseif ($order_get === 'authorid_asc') {
        $or = ['log_AuthorID' => 'ASC'];
    } elseif ($order_get === 'posttime_desc') {
        $or = ['log_PostTime' => 'DESC'];
    } elseif ($order_get === 'posttime_asc') {
        $or = ['log_PostTime' => 'ASC'];
    } elseif ($order_get === 'updatetime_desc') {
        $or = ['log_UpdateTime' => 'DESC'];
    } elseif ($order_get === 'updatetime_asc') {
        $or = ['log_UpdateTime' => 'ASC'];
    } else {
        $or = [$zbp->manageorder => 'DESC'];
    }
    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    $type = null;

    // 1.7 新加入的接口
    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_ArticleMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    foreach ($GLOBALS['hooks']['Filter_Plugin_LargeData_Article'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op, $type);
    }


    $articles = $zbp->GetPostList(
        $s,
        $w,
        $or,
        $l,
        $op,
    );

    // 上边查询会用总页数填充 page 字段
    $p->UrlRule->Rules['{%page%}'] = $p->PageNow;

    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_posttime_html) = MakeOrderButton('posttime', $p->UrlRule, $order_get);
    list($button_cateid_html) = MakeOrderButton('cateid', $p->UrlRule, $order_get);
    list($button_authorid_html) = MakeOrderButton('authorid', $p->UrlRule, $order_get);

    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_posttime_html', $button_posttime_html);
    $zbp->template_admin->SetTags('button_cateid_html', $button_cateid_html);
    $zbp->template_admin->SetTags('button_authorid_html', $button_authorid_html);

    $zbp->template_admin->SetTags('articles', $articles);
    $zbp->template_admin->SetTags('p', $p);
    $zbp->template_admin->SetTags('post_type', ZC_POST_TYPE_ARTICLE);

    $rlt = $zbp->template_admin->Output("ArticleMng");

    return $rlt;
}

function zbp_admin2_PageMng()
{
    global $zbp;

    $order_get = GetVars('order', 'GET');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=PageMng{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    $p->PageBarCount = $zbp->pagebarcount;
    $p->UrlRule->Rules['{%order%}'] = $order_get;

    $w = [];
    $w[] = ['=', 'log_Type', 1];

    if (!$zbp->CheckRights('PageAll')) {
        $w[] = ['=', 'log_AuthorID', $zbp->user->ID];
    }

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['log_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['log_ID' => 'ASC'];
    } elseif ($order_get === 'cateid_desc') {
        $or = ['log_CateID' => 'DESC'];
    } elseif ($order_get === 'cateid_asc') {
        $or = ['log_CateID' => 'ASC'];
    } elseif ($order_get === 'authorid_desc') {
        $or = ['log_AuthorID' => 'DESC'];
    } elseif ($order_get === 'authorid_asc') {
        $or = ['log_AuthorID' => 'ASC'];
    } elseif ($order_get === 'posttime_desc') {
        $or = ['log_PostTime' => 'DESC'];
    } elseif ($order_get === 'posttime_asc') {
        $or = ['log_PostTime' => 'ASC'];
    } else {
        $or = ['log_PostTime' => 'DESC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    // 1.7 新加入的接口
    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_PageMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    foreach ($GLOBALS['hooks']['Filter_Plugin_LargeData_Page'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $pages = $zbp->GetPostList(
        $s,
        $w,
        $or,
        $l,
        $op,
    );

    // 设置分页URL规则
    $p->UrlRule->Rules['{%page%}'] = $p->PageNow;

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_posttime_html) = MakeOrderButton('posttime', $p->UrlRule, $order_get);
    list($button_authorid_html) = MakeOrderButton('authorid', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_posttime_html', $button_posttime_html);
    $zbp->template_admin->SetTags('button_authorid_html', $button_authorid_html);

    $zbp->template_admin->SetTags('pages', $pages);
    $zbp->template_admin->SetTags('p', $p);
    $zbp->template_admin->SetTags('post_type', ZC_POST_TYPE_PAGE);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("PageMng");

    return $rlt;
}


function zbp_admin2_CategoryMng()
{
    global $zbp;

    $search = GetVars('search', '', '');
    $order_get = GetVars('order', 'GET');
    $posttype = (int) GetVars('type');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=CategoryMng{&type=%type%}{&search=%search%}{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    $p->PageBarCount = $zbp->pagebarcount;

    $p->UrlRule->Rules['{%search%}'] = rawurlencode($search);
    $p->UrlRule->Rules['{%type%}'] = $posttype;

    $w = [];
    $w[] = ['=', 'cate_Type', $posttype];

    if ($search) {
        $w[] = ['search', 'cate_Name', 'cate_Alias', 'cate_Intro', $search];
    }

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['cate_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['cate_ID' => 'ASC'];
    } elseif ($order_get === 'order_desc') {
        $or = ['cate_Order' => 'DESC'];
    } elseif ($order_get === 'order_asc') {
        $or = ['cate_Order' => 'ASC'];
    } elseif ($order_get === 'name_desc') {
        $or = ['cate_Name' => 'DESC'];
    } elseif ($order_get === 'name_asc') {
        $or = ['cate_Name' => 'ASC'];
    } else {
        $or = ['cate_ID' => 'ASC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_CategoryMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    if (!$zbp->option['ZC_CATEGORY_MANAGE_LEGACY_DISPLAY']) {
        $array = $zbp->GetCategoryList($s, $w, $or, $l, $op);
    } else {
        $array = $zbp->categoriesbyorder_type[$posttype];
    }

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_order_html) = MakeOrderButton('order', $p->UrlRule, $order_get);
    list($button_name_html) = MakeOrderButton('name', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_order_html', $button_order_html);
    $zbp->template_admin->SetTags('button_name_html', $button_name_html);
    $zbp->template_admin->SetTags('categories', $array);
    $zbp->template_admin->SetTags('p', $p);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("CategoryMng");

    return $rlt;
}

function zbp_admin2_TagMng()
{
    global $zbp;

    $search = GetVars('search', '', '');
    $order_get = GetVars('order', 'GET');
    $posttype = (int) GetVars('type');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=TagMng{&type=%type%}{&search=%search%}{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    $p->PageBarCount = $zbp->pagebarcount;

    $p->UrlRule->Rules['{%search%}'] = rawurlencode($search);
    $p->UrlRule->Rules['{%type%}'] = $posttype;

    $w = [];
    $w[] = ['=', 'tag_Type', $posttype];

    if ($search) {
        $w[] = ['search', 'tag_Name', 'tag_Alias', 'tag_Intro', $search];
    }

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['tag_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['tag_ID' => 'ASC'];
    } elseif ($order_get === 'order_desc') {
        $or = ['tag_Order' => 'DESC'];
    } elseif ($order_get === 'order_asc') {
        $or = ['tag_Order' => 'ASC'];
    } elseif ($order_get === 'name_desc') {
        $or = ['tag_Name' => 'DESC'];
    } elseif ($order_get === 'name_asc') {
        $or = ['tag_Name' => 'ASC'];
    } else {
        $or = ['tag_ID' => 'ASC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_TagMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $array = $zbp->GetTagList($s, $w, $or, $l, $op);

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_order_html) = MakeOrderButton('order', $p->UrlRule, $order_get);
    list($button_name_html) = MakeOrderButton('name', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_order_html', $button_order_html);
    $zbp->template_admin->SetTags('button_name_html', $button_name_html);
    $zbp->template_admin->SetTags('tags', $array);
    $zbp->template_admin->SetTags('p', $p);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("TagMng");

    return $rlt;
}

function zbp_admin2_CommentMng()
{
    global $zbp;

    $search = GetVars('search', '', '');
    $order_get = GetVars('order', 'GET');
    $ischecking = (bool) GetVars('ischecking');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=CommentMng{&ischecking=%ischecking%}{&search=%search%}{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    if (GetVars('search') !== GetVars('search', 'GET')) {
        $p->PageNow = 1;
    }
    $p->PageBarCount = $zbp->pagebarcount;

    $p->UrlRule->Rules['{%search%}'] = rawurlencode($search);
    $p->UrlRule->Rules['{%ischecking%}'] = (bool) GetVars('ischecking');
    $p->UrlRule->Rules['{%order%}'] = $order_get;

    $w = [];
    if (!$zbp->CheckRights('CommentAll')) {
        $w[] = ['=', 'comm_AuthorID', $zbp->user->ID];
    }
    if (GetVars('search')) {
        $w[] = ['search', 'comm_Content', 'comm_Name', GetVars('search')];
    }
    if (GetVars('id')) {
        $w[] = ['=', 'comm_ID', GetVars('id')];
    }

    $w[] = ['=', 'comm_Ischecking', (int) GetVars('ischecking')];

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['comm_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['comm_ID' => 'ASC'];
    } elseif ($order_get === 'posttime_desc') {
        $or = ['comm_PostTime' => 'DESC'];
    } elseif ($order_get === 'posttime_asc') {
        $or = ['comm_PostTime' => 'ASC'];
    } elseif ($order_get === 'logid_desc') {
        $or = ['comm_LogID' => 'DESC'];
    } elseif ($order_get === 'logid_asc') {
        $or = ['comm_LogID' => 'ASC'];
    } elseif ($order_get === 'authorid_desc') {
        $or = ['comm_AuthorID' => 'DESC'];
    } elseif ($order_get === 'authorid_asc') {
        $or = ['comm_AuthorID' => 'ASC'];
    } elseif ($order_get === 'parentid_desc') {
        $or = ['comm_ParentID' => 'DESC'];
    } elseif ($order_get === 'parentid_asc') {
        $or = ['comm_ParentID' => 'ASC'];
    } else {
        $or = ['comm_ID' => 'DESC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_CommentMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    foreach ($GLOBALS['hooks']['Filter_Plugin_LargeData_Comment'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $comments = $zbp->GetCommentList(
        $s,
        $w,
        $or,
        $l,
        $op,
    );

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get, 'desc');
    list($button_posttime_html) = MakeOrderButton('posttime', $p->UrlRule, $order_get);
    list($button_logid_html) = MakeOrderButton('logid', $p->UrlRule, $order_get);
    list($button_authorid_html) = MakeOrderButton('authorid', $p->UrlRule, $order_get);
    list($button_parentid_html) = MakeOrderButton('parentid', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_authorid_html', $button_authorid_html);
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_logid_html', $button_logid_html);
    $zbp->template_admin->SetTags('button_parentid_html', $button_parentid_html);
    $zbp->template_admin->SetTags('button_posttime_html', $button_posttime_html);
    $zbp->template_admin->SetTags('comments', $comments);
    $zbp->template_admin->SetTags('ischecking', $ischecking);
    $zbp->template_admin->SetTags('p', $p);


    // 渲染模板
    $rlt = $zbp->template_admin->Output("CommentMng");

    return $rlt;
}

function zbp_admin2_UploadMng()
{
    global $zbp;

    $w = [];
    if (!$zbp->CheckRights('UploadAll')) {
        $w[] = ['=', 'ul_AuthorID', $zbp->user->ID];
    }

    $order_get = GetVars('order', 'GET');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=UploadMng{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    $p->PageBarCount = $zbp->pagebarcount;

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['ul_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['ul_ID' => 'ASC'];
    } elseif ($order_get === 'size_desc') {
        $or = ['ul_Size' => 'DESC'];
    } elseif ($order_get === 'size_asc') {
        $or = ['ul_Size' => 'ASC'];
    } elseif ($order_get === 'authorid_desc') {
        $or = ['ul_AuthorID' => 'DESC'];
    } elseif ($order_get === 'authorid_asc') {
        $or = ['ul_AuthorID' => 'ASC'];
    } elseif ($order_get === 'logid_desc') {
        $or = ['ul_LogID' => 'DESC'];
    } elseif ($order_get === 'logid_asc') {
        $or = ['ul_LogID' => 'ASC'];
    } elseif ($order_get === 'posttime_desc') {
        $or = ['ul_PostTime' => 'DESC'];
    } elseif ($order_get === 'posttime_asc') {
        $or = ['ul_PostTime' => 'ASC'];
    } else {
        $or = ['ul_PostTime' => 'DESC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_UploadMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $array = $zbp->GetUploadList($s, $w, $or, $l, $op);

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_size_html) = MakeOrderButton('size', $p->UrlRule, $order_get);
    list($button_authorid_html) = MakeOrderButton('authorid', $p->UrlRule, $order_get);
    list($button_logid_html) = MakeOrderButton('logid', $p->UrlRule, $order_get);
    list($button_posttime_html) = MakeOrderButton('posttime', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_size_html', $button_size_html);
    $zbp->template_admin->SetTags('button_authorid_html', $button_authorid_html);
    $zbp->template_admin->SetTags('button_logid_html', $button_logid_html);
    $zbp->template_admin->SetTags('button_posttime_html', $button_posttime_html);
    $zbp->template_admin->SetTags('uploads', $array);
    $zbp->template_admin->SetTags('p', $p);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("UploadMng");

    return $rlt;
}

function zbp_admin2_MemberMng()
{
    global $zbp;

    $search = GetVars('search', '', '');
    $order_get = GetVars('order', 'GET');

    $p = new Pagebar('{%host%}zb_system/cmd.php?act=MemberMng{&order=%order%}{&page=%page%}', false);
    $p->PageCount = $zbp->managecount;
    $p->PageNow = (int) GetVars('page', 'GET') === 0 ? 1 : (int) GetVars('page', 'GET');
    if (GetVars('search') !== GetVars('search', 'GET')) {
        $p->PageNow = 1;
    }
    $p->PageBarCount = $zbp->pagebarcount;
    $p->UrlRule->Rules['{%order%}'] = $order_get;

    $w = [];
    if (!$zbp->CheckRights('MemberAll')) {
        $w[] = ['=', 'mem_ID', $zbp->user->ID];
    }
    if (GetVars('level')) {
        $w[] = ['=', 'mem_Level', GetVars('level')];
    }
    if (GetVars('search')) {
        $w[] = ['search', 'mem_Name', 'mem_Alias', 'mem_Email', GetVars('search')];
    }

    $s = '';
    if ($order_get === 'id_desc') {
        $or = ['mem_ID' => 'DESC'];
    } elseif ($order_get === 'id_asc') {
        $or = ['mem_ID' => 'ASC'];
    } elseif ($order_get === 'level_desc') {
        $or = ['mem_Level' => 'DESC'];
    } elseif ($order_get === 'level_asc') {
        $or = ['mem_Level' => 'ASC'];
    } elseif ($order_get === 'name_desc') {
        $or = ['mem_Name' => 'DESC'];
    } elseif ($order_get === 'name_asc') {
        $or = ['mem_Name' => 'ASC'];
    } elseif ($order_get === 'alias_desc') {
        $or = ['mem_Alias' => 'DESC'];
    } elseif ($order_get === 'alias_asc') {
        $or = ['mem_Alias' => 'ASC'];
    } else {
        $or = ['mem_ID' => 'ASC'];
    }

    $l = [($p->PageNow - 1) * $p->PageCount, $p->PageCount];
    $op = ['pagebar' => $p];

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_MemberMng_Core'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $members = $zbp->GetMemberList(
        '',
        $w,
        $or,
        $l,
        $op,
    );

    // 生成排序按钮
    list($button_id_html) = MakeOrderButton('id', $p->UrlRule, $order_get);
    list($button_level_html) = MakeOrderButton('level', $p->UrlRule, $order_get);
    list($button_name_html) = MakeOrderButton('name', $p->UrlRule, $order_get);
    list($button_alias_html) = MakeOrderButton('alias', $p->UrlRule, $order_get);

    // 设置模板变量
    $zbp->template_admin->SetTags('button_id_html', $button_id_html);
    $zbp->template_admin->SetTags('button_level_html', $button_level_html);
    $zbp->template_admin->SetTags('button_name_html', $button_name_html);
    $zbp->template_admin->SetTags('button_alias_html', $button_alias_html);
    $zbp->template_admin->SetTags('members', $members);
    $zbp->template_admin->SetTags('p', $p);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("MemberMng");

    return $rlt;
}

function zbp_admin2_ModuleMng()
{
    global $zbp;

    $sm = [];
    $um = [];
    $tm = [];
    $pm = [];

    foreach ($zbp->modules as $m) {
        if ($m->SourceType === 'system') {
            $sm[] = $m;
        } elseif ($m->SourceType === 'user') {
            $um[] = $m;
        } elseif ($m->SourceType === 'theme' || $m->SourceType === 'themeinclude') {
            // 判断模块归属当前主题
            if ($m->Source === 'theme' || (substr($m->Source, (-1 - strlen($zbp->theme)))) === ('_' . $zbp->theme)) {
                $tm[] = $m;
            }
        } else {
            $pm[] = $m;
        }
    }

    $sideids = [1 => '', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9'];

    // 设置模板变量
    $zbp->template_admin->SetTags('sm', $sm);
    $zbp->template_admin->SetTags('um', $um);
    $zbp->template_admin->SetTags('tm', $tm);
    $zbp->template_admin->SetTags('pm', $pm);
    $zbp->template_admin->SetTags('sideids', $sideids);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("ModuleMng");

    return $rlt;
}

function zbp_admin2_ThemeMng()
{
    global $zbp;

    $allthemes = $zbp->LoadThemes();

    // 设置模板变量
    $zbp->template_admin->SetTags('allthemes', $allthemes);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("ThemeMng");

    return $rlt;
}

function zbp_admin2_PluginMng()
{
    global $zbp;

    $allplugins = $zbp->LoadPlugins();

    $plugins = [];

    $app = new App();
    if ($app->LoadInfoByXml('theme', $zbp->theme) === true) {
        if ($app->HasPlugin()) {
            array_unshift($plugins, $app);
        }
    }

    $pl = $zbp->option['ZC_USING_PLUGIN_LIST'];
    $apl = explode('|', $pl);
    $apl = array_unique($apl);
    foreach ($apl as $name) {
        foreach ($allplugins as $plugin) {
            if ($name === $plugin->id) {
                $plugins[] = $plugin;
            }
        }
    }
    foreach ($allplugins as $plugin) {
        if (!$plugin->IsUsed()) {
            $plugins[] = $plugin;
        }
    }

    // 设置模板变量
    $zbp->template_admin->SetTags('plugins', $plugins);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("PluginMng");

    return $rlt;
}

function zbp_admin2_SettingMng()
{
    global $zbp;

    // 设置模板变量
    // $zbp->template_admin->SetTags('zbp', $zbp);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("SettingMng");

    return $rlt;
}

function zbp_admin2_CategoryEdt()
{
    global $zbp;

    $cateid = null;
    if (isset($_GET['id'])) {
        $cateid = (int) GetVars('id', 'GET');
    } else {
        $cateid = 0;
    }

    $type = (int) GetVars('type');

    $cate = $zbp->GetCategoryByID($cateid);
    if ($cate->ID === 0) {
        $cate->Type = (int) GetVars('type', 'GET');
    }

    $p = null;
    $p .= '<option value="0">' . $zbp->lang['msg']['none'] . '</option>';

    foreach ($zbp->categoriesbyorder_type[$cate->Type] as $k => $v) {
        if ($v->ID === $cate->ID) {
            continue;
        }
        if ($cate->ID > 0 && $v->RootID === $cate->ID) {
            continue;
        }
        if ($cate->RootID > 0) {
            if ($v->RootID === $cate->RootID && $v->Level >= $cate->Level) {
                continue;
            }
        }
        if ($v->Level < ($zbp->category_recursion_level - 1)) {
            $p .= '<option ' . ($v->ID === $cate->ParentID ? 'selected="selected"' : '') . ' value="' . $v->ID . '">' . $v->SymbolName . '</option>';
        }
    }

    // 设置模板变量
    $zbp->template_admin->SetTags('cate', $cate);
    $zbp->template_admin->SetTags('p', $p);
    $zbp->template_admin->SetTags('type', $type);

    // 渲染模板
    $rlt = $zbp->template_admin->Output("CategoryEdt");

    return $rlt;
}

function zbp_admin2_TagEdt()
{
    global $zbp;

    $tagid = null;
    if (isset($_GET['id'])) {
        $tagid = (int) GetVars('id', 'GET');
    } else {
        $tagid = 0;
    }

    $type = (int) GetVars('type');

    $tag = $zbp->GetTagByID($tagid);
    if ($tag->ID === 0) {
        $tag->Type = (int) GetVars('type', 'GET');
    }

    $zbp->template_admin->SetTags('tag', $tag);
    $zbp->template_admin->SetTags('type', $type);

    $rlt = $zbp->template_admin->Output("TagEdt");

    return $rlt;
}

function zbp_admin2_MemberEdt()
{
    global $zbp;

    $memberid = null;
    if (isset($_GET['id'])) {
        $memberid = (int) GetVars('id', 'GET');
    } else {
        $memberid = 0;
    }

    if (!$zbp->CheckRights('MemberAll')) {
        if ((int) $memberid !== (int) $zbp->user->ID) {
            $zbp->ShowError(6, __FILE__, __LINE__);
        }
    }

    $member = $zbp->GetMemberByID($memberid);

    $zbp->template_admin->SetTags('member', $member);

    $rlt = $zbp->template_admin->Output("MemberEdt");

    return $rlt;
}

function zbp_admin2_ModuleEdt()
{
    global $zbp;

    $modid = null;
    $mod = null;

    if (isset($_GET['source']) && isset($_GET['filename'])) {
        if (GetVars('source', 'GET') === 'themeinclude_' . $zbp->theme) {
            $mod = $zbp->GetModuleByFileName(GetVars('filename', 'GET'));
            if ($mod->ID === 0 || $mod->SourceType !== 'themeinclude') {
                $zbp->ShowError(61);
            }
        } else {
            $zbp->ShowError(61);
        }
    } elseif (isset($_GET['filename'])) {
        $mod = $zbp->GetModuleByFileName(GetVars('filename', 'GET'));
        if ($mod->ID === 0 || $mod->SourceType === 'themeinclude') {
            $zbp->ShowError(69);
        }
    } else {
        if (isset($_GET['id'])) {
            $modid = (int) GetVars('id', 'GET');
        } else {
            $modid = 0;
        }
        $mod = $zbp->GetModuleByID($modid);
    }

    $zbp->template_admin->SetTags('mod', $mod);

    $rlt = $zbp->template_admin->Output("ModuleEdt");

    return $rlt;
}
