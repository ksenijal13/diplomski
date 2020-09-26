<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LinkController extends FrontController
{
    private $modelLink;
    public function index(){
        $this->modelLink = new Link();
        $userId = session('user')->user_id;
        $this->data["links"] = $this->modelLink->getLinks($userId, 0);
        $this->data["total"] = count($this->modelLink->countLinks($userId)) / 8;
        return view('pages.link', $this->data);
    }
    public function addLink(Request $request){
        $this->modelLink = new Link();
        $userId = session('user')->user_id;
        $link = $request->input("new-link");
        try{
            $this->modelLink->addNewLink($userId, $link);
            $request->session()->put("success", "success");
            return redirect()->back();
        }catch(QueryException $e){
            return redirect()->back()->with("message", "Dogodila se greška, molimo Vas, pokušajte kasnije.");
        }
    }
    public function getLinks(Request $request){
        $this->modelLink = new Link();
        $userId = session('user')->user_id;
        $offset = $request->get("offset");
        $links = $this->modelLink->getLinks($userId, $offset);
        return response()->json($links, 200);
    }
    public function deleteLink(Request $request){
        $linkId = $request->get("linkId");
        $offset = $request->get("offset");
        $this->modelLink = new Link();
        $userId = session('user')->user_id;
        try{
            $this->modelLink->deleteLink($linkId);
            $data = [];
            $data[0] = $this->modelLink->getLinks($userId, $offset);
            if(!count($data[0])){
                $data[0] = $this->modelLink->getLinks($userId, $offset-1);
            }
            $data[1] = count($this->modelLink->countLinks($userId)) / 8;
            return response()->json($data, 200);
        }catch (QueryException $e){
            return response(null, 500);
        }
    }
}
