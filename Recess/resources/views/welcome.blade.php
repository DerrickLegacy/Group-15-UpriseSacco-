@extends('layouts.app')
@include('partials.navbar')
@section('content')
<div class="main-bg position-relative">
    <div class="content">
        <h1 style="color: aqua">Welcome</h1>
        <h1 style="color: aqua">Growing Together Through Savings.</h1>
    </div>
</div>
<div class="bg-secondary">
    @include('partials.footer')
</div>
@endsection