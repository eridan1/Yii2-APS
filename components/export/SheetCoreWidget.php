<?php

namespace app\components\export;

use yii\base\Widget;
use yii\helpers\Html;

class SheetCoreWidget extends Widget
{
	public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
        	$this->message = 'Welcome User';
        } else {
        	$this->message = 'Welcome, ' . $this->message;
        }
    }

    public function run()
    {
        parent::run();
        return Html::encode($this->message);
    }
}
