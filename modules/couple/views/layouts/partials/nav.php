<?php
use app\modules\couple\components\widgets\Nav;

echo Nav::widget([
    'activateItems' => true,
    'encodeLabels'  => false,
    'items'         => [
        [
            'label'       => 'Wedding ID:<span>' . $wedding->code . '</span>',
            'linkOptions' => ['class' => 'header header-menu'],
        ],
        [
            'options' => ['class' => 'primary'],
            'label'   => 'WEDDING INFO',
            'url'     => ['info/index'],
            'icon'    => 'icon-info',
        ],
        [
            'options' => ['class' => 'danger'],
            'icon'    => 'icon-trivia',
            'label'   => 'TRIVIA',
            'url'     => ['trivia/index'],
        ],
        [
            'options' => ['class' => 'success'],
            'label'   => 'POLL AUDIENCE',
            'icon'    => 'icon-poll',
            'url'     => ['poll/index'],
        ],
        [
            'options' => ['class' => 'warning'],
            'label'   => 'BAR DETAILS',
            'icon'    => 'icon-bar',
            'url'     => ['bar/index'],
        ],
        [
            'options' => ['class' => 'muted'],
            'label'   => 'FOOD',
            'icon'    => 'icon-food',
            'url'     => ['food/index'],
        ],
        [
            'options' => ['class' => 'info'],
            'label'   => 'WEDDING PARTY',
            'icon'    => 'icon-party',
            'url'     => ['party/index'],
        ],
        [
            'options' => ['class' => 'highlighted'],
            'label'   => 'WEDDING VENDORS',
            'icon'    => 'icon-vendors',
            'url'     => ['vendors/index'],
        ],
    ],
    'options'       => [
        'class' => 'nav nav-pills nav-stacked nav-menu hide',
    ],
]);
