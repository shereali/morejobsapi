@extends('_partials.app')

@section('title', 'Home')

@section('main_container')
    <div class="hero-search" style="margin-top: -20px;">
        {{--        <div class="container">--}}
        {{--            <div class="row p-4" style="background-color: whitesmoke">--}}
        {{--                <div class="col-md-6"></div>--}}
        {{--                <div class="col-md-6">--}}
        {{--                    <button class="btn btn-default">New Arrival</button>--}}
        {{--                    <button class="btn btn-success">Become a Trainer</button>--}}
        {{--                    <button class="btn btn-default">Browse Courses</button>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <div class="row">--}}
        {{--                <div class="col-sm-12">--}}
        {{--                    <div class="d-flex align-items-center justify-content-center flex-column h-100"--}}
        {{--                         style="width: 65%;margin: auto;min-height: 350px;">--}}
        {{--                        <div class="search-title mt-0 mb-4">--}}
        {{--                            <h2>Courses by industry</h2>--}}
        {{--                        </div>--}}
        {{--                        <div class="search-bar">--}}
        {{--                            <select class="niceselect" name="" id="niceselect">--}}
        {{--                                <option selected="" disabled>Select</option>--}}
        {{--                                <option value="1">Government</option>--}}
        {{--                                <option value="2">Semi Government</option>--}}
        {{--                                <option value="3">NGO</option>--}}
        {{--                                <option value="4">Private Firm/Company</option>--}}
        {{--                                <option value="5">International Agencies</option>--}}
        {{--                                <option value="6">Others</option>--}}
        {{--                            </select>--}}
        {{--                            <form>--}}
        {{--                                <input class="form-control" name="search" placeholder="Search by Keywords: ex. Accounts"--}}
        {{--                                       type="search">--}}
        {{--                                <button class="btn btn-primary"><i class="icofont-search-job"></i></button>--}}
        {{--                            </form>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    <div class="training-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group" role="group">
                        <span class="tran-title-btn">Course Type</span>
                        {{--                        <button type="button" class="btn tran-btn active">All <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">107</span></button>--}}
                        {{--                        <button type="button" class="btn tran-btn">Daylong Courses <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">76</span></button>--}}
                        {{--                        <button type="button" class="btn tran-btn">Evening Courses <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">31</span></button>--}}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        {{--                        <button type="button" class="btn tran-btn-solid"><i class="icofont-cloud-download"></i> Monthly--}}
                        {{--                            calendar--}}
                        {{--                        </button>--}}
                    </div>
                </div>
            </div>

            <div class="train-container">
                <div class="train-body">
                    <div class="list-group train-sidebar" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="all-list" data-toggle="list"
                           onclick="setFilter({id: '', title: ''}, 'training_category_id')"
                           href="Javascript:void(0)">
                            <i class="icofont-listine-dots"></i> All
                        </a>

                        @foreach($data['course_category_summary'] as $category)
                            <a class="list-group-item list-group-item-action"
                               onclick="setFilter({{collect($category)}}, 'training_category_id')"
                               id="training_category_id_{{$category->id}}" data-toggle="list"
                               href="Javascript:void(0)"><i class="icofont-calculator-alt-1"></i>
                                {{$category->title}} <span>({{$category->course_count}})</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="tab-content content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12">
                                    <i id="loader" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                       style="display:none"></i>

                                    <p class="active-session">
                                        <span class="badge badge-pill badge-secondary"
                                              id="total_records">{{$totalRecords}}</span> Courses found
                                    </p>
                                </div>
                            </div>

                            <div id="data_content">
                                @include('pages.trainings.content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(window).ready(function () {
            setQueryParamsFromUrlParams();
        });

        function setQueryParamsFromUrlParams() {
            localStorage.removeItem('filter')

            const queryParams = new URLSearchParams(window.location.search).entries();

            const filterData = {};
            for (let pair of queryParams) {
                if (pair[0] && pair[1]) {
                    filterData[pair[0]] = pair[1];
                }
            }

            localStorage.setItem('filter', JSON.stringify(filterData));
            loadFilters();
        }

        function loadFilters() {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            if (filterData && !jQuery.isEmptyObject(filterData)) {
                let filterHtml = '';
                $.each(filterData, function (key, item) {
                    filterHtml += `<div class="filter-reg ml-2">
                                            <span class="filter-reg-item">
                                                ${item.title_en}
                                                <a href="javascript:" class="ml-1" onclick="removeFilter('${key}')"><i class="icofont-close-circled"></i></a>
                                            </span>
                                        </div>`
                    setFiltersDefaultValue(key, item);
                });

                $('#filter_section').html(filterHtml);
            } else {
                $('#filter_section').empty();
            }
        }

        function setFiltersDefaultValue(key, item) {
            if (key === 'training_category_id') {
                $('.list-group-item-action').removeClass('active');
                $('#training_category_id' + item.id).addClass('active');
            }
        }

        function removeFilter(key) {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            if (filterData) {
                delete filterData[key];
                localStorage.setItem('filter', JSON.stringify(filterData));
                loadFilters()
            }

            window.history.pushState({}, document.title, getQueryParams());
            loadData()
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
                url: "{{url('training-courses')}}" + getQueryParams(),

                beforeSend: function () {
                    $("#loader").show();
                },
                complete: function () {
                    $("#loader").hide();
                },
            }).done(function (data) {
                $("#data_content").html(data.html)
                $("#total_records").html(data.totalRecords)

            }).fail(function () {
                alert('No response from server');
            });
        }

        $(function () {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();

                window.location.assign($(this).attr('href') + getQueryParams().replace('?', ''))

                // $('li').removeClass('active');
                // $(this).parent('li').addClass('active');
                //
                // $('#load a').css('color', '#dfecf6');
                // $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');
                //
                // const url = $(this).attr('href');
                // getData(url);
                // window.history.pushState("", "", url);
            });

            // function getData(url) {
            //     $.ajax({
            //         url: url
            //     }).done(function (data) {
            //         $("#data_content").html(data);
            //     }).fail(function () {
            //         alert('No response from server');
            //     });
            // }
        });
    </script>

    <script>
        function setFilter(data, key) {
            if (!data.id) {
                removeFilter(key)
                return;
            }

            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData[key] = data;

            localStorage.setItem('filter', JSON.stringify(filterData));

            loadFilters()
            loadData()

            window.history.pushState({}, document.title, getQueryParams());
        }


        function resetFilters() {
            localStorage.removeItem('filter')
            loadFilters()

            // $('#search_value').val('')
            // $("#all_cat").prop("checked", true);
            // $("#any_industry").prop("checked", true);
            // $("#any_organization").prop("checked", true);
            // $("#any_post_within").prop("checked", true);
            // $("#any_deadline").prop("checked", true);
            // $("#exp_range").val('{"id": "", "title_en": ""}');
            // $("#age_range").val('{"id": "", "title_en": ""}');
            // $("#job_nature").val('{"id": "", "title": ""}');
            // $("#job_level").val('{"id": "", "title": ""}');
            // $('#work_from_home').prop('checked', false);
            // $('#g_female').prop('checked', false);
            // $('#g_male').prop('checked', false);
            // $('#g_other').prop('checked', false);

            window.history.pushState({}, document.title, '?');

            loadData()
        }
    </script>
@endsection
