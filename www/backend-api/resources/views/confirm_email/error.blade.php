@extends('layouts.base')

@section('title') Error @endsection

@section('content')
    <div class="popup">
        <div class="header">
            <p class="error">Ошибка!</p>
        </div>
        <div class="body">
            <p>Данный код проверки email неактивен или уже использован для активации</p>
        </div>
    </div>
@endsection
