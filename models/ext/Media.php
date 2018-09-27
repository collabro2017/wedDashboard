<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/01/15
 * Time: 10:01
 */

namespace app\models\ext;

use app\models\MediaLike;
use Yii;
use yii\helpers\Url;
use yii\imagine\Image;

class Media extends \app\models\Media
{
    public function isLikedByGuest($id)
    {
        return MediaLike::find()->where([
            'media_id' => $this->id,
            'guest_id' => $id
        ])->count() > 0;
    }

    public function getThumbnail()
    {
        if (!$this->content_filename) {
            return null;
        }

        $path      = \Yii::getAlias('@webroot/' . $this->content_filename);
        $url       = \Yii::getAlias('@web/' . $this->content_filename);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $thumbPath = sprintf('%s.thumbnail.%s', substr($path, 0, strlen($path) - strlen($extension) - 1), $extension);
        $thumbUrl  = sprintf('%s.thumbnail.%s', substr($url, 0, strlen($url) - strlen($extension) - 1), $extension);

        if (!file_exists($thumbPath) && file_exists($path)) {
            try {
                Image::thumbnail($path, 300, 300)->save($thumbPath);
            } catch (\Exception $exception) {
                return Url::to(['/uploads/stub']);
            }
        }

        return $thumbUrl . '?utm=' . crc32(uniqid());
    }

    public function afterDelete()
    {
        unlink($this->content_filename);
        return parent::beforeDelete();
    }
}