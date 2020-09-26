<?php


namespace App\Models;


class Link
{
    const LINK_LIMIT = 8;
    public function getLinks($userId, $offset){
        $offset = ((int) $offset) * self::LINK_LIMIT;
        return \DB::table("important_links")
            ->where("user_id", $userId)
            ->limit(self::LINK_LIMIT)
            ->offset($offset)
            ->get();
    }
    public function addNewLink($userId, $link){
        return \DB::table("important_links")
            ->insert([
                "user_id" => $userId,
                "link" => $link
            ]);
    }
    public function countLinks($userId){
        return \DB::table("important_links")
            ->where("user_id", $userId)
            ->get();
    }
    public function deleteLink($linkId){
        \DB::table("important_links")
            ->where("important_id", $linkId)
            ->delete();
    }
}
