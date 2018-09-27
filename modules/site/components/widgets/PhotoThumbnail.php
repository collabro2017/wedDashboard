<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29/01/15
 * Time: 05:50
 */

namespace app\modules\site\components\widgets;

use app\modules\site\models\MediaComment;
use yii\bootstrap\Widget;
use yii\db\Expression;

class PhotoThumbnail extends Widget
{
    public $media;

    public $canSharing;

    public function run()
    {
        $comment             = new MediaComment();
        $comment->media_id   = $this->media->id;
        $comment->created_at = new Expression('utc_timestamp');

        return $this->render('photo-thumbnail', [
            'model'        => $this->media,
            'commentModel' => $comment,
            'canSharing'   => $this->canSharing
        ]);
    }
}