<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<?= 
	$form->field($model, 'name', [
        'inputOptions' => [
        	//'autofocus' => 'autofocus',
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Nombre Completo"
     	])->label(false);
?>
<?= 
	$form->field($model, 'app', [
        'inputOptions' => [
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Apellido Paterno"
     	])->label(false);
?>
<?= 
	$form->field($model, 'apm', [
        'inputOptions' => [
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Apellido Materno"
     	])->label(false);
?>
<div class="form-group">
	<?= Html::submitButton("Ingresar", ['class' => 'btn btn-primary btn-ingresar']) ?>
</div>
<style>
	.btn-ingresar{
		width: 100%;
	}
</style>
<?php ActiveForm::end(); ?>