@extends('_partials.app')

@section('title', 'Training')

@section('main_container')
    <div class="job-search-wrapper">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div id="filter_section"
                                 style="display: inline-block;padding: 4px 0;border-radius: 3px;font-weight: 500;">
                                <i id="loader" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                   style="display:none"></i>

{{--                                <select class="form-control-sm w-25"--}}
{{--                                        onchange="onchangeDropdown(this, 'course_industry')">--}}
{{--                                    <option value='{"id": "", "title": ""}' disabled selected id="all_course_industry">Select Industry</option>--}}
{{--                                    @foreach($data['industry_types'] as $item)--}}
{{--                                        <option value="{{collect($item)}}">{{$item->title_en}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}

                                <select class="form-control-sm w-25"
                                        onchange="onchangeDropdown(this, 'course_category')">
                                    <option value='{"id": "", "title": ""}' disabled selected id="all_course_category">Select Category</option>
                                    @foreach($data['course_category'] as $item)
                                        <option value="{{collect($item)}}">{{$item->title}}</option>
                                    @endforeach
                                </select>

                                <select class="form-control-sm" onchange="onchangeDropdown(this, 'course_type')">
                                    <option value='{"id": "", "title": ""}' disabled selected id="all_course_type">Select Course Type</option>
                                    @foreach($data['course_types'] as $item)
                                        <option value="{{collect($item)}}">{{$item->title}}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-primary ml-5" onclick="search()">Search</button>
                                <a href="Javascript:void(0)" class="btn btn-default ml-3"
                                   onclick="resetFilters()">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="data_content">
                @include('pages.trainings.course-list-content')
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function onchangeDropdown(obj, key) {
            console.log(JSON.parse(obj.value))
            setFilter(JSON.parse(obj.value), key)
        }


        function setFilter(data, key) {
            if (!data.id) {
                return;
            }

            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData[key] = data;

            localStorage.setItem('filter', JSON.stringify(filterData));
        }

        function removeFilter(key) {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            if (filterData) {
                delete filterData[key];
                localStorage.setItem('filter', JSON.stringify(filterData));
            }

            window.history.pushState({}, document.title, getQueryParams());

            loadData()

            if (key === 'course_industry') {
                $("#all_course_industry").prop("selected", true);
            } else if (key === 'course_category') {
                $("#all_course_category").prop("selected", true);
            } else if (key === 'course_type') {
                $("#all_course_type").prop("selected", true);
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

        function loadData() {
            $.ajax({
                url: formattedUrl("{{url('training-course-list')}}" + getQueryParams()),

                beforeSend: function () {
                    $("#loader").show();
                },
                complete: function () {
                    $("#loader").hide();
                },
            }).done(function (data) {
                $("#data_content").html(data.html)
                // $("#total_records").html(data.totalRecords)

            }).fail(function () {
                alert('No response from server');
            });
        }

        function resetFilters() {
            localStorage.removeItem('filter')

            $("#all_course_industry").prop("selected", true);
            $("#all_course_category").prop("selected", true);
            $("#all_course_type").prop("selected", true);

            window.history.pushState({}, document.title, '?');

            loadData()
        }

        function search() {
            loadData()
            window.history.pushState({}, document.title, getQueryParams());
        }
    </script>
@endsection
