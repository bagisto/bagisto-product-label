@extends('admin::layouts.content')

@section('page_title')
    {{ __('productlabelsystem::app.editform.page_title_bar') }}
@stop


@section('content')
    <div class="content">
        <?php $locale = request()->get('locale') ?: app()->getLocale(); ?>

        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('productlabelsystem::app.editform.page_title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('productlabelsystem::app.editform.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <input name="_method" type="hidden" value="PUT">

                    <!-- {!! view_render_event('bagisto.admin.catalog.category.edit_form_accordian.general.before', ['category' => $category]) !!} -->

                    <accordian :title="'{{ __('productlabelsystem::app.editform.label_information') }}'" :active="true">
                        <div slot="body">

                            <!-- {!! view_render_event('bagisto.admin.catalog.category.edit_form_accordian.general.controls.before', ['category' => $category]) !!} -->

                            <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                                <label for="title" class="required">{{ __('productlabelsystem::app.editform.title') }}</label>
                                <input type="text" v-validate="'required'" class="control" id="title" name="title" value="{{ old('title') ?: $category->title }}" data-vv-as="&quot;{{ __('productlabelsystem::app.editform.title') }}&quot;"/>
                                <div>Don't use space</div>
                                <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                            </div>

                            <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                                <label>{{ __('productlabelsystem::app.editform.upload_image') }}</label>
                                      
                            
                                <image-wrapper 
                                :button-label="'{{ __('productlabelsystem::app.editform.add_image') }}'" 
                                input-name="image" :multiple="false" :images='"{{ asset("storage/$category->image") }}"'>
                                </image-wrapper>
                                
                                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                    @foreach ($errors->get('image.*') as $key => $message)
                                        @php echo str_replace($key, 'Image', $message[0]); @endphp
                                    @endforeach
                                </span>

                            </div>

                            <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                                <label for="status" class="required">{{ __('productlabelsystem::app.editform.status') }}</label>
                                <select class="control" v-validate="'required'" id="status" name="status" data-vv-as="&quot;{{ __('productlabelsystem::app.editform.status') }}&quot;">
                                    <option value="1" {{ $category->status ? 'selected' : '' }}>
                                        {{ __('productlabelsystem::app.editform.enabled') }}
                                    </option>
                                    <option value="0" {{ $category->status ? '' : 'selected' }}>
                                        {{ __('productlabelsystem::app.editform.disabled') }}
                                    </option>
                                </select>
                                <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                            </div>
                            
                            <div class="control-group" :class="[errors.has('position') ? 'has-error' : '']">
                                <label for="position" class="required">{{ __('productlabelsystem::app.editform.position') }}</label>
                                <select class="control" v-validate="'required'" id="position" name="position" data-vv-as="&quot;{{ __('productlabelsystem::app.editform.position') }}&quot;">
                                    <option value={{ __("productlabelsystem::app.editform.top-left") }} {{ $category->position == __("productlabelsystem::app.editform.top-left") ? 'selected':''}} >
                                    {{ __("productlabelsystem::app.editform.top-left") }}
                                    </option>
                                    <option value={{ __("productlabelsystem::app.editform.top-right") }} {{ $category->position == __("productlabelsystem::app.editform.top-right") ? 'selected':''}} >
                                    {{ __("productlabelsystem::app.editform.top-right") }}
                                    </option>
                                    <option value={{ __("productlabelsystem::app.editform.bottom-left") }} {{ $category->position == __("productlabelsystem::app.editform.bottom-left") ? 'selected':''}} >
                                    {{ __("productlabelsystem::app.editform.bottom-left") }}
                                    </option>
                                    <option value={{ __("productlabelsystem::app.editform.bottom-right") }} {{ $category->position == __("productlabelsystem::app.editform.bottom-right") ? 'selected':''}} >
                                    {{ __("productlabelsystem::app.editform.bottom-right") }}
                                    </option>
                                    <option value={{ __("productlabelsystem::app.editform.none") }} {{ $category->position == __("productlabelsystem::app.editform.none") ? 'selected':''}} >
                                    {{ __("productlabelsystem::app.editform.none") }}
                                    </option>
                                </select>
                                <span class="control-error" v-if="errors.has('position')">@{{ errors.first('position') }}</span>
                            </div>

                            <!-- {!! view_render_event('bagisto.admin.catalog.category.edit_form_accordian.general.controls.after', ['category' => $category]) !!} -->

                        </div>
                    </accordian>

                    <!-- {!! view_render_event('bagisto.admin.catalog.category.edit_form_accordian.general.after', ['category' => $category]) !!} -->

                </div>
            </div>

        </form>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea#description',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true
            });
        });

        Vue.component('description', {

            template: '#description-template',

            inject: ['$validator'],

            data: function() {
                return {
                    isRequired: true,
                }
            },

            created: function () {
                var this_this = this;

                $(document).ready(function () {
                    $('#display_mode').on('change', function (e) {
                        if ($('#display_mode').val() != 'products_only') {
                            this_this.isRequired = true;
                        } else {
                            this_this.isRequired = false;
                        }
                    })

                    if ($('#display_mode').val() != 'products_only') {
                        this_this.isRequired = true;
                    } else {
                        this_this.isRequired = false;
                    }
                });
            }
        })
    </script>
@endpush