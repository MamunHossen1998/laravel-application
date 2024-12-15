<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestWebController extends Controller
{
    public function test(){
        return 'test';
    }
    public function testData()
    {
        return "Test Data";
    }
}
