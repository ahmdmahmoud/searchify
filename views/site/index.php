<?php

/* @var $this yii\web\View */



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

use yii\widgets\LinkPager;
use yii\jui\DatePicker;
			
$this->title = 'My Searchengine ';

//$this->registerCssFile("/searchify/web/Flexor/css/style.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-blue.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-green.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-lavender.css");



?>
<div class="site-index container-fluid"> 

    <div class="col-md-4">
        <br>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="collapse-facet panel-heading collapsed" data-placement="auto" data-target="#facetedbuckets11" data-toggle="collapse" id="collapse_facet_openAccess" style="cursor: pointer" title="select the country of the scholarship" aria-expanded="false">
                    <a>
                    Country
                    <i class="glyphicon glyphicon-triangle-bottom pull-right"></i>
                    </a>
                </div>
                <div class="panel-collapse collapse" id="facetedbuckets11" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="checkbox faceted_checkbox_openAccess" id="faceted_checkbox_openAccess">
                            <label>
                                <input class="filters-checkbox" id="filters_openAccess_" name="filters[openAccess][]" type="checkbox" value="1">
                                Germany (42)
                            </label>
                            </div>
                            <div class="checkbox faceted_checkbox_openAccess" id="faceted_checkbox_openAccess">
                            <label>
                                <input class="filters-checkbox" id="filters_openAccess_" name="filters[openAccess][]" type="checkbox" value="1">
                                Egypt (22)
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 jumbotron">
            <div>

                <?php $form = ActiveForm::begin(['id' => 'search-form', 'action' => Url::to(['site/index']), 'method' => 'get']); ?>
                    <?= $form->field($model, 'query')->textInput(['autofocus' => true]);
                                    $form->field($model, 'category')->dropdownlist ([
                                                                                                            1 => 'item 1', 
                                                                                                            2 => 'item 2'
                                                                                                    ],
                                                                                                    ['prompt'=>'Select Category']);
                    ?>

                    <?= Html::submitButton('Search', ['class' => 'btn btn-lg btn-success btn-primary', 'name' => 'search-button']) ?>                
                <?php ActiveForm::end(); ?>
                
                
                <?php if (  isset($searchresults) && (is_array($searchresults) || is_object($searchresults))  ) { ?>
		<h3 class="block-title">  
                    Latest Items 
		</h3>
		
		<?php
                    foreach($searchresults as $key => $searchresult) {
		?>
				
                    <div style="background-color:#f3f3f3;color:black;padding:20px;">

                            <div class="media-left hidden-xs">
                              <!-- Date desktop -->
                              <div class="date-wrapper"> <span class="date-m">Feb</span> <span class="date-d">01</span> </div>
                            </div>

                            <div class="media-body">
                              <h4 class="media-heading">
                                      <a href="<?= print_r($searchresult['_source']['identifier']); ?>" class="text-weight-strong"><?= print_r($searchresult['_source']['title']); ?></a>
                                    </h4>
                              <!-- Meta details mobile -->
                              <ul class="list-inline meta text-muted visible-xs">
                                    <li><span class="visible-md">Created:</span> Fri 1st Feb 2013</li>
                                    <li><a href="#">Kiel</a></li>
                              </ul>
                              <p>
                                    Fraunhofer / Kiel 
                              </p>
                              <p>
                                <?php  if (  !empty($searchresults['_source']['abstract'])  ) { 
                                   print_r($searchresult['_source']['abstract']); 
                                }
                                ?>
                                <a href="<?= print_r($searchresult['_source']['identifier']); ?>">Read more <i class="fa fa-angle-right"></i></a>

                              </p>
                            </div>
                    </div>
			
		
                <?php  }   ?>
		
	
				
		
		
		<?php  
			echo LinkPager::widget([
				'pagination' => $pages,
			]);
		?>
		
		<?php  }   ?>
				
            </div>	
		

   </div>
	

	
	 

    
</div>
