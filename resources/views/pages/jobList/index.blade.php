@extends('_partials.app')

@section('title', env('APP_NAME'))

@section('main_container')
    <div class="job-search-wrapper">
        <div class="container">
            <div class="row py-3">
                <div class="col-sm-6">
                    <h5>
                        <span class="badge badge-pill badge-success" id="total_records">
                            {{App\Services\HelperService::formattedNumber($totalRecords)}}
                        </span>
                        {{trans('words.job_found_title')}}
                    </h5>
                </div>
                <div class="col-sm-6">
                    <div class="pagination justify-content-end" id="paginate-section"></div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <p class="d-inline-block mb-0"><b>{{trans('words.active_filter_title')}}:</b></p>
                            <div id="filter_section"
                                 style="display: inline-block;padding: 4px 0;border-radius: 3px;font-weight: 500;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="col-sidebar-wrapper">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-tags"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.keyword_filter')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <label for="search_value">{{trans('words.keyword_filter_title')}}</label>
                                            <div class="input-group">
                                                <input type="search" class="form-control form-control-sm"
                                                       id="search_value"
                                                       placeholder="Search for..." aria-label="search"
                                                       aria-describedby="search-text">
                                                <div class="input-group-append">
                                                    <a href="javascript:" onclick="searchByValue()"
                                                       class="input-group-text text-white border-success bg-success"
                                                       id="search-text">
                                                        <i class="icofont-search-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-list"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.category_filter')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col">
                                                    <label>{{trans('words.category_filter_fun')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="all_cat_fun"
                                                                   onchange="setFilter({id: 'all_cat_fun', title_en: 'All Category (Functional)', title_bn: 'সকল ক্যাটাগরি (ক্রিয়ামূলক)'}, 'category')"
                                                                   name="category" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="all_cat_fun">{{trans('words.all_cat_fun')}}</label>
                                                        </div>

                                                        @foreach($data['categories'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="cat_{{$item->id}}"
                                                                       onchange="setFilter({{$item}}, 'category')"
                                                                       name="category" class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="cat_{{$item->id}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label>{{trans('words.category_filter_special')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="all_cat_skilled"
                                                                   onchange="setFilter({id: 'all_cat_special', title_en: 'All Category (Special Skilled)', title_bn: 'সকল ক্যাটাগরি (স্পেশাল স্কিল্‌ড)'}, 'category')"
                                                                   name="category" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="all_cat_skilled">{{trans('words.all_cat_special')}}</label>
                                                        </div>

                                                        @foreach($data['categories_special_skilled'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="cat_{{$item->id}}"
                                                                       onchange="setFilter({{$item}}, 'category')"
                                                                       name="category" class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="cat_{{$item->id}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="custom-control custom-radio mt-3">
                                                        <input type="radio" id="all_cat"
                                                               onchange="setFilter({id: 'all_cat', title_en: 'All Category', title_bn: 'সকল ক্যাটাগরি'}, 'category')"
                                                               name="category" class="custom-control-input">
                                                        <label class="custom-control-label"
                                                               for="all_cat">{{trans('words.all_cat')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-building"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.industry_filter')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col">
                                                    <label>{{trans('words.org_type')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="any_organization"
                                                                   onchange="setFilter({id: '', title_en: '', title_bn: ''}, 'organization_type_id')"
                                                                   name="organization_type_id"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="any_organization">{{trans('words.org_type_any')}}</label>
                                                        </div>

                                                        @foreach($data['organization_types'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="organization_{{$item->id}}"
                                                                       onchange="setFilter({{$item}}, 'organization_type_id')"
                                                                       name="organization_type_id"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="organization_{{$item->id}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label>{{trans('words.industry_type')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="any_industry"
                                                                   onchange="setFilter({id: '', title_en: ''}, 'industry_type_id')"
                                                                   name="industry_type_id" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="any_industry">{{trans('words.industry_type_any')}}</label>
                                                        </div>

                                                        @foreach($data['industry_types'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="industry_{{$item->id}}"
                                                                       onchange="setFilter({{$item}}, 'industry_type_id')"
                                                                       name="industry_type_id"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="industry_{{$item->id}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-location-pin"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.location_filter')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col">
                                                    <label>{{trans('words.location_filter')}}</label>
                                                    <div style="border: 1px solid #5f5f5f;padding: 10px 15px;">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="inside_bd" name="location_type"
                                                                   class="custom-control-input"
                                                                   onchange="subDistrictsBySlug('dhaka', 'inside_bd')"
                                                                   checked>
                                                            <label class="custom-control-label"
                                                                   for="inside_bd">{{trans('words.inside_bd')}}</label>
                                                        </div>
                                                        <div class="category-item-wrapper ml-3 mt-2">
                                                            @foreach($data['divisions'] as $item)
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="division_{{$item->slug}}"
                                                                           name="division"
                                                                           @if ($item->slug == 'dhaka') checked @endif
                                                                           class="custom-control-input"
                                                                           onchange="subDistrictsBySlug('{{$item->slug}}', 'inside_bd')">
                                                                    <label class="custom-control-label"
                                                                           for="division_{{$item->slug}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="custom-control custom-radio mt-2">
                                                            <input type="radio" id="outside_bd"
                                                                   onchange="subDistrictsBySlug('', 'outside_bd')"
                                                                   name="location_type" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="outside_bd">{{trans('words.outside_bd')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <h2 class="mb-0"><i class="icofont-swoosh-right"></i></h2>
                                                </div>
                                                <div class="col">
                                                    <div class="category-item-wrapper" style="margin-top: 62px"
                                                         id="sub_area_section">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-ui-calendar"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.posted_deadline_menu')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col">
                                                    <label>{{trans('words.posted_within')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="any_post_within"
                                                                   onchange="setFilter({id: '', title_en: '', title_bn: ''}, 'post_within')"
                                                                   name="post_within" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="any_post_within">{{trans('words.posted_within_any')}}</label>
                                                        </div>

                                                        @foreach($data['post_date_range'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="post_within{{$item['id']}}"
                                                                       onchange="setFilter({{collect($item)}}, 'post_within')"
                                                                       name="post_within"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="post_within{{$item['id']}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label>{{trans('words.deadline')}}</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="any_deadline"
                                                                   onchange="setFilter({id: '', title_en: '', title_bn: ''}, 'deadline')"
                                                                   name="deadline" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="any_deadline">{{trans('words.posted_within_any')}}</label>
                                                        </div>

                                                        @foreach($data['deadline_range'] as $item)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="deadline{{$item['id']}}"
                                                                       onchange="setFilter({{collect($item)}}, 'deadline')"
                                                                       name="deadline"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                       for="deadline{{$item['id']}}">{{App\Services\HelperService::formattedTitle($item)}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            {{--<li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-newspaper"></i>
                                        <span class="d-block">Newspaper Job</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Newspaper List</label>
                                                    <div class="category-item-wrapper">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="allCategoryFunctional"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="allCategoryFunctional">All Category
                                                                (Functional)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="accountingFinance"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label" for="accountingFinance">Accounting/Finance</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="agro" name="customRadio"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label" for="agro">Agro(Plant/Animal/Fisheries)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="allCategoryFunctional"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="allCategoryFunctional">All Category
                                                                (Functional)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="accountingFinance"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label" for="accountingFinance">Accounting/Finance</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="agro" name="customRadio"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label" for="agro">Agro(Plant/Animal/Fisheries)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="allCategoryFunctional"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="allCategoryFunctional">All Category
                                                                (Functional)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="accountingFinance"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label" for="accountingFinance">Accounting/Finance</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="agro" name="customRadio"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label" for="agro">Agro(Plant/Animal/Fisheries)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="allCategoryFunctional"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label"
                                                                   for="allCategoryFunctional">All Category
                                                                (Functional)</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="accountingFinance"
                                                                   name="customRadio" class="custom-control-input">
                                                            <label class="custom-control-label" for="accountingFinance">Accounting/Finance</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="agro" name="customRadio"
                                                                   class="custom-control-input">
                                                            <label class="custom-control-label" for="agro">Agro(Plant/Animal/Fisheries)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>--}}
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="icofont-filter"></i>
                                        <span
                                            class="d-none d-sm-none d-md-block">{{trans('words.other_filter_menu')}}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <form class="px-4">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <label class="d-block">{{trans('words.gender')}}</label>
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" id="g_male" class="custom-control-input"
                                                               onchange="onChangeCheckbox(this, 'g_male', 'Male', 'পুরুষ')">
                                                        <label class="custom-control-label mt-1"
                                                               for="g_male">{{trans('words.g_male')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" id="g_female"
                                                               class="custom-control-input"
                                                               onchange="onChangeCheckbox(this, 'g_female', 'Female', 'মহিলা')">
                                                        <label class="custom-control-label mt-1"
                                                               for="g_female">{{trans('words.g_female')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" id="g_other"
                                                               class="custom-control-input"
                                                               onchange="onChangeCheckbox(this, 'g_other', 'Other', 'অন্যান্য')">
                                                        <label class="custom-control-label mt-1"
                                                               for="g_other">{{trans('words.g_other')}}</label>
                                                    </div>
                                                    {{--                                                    <label class="my-2 d-block">Accessibility for Person with Disability--}}
                                                    {{--                                                        <span class="badge badge-info">New</span></label>--}}
                                                    {{--                                                    <div class="custom-control custom-checkbox">--}}
                                                    {{--                                                        <input type="checkbox" class="custom-control-input"--}}
                                                    {{--                                                               id="JobsPreferPersonDisability">--}}
                                                    {{--                                                        <label class="custom-control-label"--}}
                                                    {{--                                                               for="JobsPreferPersonDisability">Jobs prefer person with--}}
                                                    {{--                                                            disability</label>--}}
                                                    {{--                                                    </div>--}}
                                                    {{--                                                    <div class="custom-control custom-checkbox">--}}
                                                    {{--                                                        <input type="checkbox" class="custom-control-input"--}}
                                                    {{--                                                               id="CompaniesProvideFacilitiesDisability">--}}
                                                    {{--                                                        <label class="custom-control-label"--}}
                                                    {{--                                                               for="CompaniesProvideFacilitiesDisability">Companies--}}
                                                    {{--                                                            provide facilities for person with disability</label>--}}
                                                    {{--                                                    </div>--}}
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-2">
                                                            <label
                                                                for="job_nature">{{trans('words.job_nature')}}</label>
                                                            <select class="form-control form-control-sm" id="job_nature"
                                                                    onchange="onchangeDropdown(this, 'job_nature')">
                                                                <option
                                                                    value='{"id": "", "title": ""}'>{{trans('words.job_nature_any')}}</option>

                                                                @foreach($data['job_natures'] as $item)
                                                                    <option
                                                                        value="{{collect($item)}}">{{$item['title']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="job_level">{{trans('words.job_level')}}</label>
                                                            <select class="form-control form-control-sm" id="job_level"
                                                                    onchange="onchangeDropdown(this, 'job_level')">
                                                                <option
                                                                    value='{"id": "", "title": ""}'>{{trans('words.job_level_any')}}</option>

                                                                @foreach($data['job_levels'] as $item)
                                                                    <option
                                                                        value="{{collect($item)}}">{{$item['title']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-2">
                                                            <label for="exp_range">{{trans('words.exp_range')}}</label>
                                                            <select class="form-control form-control-sm" id="exp_range"
                                                                    onchange="onchangeDropdown(this, 'exp_range')"
                                                                    id="experienceRange">
                                                                <option
                                                                    value='{"id": "", "title_en": "", title_bn: ""}'>{{trans('words.range_any')}}</option>

                                                                @foreach($data['exp_range'] as $item)
                                                                    <option
                                                                        value="{{collect($item)}}">{{App\Services\HelperService::formattedTitle($item)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="age_range">{{trans('words.age_range')}}</label>
                                                            <select class="form-control form-control-sm" id="age_range"
                                                                    onchange="onchangeDropdown(this, 'age_range')"
                                                                    id="age_range">
                                                                <option
                                                                    value='{"id": "", "title_en": "", "title_bn": ""}'>{{trans('words.range_any')}}</option>

                                                                @foreach($data['age_range'] as $item)
                                                                    <option
                                                                        value="{{collect($item)}}">{{App\Services\HelperService::formattedTitle($item)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-2">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" id="work_from_home"
                                                                       class="custom-control-input"
                                                                       onchange="onChangeCheckbox(this, 'work_from_home', 'Work from Home', 'বাসা থেকে অফিস')">
                                                                <label class="custom-control-label"
                                                                       for="work_from_home">{{trans('words.work_from_home_menu')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            {{--                                                            <div--}}
                                                            {{--                                                                class="custom-control custom-checkbox custom-control-inline">--}}
                                                            {{--                                                                <input type="checkbox" id="preferredRetiredArmy"--}}
                                                            {{--                                                                       class="custom-control-input">--}}
                                                            {{--                                                                <label class="custom-control-label"--}}
                                                            {{--                                                                       for="preferredRetiredArmy">Preferred Retired--}}
                                                            {{--                                                                    Army</label>--}}
                                                            {{--                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="btn-group dropright">
                                    <a href="javascript:" class="dropdown-toggle filt-close-wrap"
                                       onclick="resetFilters()">
                                        <span>
                                            <span
                                                class="d-none d-sm-none d-md-block">{{trans('words.clear_filter_all')}}</span>
                                            <i class="icofont-close i-close"></i>
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-9">
                                            <div class="d-inline">
                                                <p class=""
                                                   style="font-weight: 500">{{trans('words.view_detail_instruction')}}</p>

                                                <i id="loader" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                                   style="display:none"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <form class="form-inline">
                                                <label class="mr-2">{{trans('words.job_per_page')}}</label>
                                                <select class="form-control form-control-sm" id="per_page"
                                                        onchange="setPerPage(this)">
                                                    <option
                                                        value="5">{{App\Services\HelperService::formattedNumber(5)}}</option>
                                                    <option
                                                        value="10">{{App\Services\HelperService::formattedNumber(10)}}</option>
                                                    <option
                                                        value="20">{{App\Services\HelperService::formattedNumber(20)}}</option>
                                                    <option
                                                        value="30">{{App\Services\HelperService::formattedNumber(30)}}</option>
                                                    <option
                                                        value="50">{{App\Services\HelperService::formattedNumber(50)}}</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <div id="data_content">
                                        @include('pages.jobList.content')
                                    </div>

                                    @if(@$data['ads']['5'])
                                        @foreach(collect($data['ads']['5']) as $ad)
                                            <div class="job-container-wrapper">
                                                <div class="card circular-list-wrapper">
                                                    <div class="card-body">
                                                        <div class="widget">
                                                            <a href="{{$ad->url}}" target="_blank">
                                                                <img src="{{$ad->image}}" alt="" class="img-fluid">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 sidebar-add-wrapper">
                            @if(@$data['ads']['1'])
                                @foreach(collect($data['ads']['1']) as $ad)
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
    </div>

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
    <script type="text/javascript">
        $(window).ready(function () {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : {};
            filterData.hasOwnProperty('per_page') ? $("#per_page").val(filterData.per_page.id) : $("#per_page").val(20);

            subDistrictsBySlug('dhaka', 'inside_bd')

            loadFilters();

            if (filterData) {
                if (filterData.hasOwnProperty('category')) {
                    $(document).prop('title', filterData.category.title_en);

                } else if (filterData.hasOwnProperty('job_nature')) {
                    if (filterData.job_nature.id === 2) {
                        $(document).prop('title', 'Part time jobs in Bangladesh');
                    }
                } else if (filterData.hasOwnProperty('work_from_home')) {
                    $(document).prop('title', 'Search jobs- also govt., newspaper job, post resume & apply online');
                }
            }
        })

        function loadFilters() {
            const filterData = localStorage.getItem('filter') ? JSON.parse(localStorage.getItem('filter')) : null;
            if (filterData && !jQuery.isEmptyObject(filterData)) {
                let filterHtml = '';
                $.each(filterData, function (key, item) {
                    if (key === 'per_page') {
                        return;
                    }

                    if (key === 'job_nature' || key === 'job_level') {
                        filterHtml += `<div class="filter-reg">
                                        <span class="filter-reg-item">
                                            ${item.title}
                                            <a href="javascript:" class="ml-1" onclick="removeFilter('${key}')"><i class="icofont-close-circled"></i></a>
                                        </span>
                                    </div>`
                    } else {
                        filterHtml += `<div class="filter-reg">
                                        <span class="filter-reg-item">
                                            ${formattedTitle(item)}

                                            <a href="javascript:" class="ml-1" onclick="removeFilter('${key}')"><i class="icofont-close-circled"></i></a>
                                        </span>
                                    </div>`
                    }

                    setFiltersDefaultValue(key, item);
                });

                $('#filter_section').html(filterHtml);
            } else {
                $('#filter_section').empty();
            }
        }

        function setFiltersDefaultValue(key, item) {
            if (key === 'search_value') {
                $('#search_value').val(item.id)
            } else if (key === 'category') {
                $(`#cat_${item.id}`).prop("checked", true)
            } else if (key === 'industry_type_id') {
                $(`#industry_${item.id}`).prop("checked", true);
            } else if (key === 'organization_type_id') {
                $(`#organization_${item.id}`).prop("checked", true);
            } else if (key === 'post_within') {
                $(`#post_within${item.id}`).prop("checked", true);
            } else if (key === 'deadline') {
                $(`#deadline${item.id}`).prop("checked", true);
            } else if (key === 'exp_range') {
                $("#exp_range").val(JSON.stringify(item));
            } else if (key === 'age_range') {
                $("#age_range").val(JSON.stringify(item));
            } else if (key === 'job_nature') {
                $("#job_nature").val(JSON.stringify(item));
            } else if (key === 'job_level') {
                $("#job_level").val(JSON.stringify(item));
            } else if (key === 'work_from_home') {
                $('#work_from_home').prop('checked', item.id);
            } else if (key === 'g_female') {
                $('#g_female').prop('checked', item.id);
            } else if (key === 'g_male') {
                $('#g_male').prop('checked', item.id);
            } else if (key === 'g_other') {
                $('#g_other').prop('checked', item.id);
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

            if (key === 'search_value') {
                $('#search_value').val('')
            } else if (key === 'category') {
                $("#all_cat").prop("checked", true);
            } else if (key === 'industry_type_id') {
                $("#any_industry").prop("checked", true);
            } else if (key === 'organization_type_id') {
                $("#any_organization").prop("checked", true);
            } else if (key === 'post_within') {
                $("#any_post_within").prop("checked", true);
            } else if (key === 'deadline') {
                $("#any_deadline").prop("checked", true);
            } else if (key === 'exp_range') {
                $("#exp_range").val('{"id": "", "title_en": ""}');
            } else if (key === 'age_range') {
                $("#age_range").val('{"id": "", "title_en": ""}');
            } else if (key === 'job_nature') {
                $("#job_nature").val('{"id": "", "title": ""}');
            } else if (key === 'job_level') {
                $("#job_level").val('{"id": "", "title": ""}');
            } else if (key === 'work_from_home') {
                $('#work_from_home').prop('checked', false);
            } else if (key === 'g_male') {
                $('#g_male').prop('checked', false);
            } else if (key === 'g_female') {
                $('#g_female').prop('checked', false);
            } else if (key === 'g_other') {
                $('#g_other').prop('checked', false);
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
                url: formattedUrl("{{url('job-lists')}}" + getQueryParams()),

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

            window.location.assign(formattedUrl("{{url('job-lists')}}" + getQueryParams()))
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

        function searchByValue() {
            const searchValue = $('#search_value').val();
            if (searchValue) {
                setFilter({id: searchValue, title_en: searchValue}, 'search_value')
            }
        }

        function resetFilters() {
            localStorage.removeItem('filter')
            loadFilters()

            $('#search_value').val('')
            $("#all_cat").prop("checked", true);
            $("#any_industry").prop("checked", true);
            $("#any_organization").prop("checked", true);
            $("#any_post_within").prop("checked", true);
            $("#any_deadline").prop("checked", true);
            $("#exp_range").val('{"id": "", "title_en": ""}');
            $("#age_range").val('{"id": "", "title_en": ""}');
            $("#job_nature").val('{"id": "", "title": ""}');
            $("#job_level").val('{"id": "", "title": ""}');
            $('#work_from_home').prop('checked', false);
            $('#g_female').prop('checked', false);
            $('#g_male').prop('checked', false);
            $('#g_other').prop('checked', false);

            window.history.pushState({}, document.title, '?');

            loadData()
        }

        function onchangeDropdown(obj, key) {
            setFilter(JSON.parse(obj.value), key)
        }

        function onChangeCheckbox(obj, key, title_en, title_bn) {
            const title = formattedTitle({title_en: title_en, title_bn: title_bn})
            if (obj.checked) {
                setFilter({id: obj.checked, title_en: title, title_bn: title}, key)
            } else {
                setFilter({id: '', title_en: '', title_bn: ''}, key)
            }
        }
    </script>

    <script>
        function districts(value) {
            if (value === 'inside_bd') {
                return  <?php  echo $data['divisions']; ?>
            }

            return  <?php  echo $data['outside_bd']; ?>
        }

        function subDistrictsBySlug(slug, locationType) {
            let subLocations = [];
            let html = '';

            if (locationType === 'inside_bd') {
                const data = districts(locationType).find(x => x.slug === slug);
                subLocations = data ? data.sub_areas : [];

                html = `<div class="custom-control custom-radio">
                             <input type="radio" id="all_location" name="location" class="custom-control-input"
                                onchange="setFilter({id: 'all_${locationType}' , title_en: 'All in ${formattedTitle(data)}', title_bn: 'All in ${formattedTitle(data)}'}, 'location')">
                             <label class="custom-control-label" for="all_location">All in ${formattedTitle(data)}</label>
                        </div>`;


                $('#division_' + `${slug}`).prop('checked', true);

            } else {
                subLocations = districts(locationType)

                html = `<div class="custom-control custom-radio">
                             <input type="radio" id="all_location" name="location" class="custom-control-input"
                                onchange="setFilter({id: 'all_${locationType}' , title_en: 'All Overseas', title_bn: 'সমস্ত বিদেশী'}, 'location')">
                             <label class="custom-control-label" for="all_location">All in Overseas</label>
                        </div>`;

                $('input[name=division]').prop('checked', false);
            }


            $.each(subLocations, function (key, item) {//console.log(item)
                html += `<div class="custom-control custom-radio">
                                <input type="radio" id="` + key + `" name="location" class="custom-control-input"
                                   onchange="setFilter({id: '${item.id}' , title_en: '${item.title_en}', title_bn: '${item.title_bn}'}, 'location')">
                                <label class="custom-control-label" for="` + key + `">${formattedTitle(item)}</label>
                              </div>`
            });


            $('#sub_area_section').html(html)
        }
    </script>
@endsection
