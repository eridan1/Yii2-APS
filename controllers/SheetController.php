<?php

namespace app\controllers;

use Yii;
use app\models\Sheet;
use app\models\SheetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SheetController implements the CRUD actions for Sheet model.
 */
class SheetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SheetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sheet model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sheet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sheet_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sheet_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sheet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошувана сторінка не знайдена.');
    }

    public function actionReport($sheet_id, $type)
    {
        $model = $this->findModel($sheet_id);
        $report = Sheet::getDataSheet($sheet_id, $type);
        $sheet_dept_name = $model->dept->dept_name;
        $sheet_time_start = $model->sheet_time_start;
        $sheet_time_end = $model->sheet_time_end;
        if ($type == Sheet::SERVICE_INFORMATION) {
            return $this->render('service-info', [
                'sheet_dept_name' => $sheet_dept_name,
                'sheet_time_start' => $sheet_time_start,
                'sheet_time_end' => $sheet_time_end,
                'result' => $report['result'],
            ]);
        } elseif ($type == Sheet::SERVICE_DISTRIBUTION) {
            return $this->render('service-dist', [
                'sheet_dept_name' => $sheet_dept_name,
                'sheet_time_start' => $sheet_time_start,
                'sheet_time_end' => $sheet_time_end,
                'result' => $report['result'],
                'distribution_columns_count' => $report['dist_col_count'],
                'distribution_names' => $report['dist_names'],
                'output_distribution' => $report['out_dist'],
                'sum_values' => $report['column_sum'],
            ]);
        } else {
            throw new NotFoundHttpException('Запрошувана сторінка не знайдена.');
        }
    }

    public function actionAllSheets()
    {
        $searchAllSheets = new SheetSearch();
        $dataProvider = $searchAllSheets->search(Yii::$app->request->queryParams);

        return $this->render('sheet-grid', [
            'allSheets' => $searchAllSheets,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSheetCoreWidget()
    {
        return $this->render('sheet-core-widget');
    }

    public function actionPrint()
    {
        // require Yii::getAlias('@vendor') . '/tecnickcom/tcpdf/examples/example_001.php';
        $pdf = new \TCPDF();
        $pdf->addPage();
        $pdf->Write(1, 'Base PDF example of using tcpdf library for generating PDF documents.');
        $pdf->Output('Base-Pdf-Example.pdf');
    }
}
