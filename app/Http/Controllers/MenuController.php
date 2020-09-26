<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuModel;
    public function __construct()
    {
        $this->menuModel = new Menu();
    }

    public function addLink(Request $request){
        $text = $request->post("link-text");
        $path = $request->post("link-path");
        $icon = $request->post("link-icon");
        try{
            $this->menuModel->addLink($text, $path, $icon);
            $request->session()->put("success", "Uspešno ste dodali novi link.");
            return redirect()->back();
        }catch(QueryException $e){
             $request->session()->put("message", "Dogodila se greška. Molimo Vas pokušajte kasnije.");
            return redirect()->back();
        }
    }

    public function deleteMenuLink(Request $request){
        $linkId = $request->get("linkId");
        $offset = $request->get("offset");

        try{
            $this->menuModel->deleteLink($linkId);
            $linkData = [];
            $data[0] = $this->menuModel->GetLinks($offset);
            if(!count($data[0])){
                $data[0] = $this->menuModel->GetLinks($offset-1);
            }
            $data[1] = count($this->menuModel->getMenu()) / 6;
            return response()->json($data, 200);
        }catch (QueryException $e){
            return response(null, 500);
        }
    }

    public function getMenuLinks(Request $request){
        $offset = $request->get("offset");
        $data = $this->menuModel->GetLinks($offset);
        return response()->json($data, 200);
    }

    public function updateMenuLink(Request $request){
        $linkId = $request->post("link-id");
        $text =  $request->post("link-text");
        $href =  $request->post("link-href");
        $icon =  $request->post("link-icon");
        try{
            $this->menuModel->updateMenuLink($linkId,$text,$href,$icon);
            $request->session()->put("success", "Uspešno ste izmenili link.");
            return redirect()->back();
        }catch(QueryException $e){
            $request->session()->put("error", "Dogodila se greška.");
            return redirect()->back();
        }
    }
}
