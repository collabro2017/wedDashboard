<?php

namespace app\modules\site\controllers;

use app\models\ext\Wedding;
use app\models\MediaLike;
use app\modules\site\components\Controller;
use app\modules\site\models\forms\SignInForm;
use app\modules\site\models\Guest;
use app\modules\site\models\Media;
use app\modules\site\models\MediaComment;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;
use yii2vm\media\upload\ImageUpload;
use zip_factory\ArchiverZipArchive;

/**
 * Class DefaultController
 * @package app\modules\site\controllers
 */
class DefaultController extends Controller
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(\Yii::$app->homeUrl);
    }

    /**
     * @return string
     */
    public function actionSignIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(\Yii::$app->homeUrl);
        }

        $this->layout = 'basic';

        $model = new SignInForm();

        if ($model->load(Yii::$app->request->post()) && $model->authorize()) {
            return $this->redirect(\Yii::$app->homeUrl);
        }

        return $this->render('sign-in', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     */
    public function actionDownload($id)
    {
        $media = Media::findOne($id);
        if ($media) {
            $path = Url::to('@webroot/' . $media->content_filename);
            $info = (object)pathinfo($path);
            Yii::$app->response->sendFile($path, $info->basename);
        }
    }

    /**
     * @param string $id
     */
    public function actionDownloadAll($id = '')
    {
        $archiveFile = tempnam(Url::to('@app/runtime'), 'zip');

        $zip = new \ZipArchive();
        $zip->open($archiveFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $ids = [];
        if ($id) {
            $ids = explode(',', $id);
        }

        /** @var ArchiverZipArchive $archive */
        $allMedia = Media::find()
                         ->joinWith(['guest'])
                         ->andWhere([
                             'guest.wedding_id' => Yii::$app->user->identity->guest->wedding_id
                         ])
                         ->andFilterWhere(['media.id' => $ids])
                         ->all();

        /** @var Media $media */
        foreach ($allMedia as $media) {
            $path = Url::to('@webroot/' . $media->content_filename);
            if (file_exists($path) && is_file($path) && is_readable($path)) {
                $info = (object)pathinfo($path);
                $zip->addFile($path, $info->basename);
            }
        }

        $zip->close();

        Yii::$app->response->sendFile($archiveFile, 'All media files.zip');
        //        unlink($file);
    }

    /**
     * @return string
     */
    public function actionSlideShow()
    {
        return $this->render('slide-show', [
            'query' => Media::find()
                            ->joinWith(['guest'])
                            ->where([
                                'guest.wedding_id' => Yii::$app->user->identity->guest->wedding_id,
                                'media.kind'       => 'photo',
                            ])
                            ->orderBy('created_at')
        ]);
    }

    /**
     * @return string
     */
    public function actionUploadPictures()
    {
        return $this->render('upload-pictures');
    }

    /**
     * @throws BadRequestHttpException
     * @throws ModelException
     */
    public function actionUpload()
    {
        $media = new Media();

        if ($media->load(Yii::$app->request->post()) && $media->save()) {
            return ImageUpload::createFromEntity($media, 'image')->toEntity($media, 'content_filename');
        } else {
            throw new BadRequestHttpException('Cannot load media');
        }
    }

    public function actionRemovePicture()
    {
        if (Yii::$app->request->post('filename')) {
            Media::find()->where(['content_filename' => Yii::$app->request->post('filename')])->one()->delete();
        }
    }

    /**
     * @return string
     */
    public function actionWeddingPictures()
    {
        /** @var Wedding $wedding */
        $wedding = Wedding::findOne(Yii::$app->user->identity->guest->wedding_id);

        return $this->render('wedding-pictures', [
            'query'      => Media::find()
                                 ->joinWith(['guest'])
                                 ->where([
                                     'guest.wedding_id' => Yii::$app->user->identity->guest->wedding_id
                                 ])
                                 ->orderBy('created_at'),
            'canSharing' => $wedding->enable_sharing
        ]);
    }

    /**
     * @return string
     */
    public function actionUserProfile()
    {
        return $this->render('user-profile', [
            'query' => Media::find()
                            ->where([
                                'guest_id' => Yii::$app->user->identity->guest_id
                            ])
        ]);
    }

    /**
     * @return string
     * @throws ModelException
     */
    public function actionAddComment()
    {
        $comment = new MediaComment();

        if ($comment->load(Yii::$app->request->post())) {
            $comment->guest_id = Yii::$app->user->identity->guest_id;

            if (!($comment->save() && $comment->refresh())) {
                throw new ModelException($comment);
            }

            return Json::encode($comment);
        }
    }

    /**
     * @param $id
     *
     * @return int|string
     */
    public function actionToggleLike($id)
    {
        /** @var Media $media */
        $media = Media::findOne($id);

        /** @var Guest $guest */
        $guest = Yii::$app->user->identity->guest;

        $like = $media->getMediaLikes()->where([
            'guest_id' => $guest->id
        ])->one();

        if ($like) {
            $guest->unlink('mediaLikes', $like, true);
        } else {
            $like             = new MediaLike();
            $like->attributes = [
                'liked_at' => new Expression('utc_timestamp'),
                'media_id' => $id
            ];

            $guest->link('mediaLikes', $like);
        }

        return $media->getMediaLikes()->count();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
