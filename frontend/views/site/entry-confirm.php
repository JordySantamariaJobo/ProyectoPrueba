<?php
	use yii\helpers\Html;
?>
<p>Esta es la informacion que tu ingresaste:</p>
<ul>
	<li><label>Nombre Completo:</label> <?= Html::encode($model->name) ?></li>
	<li><label>Apellido Paterno:</label> <?= Html::encode($model->app) ?></li>
	<li><label>Apellido Materno:</label> <?= Html::encode($model->apm) ?></li>
</ul>