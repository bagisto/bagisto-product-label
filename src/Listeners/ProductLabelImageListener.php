<?php

namespace Webkul\ProductLabelSystem\Listeners;

use Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository;
use Webkul\ProductLabelSystem\Repositories\ProductLabelRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;


class ProductLabelImageListener
{

    protected $productLabelImageRepository;
    
    protected $productLabelRepository;

    public function __construct(
        ProductLabelImageRepository $productLabelImageRepository,
        ProductLabelRepository $productLabelRepository
        
    )
    {
        $this->productLabelImageRepository = $productLabelImageRepository;
        $this->productLabelRepository = $productLabelRepository;
    }

    public function afterProductCreatedUpdated($product)
    {
        $this->validate(request(), [
            'custom_label_id' => 'required'
        ]);
        $data = request()->all();

        $findProductLabel = $this->productLabelImageRepository->findOneWhere(['product_id'=>$product->id]);
        if($findProductLabel)
        {
            $this->updateProductLabel($product,$data);
        }
        else
        {
            $this->createProductLabel($product,$data);
        }
    }

    function createProductLabel($product,$data){

        $this->validate(request(), [
            'custom_label_id' => 'required'
        ]);

        $this->productLabelImageRepository->create([
            'product_id' => $product->id,
            'product_url_key' => $product->url_key,
            'custom_label_id' => $data['custom_label_id'],
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }

    function updateProductLabel($product,$data){
        $this->validate(request(), [
            'custom_label_id' => 'required'
        ]);
        $this->productLabelImageRepository->where('product_id', $product->id)->update([
            'product_id' => $product->id,
            'custom_label_id' => $data['custom_label_id'],
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }



    function editFormProduct($product)
    {
        $customLabelIds = $this->productLabelImageRepository->get();
        return $customLabelIds;
    }

    function getLabel($product)
    {
        dd($product);
    }
}