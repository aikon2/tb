<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\base\Widget;

class FirstWidget extends Widget {
    
    public $a;
    public $b;


    public function init () {
        parent::init();
        if ($this->a === NULL) {
            $this->a = 0;
        }
        if ($this->b === NULL) {
            $this->b = 0;
        }
    }
    
    public function run() {
        $c=$this->a + $this->b;
        
        return $this->render(
                'first',
                [
                    'c'=>$c
                ]
                );
    }
}