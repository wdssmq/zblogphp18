<?php

function AdminColor_2026_GetColors()
{
    return [
        [
            'BoldColor'  => '#1d4c7d',
            'NormalColor' => '#3a6ea5',
            'LightColor' => '#b0cdee',
            'HighColor'  => '#3399cc',
            'AntiColor'  => '#d60000',
            'Title'      => 'ZB蓝',
            'Square'     => '#3a6ea5',
        ],
        [
            'BoldColor'  => '#143c1f',
            'NormalColor' => '#5b992e',
            'LightColor' => '#bee3a3',
            'HighColor'  => '#6ac726',
            'AntiColor'  => '#d60000',
            'Title'      => '',
            'Square'     => '#5b992e',
        ],
        [
            'BoldColor'  => '#06282b',
            'NormalColor' => '#2db1bd',
            'LightColor' => '#87e6ef',
            'HighColor'  => '#119ba7',
            'AntiColor'  => '#d60000',
            'Title'      => '',
            'Square'     => '#2db1bd',
        ],
        [
            'BoldColor'  => '#3e1165',
            'NormalColor' => '#5c2c84',
            'LightColor' => '#a777d0',
            'HighColor'  => '#8627d7',
            'AntiColor'  => '#08a200',
            'Title'      => '',
            'Square'     => '#5c2c84',
        ],
        [
            'BoldColor'  => '#3f280d',
            'NormalColor' => '#b26e1e',
            'LightColor' => '#e3b987',
            'HighColor'  => '#d88625',
            'AntiColor'  => '#d60000',
            'Title'      => '',
            'Square'     => '#b26e1e',
        ],
        [
            'BoldColor'  => '#0a4f3e',
            'NormalColor' => '#267662',
            'LightColor' => '#68cdb4',
            'HighColor'  => '#25bb96',
            'AntiColor'  => '#d60000',
            'Title'      => '',
            'Square'     => '#267662',
        ],
        [
            'BoldColor'  => '#3a0b19',
            'NormalColor' => '#7c243f',
            'LightColor' => '#d57c98',
            'HighColor'  => '#d31b54',
            'AntiColor'  => '#2039b7',
            'Title'      => '',
            'Square'     => '#7c243f',
        ],
        [
            'BoldColor'  => '#2d2606',
            'NormalColor' => '#d4a30e',
            'LightColor' => '#fcd251',
            'HighColor'  => '#e9b20a',
            'AntiColor'  => '#d60000',
            'Title'      => '',
            'Square'     => '#d4a30e',
        ],
        [
            'BoldColor'  => '#a60138',
            'NormalColor' => '#ff6699',
            'LightColor' => '#f993b5',
            'HighColor'  => '#df4679',
            'AntiColor'  => '#df1ce6',
            'Title'      => '',
            'Square'     => '#ff6699',
        ],
        [
            'BoldColor'  => '#17365d',
            'NormalColor' => '#366092',
            'LightColor' => '#b8cce4',
            'HighColor'  => '#8db3e2',
            'AntiColor'  => '#e36c09',
            'Title'      => '星空云',
            'Square'     => '#17365d',
        ],
        [
            'BoldColor'  => '#262f3e',
            'NormalColor' => '#0070c0',
            'LightColor' => '#D9DFE5',
            'HighColor'  => '#3f3f3f',
            'AntiColor'  => '#c0504d',
            'Title'      => '深度云',
            'Square'     => '#262f3e',
        ],
    ];
}

function AdminColor_2026_GenCSS()
{
    global $zbp;
    $uFile = AdminColor_2026_Path('usr/style.css');
    $vFile = AdminColor_2026_Path('var/style.css');
    $cfg_colors = $zbp->Config('AdminColor_2026')->colors;
    $tpl = file_get_contents($vFile);
    foreach ($cfg_colors as $key => $value) {
        $tpl = str_replace("{{{$key}}}", $value, $tpl);
    }
    file_put_contents($uFile, $tpl);
}
