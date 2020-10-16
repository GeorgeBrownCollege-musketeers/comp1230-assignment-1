<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    public function getItems() {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $csv = array_map("str_getcsv", file($csvPath,FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach ($csv as $i=>$row) {
            $csv[$i] = array_combine($keys, $row);
        }
        
        return $csv;
    }

    public function getItemsByCategory($category) {
        $items = $this->getItems();
        $result = [];
        foreach($items as $item) {
            if ($category == $item['category']) {
                $result[] = $item;
            }
        }
        return $result;
    }

    public function getCategories() {
        $items = $this->getItems();
        $categories = [];

        foreach($items as $item) {
            if (!in_array($item["category"], $categories)) {
                $categories[] = $item["category"];
            }
        }
        return $categories;
    }

}