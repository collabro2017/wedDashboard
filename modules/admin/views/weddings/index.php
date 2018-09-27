<!-- page content -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $.noConflict();
</script>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Weddings
                    <small>All weddings created so far</small>
                </h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <?php

                        use \app\models\Wedding;
                        use yii\grid\GridView;
                        use yii\widgets\Pjax;
                        use yii\helpers\Html;
                        use yii\widgets\ActiveForm;

Pjax::begin(['id' => 'pjax-grid-view']);



                        /* @var $this yii\web\View */
                        /* @var $model app\models\PostSearch */
                        /* @var $form yii\widgets\ActiveForm */
                        ?>

                        <div class="post-search">
                            <?php
                            $form = ActiveForm::begin([
                                        'action' => ['index'],
                                        'method' => 'get',
                            ]);
                            ?>
                            <div class="col-lg-4">
                                <div style="float: left;margin-right: 10px;margin-top: 5px;" class="text">Show</div> &nbsp;&nbsp;
                                <div style="float: left;margin-right: 10px;"  class="select-style">
                                <select onchange="this.form.submit()" name="per-page">
                                    <option <?php if (isset($_REQUEST['per-page'])) {
                                if ($_REQUEST['per-page'] == '10') echo 'selected';
                            } ?> value="10">10</option>
                                    <option <?php if (isset($_REQUEST['per-page'])) {
                                if ($_REQUEST['per-page'] == '25') echo 'selected';
                            } ?> value="25">25</option>
                                    <option <?php if (isset($_REQUEST['per-page'])) {
                               if ($_REQUEST['per-page'] == '50') echo 'selected';
                            }else{ echo 'selected'; } ?> value="50">50</option>
                                    <option <?php if (isset($_REQUEST['per-page'])) {
                                if ($_REQUEST['per-page'] == '100') echo 'selected';
                            } ?> value="100">100</option>
                                </select>
                                </div>&nbsp;&nbsp;
                                <div style="float: left;margin-top: 5px;" class="text">Enteries</div> 
                                <div style="clear:  both"></div>
                            </div>
                            <div class="col-lg-8">
                                <div class="title_right">
                                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                        <div class="input-group">
                                            <input value="<?php if (isset($_REQUEST['q'])) echo $_REQUEST['q']; ?>" name="q" type="text" class="form-control" placeholder="Search for...">
                                            <span class="input-group-btn">
                        <?= Html::submitButton('Go!', ['class' => 'btn btn-default']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php ActiveForm::end(); ?>
                        </div>
                        <?= Html::beginForm(['weddings/bulk'], 'post'); ?>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-5">
                                <div class="title_right">
                                    <div class="col-md-8 col-sm-5 col-xs-12 form-group pull-right top_search" style="margin-top: -51px;margin-right: 25px;">
                                        <?= Html::submitButton('<i class="fa fa-pencil"></i> Edit', ['class' => 'btn btn-info','name' => 'btnBulk','value' => 'edit',]); ?>
                                        <?= Html::submitButton('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-danger','name' => 'btnBulk','value' => 'delete',]); ?>
                                        <?= Html::submitButton('<i class="fa fa-download"></i> Download', ['class' => 'btn btn-warning','name' => 'btnBulk','value' => 'download',]); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>
                        <?php
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}\n{summary}{pager}",
                            'tableOptions' => ['class' => 'table table-striped table-bordered grid-view'],
                            'pager' => [
                                'options'          => ['class'=>'pagination'],   // set clas name used in ui list of pagination
                                'prevPageLabel'    => 'Previous',
                                'nextPageLabel'    => 'Next',
                            ],
                            'columns' => [
                                    ['class' => 'yii\grid\CheckboxColumn',
                                    'checkboxOptions' => function(Wedding $wedding, $key, $index, $column) {
                                        return ['value' => $wedding->id];
                                    },
                                ],
                                'id',
                                    [
                                    'label' => 'Bride',
                                    'attribute' => 'bride_first_name',
                                    'value' => function (Wedding $wedding) {
                                        return $wedding->bride_first_name . ' ' . $wedding->bride_last_name;
                                    },
                                ],
                                    [
                                    'label' => 'Groom',
                                    'attribute' => 'groom_first_name',
                                    'value' => function (Wedding $wedding) {
                                        return $wedding->groom_first_name . ' ' . $wedding->groom_last_name;
                                    },
                                ],
                                'code',
                                'admin_email',
                                    [
                                    'label' => 'Guests',
                                    'attribute' => 'guest_count',
                                    'value' => function ($wedding) {
                                        return $wedding->getGuests()->count();
                                    },
                                ],
                                    [
                                    'label' => 'Wedding Date',
                                    'attribute' => 'wedding_date',
                                    'value' => function (Wedding $wedding) {
                                        return Yii::$app->formatter->asDate($wedding->wedding_date, 'php:m/d/y');
                                    },
                                ],
                            ],
                        ]);
                        ?>
<?= Html::endForm(); ?> 
<?php Pjax::end(); ?>
                    </div>
                    <div style="clear:both"></div>
                    <script>
                        jQuery(document).ready(function ($) {
//                            jQuery('.pagination a').on('click', function () {
//                                 jQuery.pjax.reload({container:"#pjax-grid-view"});
//                            });
//                            jQuery('.grid-view').yiiGridView('applyFilter');
//                            jQuery('#w0').yiiGridView('getSelectedRows');
                            jQuery(document).on('click', '[name="selection_all"]', function () {
                                $('[name="selection[]"]').prop('checked', $(this).prop('checked')).trigger('change');
                            });

                        });
                    </script>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /page content -->
