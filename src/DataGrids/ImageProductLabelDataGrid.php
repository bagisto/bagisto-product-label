<?php

namespace Webkul\ProductLabelSystem\DataGrids;

use Webkul\Core\Models\Locale;
use Webkul\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;

class ImageProductLabelDataGrid extends DataGrid
{
    protected $sortOrder = 'desc';

    protected $index = 'id';


    public function __construct()
    {
        parent::__construct();
    }

    public function prepareQueryBuilder()
    {
        
        /* query builder */
        $queryBuilder = DB::table('product_labels')->where("status", 1)->where("image", '!=', '');



     

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {

        $this->addColumn([
            'index'      => 'image',
            'label'      => trans('productlabelsystem::app.product_edit_datagrids.image_title'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'  => true,
            'wrapper' => function($row) {
                return '<img src="' . asset('storage/'. $row->image) . '" class="imagelabel">';
                }
            
        ]);

        $this->addColumn([
            'index'      => 'position',
            'label'      => trans('productlabelsystem::app.product_edit_datagrids.position'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('productlabelsystem::app.product_edit_datagrids.select'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'  => true,
            'wrapper' => function($row) {                
                return '<span><input type="radio" name="custom_label_id" value="'. $row->id .'" class="gridradio"></span>';
            }
        ]);
    }


   
}