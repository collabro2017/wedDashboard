<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<a class="btn btn-out btn-share"

   href=" https://www.facebook.com/sharer/sharer.php?u=<?= Html::encode(Url::to
   ('@web/' . $filename, true)) ?>"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
   target="_blank" title="Share on Facebook">
    <i class="icon icon-thumb icon-share"></i>
</a>