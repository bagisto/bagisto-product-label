<?php

namespace Webkul\ProductLabelSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\ProductLabelSystem\Models\ProductLabelProxy;
use Webkul\ProductLabelSystem\Contracts\ProductLabel as ProductLabelContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webkul\ProductLabelSystem\Repositories\ProductLabelRepository;

class ProductLabel extends Model implements ProductLabelContract
{
    protected $fillable = [
        'title',
        'image',
        'status',
        'position',
    ];
}