<?php

use maks757\language\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Module::t('Languages');

?>

<!-- LANGUAGES -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>
                    <i class="glyphicon glyphicon-globe"></i>
                    <?= Module::t('Languages list') ?>
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><?= Module::t('Language') ?></th>
                            <th><?= Module::t('Code') ?></th>
                            <th class="text-center"><?= Module::t('Active') ?></th>
                            <th class="text-center"><?= Module::t('Show') ?></th>
                            <th class="text-center"><?= Module::t('Default') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($languages)): ?>
                            <?php foreach ($languages as $lang): ?>
                                <tr>
                                    <td><?= $lang->name ?></td>
                                    <td><?= $lang->lang_id ?></td>
                                    <td class="text-center">
                                        <a href="<?= Url::to(['language/switch-active', 'id' => $lang->id]) ?>">
                                            <?php if ($lang->active > 0): ?>
                                                <i class="glyphicon glyphicon-ok text-success"></i>
                                            <?php else: ?>
                                                <i class="glyphicon glyphicon-remove text-danger"></i>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= Url::to(['language/switch-show', 'id' => $lang->id]) ?>">
                                            <?php if ($lang->show > 0): ?>
                                                <i class="glyphicon glyphicon-ok text-success"></i>
                                            <?php else: ?>
                                                <i class="glyphicon glyphicon-remove text-danger"></i>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= Url::to(['language/switch-default', 'id' => $lang->id]) ?>">
                                            <?php if ($lang->default > 0): ?>
                                                <i class="glyphicon glyphicon-ok text-success"></i>
                                            <?php else: ?>
                                                <i class="glyphicon glyphicon-remove text-danger"></i>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?=Url::to(['language/delete', 'id' => $lang->id])?>" class="glyphicon glyphicon-remove text-danger"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">
                                    <?= Module::t('There no found languages') ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#addLanguagePopup">
                    <i class="glyphicon glyphicon-plus"></i> <?= Module::t('Add') ?>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>

<!-- Create Language Modal -->

<div class="modal fade" id="addLanguagePopup" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $createLangForm = ActiveForm::begin(['action' => Url::to(['language/create']), 'method' => 'post']) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i><?= Module::t('Add new language') ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $createLangForm->field($createLanguageForm, 'name', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Module::t('Name'))
                    ?>
                </div>
                <div class="form-group">
                    <?= $createLangForm->field($createLanguageForm, 'lang_id', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Module::t('Code'))
                    ?>
                </div>
                <?= Html::activeCheckbox($createLanguageForm, 'active', ['label' => Module::t('Active')]) ?>
                <?= Html::activeCheckbox($createLanguageForm, 'show', ['label' => Module::t('Show')]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Module::t('Close') ?></button>
                <input type="submit" class="btn btn-primary pull-right" value="Add">
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
