@extends('_partials.app')

@section('title', 'Morejobs | '. @$type['title'])

@section('main_container')
    <div class="hero-search" style="margin-top: -20px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex align-items-center justify-content-center flex-column h-100"
                         style="width: 65%;margin: auto;min-height: 350px;">
                        <div class="search-title mt-0 mb-4">
                            <h2>{{$type['title']}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .vtimeline-content {
            margin-left: 350px;
            background: #fff;
            border: 1px solid #e6e6e6;
            padding: 35px 20px;
            border-radius: 3px;
            text-align: left;

            -webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.3);
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.3);
        }

        .vtimeline-content h3 {
            font-size: 1.5em;
            font-weight: 600;
            display: inline-block;
            margin: 0;
        }

        .vtimeline-content p {
            font-size: 0.9em;
            margin: 0;
        }

        .vtimeline-point {
            position: relative;
            display: block;
            vertical-align: top;
            margin-bottom: 30px;
        }


        .vtimeline-date {
            width: 260px;
            text-align: right;
            position: absolute;
            left: 0;
            top: 10px;
            font-weight: 400;
            color: #374054;
        }

        .post-meta {
            padding-top: 15px;
            margin-bottom: 20px;
        }

        .post-meta li:not(:last-child) {
            margin-right: 10px;
        }

        h3 {
            font-family: "Montserrat", sans-serif;
            color: #252525;
            font-weight: 700;
            font-variant-ligatures: common-ligatures;
            margin-top: 0;
            letter-spacing: -0.2px;
            line-height: 1.3;
        }

        .mb20 {
            margin-bottom: 20px !important;
        }

        .ellipse {
            white-space: nowrap;
            display:inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .two-lines {
            -webkit-line-clamp: 5;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            white-space: normal;
        }
    </style>

    <div class="container" style="margin: 20px 0">
        @forelse($data as $value)
            <div class="vtimeline-point">
                <div class="vtimeline-block">
                    <span class="vtimeline-date"></span>
                    <div class="vtimeline-content">
                        <a><img src="{{$value->cover_image ? $value->cover_image : asset('img/default.png')}}"
                                alt=""
                                class="img-fluid mb20" style="width: 100%"></a>
                        <a href="{{url($type['url'])}}/{{$value['id']}}"><h3>{{$value['title']}}</h3></a>
                        <ul class="post-meta list-inline">
                            <li class="list-inline-item">
                                @if($value['status']['id'] == 1)
                                    <i class="fa fa-check-circle text-success"></i> {{$value['status']['title']}}
                                @else
                                    <i class="fa fa-check-circle text-danger"></i> {{$value['status']['title']}}
                                @endif
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-calendar-o"></i> {{\Carbon\Carbon::parse($value['created_at'])->format('M d Y')}}
                            </li>
                            {{--                            <li class="list-inline-item">--}}
                            {{--                                <i class="fa fa-tags"></i> <a href="#">Bootstrap4</a>--}}
                            {{--                            </li>--}}
                        </ul>
                        <div class="ellipse two-lines">{!! $value['description'] !!}</div>
                        <br>
{{--                        <a href="#" class="btn btn-outline-secondary btn-sm">Read More</a>--}}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-sm-12" style="min-height: 200px">
                <h6 class=""
                    style="position: absolute;top: 50%;left: 68%;transform: translateX(-50%) translateY(-50%);">
                    No records found!
                </h6>
            </div>
        @endforelse

        <div class="d-flex justify-content-center" style="margin-left: 33%">
            {{$data->links()}}
        </div>
    </div>



    {{--    <div class="admission-wrapper">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-sm-3">--}}
    {{--                    <h5 style="border-left: 4px solid #222;padding-left: 10px">All Category</h5>--}}
    {{--                    <ul class="list-group list-group-flush">--}}
    {{--                        <li class="list-group-item"><a href="javascrip:">Dapibus ac facilisis in</a></li>--}}
    {{--                        <li class="list-group-item"><a href="javascrip:">Morbi leo risus</a></li>--}}
    {{--                        <li class="list-group-item"><a href="javascrip:">Porta ac consectetur ac</a></li>--}}
    {{--                        <li class="list-group-item"><a href="javascrip:">Vestibulum at eros</a></li>--}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-12">--}}
    {{--                    <div class="blog-wrapper">--}}
    {{--                        <div class="row">--}}
    {{--                            @forelse($data as $value)--}}
    {{--                            <div class="col-sm-3">--}}
    {{--                                <div class="blog-details">--}}
    {{--                                    <a href="javascrip:">--}}
    {{--                                        <img src="{{$value->cover_image ? $value->cover_image : asset('img/default.png')}}" class="cover-img" alt="">--}}
    {{--                                    </a>--}}
    {{--                                    <div class="blog-contents">--}}
    {{--                                        <a href="{{url($type['url'])}}/{{$value['id']}}">{{$value['title']}}</a>--}}
    {{--                                    </div>--}}
    {{--                                    <p class="writer-wrapper">--}}
    {{--                                        {{$value['subtitle']}}--}}
    {{--                                    </p>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            @empty--}}
    {{--                                <div class="col-sm-12" style="min-height: 200px">--}}
    {{--                                    <h6>No records found</h6>--}}
    {{--                                </div>--}}
    {{--                            @endforelse--}}

    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

@endsection

