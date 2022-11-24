<?php

namespace app\controller;

use support\Request;
use support\Db;

class Index
{
    public function index(Request $request)
    {
        return response('hello yijiantea index');
    }
}
