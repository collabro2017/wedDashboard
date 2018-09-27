<?php
use app\modules\site\models\Wedding;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var string $isSlideShow
 */

?>

<div class="col-sm-3 col-md-2 menu">
    <div class="header">
        <h1><?= Wedding::current()->getTitle() ?></h1>
    </div>
    <div class="menu-img">
        <?= Html::img(Wedding::current()->welcomeUrl); ?>

    </div>
    <div class="block-id">
        WEDDING ID: <span><?= Wedding::current()->code; ?></span>
    </div>

    <?= Nav::widget([
        'options' => [
            'class' => 'nav nav-pills nav-stacked'
        ],
        'items'   => [
            [
                'encode' => false,
                'label'  => sprintf('%s%s',
                    Html::tag('i', null, ['class' => 'icon icon-nav icon-nav-download']),
                    Html::tag('span', 'DOWNLOAD ALL PICTURES')
                ),
                'url'    => ['default/download-all'],
                'linkOptions' => [
                    'class' => 'download-link'
                ]
            ],
            [
                'encode' => false,
                'label'  => sprintf('%s%s',
                    Html::tag('i', null, ['class' => 'icon icon-nav icon-nav-start']),
                    Html::tag('span', 'START SLIDE SHOW')
                ),
                'url'    => ['default/slide-show'],
                'options' => [
                    'class' => $isSlideShow
                ]
            ],
            [
                'encode' => false,
                'label'  => sprintf('%s%s',
                    Html::tag('i', null, ['class' => 'icon icon-nav icon-nav-upload']),
                    Html::tag('span', 'UPLOAD PICTURES')
                ),
                'url'    => ['default/upload-pictures']
            ],
            [
                'encode' => false,
                'label'  => sprintf('%s%s',
                    Html::tag('i', null, ['class' => 'icon icon-nav icon-nav-user']),
                    Html::tag('span', 'VIEW USER PROFILE')
                ),
                'url'    => ['default/user-profile']
            ],
            [
                'encode' => false,
                'label'  => sprintf('%s%s',
                    Html::tag('i', null, ['class' => 'icon icon-nav icon-nav-logout']),
                    Html::tag('span', 'LOGOUT')
                ),
                'url'    => ['default/logout']
            ],
        ]
    ]);

    ?>
</div>