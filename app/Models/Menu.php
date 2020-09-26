<?php


namespace App\Models;




class Menu
{
    const LINK_LIMIT = 6;
    public function getMenu(){
        return \DB::table("menu")->get();
    }
    public function GetLinks($offset){
        $offset = ((int) $offset) * self::LINK_LIMIT;
        return \DB::table("menu")
            ->select("*")
            ->limit(self::LINK_LIMIT)
            ->offset($offset)
            ->get();
    }
    public function countLinks(){
        return \DB::table("menu")
            ->select(\DB::raw("COUNT(*) as number"))
            ->first();
    }

    public function addLink($text, $path, $icon){
        \DB::table("menu")
            ->insert([
                "text" => $text,
                "href" => $path,
                "icon" => $icon
            ]);
    }

    public function deleteLink($linkId){
         \DB::table("menu")
            ->where("link_id", $linkId)
            ->delete();
    }

    public function updateMenuLink($linkId, $text, $href, $icon){
        \DB::table("menu")
            ->where("link_id", $linkId)
            ->update([
                "text" => $text,
                "href" => $href,
                "icon" => $icon
            ]);
    }

}
