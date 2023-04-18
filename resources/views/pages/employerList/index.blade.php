@extends('_partials.app')

@section('title', 'Employer List')

@section('main_container')
    <div class="job-search-wrapper">
        <div class="container">
            <div class="table-top">
                <div>
                    <h6>
                        <span class="badge badge-success">
                            {{App\Services\HelperService::formattedNumber($totalRecords)}}
                        </span>
                        {{trans('words.employer_job_offer')}}
                    </h6>
                    <small>{{trans('words.employer_list_view_job_instruction')}}</small>
                </div>
                <div class="pagination-wrapper mt-0">
                    <!--              <ngb-pagination [collectionSize]="120" [(page)]="page" [maxSize]="5" [rotate]="true" [boundaryLinks]="true"-->
                    <!--                              size="sm"></ngb-pagination>-->
                </div>
            </div>

            <div class="filter-wrapper">
                <div class="row">
                    <div class="col">
                        <ul class="employer-offer-filter">
                            <li><a href="javascript:" class="btn_option" id="a"
                                   onclick="onClickBtn(this, {id: 'a', title_en: 'A'}, 'start_with')">A</a></li>
                            <li><a href="javascript:" class="btn_option" id="b"
                                   onclick="onClickBtn(this, {id: 'b', title_en: 'B'}, 'start_with')">B</a></li>
                            <li><a href="javascript:" class="btn_option" id="c"
                                   onclick="onClickBtn(this, {id: 'c', title_en: 'C'}, 'start_with')">C</a></li>
                            <li><a href="javascript:" class="btn_option" id="d"
                                   onclick="onClickBtn(this, {id: 'd', title_en: 'D'}, 'start_with')">D</a></li>
                            <li><a href="javascript:" class="btn_option" id="e"
                                   onclick="onClickBtn(this, {id: 'e', title_en: 'E'}, 'start_with')">E</a></li>
                            <li><a href="javascript:" class="btn_option" id="f"
                                   onclick="onClickBtn(this, {id: 'f', title_en: 'F'}, 'start_with')">F</a></li>
                            <li><a href="javascript:" class="btn_option" id="g"
                                   onclick="onClickBtn(this, {id: 'g', title_en: 'G'}, 'start_with')">G</a></li>
                            <li><a href="javascript:" class="btn_option" id="h"
                                   onclick="onClickBtn(this, {id: 'h', title_en: 'H'}, 'start_with')">H</a></li>
                            <li><a href="javascript:" class="btn_option" id="i"
                                   onclick="onClickBtn(this, {id: 'i', title_en: 'I'}, 'start_with')">I</a></li>
                            <li><a href="javascript:" class="btn_option" id="j"
                                   onclick="onClickBtn(this, {id: 'j', title_en: 'J'}, 'start_with')">J</a></li>
                            <li><a href="javascript:" class="btn_option" id="k"
                                   onclick="onClickBtn(this, {id: 'k', title_en: 'K'}, 'start_with')">K</a></li>
                            <li><a href="javascript:" class="btn_option" id="l"
                                   onclick="onClickBtn(this, {id: 'l', title_en: 'L'}, 'start_with')">L</a></li>
                            <li><a href="javascript:" class="btn_option" id="m"
                                   onclick="onClickBtn(this, {id: 'm', title_en: 'M'}, 'start_with')">M</a></li>
                            <li><a href="javascript:" class="btn_option" id="n"
                                   onclick="onClickBtn(this, {id: 'n', title_en: 'N'}, 'start_with')">N</a></li>
                            <li><a href="javascript:" class="btn_option" id="o"
                                   onclick="onClickBtn(this, {id: 'o', title_en: 'O'}, 'start_with')">O</a></li>
                            <li><a href="javascript:" class="btn_option" id="p"
                                   onclick="onClickBtn(this, {id: 'p', title_en: 'P'}, 'start_with')">P</a></li>
                            <li><a href="javascript:" class="btn_option" id="q"
                                   onclick="onClickBtn(this, {id: 'q', title_en: 'Q'}, 'start_with')">Q</a></li>
                            <li><a href="javascript:" class="btn_option" id="r"
                                   onclick="onClickBtn(this, {id: 'r', title_en: 'R'}, 'start_with')">R</a></li>
                            <li><a href="javascript:" class="btn_option" id="s"
                                   onclick="onClickBtn(this, {id: 's', title_en: 'S'}, 'start_with')">S</a></li>
                            <li><a href="javascript:" class="btn_option" id="t"
                                   onclick="onClickBtn(this, {id: 't', title_en: 'T'}, 'start_with')">T</a></li>
                            <li><a href="javascript:" class="btn_option" id="u"
                                   onclick="onClickBtn(this, {id: 'u', title_en: 'U'}, 'start_with')">U</a></li>
                            <li><a href="javascript:" class="btn_option" id="v"
                                   onclick="onClickBtn(this, {id: 'v', title_en: 'V'}, 'start_with')">V</a></li>
                            <li><a href="javascript:" class="btn_option" id="w"
                                   onclick="onClickBtn(this, {id: 'w', title_en: 'W'}, 'start_with')">W</a></li>
                            <li><a href="javascript:" class="btn_option" id="x"
                                   onclick="onClickBtn(this, {id: 'x', title_en: 'X'}, 'start_with')">X</a></li>
                            <li><a href="javascript:" class="btn_option" id="y"
                                   onclick="onClickBtn(this, {id: 'y', title_en: 'Y'}, 'start_with')">Y</a></li>
                            <li><a href="javascript:" class="btn_option" id="z"
                                   onclick="onClickBtn(this, {id: 'z', title_en: 'Z'}, 'start_with')">Z</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="organization_type">{{trans('words.org_type')}}</label>
                            <select class="form-control form-control-sm" id="organization_type">
                                <option selected value="" disabled>{{trans('words.org_type_any')}}</option>
                                @foreach($data['organization_types'] as  $item)
                                    <option value="{{collect($item)}}">{{App\Services\HelperService::formattedTitle($item)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="search_value">{{trans('words.employee_list_table_company_name_column')}}</label>
                            <input type="text" class="form-control form-control-sm" id="search_value">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group" style="display: flex;align-items: flex-end;height: 57px">
                            <button type="button" class="btn btn-success btn-sm" onclick="searchByValue()">Search
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm ml-2" id="clear_btn"
                                    style="display: none" onclick="resetFilters()">clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination-wrapper mb-2">
                <nav aria-label="Page navigation example">
                    {{$records->render()}}
                </nav>

                <div class="form-inline ml-auto mbl-hidden">
                    <div class="filter-item">
                        {{trans('words.item_per_page')}}
                        <select class="form-control form-control-sm per_page" onchange="setPerPage(this)">
                            <option value="5">{{App\Services\HelperService::formattedNumber(5)}}</option>
                            <option value="10">{{App\Services\HelperService::formattedNumber(10)}}</option>
                            <option value="15">{{App\Services\HelperService::formattedNumber(15)}}</option>
                            <option value="20">{{App\Services\HelperService::formattedNumber(20)}}</option>
                            <option value="50">{{App\Services\HelperService::formattedNumber(50)}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="data_content">
                        @include('pages.employerList.content')
                    </div>
                </div>
            </div>

            <div class="pagination-wrapper">
                <nav aria-label="Page navigation example">
                    {{$records->render()}}
                </nav>

                <div class="form-inline ml-auto mbl-hidden mb-4">
                    <div class="filter-item">
                        {{trans('words.item_per_page')}}
                        <select class="form-control form-control-sm per_page" onchange="setPerPage(this)">
                            <option value="5">{{App\Services\HelperService::formattedNumber(5)}}</option>
                            <option value="10">{{App\Services\HelperService::formattedNumber(10)}}</option>
                            <option value="15">{{App\Services\HelperService::formattedNumber(15)}}</option>
                            <option value="20">{{App\Services\HelperService::formattedNumber(20)}}</option>
                            <option value="50">{{App\Services\HelperService::formattedNumber(50)}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(window).ready(function () {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData.hasOwnProperty('per_page') ? $(".per_page").val(filterData.per_page.id) : $(".per_page").val(20);

            setFiltersDefaultValue();
            isShowResetBtn()
        })

        function setFiltersDefaultValue() {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};

            if (filterData && !jQuery.isEmptyObject(filterData)) {
                $.each(filterData, function (key, item) {
                    if (key === 'per_page') {
                        return;
                    }

                    if (key === 'search_value') {
                        $('#search_value').val(item.id)
                    } else if (key === 'organization_type_id') {
                        $('#organization_type').val(JSON.stringify(item))
                    } else if (key === 'start_with') {
                        $('#' + item.id).addClass('active')
                    }
                });
            }
        }

        function removeFilter(key) {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            if (filterData) {
                delete filterData[key];
                localStorage.setItem('filter', JSON.stringify(filterData));
            }

            window.history.pushState({}, document.title, getQueryParams());
            loadData();
            isShowResetBtn();

            if (key === 'search_value') {
                $('#search_value').val('')
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
                url: "{{url('company-list')}}" + getQueryParams(),

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

        function setPerPage(obj) {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData.per_page = {id: obj.value};
            localStorage.setItem('filter', JSON.stringify(filterData));

            window.location.assign("{{url('company-list')}}" + getQueryParams())
        }

        $(function () {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                window.location.assign($(this).attr('href') + getQueryParams().replace('?', ''))
            });
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

            loadData();
            isShowResetBtn();

            window.history.pushState({}, document.title, getQueryParams());
        }

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

                window.location.assign("{{url('company-list')}}" + getQueryParams())
            }
        }

        function resetFilters() {
            localStorage.removeItem('filter')

            $('#search_value').val('')
            $('#organization_type').val('')
            $('.btn_option').removeClass('active')

            window.history.pushState({}, document.title, '?');
            loadData();
            isShowResetBtn();
        }

        function isShowResetBtn() {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            if (jQuery.isEmptyObject(filterData)) {
                $('#clear_btn').hide()
            } else {
                $('#clear_btn').show()
            }
        }

        function onClickBtn(obj, item, key) {
            $('.btn_option').removeClass('active')
            $(obj).addClass('active');
            setFilter(item, key)
        }
    </script>

    <script>

    </script>
@endsection
