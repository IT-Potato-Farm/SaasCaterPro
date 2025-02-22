<?php 
    namespace App\Models;

    class Listing {
        public static function all(){
            return [
                [
                    'id' => 1,
                    'title' => 'Listing One',
                    'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Sequi molestiae accusantium odit atque nihil, quae tempora et officia iure 
                    labore fuga! Harum, laborum eveniet! Voluptatem ipsum sapiente repudiandae 
                    explicabo saepe!'
                ],
                [
                    'id' => 2,
                    'title' => 'Listing Two',
                    'description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Sequi molestiae accusantium odit atque nihil, quae tempora et officia iure 
                    labore fuga! Harum, laborum eveniet! Voluptatem ipsum sapiente repudiandae 
                    explicabo saepe!'
                ]
                ];
        }

        public static function find($id){
            $listings = self::all();

            foreach($listings as $listing){
                if($listing['id'] == $id){
                    return $listing;
                }
            }
        }
    }
