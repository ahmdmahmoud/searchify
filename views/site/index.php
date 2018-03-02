<?php

/* @var $this yii\web\View */



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

use yii\widgets\LinkPager;

			
$this->title = 'My Searchengine ';



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
	
		<h1>Search Results</h1>
		<ul>
			
		<?php if (  isset($searchresults) && (is_array($searchresults) || is_object($searchresults))  ) {  
				foreach($searchresults as $key => $searchresult) {
		?>
				<li>
				
					<?= 
						//$searchresult = json_encode($searchresult, true);
						print_r($searchresult);
						//echo ($searchresult->_index)
					?>

				</li>
			
		
				<?php  }   ?>
		
	
		
		</ul>
		
		
		
		<?php  
						
			
			echo LinkPager::widget([
				'pagination' => $pages,
			]);

		?>
		
		
		<?php  }   ?>
		
		
	</div>
	
	
	
	 

    
</div>
