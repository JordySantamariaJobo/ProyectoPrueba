<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;
	use yii\db\ActiveRecord;

	class EntryForm extends Model
	{
		public $name;
		public $app;
		public $apm;

		public function rules()
		{
			return[
				[['name','app', 'apm'], 'required'],
			];
		}

		public function saveAs()
		{
			yii::$app->db->createCommand()->insert('Usuario', [
				'nombre' => $this->name,
				'app' => $this->app,
				'apm' => $this->apm,
				'activo' => 1,
			])->execute();
		}
	}
?>
