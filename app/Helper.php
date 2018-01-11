<?php

function getModelList($modelName,$filters=[],$skip=0,$length=0,$orderDataBy=[]){

    $model    = new $modelName;

    if(empty($filters))
        $modelQuery = $model::all(); 
    else
        $modelQuery = $model::where($filters); 

     foreach ($orderDataBy as $columnName => $orderBy) {
        $modelQuery->orderBy($columnName,$orderBy);
    }

    if($length>1)
    {  
        $listCount = $modelQuery->get()->count(); 
        $list    = $modelQuery->skip($skip)->take($length)->get();   
    }
    else
    {
        $list    = (empty($filters))? $modelQuery :$modelQuery->get();  
        $listCount = $list->count();  
    }

    return ['listCount' =>$listCount,'list'=>$list ];

}