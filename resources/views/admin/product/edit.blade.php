@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit Product
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @if($errors->has('model') )
            <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>Edit Product</h3>
                    </div>
                </div>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(isset($product))
                <div class="panel-body">
                    <div class="col-md-6 col-xs-12">
                        <h4>Update Product</h4>
                        @if(isset($product->id))

                            {!! Form::model($product, [ 'url' => URL::route('products.update', ['id' => $product->id])] )  !!}
                            {{ Form::hidden('_method', 'PUT') }}
                            <meta name="_token" content="{!! csrf_token() !!}" />

                            <!-- Category name text field -->
                            <div class="form-group">
                                {!! Form::label('Category name',!isset($product->category_id) ? "Login first: " : "Category: ") !!}
                                {!! Form::select('category_id', $category, null, ['class' => 'form-control category_id']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('category_id') !!}</span>

                            <!-- Product name text field -->
                            <div class="form-group">
                                {!! Form::label('name','product: *') !!}
                                {!! Form::text('name', $product->name, ['class' => 'form-control name', 'placeholder' => 'Product name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('name') !!}</span>

                            <!-- weight text field -->
                            <div class="form-group">
                                {!! Form::label('Weight',!isset($product->id) ? "Weight: " : "Weight: ") !!}
                                {!! Form::text('weight', $product->min_size, ['class' => 'form-control weight', 'placeholder' => 'Weight', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('weight') !!}</span>

                            <!-- flavor text field -->
                            <div class="form-group">
                                {!! Form::label('Flavor',!isset($product->id) ? "Flavor: " : "Flavor: ") !!}
                                @if(isset($flavours))

                                    @if(isset($flavours) && isset($selectedFlavor))
                                        <select name="flavor" id="flavor" class="form-control flavor">
                                            @foreach ($flavours as $flavour)
                                                @if($flavour->id == $selectedFlavor)
                                                    <option selected value="{{ $flavour->id }}">{{ $flavour->name }}</option>
                                                @else
                                                    <option value="{{ $flavour->id }}">{{ $flavour->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                    {!! Form::select('flavor', $flavours, null, ['class' => 'form-control flavor']) !!}
                                    @endif

                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('flavor') !!}</span>

                            <!-- price text field -->
                            <div class="form-group">
                                {!! Form::label('price',!isset($product->id) ? "price: " : "price: ") !!}
                                {!! Form::text('price', $product->price, ['class' => 'form-control price', 'placeholder' => 'price', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('price') !!}</span>

                            <!-- Active or not feild text field -->
                            @if(isset($active))
                                <div class="form-group">
                                    {!! Form::label('active', "Active: ") !!}
                                    {!! Form::select('active',  $active, null,  ['class' => 'form-control']) !!}

                                </div>
                                <span class="text-danger">{!! $errors->first('active') !!}</span>
                            @else
                                <div class="form-group">
                                    {!! Form::label('active', "Active: ") !!}
                                    {!! Form::select('active',  [1=>'Active', 0=>'Not'], null,  ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{!! $errors->first('active') !!}</span>
                            @endif
                            <!-- min agetext field -->
                            <div class="form-group">
                                {!! Form::label('min_age',!isset($product->id) ? "min_age: " : "min_age: ") !!}
                                {!! Form::text('min_age', $product->min_age, ['class' => 'form-control min_age', 'placeholder' => 'min_age', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('min_age') !!}</span>

                            <!-- max age text field -->
                            <div class="form-group">
                                {!! Form::label('max_age',!isset($product->id) ? "max_age: " : "max_age: ") !!}
                                {!! Form::text('max_age', $product->max_age, ['class' => 'form-control max_age', 'placeholder' => 'max_age', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('max_age') !!}</span>

                            <!-- Tag text field -->
                            <div class="form-group">
                                {!! Form::label('tag',!isset($product->id) ? "tag: " : "tag: ") !!}
                                {!! Form::text('tag', $product->tag, ['class' => 'form-control tag', 'placeholder' => 'tag', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('tag') !!}</span>

                            <!-- image field -->
                            <div class="form-group">
                                {!! Form::label('Image',!isset($product->id) ? "Main image: " : "Image path: ") !!}
                                <br>
                                @if(isset($product->image))
                                    {{--Remove old image--}}
        {{--                            {{ Form::hidden('invisible', $product->id, array('id' => 'p_invisible_id')) }}--}}
                                    {{ Form::hidden('invisible', $product->image, array('id' => 'p_invisible_image')) }}
                                    {{ Form::image(url('assets/images/usersImages/product/'.$product->image), 'p_old_image', array("class"=>"p_old_image", "style" => "width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                    {{--<a href="javascript:void(0);" class="p_delete_image_button" aria-label="Delete"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>--}}
                                    <br><br>
                                    {!! Form::file('image', ['id' =>'fileinput']) !!}
                                @else
                                    {!! Form::file('image', ['id' =>'fileinput']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('image') !!}</span>

                            {!! Form::hidden('id') !!}
                            {!! Form::hidden('form_name','product_updation') !!}
                            {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                            {!! Form::close() !!}

                            {{--Form for delete request--}}
                            {!! Form::model($product, [ 'url' => URL::route('products.destroy', ['id' => $product->id])] )  !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {!! Form::submit('Delete', array("class"=>"btn btn-danger pull-right delete", "style"=>"margin-right:10px")) !!}
                            {!! Form::close() !!}

                        @endif
                    </div>
                </div>
            @endif
      </div>
</div>
@stop

@section('footer_scripts')
<script>




    (function($) {


        $('#fileinput').on('change', function (event, files, label) {
            var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '')
            console.log(file_name);

//            http://localhost:8000/assets/images/usersImages/product/4126b46bb8717d16dd1a0ffc20453b91.png

            image = 'images/'+file_name ;
//            console.log(image)

            $('.p_old_image').attr('src', '{{env('APP_URL')}}'+'assets/images/staticImage/'+file_name);

            $('.invisible_image_feild').val(file_name);
        });


    })(jQuery);

    $(".delete").click(function(){
        return confirm("Are you sure to delete this item?");
    });


    window.reset = function (e) {

        console.log("function is called");
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }

</script>
@stop