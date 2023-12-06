<?php

namespace App\Services;

use App\DTO\ListDTO;
use App\Models\Userlist;

class ListService
{

    public function getList(string $user_id): array
    {
        return Userlist::select("id", "title", "login", "password", "description")
            ->where("user_id", $user_id)
            ->get()
            ->toArray();
    }

    public function createNewList(ListDTO $data): bool
    {

        if (Userlist::create($data->toArray())) {
            return true;
        }

        return false;
    }

    public function updateList(string $id, ListDTO $data): bool
    {
        if (Userlist::where([
            ["id", "=", $id],
            ["user_id", "=", $data->user_id]
        ])->update($data->toArray())) {
            return true;
        }

        return false;
    }

    public function deleteList(string $id, string $user_id): bool
    {
        if (Userlist::where([
            ["id","=", $id],
            ["user_id","=",$user_id]
        ])->delete()) {
            return true;
        }

        return false;
    }

}
