<?php

use panix\engine\helpers\TimeZoneHelper;
use panix\engine\Html;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */

?>

<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []); ?>
<?= $form->field($model, 'pagenum'); ?>
