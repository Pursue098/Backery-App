
<h3 class="bariol-thin"><i class="fa fa-search"></i> Search Order</h3>
{!! Form::model('order', [ 'url' => URL::route('products.search')])  !!}
{{ Form::hidden('_method', 'POST') }}

<div class="form-group row">
    {!! Form::label('order_no','Search By: ', ['class'=>"col-xs-2 col-form-label", 'for'=>"text-input-product"]) !!}
    <div class="col-xs-7">
        {!! Form::text('admin_order_search', null, ['style'=>'border:1px solid gray;border-radius: 0;', 'class' => 'form-control', 'id' => 'text-input-product', 'placeholder' => 'Order no or Category name or Product name']) !!}
    </div>
</div>
<span class="text-danger">{!! $errors->first('order_no') !!}</span>

<a href="{!! URL::route('products.index') !!}" class="btn btn-default search-reset" style='margin-left: 17%; border-radius: 0'>All products</a>
{!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit", 'style'=>'border-radius: 0; margin-left:8px;']) !!}

{!! Form::close() !!}
