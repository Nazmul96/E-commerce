@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_styles.css">
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend') }}/styles/shop_responsive.css">
@include('layouts.frontend_partial.collaps_nav')

<div class="home">
    <div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{ asset('public/frontend') }}/images/shop_background.jpg"></div>
    <div class="home_overlay"></div>
    <div class="home_content d-flex flex-column align-items-center justify-content-center">
        <h2 class="home_title">{{ $page->page_title }}</h2>
    </div>
</div>


<div class="viewed">
    <div class="container">
        {!! $page->page_description !!}
    </div>
</div>



<script src="{{ asset('public/frontend') }}/js/shop_custom.js"></script>



@endsection