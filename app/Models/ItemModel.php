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

    public function deleteItem($itemId) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $items = $this->getItems();
        $newItems = [];
        foreach($items as $item) {
            if ($item["id"] != $itemId) {
                $newItems[] = $item;
            }
        }

        $header = $this->getHeader();
        $csv = fopen($csvPath,"w");

        fputcsv($csv, $header);
        foreach($newItems as $item) {
            fputcsv($csv, $item);
        }
        fclose($csv);
    }

    public function getHeader() {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $csv = array_map("str_getcsv", file($csvPath,FILE_SKIP_EMPTY_LINES));
        $header = array_shift($csv);
        return $header;
    }

    public function generateID() {
        $items = $this->getItems();
        $last_item_id = intval(array_pop($items)['id']);
        return $last_item_id + 1;
    } 
    
    public function addItem($item) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $handle = fopen($csvPath, "a");
        $new_item_row = [
            $this->generateID(),
            $item["name"],
            $item["category"],
            $item["price"],
            $item["image"],
            $item["rating"],
            $item["quantity"]
        ];
        fputcsv($handle, $new_item_row);
        fclose($handle);
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

    public function renameCategory($previousCategoryName, $newCategoryName) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $items = $this->getItems();
        $newItems = [];
        foreach($items as $item) {
            if ($item["category"] == $previousCategoryName) {
                $item["category"] = $newCategoryName;
            }
            $newItems[] = $item;
        }

        $header = $this->getHeader();
        $csv = fopen($csvPath,"w");

        fputcsv($csv, $header);
        foreach($newItems as $item) {
            fputcsv($csv, $item);
        }
        fclose($csv);
    }
}