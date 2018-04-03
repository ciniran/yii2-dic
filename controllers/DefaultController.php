<?php

namespace ciniran\dic\controllers;

use ciniran\dic\components\DicTools;
use Yii;
use ciniran\dic\models\SystemDic;
use ciniran\dic\models\SystemDicQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for DicTools model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all DicTools models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->request->queryParams;
        $searchModel = new SystemDicQuery();
        if (!$searchModel->check()) {

            $searchModel->initTable();

        }
        $dataProvider = $searchModel->search($data);
        $dataProvider->query->andWhere(['pid' => null]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionAddSub($id)
    {

        $model = new SystemDic();
        $data = Yii::$app->request->post();
        $pModel = $this->findModel($id);
        if ($data) {
            $model->load($data);
            $model->pid = $pModel->id;
            if (!$model->isExist($model)) {
                if ($model->save()) {
                    $this->redirect(['index', 'pid' => $model->pid]);
                };
            } else {
                Yii::$app->session->setFlash('error', Yii::t('dic', 'The value you have set already exists. Please check it!'));
            }
        }
        return $this->render('addSub', [
            'model' => $model,
            'pModel' => $pModel,
        ]);
    }

    /**
     * Creates a new DicTools model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SystemDic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'pid' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DicTools model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'pid' => $model->pid ?: $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DicTools model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $pid = $model->pid;
        try {
            $model->delete();
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('error', Yii::t('dic', 'There are also child entries that cannot be deleted'));
            return $this->redirect('index');
        }

        if ($pid) {
            return $this->redirect(['index', 'pid' => $pid]);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the DicTools model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SystemDic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SystemDic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSub($id)
    {
        $searchModel = new SystemDicQuery();
        $pModel = $searchModel->find()->where(['id' => $id])->select('name')->one();
        $data['SystemDicQuery']['pid'] = $id;
        $dataProvider = $searchModel->search($data);
        return $this->renderAjax('_sub', [
            'name' => $pModel->name ? $pModel->name : "",
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


}
