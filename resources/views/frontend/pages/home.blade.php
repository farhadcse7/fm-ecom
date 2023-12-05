@extends('frontend.layouts.master')

@section('frontendtitle')
    Home Page
@endsection

@section('frontend_content')
    @include('frontend.pages.widgets.slider')

    @include('frontend.pages.widgets.featured')

    @include('frontend.pages.widgets.countdown')

    @include('frontend.pages.widgets.best-seller')

    @include('frontend.pages.widgets.latest-product')

    @include('frontend.pages.widgets.testimonial')


@endsection

@push('frontend_script')
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/656c2cc7ff45ca7d478656bb/1hgn8trd9';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
@endpush
