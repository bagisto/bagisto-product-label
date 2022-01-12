@extends('admin::layouts.content')

@section('page_title')
    {{ __('productlabelsystem::app.form.page_title_bar') }}
@stop

@section('css')
    <style>
        
    </style>
@stop

@section('content')
    <div class="content">
        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('productlabelsystem::app.form.page_title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('productlabelsystem::app.productlabel.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                @csrf()
                

                <accordian :title="'{{ __('productlabelsystem::app.productlabel.label_information') }}'" :active="true">
                    <div slot="body">
                        <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                            <label for="title" class="required">{{ __('productlabelsystem::app.form.title') }}</label>
                            <input type="text" v-validate="'required'" class="control" id="title" name="title" value="{{ old('title') }}" data-vv-as="&quot;{{ __('productlabelsystem::app.form.title') }}&quot;" v-slugify-target="'slug'"/>
                            <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                        </div>
                        <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                            <label>{{ __('productlabelsystem::app.form.upload_image') }}</label>
                            <image-wrapper 
                            :button-label="'{{ __('productlabelsystem::app.form.add_image') }}'" 
                                input-name="image" :multiple="false"></image-wrapper>
                            <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                @foreach ($errors->get('image.*') as $key => $message)
                                    @php echo str_replace($key, 'Image', $message[0]); @endphp
                                @endforeach
                            </span>
                        </div>                               
                        <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                            <label for="status" class="required">{{ __('productlabelsystem::app.form.status') }}</label>
                            <select class="control" v-validate="'required'" id="status" name="status" data-vv-as="&quot;{{ __('productlabelsystem::app.form.status') }}&quot;">
                                <option value="1">
                                    {{ __('productlabelsystem::app.form.enabled') }}
                                </option>
                                <option value="0">
                                    {{ __('productlabelsystem::app.form.disabled') }}
                                </option>
                            </select>
                            <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                        </div>
                        <div class="control-group" :class="[errors.has('position') ? 'has-error' : '']">
                            <label for="position" class="required">{{ __('productlabelsystem::app.form.position') }}</label>
                            <select class="control" v-validate="'required'" id="position" name="position" data-vv-as="&quot;{{ __('productlabelsystem::app.form.position') }}&quot;">
                                <option value={{ __("productlabelsystem::app.form.top-left") }}>
                                    {{ __('productlabelsystem::app.form.top-left') }}
                                </option>
                                <option value={{ __('productlabelsystem::app.form.top-right') }}>
                                    {{ __('productlabelsystem::app.form.top-right') }}
                                </option>
                                <option value={{ __('productlabelsystem::app.form.bottom-left') }}>
                                    {{ __('productlabelsystem::app.form.bottom-left') }}
                                </option>
                                <option value={{ __('productlabelsystem::app.form.bottom-right') }}>
                                    {{ __('productlabelsystem::app.form.bottom-right') }}
                                </option>
                                <option value={{ __('productlabelsystem::app.form.none') }}>
                                    {{ __('productlabelsystem::app.form.none') }}
                                </option>
                            </select>
                            <span class="control-error" v-if="errors.has('position')">@{{ errors.first('position') }}</span>
                        </div>
                       
                        
                    </div>
                </accordian>

            </div>

        </form>
    </div>
@stop

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.label .cross-icon').on('click', function(e) {
                $(e.target).parent().remove();
            })

            $('.actions .trash-icon').on('click', function(e) {
                $(e.target).parents('tr').remove();
            })
        });
    </script>
@endpush