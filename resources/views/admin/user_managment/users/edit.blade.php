@extends('admin.layouts.app_admin')

@section('content')

<div class="container">

  @component('admin.components.breadcrumb')
    @slot('title') Редактирование пользователя @endslot
    @slot('parent') Главная @endslot
    @slot('active') Пользователи @endslot
  @endcomponent

  <hr />
  <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px; height: 150px; float:none; border-radius:50%; margin-bottom:25px;" alt="">

    <form class="form-horizontal" action="{{route('admin.user_managment.user.update', $user)}}" method="post" enctype="multipart/form-data">
        {{-- Путь к admin.user_managment.user.update --}}
        {{ method_field('PUT')}}
        {{-- установка CSRF-защиты --}}
        {{ csrf_field() }}
        {{-- Вставка формы --}}
        @include('admin.user_managment.users.partials.form')

    </form>
</div>

@endsection
