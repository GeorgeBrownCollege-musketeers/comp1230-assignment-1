<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    public function readItems() {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $csv = array_map("str_getcsv", file($csvPath,FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        foreach ($csv as $i=>$row) {
            $csv[$i] = array_combine($keys, $row);
        }
        
        return $csv;
    }

    public function readItems1() {
        $csvPath = getcwd() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data"  . DIRECTORY_SEPARATOR . "items.csv";
        $file = fopen($csvPath,"r");
        $items = [];

        while(!feof($file)){
           $items[] = fgetcsv($file);
        }
        fclose($file);

        $titles = array_shift($items);

        return $items;
        }
}