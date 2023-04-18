@extends('_partials.app')

@section('title', env('APP_NAME'))

@section('main_container')
    <div class="job-category-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="category-title d-block overflow-hidden">
                        <h4>{{$title}}</h4>
                        <p><b>Total Job Found</b>: {{$totalRecords}}</p>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @foreach($data['category_types'] as $key=>$item)
                                <li class="nav-item">
                                    <a class="nav-link {{$key == 0 ? 'active' : ''}}" id=" pills-home-tab"
                                       data-toggle="pill" href="#{{$item['id']}}"
                                       role="tab" aria-controls="pills-home"
                                       aria-selected="true">{{$item['title']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="category-list">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="1" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                <div class="catlist">
                                    <ul>
                                        <li>
                                            <div class="row">
                                                @foreach($data['categories_functional'] as $item)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id] + $params)}}"
                                                           onclick="setFilter({{$item}}, 'category', '', false)">
                                                            {{$item->title_en}}
                                                            <span class="float-right">{{$item->job_count}}</span></a>
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
                                                        <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id] + $params)}}"
                                                           onclick="setFilter({{$item}}, 'category', '', false)">{{$item->title_en}}
                                                            <span class="float-right">{{$item->job_count}}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="3" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="catlist">
                                    <ul>
                                        <li>
                                            <div class="row">
                                                @foreach($data['categories_special_skilled'] as $item)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <a href="{{url('job-lists').'?'. http_build_query(['category' => $item->id] + $params)}}"
                                                           onclick="setFilter({{$item}}, 'category', '', false)">{{$item->title_en}}
                                                            <span class="float-right">{{$item->job_count}}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            if (filterData) {
                if (filterData.hasOwnProperty('post_within')) {
                    $(document).prop('title', 'New jobs of Bangladesh');
                } else if (filterData.hasOwnProperty('deadline')) {
                    $(document).prop('title', 'Deadline tomorrow to apply');
                } else if (filterData.hasOwnProperty('job_nature')) {
                    if (filterData.job_nature.id === 3) {
                        $(document).prop('title', 'Contractual jobs in Bangladesh');
                    }
                }
            }
        });

        function setFilter(data, key, url = "{{url('job-lists')}}", goToExternalLink = true) {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData[key] = data;

            localStorage.setItem('filter', JSON.stringify(filterData));

            if (goToExternalLink) {
                window.location.assign(url + getQueryParams())
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
    </script>
@endsection
