<?php

namespace Controllers;

use ElegantGlacier\ElegantGlacier;

class TestController {
    public function TestAction() {
        echo 'test action executed';
    }

    public function TestParam($id){
        echo 'the id is ' . $id;
    }

}