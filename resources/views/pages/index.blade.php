@extends('_partials.app')

@section('title', 'A Leading Job Site in Bangladesh, Search Jobs')

@section('main_container')
    <div class="hero-search" style="margin-top: -20px;">
        <div class="hero-search-inner">
            {{--            <div class="search-title">--}}
            {{--                <h2>--}}
            {{--                    {{ trans('words.find_job_title') }}--}}
            {{--                </h2>--}}
            {{--            </div>--}}
            <div class="search-bar">
                <select class="niceselect" id="organization_type">
                    <option selected="" disabled>{{trans('words.org_selection')}}</option>
                    @foreach($data['organization_types'] as  $item)
                        <option
                            value="{{collect($item)}}">{{App\Services\HelperService::formattedTitle($item)}}</option>
                    @endforeach
                </select>
                <input class="form-control" placeholder="Search by keyword" type="search" id="search_value"
                       style="width: 72%">
                <button class="btn btn-primary" onclick="searchByValue()">
                    <i class="icofont-search-job"></i>
                </button>
            </div>
            <div class="search-sugggesion">
                <a href="{{url('company-list')}}" class="btn btn-primary btn-sm"
                   onclick="setFilter({id: '', title_en: ''}, '', '', false)">{{ trans('words.employers')}}</a>
                <a href="{{url('category-wise-job-summary') .'?'. http_build_query(['post_within' => 'today'])}}"
                   class="btn btn-secondary btn-sm"
                   onclick="setFilter({id: 'today', title_en: 'Today'}, 'post_within', '', false)"> {{trans('words.new_job_menu')}}
                </a>
                <a href="{{url('category-wise-job-summary').'?'. http_build_query(['deadline' => 'tomorrow'])}}"
                   class="btn btn-danger btn-sm"
                   onclick="setFilter({id: 'tomorrow', title_en: 'Tomorrow'}, 'deadline', '', false)">
                    {{trans('words.deadline_tomorrow_menu')}}
                </a>
                <a href="{{url('category-wise-job-summary').'?'. http_build_query(['job_nature' => 3])}}"
                   class="btn btn-warning btn-sm"
                   onclick="setFilter({id: 3, title: 'Contractual'}, 'job_nature', '', false)">
                    {{trans('words.contractual_job_menu')}}
                </a>
                <a href="{{url('job-lists').'?'. http_build_query(['job_nature' => 2])}}"
                   class="btn btn-info btn-sm"
                   onclick="setFilter({id: 2, title: 'Part time'}, 'job_nature', '', false)">{{trans('words.part_time_job_menu')}}</a>
                {{--                        <a href="" class="btn btn-success btn-sm">Overseas Jobs</a>--}}
                <a href="{{url('job-lists').'?'. http_build_query(['work_from_home' => true])}}"
                   class="btn btn-default btn-sm"
                   onclick="setFilter({id:true, title_en: 'Work from Home'}, 'work_from_home', '', false)">
                    {{trans('words.work_from_home_menu')}}
                </a>
            </div>
        </div>
    </div>

    <div class="job-category-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="category-title d-block overflow-hidden">
                        <h2 class="float-left"><i
                                class="icofont-align-left"></i> {{trans('words.browse_category_menu')}}</h2>
                        <ul class="nav nav-pills mb-3 float-right" id="pills-tab" role="tablist">
                            @foreach($data['tag_types'] as $key=>$item)
                                <li class="nav-item">
                                    <a class="nav-link {{$key == 0 ? 'active' : ''}}" id=" pills-home-tab"
                                       data-toggle="pill" href="#{{$item->id}}"
                                       role="tab" aria-controls="pills-home"
                                       aria-selected="true">{{App\Services\HelperService::formattedTitle($item)}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="category-list mb-4">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="1" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                <div class="catlist">
                                    <ul>
                                        <li>
                                            <div class="row">
                                                @foreach($data['categories_functional'] as $item)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id])}}"
                                                           class="link-changeable" target="_blank"
                                                           onclick="setFilter({{$item}}, 'category', '', false)">
                                                            <i class="icofont-caret-right"></i> {{App\Services\HelperService::formattedTitle($item)}}
                                                            <span class="float-right">
                                                                {{App\Services\HelperService::formattedNumber($item->job_count)}}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- tab close -->

                            <div class="tab-pane fade" id="2" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="catlist">
                                    <ul>
                                        <li>
                                            <div class="row">
                                                @foreach($data['categories_industrial'] as $item)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id])}}"
                                                           class="link-changeable" target="_blank"
                                                           onclick="setFilter({{$item}}, 'category', '', false)">
                                                            <i class="icofont-caret-right"></i> {{App\Services\HelperService::formattedTitle($item)}}
                                                            <span class="float-right">
                                                                 {{App\Services\HelperService::formattedNumber($item->job_count)}}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- tab close -->
                        </div>
                    </div>

                    <div class="category-title d-block overflow-hidden colorSpecial">
                        <h2 class="float-left"><i
                                class="icofont-user-suited"></i> {{trans('words.special_skilled_job_menu')}}</h2>
                    </div>
                    <div class="category-list colorSpecial">
                        <div class="catlist colorSpecial">
                            <ul>
                                <li>
                                    <div class="row">
                                        @foreach($data['categories_special_skilled'] as $key=>$item)
                                            @if($key < 15)
                                                <div class="col-lg-4 col-sm-12">
                                                    <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id])}}"
                                                       class="link-changeable" target="_blank"
                                                       onclick="setFilter({{$item}}, 'category', '', false)">
                                                        <i class="icofont-caret-right"></i> {{App\Services\HelperService::formattedTitle($item)}}
                                                        <span class="float-right">
                                                         {{App\Services\HelperService::formattedNumber($item->job_count)}}
                                                        </span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="col-lg-4 col-sm-12 extra_section_sk_jobs"
                                                     style="display: none">
                                                    <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id])}}"
                                                       class="link-changeable" target="_blank"
                                                       onclick="setFilter({{$item}}, 'category', '', false)">
                                                        <i class="icofont-caret-right"></i> {{App\Services\HelperService::formattedTitle($item)}}
                                                        <span class="float-right">
                                                         {{App\Services\HelperService::formattedNumber($item->job_count)}}
                                                        </span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if($key > 15)
                                            <div class="col-md-12">
                                                <a href="Javascript:void(0)" class="float-right p-0 m-0"
                                                   id="sk_skill_more"
                                                   style="border: none;" onclick="moreLess('more', 'sk_skills')">
                                                    <i class="fa fa-plus"></i> {{trans('words.more')}}
                                                </a>

                                                <a href="Javascript:void(0)" class="float-right p-0 m-0"
                                                   style="border: none; display: none" id="sk_skill_less"
                                                   onclick="moreLess('less', 'sk_skills')">
                                                    <i class="fa fa-minus"></i> {{trans('words.less')}}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <div class="single-border-box">
                        <div class="quick-search">
                            <h3>{{trans('words.divisional_job_menu')}}</h3>
                            <ul>
                                @foreach($data['divisions'] as $item)
                                    <li>
                                        <a href="{{url('job-lists').'?'. http_build_query(['area_id' => $item->id])}}"
                                           class="link-changeable"
                                           onclick="setFilter({{$item}}, 'area_id', '', false)">{{App\Services\HelperService::formattedTitle($item)}}
                                            <span class="float-right">
                                            {{ App\Services\HelperService::formattedNumber($item->job_count)}}
                                        </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="govt-job">
                            <h3><i class="icofont-map-pins"></i> Govt Jobs</h3>
                            <div class="govtjobcarousel">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @forelse($data['govt_jobs'] as $key=>$jobs)
                                            <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                                                @foreach($jobs as $item)
                                                    <a href="{{url('job-list/'.$item['id'].'/details')}}"
                                                       class="link-changeable" target="_blank">
                                                        <span class="gjTitle">{{$item['company']['title_en']}}</span>
                                                        <span class="jobDesignation">{{$item['title']}}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @empty
                                            <p class="text-center">No jobs found!</p>
                                        @endforelse
                                    </div>

                                    <a href="Javascript:void(0)" class="text-success view"
                                       style="bottom: 18px;position: absolute;font-size: 11px;"
                                       onclick="setFilter({id: 1, title_en: 'Government', title_bn: 'সরকারী'}, 'organization_type_id')">
                                        <b>VIEW ALL ({{$data['total_govt_jobs']}})</b>
                                    </a>

                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only ">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--below govt section ads--}}
                    <div>
                        @if(@$data['ads']['3'])
                            @foreach(collect($data['ads']['3']) as $ad)
                                <div class="single-border-box">
                                    <a href="{{$ad->url}}" target="_blank">
                                        <img src="{{$ad->image}}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="featured-company-jobs">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-md-12 col-xs-12">
                    <div class="fcj-content">
                        <h2><i class="icofont-business-man"></i> {{trans('words.hot_job_menu')}}</h2>
                        <div class="local-jobs">
                            <div class="row">
                                @forelse($data['hot_jobs'] as $item)
                                    <div class="col-md-4 col-sm-12 padding10">
                                        <div class="local-job-inner">
                                            <div class="local-job-content d-block overflow-hidden">
                                                <h3>{{App\Services\HelperService::formattedTitle($item)}}</h3>
                                                <div class="company-job-list">
                                                    <ul>
                                                        @foreach($item->jobs as $job)
                                                            <li><a href="{{url('job-list/'.$job['id'].'/details')}}"
                                                                   class="link-changeable"
                                                                   target="_blank">{{$job->title}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="company-logo">
                                                    <img
                                                        src="{{$item->logo ? $item->logo : asset('/img/default.png') }}"
                                                        alt="company logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-sm-12">
                                        <p class="text-center">No jobs found!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div><!-- featured job content end -->
                </div><!-- col end -->
                <div class="col-xl-3  d-xl-block">
                    @if(@$data['ads']['4'])
                        <div class="single-border-box">
                            @foreach(collect($data['ads']['4']) as $ad)
                                <div class="widget">
                                    <a href="{{$ad->url}}" target="_blank">
                                        <img src="{{$ad->image}}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div><!-- col end -->
        </div>
    </div>
    </div><!-- Featured company job close -->

    <div class="tender-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="fcj-content">
                        <h2><i class="icofont-briefcase-1"></i> {{trans('words.tender_eoi_menu')}}</h2>
                        <div class="local-jobs">
                            <div class="row">
                                @forelse($data['tenders'] as $item)
                                    <div class="col-md-4">
                                        <div class="local-job-inner">
                                            <div class="local-job-content d-block overflow-hidden">
                                                <h3>{{App\Services\HelperService::formattedTitle($item)}}</h3>
                                                <div class="company-job-list">
                                                    <ul>
                                                        @foreach($item->jobs as $job)
                                                            <li><a href="{{url('job-list/'.$job['id'].'/details')}}"
                                                                   class="link-changeable"
                                                                   target="_blank">{{$job->title}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="company-logo">
                                                    <img
                                                        src="{{$item->logo ? $item->logo : asset('/img/default.png') }}"
                                                        alt="company logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-sm-12">
                                        <p class="text-center">No jobs found!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div><!-- featured job content end -->
                </div><!-- col end -->
            </div>
        </div>
    </div>

    {{--<div class="promo-slider">
        <div id="promoSliderControl" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/slide4.jpg" alt="...">
                    <div class="carousel-caption">
                        <h5>Join the Largest Job Site of Bangladesh</h5>
                        <p>Be a member of a family of more than one million job seekers<br>and apply to any of the 3000+
                            live jobs </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/slide1.jpg" alt="...">
                    <div class="carousel-caption">
                        <h5>Customize Everything</h5>
                        <p>Customize your profile, job preference and everything<br>to get the better job in shorter
                            time. </p>
                        <a href="" class="btn btn-success btn-sm mt-1">My Morejobs</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/slide2.jpg" alt="...">
                    <div class="carousel-caption">
                        <h5>Develop Yourself for better career</h5>
                        <p>Get relevant trainings and develop yourself as a keen professional<br>to stand out in this
                            competitive job market. </p>
                        <a href="" class="btn btn-success btn-sm mt-1">Visit Morejobs Training</a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#promoSliderControl" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#promoSliderControl" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>--}}

    @if(count($data['courses']) > 0)
        <div class="training-area">
            <div class="container">
                <div class="row">
                    @foreach($data['courses'] as $item)
                        <div class="col-md-6 col-sm-12">
                            <div class="training-section tLeft">
                                <div class="training-title d-block overflow-hidden">
                                    <h2><i class="icofont-sunny-day-temp"></i> {{$item->title}}</h2>
                                </div>
                                <div class="training-list">
                                    @foreach($item->courses as $course)
                                        <div class="short-training">
                                            <div class="trn-icon">
                                                <i class="icofont-medal"></i>
                                            </div>
                                            <div class="trn-details">
                                                <h3>{{$course->title}}</h3>
                                                <p>{{\Carbon\Carbon::parse($course->start_date)->day}}
                                                    , {{\Carbon\Carbon::parse($course->end_date)->format('d M Y')}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    <div class="col-xl-6 container  d-xl-block">
        @if(@$data['ads']['2'])
            <div class="single-border-box">
                @foreach(collect($data['ads']['2']) as $ad)
                    <div class="widget">
                        <a href="{{$ad->url}}" target="_blank">
                            <img src="{{$ad->image}}" alt="" class="img-fluid">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        function setFilter(data, key, url = "{{url('job-lists')}}", goToExternalLink = true) {
            let filterData = {};

            if (!data.id) {
                localStorage.removeItem('filter');
            } else {
                filterData[key] = data;
                localStorage.setItem('filter', JSON.stringify(filterData));
            }

            if (goToExternalLink) {
                window.location.assign(url + getQueryParams())
            }
        }

        // $(document).keypress(function (event) {
        //     alert(8888)
        //     var keycode = (event.keyCode ? event.keyCode : event.which);
        //
        //     if (keycode === '13') {
        //         alert('You pressed a ENTER key.');
        //     }
        // });

        $("#search_value").on("keypress", function (event) {
            if (event.which === 13 && !event.shiftKey) {
                event.preventDefault();
                searchByValue();
            }
        });

        function searchByValue() {
            const searchValue = $('#search_value').val();
            const orgTypeValue = $('#organization_type').val();

            if (searchValue || orgTypeValue) {
                let filterData = {};
                if (searchValue) {
                    filterData.search_value = {id: searchValue, title_en: searchValue};
                }

                if (orgTypeValue) {
                    filterData.organization_type_id = JSON.parse(orgTypeValue);
                }

                localStorage.setItem('filter', JSON.stringify(filterData));

                window.location.assign("{{url('job-lists')}}" + getQueryParams())
            }
        }

        function getQueryParams() {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            let queryParams = '';
            if (filterData) {
                queryParams = '?'
                $.each(filterData, function (key, item) {
                    const obj = {}
                    obj[key] = item.id
                    queryParams += '&' + $.param(obj)
                });
            }
            return queryParams;
        }

        function moreLess(action, catType) {
            if (action === 'more') {
                if (catType === 'sk_skills') {
                    $('.extra_section_sk_jobs').show();
                    $('#sk_skill_less').show();
                    $('#sk_skill_more').hide();
                }
            } else {
                if (catType === 'sk_skills') {
                    $('.extra_section_sk_jobs').hide();
                    $('#sk_skill_more').show();
                    $('#sk_skill_less').hide();
                }
            }
        }
    </script>
@endsection
