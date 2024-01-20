<?php
namespace plugin\saiadmin\app\controller;

use support\Request;
use support\Response;

class IndexController
{

    public function index(Request $request): Response
    {
        return json(['code' => 0, 'message' => 'ok']);
    }
}