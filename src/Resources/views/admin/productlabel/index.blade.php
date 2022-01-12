@extends('admin::layouts.content')

@section('page_title')
    {{ __('productlabelsystem::app.productlabel.page_title_bar') }}
@stop

@section('content')
    <div class="content" style="height: 100%;">
        <?php $locale = request()->get('locale') ?: null; ?>
        <?php $channel = request()->get('channel') ?: null; ?>
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('productlabelsystem::app.productlabel.page_title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('productlabelsystem.admin.productlabel.create') }}" class="btn btn-lg btn-primary">
                    {{ __('productlabelsystem::app.productlabel.add-product-btn-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('products', 'Webkul\ProductLabelSystem\DataGrids\ProductLabelDataGrid')
            {!! $products->render() !!}
        </div>
        
    </div>
@stop

@push('scripts')
    
    <script>

        function reloadPage(getVar, getVal) {
            let url = new URL(window.location.href);
            url.searchParams.set(getVar, getVal);

            window.location.href = url.href;
        }

    </script>
@endpush