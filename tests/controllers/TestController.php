<?php

namespace ElegantGlacier\Tests\Controllers;

class TestController{
    public function testAction(){
        echo 'Test action executed';
    }

    public function testParam($id){
        echo 'the id is {$id}';
    }
}
