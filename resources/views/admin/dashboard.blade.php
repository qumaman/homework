@extends('admin.layouts.app_admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <a href="{{route('admin.user_managment.user.index')}}" class="list-group-item">
                <h4 class="list-group-item-heading">Список пользователей</h4>
            </a>
        </div>
    </div>
</div>
@endsection