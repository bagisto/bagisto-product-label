<?php

namespace Webkul\ProductLabelSystem\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\ProductLabelSystem\Models\ProductLabel;
use Webkul\ProductLabelSystem\Models\ProductLabelProxy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProductLabelRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\ProductLabelSystem\Models\ProductLabel';
    }

    /**
     * @param  array  $data
     * @return \Webkul\Category\Contracts\Category
     */
    public function create(array $data)
    {
        // Event::dispatch('catalog.category.create.before');

        if (isset($data['locale']) && $data['locale'] == 'all') {
            $model = app()->make($this->model());

            foreach (core()->getAllLocales() as $locale) {
                foreach ($model->translatedAttributes as $attribute) {
                    if (isset($data[$attribute])) {
                        $data[$locale->code][$attribute] = $data[$attribute];
                        $data[$locale->code]['locale_id'] = $locale->id;
                    }
                }
            }
        }
     
        $insertdata = $data;
        unset($data['image']);
        
        $productLabels = $this->model->create($data);
        
        $this->uploadImages($insertdata, $productLabels);

        if (isset($data['attributes'])) {
            $productLabels->filterableAttributes()->sync($data['attributes']);
        }

        // Event::dispatch('catalog.category.create.after', $category);

        return $productLabels;
    }

    /**
     * Specify category tree
     *
     * @param  int  $id
     * @return \Webkul\Category\Contracts\Category
     */
    public function getCategoryTree($id = null)
    {
        return $id
               ? $this->model::orderBy('id', 'ASC')->where('id', '!=', $id)->get()
               : $this->model::orderBy('id', 'ASC')->get();
    }

    

    // public function getCategoryTree($id = null)
    // {
    //     return $id
    //            ? $this->model::orderBy('sort', 'ASC')->where('id', '!=', $id)->get()
    //            : $this->model::orderBy('sort', 'ASC')->get();
    // }

    /**
     * Specify category tree
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryTreeWithoutDescendant($id = null)
    {
        return $id
               ? $this->model::orderBy('sort', 'ASC')->where('id', '!=', $id)->get()
               : $this->model::orderBy('sort', 'ASC')->get();
    }

  
    public function isSlugUnique($id, $slug)
    {   
        $exists = ProductLabelProxy::modelClass()::where('id', '<>', $id)
            ->where('slug', $slug)
            ->limit(1)
            ->select(DB::raw(1))
            ->exists();

        return $exists ? false : true;
    }

  
    public function update(array $data, $id, $attribute = "id")
    {
        $category = $this->find($id);
        $value = $data;
        unset($data['image']);
        
        $category->update($data);

        if(array_key_exists("image",$value) && !$value['image']['image_0'] == "")
        {
            $this->uploadImages($value, $category);
        }
        

        if (isset($data['attributes'])) {
            $category->filterableAttributes()->sync($data['attributes']);
        }

        

        return $category;
    }

  
    public function uploadImages($data, $imagegallery, $type = "image")
    {
        
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                
                $file = $type . '.' . $imageId;
                $dir = 'productlabel/' . $imagegallery->id;

                if ($request->hasFile($file)) {
                    if ($imagegallery->{$type}) {
                        Storage::delete($imagegallery->{$type});
                    }

                    $imagegallery->{$type} = $request->file($file)->store($dir);
                    $imagegallery->save();
                }
            }
        } else {
            if ($imagegallery->{$type}) {
                Storage::delete($imagegallery->{$type});
            }

            $imagegallery->{$type} = null;
            $imagegallery->save();
        }
    }

  
    function getData($id)
    {
        return $this->model::where('id', $id)->get('*');
    }

    
}