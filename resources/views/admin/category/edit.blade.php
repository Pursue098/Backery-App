@extends('laravel-authentication-acl::admin.layouts.base-2cols')

@section('title')
Admin area: edit category
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- successful message --}}
        <?php $message = Session::get('message'); ?>
        @if( isset($message) )
        <div class="alert alert-success">{!! $message !!}</div>
        @endif
        @if($errors->has('model') )
            <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i>Edit Category</h3>
                    </div>
                </div>
            </div>
            <div class="custom_message">
            </div>
            @if (Session::has('categoryError'))
                <div class="alert alert-danger">{{ Session::get('categoryError') }}</div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger custom_message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(isset($category))
                <div class="panel-body">
                    <div class="col-md-6 col-xs-12">
                        <h4>Update Category</h4>
                        @if(isset($category->id))
        {{--                    {!! Form::model($category, [ 'url' => URL::route('categories.update', ['id' => $category->id])] )  !!}--}}
                            {!! Form::open(array('route' => array('categories.update', $category->id), 'class' => 'ajax', 'method' => 'PATCH', 'files'=>true), ['files'=>true]) !!}

                            {{ Form::hidden('_method', 'PATCH') }}

                            {{ Form::hidden('invisible_id', $category->id, array('id' => 'invisible_id_feild')) }}

                        <!-- Category text field -->
                            <div class="form-group">
                                {!! Form::label('Category name','Category: *') !!}
                                {!! Form::text('name', $category->name, ['class' => 'form-control name', 'placeholder' => 'Category name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('name') !!}</span>

                            <!-- Description text field -->
                            <div class="form-group">
                                {!! Form::label('description', "Description: ") !!}
                                {!! Form::text('description', $category->description, ['class' => 'form-control description', 'placeholder' => 'Description here', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('description') !!}</span>

                            <!-- parent ID text field -->
                            <div class="form-group">
                                {!! Form::label('parent_id', "parent id: ") !!}
{{--                                {!! Form::select('parent_id', $categories, null, ['class' => 'form-control parent_id']) !!}--}}
                                @if(isset($categoryParentData) && isset($categoryChildData) && isset($parentCategoryId))
                                    <select name="parent_id" id="parent_id" class="form-control parent_id">
                                        <option>Select Category</option>
                                        <optgroup label="Parent Categories" >
                                            @foreach ($categoryParentData as $parentCat)
                                                @if($parentCat['id'] == $parentCategoryId)
                                                    <option selected value="{{ $parentCat['id'] }}">{{ $parentCat['name'] }}</option>
                                                @else
                                                    <option value="{{ $parentCat['id'] }}">{{ $parentCat['name'] }}</option>
                                                @endif
                                            @endforeach
                                            <option value="NULL">None</option>
                                        </optgroup>
                                        <optgroup label="Child Categories">
                                            @foreach ($categoryChildData as $childCat)
                                                @if($childCat['id'] == $parentCategoryId)
                                                    <option selected value="{{ $childCat['id'] }}">{{ $childCat['name'] }}</option>
                                                @else
                                                    <option value="{{ $childCat['id'] }}">{{ $childCat['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('parent_id') !!}</span>

                            <!-- Active or not feild text field -->
                            @if(isset($activeField))
                                <div class="form-group ">
                                    {!! Form::label('active', "Active: ") !!}
                                    {{--{!! Form::select('active',  $active, null,  ['class' => 'form-control']) !!}--}}

                                    @if(isset($activeField) && isset($activeSlected))
                                        <select name="active" id="active" class="form-control active">
                                            @foreach ($activeField as $active)
                                                @if($active['key'] == $activeSlected)
                                                    <option selected value="{{ $active['key'] }}">{{ $active['value'] }}</option>
                                                @else
                                                    <option value="{{ $active['key'] }}">{{ $active['value'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <span class="text-danger">{!! $errors->first('active') !!}</span>
                            @endif

                            <!-- image text field -->
                            <div class="form-group">
                                {!! Form::label('Image',!isset($category->image) ? "Image: " : "Image: ") !!}
                                <br>

                                @if(isset($category->image))
                                    {{--Remove old image--}}
                                    {{ Form::hidden('invisible_image', $category->image, array('id' => 'invisible_image_feild')) }}
                                    {{ Form::image(url('assets/images/usersImages/category/'.$category->image), 'old_image', array("class"=>"old_image", "style" => " width: 50px; height: 50px; margin-left:20px; border: 1px solid black;")) }}
                                    <a href="javascript:void(0);" class="delete_image_button" aria-label="Delete"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                                    <br><br>

                                    {!! Form::file('image', ['id'=>'fileinput']) !!}
                                @else
                                    {!! Form::file('image', ['id'=>'fileinput']) !!}
                                @endif
                            </div>
                            <span class="text-danger">{!! $errors->first('image') !!}</span>

                            {!! Form::hidden('id') !!}
                            {!! Form::hidden('form_name','category') !!}
                            {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                            {!! Form::close() !!}

                            {{--Form for delete request--}}
                            {!! Form::model($category, [ 'url' => URL::route('categories.destroy', ['id' => $category->id])] )  !!}
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
    <script type="text/javascript">


        $(document).ready(function() {
            $('form.ajax').on('submit', function(event) {
                event.preventDefault();

                var fileinput= $("#fileinput").val();
                if(fileinput){
                    var file_name = fileinput.replace(/\\/g, '/').replace(/.*\//, '')
                }


                var name, description, parent_id, active, category_id, invisible_image_feild, image_name;
                var formData = $(this).serialize();
                var formAction = $(this).attr('action');
                var formMethod = $(this).attr('method');

                if($('.name').val()){
                    name = $('.name').val();
                }
                if($('.description').val()){
                    description = $('.description').val();

                }
                if($('.parent_id').val()){
                    parent_id = $('.parent_id').val();

                }
                if($('#active').val()){
                    active = $('#active').val();

                }
                if($('#invisible_id_feild').val()){
                    category_id = $('#invisible_id_feild').val();

                }
                if($('#invisible_image_feild').val()){
                    invisible_image_feild = $('#invisible_image_feild').val();

                }else{
                    invisible_image_feild = null;
                }
                image_name = file_name;

                var data = {
                    id: category_id,
                    name: name,
                    description: description,
                    parent_id: parent_id,
                    active: active,
                    image: image_name,
                    invisible_image_feild: invisible_image_feild
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                    }
                });

                $.ajax({
                    type  : 'PATCH',
                    url   : formAction,
                    data  : data,
                    cache : false,
                    success : function(data, textStatus) {
                        if(data.status == 'success'){

//                        $('.old_image').remove();
//                        $('.delete_image_button').remove();
                            $('#invisible_image_feild').remove();
                            $('#invisible_id_feild').remove();
                            $('#invisible_id').val('');

                            window.location.replace('{{env('APP_URL')}}'+'admin/categories');
                        } else if(data.status == 'failed'){
                            console.log('failed');

                            $( ".custom_message" ).after( '<div class="alert alert-danger">Please provide category image</div>' );

                        }
                    },
                    error : function(data) {

                        window.location = '{{ env('APP_URL') }}'+'admin/categories/'+category_id+'/edit';
                    }
                });

                return false;
            });
        });

        (function($) {

            $('.delete_image_button').click(function() {

                var confirmation = confirm("Are you sure to delete this item?");

                if(confirmation == true){

                    $('.old_image').remove();
                    $('.delete_image_button').remove();
                    $('#invisible_image_feild').remove();

                    return;
                }
                return;

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