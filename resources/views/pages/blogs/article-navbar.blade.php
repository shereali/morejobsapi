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

<div class="col-xl-4 col-md-4 col-sm-4">
    <div class="card">
        <div class="card-body">
            <h5 class="">{{trans('words.keyword_filter_title')}}</h5>

            <div class="input-group">
                <input type="search" class="form-control form-control-sm" placeholder="Search" id="search_value">
                <div class="input-group-btn">
                    <button class="btn btn-default" onclick="searchByValue()"
                            style="border-left: none; border-radius: 0 4px 4px 0; height: 100%">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <hr>

            @php
                $currentPageNo = $list->currentPage();
                $pageNoParams = null;
                if($currentPageNo)
                    $pageNoParams = "?page=$currentPageNo";
            @endphp

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="" style="margin: 0 auto">Articles</h5>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach($list->take(6) as $value)
                            <a href="{{url($type['url'])}}/{{$value['id']}}{{$pageNoParams}}"
                               class="list-group-item"> {{$value['title']}}</a>
                        @endforeach

                        @if(count($list) > 6)
                            <div id="categories" class="collapse">
                                @foreach($list->slice(6) as $value)
                                    <a href="{{url($type['url'])}}/{{$value['id']}}{{$pageNoParams}}"
                                       class="list-group-item"> {{$value['title']}}</a>
                                @endforeach
                            </div>

                            <button id="more_less_btn" class="btn btn-default btn-sm btn-block" data-toggle="collapse"
                                    data-target="#categories" data-text="more"><span id="btn_title">More</span> <i class="fa fa-caret-down"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<script src="{{ asset('js/searchFunctions.js')}}"></script>--}}

<script>
    $('#more_less_btn').on('click', function () {
        let currentText = $(this).attr('data-text');

        if (currentText === 'more'){
            $(this).attr('data-text', 'less');
            $(this).children('#btn_title').text('Less')
            $(this).children('.fa').removeClass('fa-caret-down').addClass('fa-caret-up')
        }else {
            $(this).attr('data-text', 'more');
            $(this).children('#btn_title').text('More')
            $(this).children('.fa').removeClass('fa-caret-up').addClass('fa-caret-down')
        }
    });

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

            window.open("{{url('job-lists')}}" + getQueryParams(), '_blank')
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

