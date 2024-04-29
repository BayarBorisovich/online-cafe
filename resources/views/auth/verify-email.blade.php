@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <h1 class="log_in mb-5">Пожалуйста, подтвердите Ваш адрес электронной почты</h1>

        @if(Session::has('message'))
            <div class="alert alert-success">
                {{Session::get('message')}}
            </div>
        @endif
        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <input type="submit" class="btn btn-success mb-3" value="Отправить электронное письмо еще раз">
        </form>
        <a class="btn btn-success" href="{{ route('main') }}" role="button">Вернуться на главную страницу</a>
    </div>
@endsection
