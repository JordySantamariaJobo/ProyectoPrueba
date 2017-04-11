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
     		'placeholder' => "Nombre..."
     	])->label(false);
?>
<?= 
	$form->field($model, 'email', [
        'inputOptions' => [
        	'autofocus' => 'autofocus', 
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Correo..."
     	])->label(false);
?>
<?= 
	$form->field($model, 'apellido', [
        'inputOptions' => [
        	'autofocus' => 'autofocus', 
           	'class' => 'form-control transparent'
        ]
    	])->textInput()->input('text', [
     		'placeholder' => "Apellidos..."
     	])->label(false);
?>
<div class="form-group">
	<?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>