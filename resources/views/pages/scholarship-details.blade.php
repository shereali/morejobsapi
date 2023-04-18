@extends('_partials.app')

@section('title', 'Home')

@section('main_container')

    <div class="admission-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog-wrapper">
                        <img src="{{asset('img/default.png')}}" class="cover-img" alt="">
                        <div class="blog-contents mt-2">
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing.</h5>
                        </div>
                        <small class="d-block mb-3">
                            <span class="text-muted">Category:</span>
                            <a href="https://emedical.com.bd/blog/category/cancer">Category 1</a>
                            ,
                            <a href="https://emedical.com.bd/blog/category/healthcare">Category 2</a>
                        </small>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias dolorem, magnam
                            nulla numquam quibusdam repellat sed voluptatibus. Beatae eveniet explicabo libero nulla
                            optio placeat quos sed temporibus vel voluptate!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

