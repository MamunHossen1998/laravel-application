<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestWebController extends Controller
{
    public function test(){
        return 'test';
    }
<<<<<<< HEAD
    public function testDataDetails(){
        return 'test details';
    }
    public function testController(){
        return "test controller";
=======
    public function testData()
    {
        return "Test Data";
>>>>>>> 8003b5683cde8d4baa1b2ade3dff5c84ff4bd98b
    }
}
