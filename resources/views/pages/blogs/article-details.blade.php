@extends('_partials.app')

@section('title', 'Morejobs | '. @$type['title'])

@section('main_container')
    <div class="container">
        <div class="row" style="margin-bottom: 20px">
            <div class="col-xl-8 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        @if($data->cover_image)
                            <img src="{{$data->cover_image}}" class="cover-img" alt="" style="width: 100%;">
                        @endif

                        <div class="col-xl-12 col-md-12 col-sm-12" style="margin-top: 10px">
                            {!! $data['description'] !!}
                        </div>
                    </div>
                </div>
            </div>


            @include('pages.blogs.article-navbar', ['list' => $data['article_list']])
        </div>
    </div>
@endsection

