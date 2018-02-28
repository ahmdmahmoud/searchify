<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SearchForm is the model behind the contact form.
 */
class SearchForm extends Model
{
    public $query;
    public $category;
	public $searchresults_json;
	public $searchresults;
	


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['query'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }
	
	public function search()
	{
		//echo "we will do something";
		return true ;
	}

    
}
