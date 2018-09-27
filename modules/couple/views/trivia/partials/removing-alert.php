<div class="alert alert-danger hide" role="alert">
    <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
    <h4>Are you sure?</h4>

    <p>Selecting Yes will permanently delete this section</p>

    <p class="text-right">
        <button type="button" class="btn btn-warning close-alert">No</button>
        <a href="<?= \yii\helpers\Url::to(['delete', 'id' => $model->id]) ?>" class="btn btn-danger">Yes, please!</a>
    </p>
</div>