<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    public function getItems() {
        $db = db_connect();

        $query = $db->query("SELECT * FROM ITEMS");
        $results = $query->getResult();
        $items = [];


        foreach($results as $item){
            
            $items[] = [
                "id" => $item->id,
                "name" => $item->title,
                "category" => $item->cat_id,
                "price" => $item->price,
                "image" => $item->picture1,
                "quantity" => 0,
                "description" => $item->description,
                "rating" => $item->rating
            ];
        }
        return $items;    
    }

    public function getItemsWithCategoryId() {
        $categories = $this->getCategories();
        return $categories;
    }

    public function getCategories() {
        $db = db_connect();
        $query = $db->query("SELECT * FROM categories");
        $results = $query->getResult();
        $categories = [];


        foreach($results as $category){
            
            $categories[] = [
                "id" => $category->id,
                "name" => $category->name,
                "description" => $category->description,
                "status" => $category->status
            ];
        }
        return $categories;  
    }

    function getCategoryById($id) {
        $categories = $this->getCategories();
        foreach ($categories as $i => $category) {
            if ($category['id'] === $id) {
                return $category["name"];
            }
        }
        return null;
     }

    public function deleteItem($itemId) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $items = $this->getItemsWithCategoryId();
        $newItems = [];
        foreach($items as $item) {
            if ($item["id"] != $itemId) {
                $newItems[] = $item;
            } else {
                if ($item['image'] != '/img/no-image.png') {
                    unlink("." . $item['image']); // Delete image
                }
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

    public function getCategoryHeader() {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "categories.csv";
        $csv = array_map("str_getcsv", file($csvPath,FILE_SKIP_EMPTY_LINES));
        $header = array_shift($csv);
        return $header;
    }

    public function generateItemID() {
        $items = $this->getItems();
        $last_item_id = intval(array_pop($items)['id']);
        return $last_item_id + 1;
    } 
    
    public function addItem($item) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $handle = fopen($csvPath, "a");
        $new_item_row = [
            $this->generateItemID(),
            $item["name"],
            $item["category"],
            $item["price"],
            $item["image"],
            $item["rating"],
            $item["quantity"],
            $item["description"],
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

    public function getNumberOfItemsPerCategory($category) {
        $items = $this->getItems();
        $result = [];
        foreach($items as $item) {
            if ($category == $item['category']) {
                $result[] = $item;
            }
        }
        return count($result);
    }

    public function renameCategory($previousCategoryName, $newCategoryName, $newDescription) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "categories.csv";
        $categories = $this->getCategories();
        $newCategories = [];
        foreach($categories as $category) {
            if ($category["name"] == $previousCategoryName) {
                $category["name"] = $newCategoryName;
                $category["description"] = $newDescription;
            }
            $newCategories[] = $category;
        }

        $header = $this->getCategoryHeader();
        $csv = fopen($csvPath,"w");

        fputcsv($csv, $header);
        foreach($newCategories as $category) {
            fputcsv($csv, $category);
        }
        fclose($csv);
    }

    public function editItem($itemToModify) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $items = $this->getItemsWithCategoryId();
        $newItems = [];
        foreach($items as $item) {
            if ($item['id'] == $itemToModify['id']) {
                $newItems[] = $itemToModify;
            } else {
                $newItems[] = $item;
            }
        }
        echo "<pre>";
        var_dump($newItems);
        $header = $this->getHeader();
        $csv = fopen($csvPath,"w");

        fputcsv($csv, $header);
        foreach($newItems as $item) {
            fputcsv($csv, $item);
        }
        fclose($csv);
    }

    public function generateCategoryID() {
        $items = $this->getCategories();
        $last_item_id = intval(array_pop($items)['id']);
        return $last_item_id + 1;
    } 

    public function addCategory($name, $description) {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "categories.csv";
        $categories = $this->getCategories();

        $handle = fopen($csvPath, "a");
        fputcsv($handle, [$this->generateCategoryID(), $name, $description]); 
    }
}