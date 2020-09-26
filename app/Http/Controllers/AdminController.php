<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class AdminController extends Controller
{
    private $data = [];
    private $user;
    private $menu;
    public function __construct()
    {
        $this->user = new User();
        $this->menu = new Menu();
    }
    public function index(){
        $this->data["users"] = $this->user->getAllUsers(0);
        $this->data["total"] = $this->user->countUsers()->number / 6;
        $this->data["menu"] = $this->menu->getLinks(0);
        $this->data["totalLinks"] = $this->menu->countLinks()->number / 6;
        return view('pages.admin', $this->data);
    }
}
