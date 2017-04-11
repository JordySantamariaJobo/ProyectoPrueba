<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<?= 
	$form->field($model, 'name', [
        'inputOptions' => [
        	'autofocus' => 'autofocus', 
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Ingresa tu nombre"
     	])->label(false);
?>
<?= 
	$form->field($model, 'email', [
        'inputOptions' => [
        	'autofocus' => 'autofocus', 
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Ingresa tu correo"
     	])->label(false);
?>
<?= 
	$form->field($model, 'apellido', [
        'inputOptions' => [
        	'autofocus' => 'autofocus', 
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Ingresa tu correo"
     	])->label(false);
?>
<div class="form-group">
	<?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>