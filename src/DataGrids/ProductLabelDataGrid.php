<?php

namespace Webkul\ProductLabelSystem\DataGrids;

use Webkul\Core\Models\Locale;
use Webkul\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;

class ProductLabelDataGrid extends DataGrid
{
    protected $sortOrder = 'desc';

    protected $index = 'id';

    protected $itemsPerPage = 10;

    protected $locale = 'all';

    protected $channel = 'all';

    /** @var string[] contains the keys for which extra filters to render */
    protected $extraFilters = [
        'channels',
        'locales',
    ];

    public function __construct()
    {
        parent::__construct();

        /* locale */
        $this->locale = request()->get('locale') ?? 'all';

        /* channel */
        $this->channel = request()->get('channel') ?? 'all';

        /* finding channel code */
        if ($this->channel !== 'all') {
            $this->channel = Channel::query()->find($this->channel);
            $this->channel = $this->channel ? $this->channel->code : 'all';
        }
    }

    public function prepareQueryBuilder()
    {
        if ($this->channel === 'all') {
            $whereInChannels = Channel::query()->pluck('code')->toArray();
        } else {
            $whereInChannels = [$this->channel];
        }

        if ($this->locale === 'all') {
            $whereInLocales = Locale::query()->pluck('code')->toArray();
        } else {
            $whereInLocales = [$this->locale];
        }

        /* query builder */
        $queryBuilder = DB::table('product_labels');



            // ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
            // ->leftJoin('attribute_families', 'products.attribute_family_id', '=', 'attribute_families.id')
            // ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')

        //$queryBuilder->groupBy('product_flat.product_id', 'product_flat.channel');

        //$queryBuilder->whereIn('product_flat.locale', $whereInLocales);
        //$queryBuilder->whereIn('product_flat.channel', $whereInChannels);
        // $queryBuilder->whereNotNull('product_flat.name');

        // $this->addFilter('image_id', 'image_galleries.id');
        // $this->addFilter('product_name', 'product_flat.name');
        // $this->addFilter('product_sku', 'products.sku');
        // $this->addFilter('status', 'product_flat.status');
        // $this->addFilter('product_type', 'products.type');
        // $this->addFilter('attribute_family', 'attribute_families.name');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('productlabelsystem::app.datagrids.title'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'position',
            'label'      => trans('productlabelsystem::app.datagrids.position'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('productlabelsystem::app.datagrids.status'),
            'type'       => 'boolean',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper'    => function ($value) {
                if ($value->status == 1) {
                    return trans("productlabelsystem::app.datagrids.enabled");
                } else {
                    return trans("productlabelsystem::app.datagrids.disabled");
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'     => trans('productlabelsystem::app.datagrids.edit'),
            'method'    => 'GET',
            'route'     => 'productlabelsystem.admin.productlabel.edit',
            'icon'      => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'        => trans('productlabelsystem::app.datagrids.delete'),
            'method'       => 'POST',
            'route'        => 'productlabelsystem.admin.productlabel.delete',
            'confirm_text' => trans('productlabelsystem::app.datagrids.confirm_text'),
            'icon'         => 'icon trash-icon',
        ]);

        
    }
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('productlabelsystem::app.datagrids.delete'),
            'action' => route('productlabelsystem.admin.productlabel.mass-delete'),
            'method' => 'POST',
        ]);
    }


   
}
