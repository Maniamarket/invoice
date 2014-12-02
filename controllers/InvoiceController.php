<?php

class InvoiceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
	return array(
	    'accessControl', // perform access control for CRUD operations
	    'postOnly + delete', // we only allow deletion via POST request
	);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

	/*
	  $mPDF1 = Yii::app()->ePdf->mpdf();
	  $mPDF1->WriteHTML($this->renderPartial('view', array(
	  'model' => $this->loadModel($id),
	  ), true));

	  $mPDF1->Output();
	 */

	$this->render('view', array(
	    'model' => $this->loadModel($id),
	));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new Invoice;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Invoice'])) {

	    $service = '';
	    foreach ($_POST['Invoice']['service'] as $v) {
		$service .= $v . ',';
	    }
	    $service = rtrim($service, ",");

	    $model->attributes = $_POST['Invoice'];
	    $model->date = date("Y-m-d", strtotime($model->date));
	    $model->service = $service;
	    $model->created_date = date("Y-m-d H:i:s");
	    

	    if ($model->save()) {
		if(isset($_POST['Invoice']['name'])) {
		    $this->redirect(array('index', 'id' => $model->id));
		}
		$this->redirect(array('index', 'id' => $model->id));
	    }
		
		
	}

	$this->render('create', array(
	    'model' => $model,
	));
    }

    public function actionCreatepdf($id) {
	//$this->renderPartial('invoice', array('model' => $this->loadModel($id))); exit;


	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	spl_autoload_register(array('YiiBase', 'autoload'));

	// set document information
	$pdf->SetCreator(PDF_CREATOR);

	$pdf->SetTitle("Invoice - ");
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Invoice - " . $id, "invoice for user %USERNAME%");
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->SetTextColor(80, 80, 80);
	$pdf->AddPage();

	$data = $this->loadModel($id);
	if (empty($data->finished)) {
	    $pdf->Header();
	}

	//Write the html
	$html = $this->renderPartial('invoice', array('model' => $data), true);



	//$html = "<div style='margin-bottom:15px;'>This is testing HTML.</div>";
	//Convert the Html to a pdf document
	$pdf->writeHTML($html, true, false, true, false, '');

	$header = array('Created by biling system'); //TODO:you can change this Header information according to your need.Also create a Dynamic Header.
	// data loading
	//$data = 'aaaaaaaaaaaaaaaaaa';
	//$data = $pdf->LoadData(Yii::getPathOfAlias('ext.tcpdf').DIRECTORY_SEPARATOR.'table_data_demo.txt'); //This is the example to load a data from text file. You can change here code to generate a Data Set from your model active Records. Any how we need a Data set Array here.
	// print colored table
	//$pdf->ColoredTable($header, $data);
	// reset pointer to the last page
	$pdf->lastPage();
	//echo 'aaaaa';
	//Close and output PDF document
	ob_end_clean();
	$pdf->Output('invoice_' . $id, 'I');
	Yii::app()->end();
    }

   
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
	$model = $this->loadModel($id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Invoice'])) {
	    $model->attributes = $_POST['Invoice'];
	    if ($model->save())
		$this->redirect(array('view', 'id' => $model->id));
	}

	$this->render('update', array(
	    'model' => $model,
	));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
	$this->loadModel($id)->delete();

	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	if (!isset($_GET['ajax']))
	    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
	$model = new Invoice('search');
	$model->unsetAttributes();  // clear any default values
	if (isset($_GET['Invoice']))
	    $model->attributes = $_GET['Invoice'];

	$this->render('admin', array(
	    'model' => $model,
	));
	/*
	  $dataProvider = new CActiveDataProvider('Invoice');
	  $this->render('index', array(
	  'dataProvider' => $dataProvider,
	  ));
	 * 
	 */
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
	$model = new Invoice('search');
	$model->unsetAttributes();  // clear any default values
	if (isset($_GET['Invoice']))
	    $model->attributes = $_GET['Invoice'];

	$this->render('admin', array(
	    'model' => $model,
	));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Invoice the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
	$model = Invoice::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Invoice $model the model to be validated
     */
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }

}
