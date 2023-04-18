@extends('_partials.app')

@section('title', 'Morejobs | '. @$type['title'])

<style>
    .list-group {
        padding-left: 0;
        margin-bottom: 20px;
    }

    a.list-group-item, button.list-group-item {
        color: #555;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .panel-default > .panel-heading {
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
    }

    .panel-heading {
        padding: 10px 5px;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .btn-default:hover {
        color: #333 !important;
        background-color: #e6e6e6 !important;
        border-color: #adadad !important;
    }

</style>

@section('main_container')
    <div class="container">
        <div class="row" style="margin-bottom: 20px">
            <div class="col-xl-8 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        @forelse($data as $value)
                            <h4 class="title"><a class="link-color" style="color: #2f64a3"
                                                 href="{{url($type['url'])}}/{{$value['id']}}">{{$value->title}}</a>
                            </h4>
                            <p class="text-muted"><span
                                    class="fa fa-calendar"></span> {{\Carbon\Carbon::parse($value->created_at)->format('d M Y H:i:s')}}
                            </p>
                            <div class="overflow-3dots">{!! $value->description !!}</div>
                            {{--                            <p class="text-muted">Presented by <a href="#">Mike Braatz</a>, <a href="#">Jonathan--}}
                            {{--                                    Eber</a>--}}
                            {{--                            </p>--}}

                            <hr>
                        @empty
                            <div class="col-xl-12 col-md-12 col-sm-12" style="min-height: 200px">
                                <h6>No records found</h6>
                            </div>
                        @endforelse

                        {{$data->render()}}
                    </div>
                </div>
            </div>


            @include('pages.blogs.article-navbar', ['list' => $data])
        </div>
    </div>
@endsection

