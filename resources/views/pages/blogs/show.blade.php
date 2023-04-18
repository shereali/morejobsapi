@extends('_partials.app')

@section('title', $type['title'].' | '. $data->title)

@section('main_container')

    <div class="admission-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="blog-wrapper">
                        <img src="{{$data->cover_image ? $data->cover_image : asset('img/default.png')}}" class="cover-img" alt="" style="width: 100%;">
                        <div class="blog-contents mt-2">
                            <h5>{{$data->title}}</h5>
                        </div>
                        {{--<small class="d-block mb-3">
                            <span class="text-muted">Category:</span>
                            <a href="https://emedical.com.bd/blog/category/cancer">Category 1</a>
                            ,
                            <a href="https://emedical.com.bd/blog/category/healthcare">Category 2</a>
                        </small>--}}
                        <p>
                            {!! $data->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

