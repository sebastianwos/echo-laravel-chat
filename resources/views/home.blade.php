@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Public Chat Room</div>
                <div class="panel-body">
                    <public-chat api-token="{{ $api_token }}"></public-chat>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
