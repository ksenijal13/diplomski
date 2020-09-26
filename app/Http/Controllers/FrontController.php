<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $data = [];
    private $menuModel;
    private $userModel;
    private $id;
    public function __construct()
    {
        $this->menuModel = new Menu();
        $this->data['menu'] = $this->menuModel->getMenu();

        $this->userModel = new User();

        if(session()->has("user")){
             $this->id = session()->get('user')->user_id;
        }
        $this->data['userData'] = $this->userModel->getUserInfo($this->id);
    }
}
