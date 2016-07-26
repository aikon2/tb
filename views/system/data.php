<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Данные';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['tree']=$data;
//Дерево объектов
//$data=Tree::parseData([1,5]);

                  