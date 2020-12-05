<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    public function getItems() {
        $query = $this->db->query("SELECT * FROM ITEMS");
        $results = $query->getResult();
        $items = [];


        foreach($results as $item){
            $images = [
                $item->image1,
                $item->image2,
                $item->image3,
                $item->image4,
                $item->image5
            ];
            $items[] = [
                "id" => $item->id,
                "name" => $item->name,
                "category" => $item->category_id,
                "price" => $item->price,
                "image" => $item->image1,
                // "images" => $images,
                "quantity" => 0,
                "description" => $item->description,
                "rating" => $item->rating
            ];
        }
        return $items;    
    }

    public function getHeader() {
        return [
            "id",
            "name",
            "category",
            "price",
            "image",
            "rating",
            "description",
            "quantity"
        ];
    }

    public function getItemsWithCategoryId() {
        $categories = $this->getCategories();
        return $categories;
    }

    public function getCategories() {
        $query = $this->db->query("SELECT * FROM categories");
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

    function getCategoryById($id) { # TODO: Check
        $query = $this->db->query("SELECT * FROM categories WHERE id=$id");
        $category = $query->getResult()[0];
        if($category) {
            return [
                "id" => $category->id,
                "name" => $category->name,
                "description" => $category->description,
                "status" => $category->status
            ];
        } else {
            return null;
        }
     }

    public function deleteItem($itemId) {
        $item_to_delete = $this->db->query("SELECT * FROM items WHERE id = ?", $itemId)->getResult()[0];

        if ($item_to_delete) {
            $this->db->simpleQuery("DELETE FROM items WHERE id = $itemId");
            if ($item_to_delete->image1 != '/img/no-image.png') {
                unlink("." . $item_to_delete->image1); // Delete image
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function addItem($item) {
        $this->db->table('items')->insert($item); 
    }     

    public function getItemsByCategory($category) {
        $query = $this->db->query("SELECT * FROM items WHERE category_id=$category");
        $results = $query->getResult();
        $items = [];


        foreach($results as $item){
            
            $items[] = [
                "id" => $item->id,
                "name" => $item->title,
                "category" => $item->category_id,
                "price" => $item->price,
                "image" => $item->picture1,
                "quantity" => 0,
                "description" => $item->description,
                "rating" => $item->rating
            ];
        }
        return $items;    
    }

    public function getNumberOfItemsPerCategory($categoryName) {
        $query = $this->db->query("SELECT * FROM categories WHERE name = ?", $categoryName);
        $categoryID = $query->getResult()[0]->id;

        $query = $this->db->query("SELECT COUNT(*) as number_of_items FROM items WHERE category_id = ?", $categoryID);
        $results = $query->getResult()[0];
        return $results->number_of_items;
    }

    public function renameCategory($previousCategoryName, $newCategoryName, $newDescription) {
        $newValues = [
            'name' => $newCategoryName,
            'description' => $newDescription
        ];

        $this->db->table('categories')->where('name',$previousCategoryName)->update($newValues); 
    }

    public function editItem($itemToModify) { # TODO
        $this->db->table('items')->where('id',$itemToModify['id'])->update($itemToModify); 
    }

    public function generateCategoryID() {
        $items = $this->getCategories();
        $last_item_id = intval(array_pop($items)['id']);
        return $last_item_id + 1;
    } 

    public function addCategory($name, $description) {
        $data = [
            'name' => $name,
            'description' => $description
        ];

        $this->db->table('categories')->insert($data);
    }
}