@extends('_partials.app')

@section('title', 'Home')

@section('main_container')
    <div class="hero-search" style="margin-top: -20px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex align-items-center justify-content-center flex-column h-100"
                         style="width: 65%;margin: auto;min-height: 350px;">
                        <div class="search-title mt-0 mb-4">
                            <h2>Scholarship</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admission-wrapper">
        <div class="container">
            <div class="row">
{{--                <div class="col-sm-3">--}}
{{--                    <h5 style="border-left: 4px solid #222;padding-left: 10px">All Category</h5>--}}
{{--                    <ul class="list-group list-group-flush">--}}
{{--                        <li class="list-group-item"><a href="javascrip:">Dapibus ac facilisis in</a></li>--}}
{{--                        <li class="list-group-item"><a href="javascrip:">Morbi leo risus</a></li>--}}
{{--                        <li class="list-group-item"><a href="javascrip:">Porta ac consectetur ac</a></li>--}}
{{--                        <li class="list-group-item"><a href="javascrip:">Vestibulum at eros</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
                <div class="col-sm-12">
                    <div class="blog-wrapper">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="blog-details">
                                    <a href="javascrip:">
                                        <img src="{{asset('img/default.png')}}" class="cover-img" alt="">
                                    </a>
                                    <div class="blog-contents">
                                        <a href="/pages/scholarship-details">Lorem ipsum dolor sit amet, consectetur adipisicing.</a>
                                    </div>
                                    <p class="writer-wrapper">
                                        Lorem ipsum dolor sit amet, consec adipisicing elit. Aliquam cumque earum
                                        enim exercitationem ipsa, iste labore odio, odit omnis quod rem vitae.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="blog-details">
                                    <a href="javascrip:">
                                        <img src="{{asset('img/default.png')}}" class="cover-img" alt="">
                                    </a>
                                    <div class="blog-contents">
                                        <a href="/pages/scholarship-details">Lorem ipsum dolor sit amet, consectetur adipisicing.</a>
                                    </div>
                                    <p class="writer-wrapper">
                                        Lorem ipsum dolor sit amet, consec adipisicing elit. Aliquam cumque earum
                                        enim exercitationem ipsa, iste labore odio, odit omnis quod rem vitae.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="blog-details">
                                    <a href="javascrip:">
                                        <img src="{{asset('img/default.png')}}" class="cover-img" alt="">
                                    </a>
                                    <div class="blog-contents">
                                        <a href="/pages/scholarship-details">Lorem ipsum dolor sit amet, consectetur adipisicing.</a>
                                    </div>
                                    <p class="writer-wrapper">
                                        Lorem ipsum dolor sit amet, consec adipisicing elit. Aliquam cumque earum
                                        enim exercitationem ipsa, iste labore odio, odit omnis quod rem vitae.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="blog-details">
                                    <a href="javascrip:">
                                        <img src="{{asset('img/default.png')}}" class="cover-img" alt="">
                                    </a>
                                    <div class="blog-contents">
                                        <a href="/pages/scholarship-details">Lorem ipsum dolor sit amet, consectetur adipisicing.</a>
                                    </div>
                                    <p class="writer-wrapper">
                                        Lorem ipsum dolor sit amet, consec adipisicing elit. Aliquam cumque earum
                                        enim exercitationem ipsa, iste labore odio, odit omnis quod rem vitae.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

