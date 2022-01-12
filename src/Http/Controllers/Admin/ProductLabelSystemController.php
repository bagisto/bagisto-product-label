<?php

namespace Webkul\ProductLabelSystem\Http\Controllers\Admin;

use Illuminate\Support\Facades\Event;
use Webkul\ProductLabelSystem\Repositories\ProductLabelRepository;
use Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository;

class ProductLabelSystemController extends Controller
{    
    /**
     * Contain route related configuration
     *
     * @var array
     */
    protected $_config;

    protected $productLabelRepository;

    protected $productLabelImageRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductLabelImageRepository $productLabelImageRepository,
        ProductLabelRepository $productLabelRepository
    )
    {
        $this->productLabelRepository = $productLabelRepository;

        $this->_config = request('_config');

        $this->middleware('admin');

        $this->productLabelImageRepository = $productLabelImageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productLabels = $this->productLabelRepository->getCategoryTree(null, ['id']);

        return view($this->_config['view'], compact('productLabels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|unique:product_labels,title',
            'image.*'    => 'required|mimes:jpeg,bmp,png,jpg',
        ]);
        
        $productLabel = $this->productLabelRepository->create(request()->all());
        session()->flash('success', trans('productlabelsystem::app.response.create-success', ['name' => 'ProductLabel']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->productLabelRepository->findOrFail($id);        

        return view($this->_config['view'], compact('category'));
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = request()->all();

        if(array_key_exists("image",$data))
        {
            if(!$data['image']['image_0'] == "")
            {
                $this->validate(request(), [
                    'title' => ['required', 'unique:product_labels,title,' . $id, new \Webkul\Core\Contracts\Validations\Code],
                    'image.*'    => 'required|mimes:jpeg,bmp,png,jpg'
                ]);
            }

            if($data['image']['image_0'] == "")
            {
                $this->validate(request(), [
                    'title' => ['required', 'unique:product_labels,title,' . $id, new \Webkul\Core\Contracts\Validations\Code],
                ]);
            }
        }
        else{
            $this->validate(request(), [
                'title' => ['required', 'unique:product_labels,title,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            ]);

        }
        
        
        
        $locale = request()->get('locale') ?: app()->getLocale();
        
        $this->productLabelRepository->update($data, $id);

        session()->flash('success', trans('productlabelsystem::app.response.update-success', ['name' => 'ProductLabel']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productlabel = $this->productLabelRepository->findorFail($id);

        try {
                $this->productLabelRepository->delete($id);

            session()->flash('success', trans('productlabelsystem::app.response.delete-success', ['name' => 'ProductLabel']));
            return response()->json(['message' => true], 200);
        } catch (\Exception $e) {

            session()->flash('error', trans('productlabelsystem::app.response.delete-failed', ['name' => 'ProductLabel']));
        }

        return response()->json(['message' => false], 400);
    }

    public function massDestroy()
    {
        $productlabelIds = explode(',', request()->input('indexes'));

            foreach ($productlabelIds as $productlabelId) {
                $this->productLabelRepository->deleteWhere(['id' => $productlabelId]);
            }

            session()->flash('success', trans('productlabelsystem::app.response.mass-destroy-success'));
            return redirect()->back();
    }
    public function afterProductCreatedValidate()
    {
        // $this->validate(request(), [
        //     'custom_label_id' => 'required'
        // ]);
    }

    public function afterProductCreatedUpdated($product)
    {
        
        $data = request()->all();

       
        
        if (array_key_exists("custom_label_id",$data))
        {
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
    }

    function createProductLabel($product,$data){

        $this->productLabelImageRepository->create([
            'product_id' => $product->id,
            'product_url_key' => $product->url_key,
            'custom_label_id' => $data['custom_label_id'],
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);
    }

    function updateProductLabel($product,$data){
        
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
