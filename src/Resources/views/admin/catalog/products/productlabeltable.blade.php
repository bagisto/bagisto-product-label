@section('css')
    <style>
     .datagrid-filters{
         display: none;
     }
     .imagelabel{
         width: 60px;
         height: 60px;
     }
     th,td{
         text-align: center;
     }
    </style>
@stop

    {!! app('Webkul\ProductLabelSystem\DataGrids\ImageProductLabelDataGrid')->render() !!}
    
    <div class="control-group">
        <input type="text" readonly id="custom_label_id_input" name="custom_label_id_input" value="{{ old('custom_label_id_input') }}" data-vv-as="&quot;{{ __('productlabelsystem::app.product_edit.product_label_image') }}&quot;" v-slugify-target="'slug'" style="display: none;" />
    </div>
    
@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>


    <script>
        $(document).ready(function(){
          
            var slide = $(".gridradio");

            var img_idradios =  
                <?php echo json_encode(app('Webkul\ProductLabelSystem\Repositories\ProductLabelImageRepository')->getProductsLabelId($product->id)); ?>;
            
            if (img_idradios.length !=0)
            { 
            for (var i=0;i<slide.length;i++) {
                if(slide.eq(i).attr("value") == img_idradios){
                    slide.eq(i).prop('checked', true);
                }
            }
            } 
        });
        

        $(document).ready(function(){    
            $(".gridradio").click(function() {
                $("#custom_label_id_input").val("not null");
            });
        });

        
    </script>
    @endpush