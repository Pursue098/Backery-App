<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'parent_id', 'description', 'image', 'active'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * Get child of category.
     *
     * @var bool
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'cat_id');
    }

    /**
     * Get parent of category.
     *
     * @var bool
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Category has following products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }



    /**
     * Category has child categories
     */
    public function hasChild($id)
    {
        $categoriesData = Category::where('parent_id', $id)->get();


        $products = $this->products;

        if(isset($categoriesData) && $categoriesData->count() > 0){


            return true;

        }else{
            return false;
        }
    }

    /**
     * Category has child categories
     */
    public function hasChildOrProduct($id)
    {
        $categoriesData = Category::where('parent_id', $id)->get();


        $products = $this->products;

        if(isset($categoriesData) && $categoriesData->count() > 0){

            return true;

        }elseif(isset($products) && $products->count() > 0){


            return true;

        }else{
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function custom_function($category)
    {
//        dd($category);

        $array = null;
        if(!empty($category)){

            $sub_category = Category::find($category);

        }

        return $sub_category;
    }





    function getAllSiblings($children, $child_branch)
    {

        foreach ($children as $child) {
//        dd($child);

            $child_branch['id'] = $child->id;
            $child_branch['name'] = $child->name;

            $category1 = Category::find($child->id);

            $categoryParent = Category::orderBy('created_at', 'asc')->select('parent_id')->where('id', $child->id)->get();


            if(!empty($categoryParent->parent_id)){

                $parent_id = $categoryParent->parent_id;

                $categoryData = Category::orderBy('created_at', 'asc')->select('id', 'name')->where('id', $parent_id)->get();

                if ( $categoryData->first()) {

                    $child_branch['child'] = $category1->getAllSiblings($categoryData);

                }
            }


            $collection = collect($child_branch);
//            dd('$collection 1', $collection);

            return $collection;
        }
    }

}
