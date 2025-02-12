<?php
class Product
{
    public static function listing()
    {
        return query()->select("*")->from("products")->sort("id", "DESC")->paging(limit: 10)->execute()->fetch("all");
    }

    public static function single($id)
    {
        return query()->select("*")->from("products")->where(["id" => $id])->execute()->fetch("one");
    }

    public static function create($data)
    {
        return query()->create("products", $data)->execute();
    }

    public static function update($data, $id)
    {
        return query()->update("products", $data)->where(["id" => $id])->execute();
    }

    public static function delete($id)
    {
        return  query()->delete("products")->where(["id" => $id])->execute();
    }
}
