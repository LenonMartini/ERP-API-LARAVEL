<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuService;

class MenuController extends Controller
{
    public function __construct(private MenuService $menuService) {}

    public function index()
    {

        $response = $this->menuService->findAll();

        return response()->json($response);
    }
}
