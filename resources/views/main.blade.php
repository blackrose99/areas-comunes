@extends('layouts.app')

@section('content')
<div class="container">
    <div id="login">
        @include('components.search')
    </div>

    <div id="registro" style="display: none;">
        <h2>Registrar Residente</h2>
        @include('components.register')
    </div>

    <div id="bookingModal" style="display: none;">
        @include('components.booking')
    </div>
</div>

@endsection