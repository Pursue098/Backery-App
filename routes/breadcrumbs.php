<?php


// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('categories.index'));
});

Breadcrumbs::register('parent1', function($breadcrumbs, $category)
{
    if (isset($category)){

        $breadcrumbs->push($category, route('categories.listSubCategories', $category));

//        $breadcrumbs->parent('parent2', $category);

    } else{

        $breadcrumbs->parent('home');
    }
//    $breadcrumbs->push($category[0]->name, route('categories.listSubCategories', $category[0]->id));
});


Breadcrumbs::register('listSubCategories', function($breadcrumbs, $category, $name=null) {

    if (isset($category[0]->parent_id)){

        $breadcrumbs->parent('listSubCategories', $category[0]->parent_id, $category[0]->name);

    } else{

        $breadcrumbs->parent('home');
    }

    if(isset($name)){
        $breadcrumbs->push($name, route('categories.listSubCategories', $category));

    } else{
        $breadcrumbs->push($category[0]->name, route('categories.listSubCategories', $category[0]->id));

    }
});
