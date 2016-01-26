<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\base\Widget;

class SecondWidget extends Widget {
      
    public function init () {
        parent::init();
        ob_start();
    }
    
    public function run() {
        $content = ob_get_clean();
               
        return $this->render(
                'second',
                [
                    'content'=> 'Новый текст: '.$content
                ]
                );
    }
}