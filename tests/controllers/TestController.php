<?php


namespace ElegantGlacier\Tests\Controllers;


class TestController{
    public function TestAction(){
        echo 'Test action executed';
    }


    public function testParam($id){
        echo 'the id is {$id}';
    }
}