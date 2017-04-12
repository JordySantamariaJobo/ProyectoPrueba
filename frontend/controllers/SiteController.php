<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\ValidarFormulario;
use frontend\models\FormAlumnos;
use frontend\models\Alumnos;
use frontend\models\FormSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionUpdate()
    {
        $model = new FormAlumnos;
        $msg = null;
        $alumno_id = Yii::$app->request->get('id_alumno');

        $table = Alumnos::findOne($alumno_id);
    }

    public function actionDelete()
    {
        if (Yii::$app->request->post()) {
            $id_alumno = Html::encode($_POST["id_alumno"]);
            if ((int) $id_alumno) {
                if (Alumnos::deleteAll("id_alumno=:id_alumno", ["id_alumno" => $id_alumno])) {
                    Yii::$app->session->setFlash('success',"The Student has been successfully removed!");
                    return $this->redirect('/yii-aplication/frontend/web/index.php?r=site%2Fview',302);
                }
                else
                {
                     echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                     return $this->redirect('/yii-aplication/frontend/web/index.php?r=site%2Fview',302);
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                return $this->redirect('/yii-aplication/frontend/web/index.php?r=site%2Fview',302);
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
    }

    public function actionView()
    {
        $table = new Alumnos;
        $dataProvider = new ActiveDataProvider([
            'query' => Alumnos::find()->orderBy(['id_alumno'=>SORT_DESC]),
        ]);
        /*print_r($dataProvider);
        exit();*/
        $model = $table->find()->orderBy(['id_alumno'=>SORT_DESC])->all(); //Con order by
        //$model = Alumnos::find()->all(); //Trae todos los datos
        $form = new FormSearch;
        $search = null;
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $query = "SELECT * FROM alumnos WHERE id_alumno LIKE '%$search%' OR nombre LIKE '%$search%' OR apellidos LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        return $this->render("view", ["model" => $model, "form" => $form, "search" => $search, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new FormAlumnos;
        $msg = null;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $table = new Alumnos;
                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->clase = $model->clase;
                $table->nota_final = $model->nota_final;

                if ($table->insert()) {

                    Yii::$app->session->setFlash('success',"Student successfully registered!");
                    $model->nombre = null;
                    $model->apellidos = null;
                    $model->clase = null;
                    $model->nota_final = null;
                    return $this->redirect('/yii-aplication/frontend/web/index.php?r=site%2Fcreate',302);

                }
                else {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("create", ['model' => $model, 'msg' => $msg]);
    }

    public function actionSaluda($get = "Tutorial Yii")
    {
        $mensaje = "Hola Mundo";
        $numeros = [0, 1, 2, 3, 4, 5];
        return $this->render("saluda",
            [
                "saluda" => $mensaje,
                "numeros" => $numeros,
                "get" => $get,
            ]);
    }

    public function actionRequest()
    {
        $mensaje = null;
        if (isset($_REQUEST["nombre"])) {
            $mensaje = "Tu nombre es: ".$_REQUEST["nombre"];
        }
        $this->redirect(["site/formulario", "mensaje" => $mensaje]);
    }

    public function actionFormulario($mensaje = null)
    {
        return $this->render("formulario", ["mensaje" => $mensaje]);
    }

    public function actionValidarformulario()
    {
        $model = new ValidarFormulario;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Por ejemplo, consultar en una base de datos.
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("validarformulario", ["model" => $model]);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
