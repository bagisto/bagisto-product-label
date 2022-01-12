<?php

namespace Webkul\ProductLabelSystem\Repositories;

use Elasticsearch\Endpoints\Snapshot\Status;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\ProductLabelSystem\Repositories\ProductLabelRepository;

class ProductLabelImageRepository extends Repository
{
    public function model()
    {
        return 'Webkul\ProductLabelSystem\Models\ProductLabelImage';
    }

    public function getProductsLabel($id)
    {
        $labelData = null;
        
        if( $this->model::where('product_id', $id)->exists())
        {
        
        $labelId= $this->model::where('product_id', $id)->get('custom_label_id');
        
        $labelData = app(ProductLabelRepository::class)->getData($labelId[0]->custom_label_id);
        
        return $labelData;
        }
        else{
        
        
        return $labelData;
        }
    }

    public function getProductsUrl($id)
    {
       
        $labelId= $this->model::where('product_url_key', $id)->get('custom_label_id');
        $labelData = app(ProductLabelRepository::class)->getData($labelId[0]->custom_label_id);
        
        return $labelData[0];
    }

    public function getProductsLabelId($id)
    {
        
        $labelId= $this->model::where('product_id', $id)->get('custom_label_id');
        $labelData = null;
        
        foreach($labelId as $labelid)
        {
            $labelData = app(ProductLabelRepository::class)->getData($labelid->custom_label_id);
        }
        if($labelData == null){
            return null;
        }
        else{
            return $labelData[0]->id;
        }
    }


    function getAllProductsLabel(){
        $labelData = $this->model::orderBy('id', 'ASC')->get();
        
        $arrayVariable = []; 
            foreach($labelData as $key =>$labelId)
            {
            $labelShow = app(ProductLabelRepository::class)->getData($labelId->custom_label_id);
            $arrayVariable[$key] = array(
                'product_id' => $labelId->product_id,
                'product_url_key' => $labelId->product_url_key,
                'image' => $labelShow[0]->image,
                'title' => $labelShow[0]->title,
                'position' => $labelShow[0]->position,
                
            );
            }
        
        
        return $arrayVariable;
    }

}