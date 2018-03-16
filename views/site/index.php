<?php

/* @var $this yii\web\View */



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

use yii\widgets\LinkPager;

			
$this->title = 'My Searchengine ';

//$this->registerCssFile("/searchify/web/Flexor/css/style.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-blue.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-green.css");
//$this->registerCssFile("/searchify/web/Flexor/css/colour-lavender.css");



?>
<div class="site-index">

	

    <div class="jumbotron">
        
		<div class="row">
            <div >

				<?php $form = ActiveForm::begin(['id' => 'search-form', 'action' => Url::to(['site/index']), 'method' => 'get']); ?>

                    <?= $form->field($model, 'query')->textInput(['autofocus' => true]);
					
						$form->field($model, 'category')->dropdownlist ([
															1 => 'item 1', 
															2 => 'item 2'
														],
														['prompt'=>'Select Category']
													);


					?>
					

                    
                    
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-lg btn-success btn-primary', 'name' => 'search-button']) ?>
                
                <?php ActiveForm::end(); ?>
				
				
				
            </div>	
			
        </div>

    </div>
	
	
	<div>
	
		
			
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
						<strong>Fraunhofer / Kiel</strong> 
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
