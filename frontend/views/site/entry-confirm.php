<?php
	use yii\helpers\Html;
?>
<p>Esta es la informacion que tu ingresaste:</p>
<ul>
	<li><label>Nombre:</label> <?= Html::encode($model->name) ?></li>
	<li><label>Correo:</label> <?= Html::encode($model->email) ?></li>
	<li><label>Apellidos:</label> <?= Html::encode($model->apellido) ?></li>
</ul>