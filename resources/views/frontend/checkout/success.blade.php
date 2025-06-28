@extends('frontend.layout')

@section('title', 'تم استلام طلبك')

@section('content')
<div class="container py-5 text-center">
    <div class="py-5">
        <img src="https://i.imgur.com/L4pWb4j.png" alt="طلب ناجح" class="img-fluid mb-4" style="max-width: 150px;">
        <h1 class="display-5 fw-bold">شكراً لك!</h1>
        @if(session('success_message'))
            <div class="alert alert-success col-md-6 mx-auto">
                {{ session('success_message') }}
            </div>
        @endif
        <p class="fs-5 text-muted">سنتصل بك قريباً لتأكيد تفاصيل التوصيل.</p>
        <a class="btn brand-gradient text-white btn-lg mt-3" href="{{ route('shop') }}" role="button">العودة للتسوق</a>
    </div>
</div>
@endsection