@extends('layouts.app')

@section('content')
<div class="container">
    <div id="login">
        @include('components.search')
    </div>

    <div id="registro" style="display: none;">
        @include('components.register')
    </div>

    <div id="bookings-list-container" style="display: none;"></div>

    @include('components.booking')
</div>
@endsection

@section('extra')
<div id="alert-container" class="alert-container"></div>
@endsection