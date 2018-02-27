<?php

/* @var $this yii\web\View */



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use yii\widgets\LinkPager;

$this->title = 'My Searchengine ';



?>
<div class="site-index">

	

    <div class="jumbotron">
        
		<div class="row">
            <div >

				<?php $form = ActiveForm::begin(['id' => 'search-form']); ?>

                    <?= $form->field($model, 'query')->textInput(['autofocus' => true]) ?>
					<?= $form->field($model, 'category')->dropdownlist ([
														1 => 'item 1', 
														2 => 'item 2'
													],
													['prompt'=>'Select Category']
												); ?>

                    
                    
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-lg btn-success btn-primary', 'name' => 'search-button']) ?>
                
                <?php ActiveForm::end(); ?>
				
				
				
            </div>	
			
        </div>

    </div>
	
	
	<div>
	
		<h1>Search Results</h1>
		<ul>
		<?php  ?>
			<li>
				<?= Html::encode("{$searchresults}") ?>
			</li>
		</ul>

		
	</div>
	
	
	
	 

    
</div>
