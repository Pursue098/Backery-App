
<div class="panel panel-info">
    <div class="panel-heading">
        <p> Configuration Section</p>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                @if(! $branchName->isEmpty() && ! $branchCode->isEmpty())

                    {!! Form::model($branchCode, [ 'url' => URL::route('configuration.update', ['id' => $branchCode[0]->id])] )  !!}
                    {{ Form::hidden('_method', 'PUT') }}
                    <!-- Branch's name text field -->
                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::label('value','Branch name: *', ['style' => 'font-size: 13px; margin-left: 2px;']) !!}
                                {!! Form::text('value', $branchName[0]->value, ['class' => 'form-control', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('name') !!}</span>
                        </div>

                        <!-- Branch's code text field -->
                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::label('value','Branch code: *', ['style' => 'font-size: 13px; margin-left: 2px;']) !!}
                                {!! Form::text('key', $branchCode[0]->value, ['class' => 'form-control', 'placeholder' => 'Branch code', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('code') !!}</span>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::hidden('id') !!}
                                {!! Form::hidden('form_name','config_update') !!}
                                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    @else
                        <span class="text-warning"><h5>Nothing to show in configurationn section.</h5></span>
                    @endif
                </div>
                <div class="col-md-6">
                    @if(! $remarksLimitKey->isEmpty() && ! $remarksLimitValue->isEmpty())

                        {!! Form::model($remarksLimitValue, [ 'url' => URL::route('configuration.update', ['id' => $remarksLimitValue[0]->id])] )  !!}
                        {{ Form::hidden('_method', 'PUT') }}

                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::label('value','Remarks: *', ['style' => 'font-size: 13px; margin-left: 2px;']) !!}
                                {!! Form::number('remarksValue', $remarksLimitValue[0]->value, ['class' => 'form-control', 'placeholder' => 'Branch name', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('remarksValue') !!}</span>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::hidden('id') !!}
                                {!! Form::hidden('form_name','config_update') !!}
                                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    @else
                        {!! Form::model('remarksLimit', [ 'url' => URL::route('configuration.store')] )  !!}
                        {{ Form::hidden('_method', 'POST') }}

                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::label('value','Remarks: *', ['style' => 'font-size: 13px; margin-left: 2px;']) !!}
                                {!! Form::number('remarksValue', null, ['class' => 'form-control', 'placeholder' => 'Enter limit for remarks text box', 'autocomplete' => 'off']) !!}
                            </div>
                            <span class="text-danger">{!! $errors->first('remarksValue') !!}</span>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 col-xs-12">
                                {!! Form::hidden('id') !!}
                                {!! Form::hidden('form_name','config_update') !!}
                                {!! Form::submit('Save', array("class"=>"btn btn-info pull-right ")) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table > tbody > tr:nth-child(2n+1) > td, .table > tbody > tr:nth-child(2n+1) > th {
        background-color: #f9f9f9;
    }
    table, tr, td {
        font-size: 13px;
    }

    .pagination{margin: 0; margin-bottom: 10px;}
    thead{ background-color: #d9edf7}

</style>