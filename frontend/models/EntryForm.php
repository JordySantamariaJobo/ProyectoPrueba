<?php
	namespace app\models;

	use Yii;
	use yii\base\Model;

	class EntryForm extends Model
	{
		public $name;
		public $email;
		public $apellido;

		public function rules()
		{
			return[
				[['name','email', 'apellido'], 'required'],
				['email', 'email'],
			];
		}
		//loleros.compact(varname)
	}
?>