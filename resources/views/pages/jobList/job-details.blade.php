@extends('_partials.app')

@section('title', $post->title)

@section('main_container')
    <div class="float-right">
        @include('_partials.messages')
    </div>

    <div>
        <div class="job-details-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-body">
                                <div id="alert-section"></div>

                                @if(\Carbon\Carbon::now()->toDateTimeString() > $post->deadline)
                                    <div class="alert alert-danger text-center">
                                        The job is expired
                                    </div>
                                @endif

                                @if($post->job_listing_type_id == 1)
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h5 class="job-title">{{$post->title}}</h5>
                                            <p><b>{{$post->company->title_en}}</b></p>
                                            <h6 class="sub-title mb-3">Vacancy:
                                                <b class="text-dark">{{$post->no_of_vacancy ? $post->no_of_vacancy : 'Not specific'}}</b>
                                            </h6>
                                            <h6 class="sub-title">Job Context</h6>
                                            <ul>{!! $post->job_context !!}</ul>
                                            <h6 class="sub-title">Job Responsibilities</h6>
                                            <ul>{!! $post->responsibilities !!}</ul>
                                            <h6 class="sub-title">Employment Status</h6>
                                            <p>{{implode(', ', $post->postNatures->pluck('title')->toArray())}}</p>
                                            <h6 class="sub-title">Educational Requirements</h6>
                                            <ul>
                                                <li>{{implode(', ', $post->postDegrees->pluck('title')->toArray())}}</li>
                                                <li>Skills Required:
                                                    {{implode(', ', $post->postAreaExperiences->pluck('title')->toArray())}}
                                                </li>
                                            </ul>
                                            <h6 class="sub-title">Experience Requirements</h6>
                                            <ul>
                                                <li>{{$post->experience_min}} to {{$post->experience_max}} year(s)</li>
                                                @if($post->is_fresher_allowed)
                                                    <li>Freshers are also encouraged to apply</li>
                                                @endif
                                            </ul>
                                            <h6 class="sub-title">Additional Requirements</h6>
                                            <ul>
                                                <li>Age {{$post->age_min}} to {{$post->age_max}} years</li>
                                                    @if(count($post->postGenders) > 1)
                                                    <li>
                                                        <span>Both {{implode(', ', $post->postGenders->pluck('title')->toArray())}} are allowed to apply</span>
                                                    </li>

                                                @elseif(count($post->postGenders) == 1)
                                                    <li>
                                                        <span>Only {{implode(', ', $post->postGenders->pluck('title')->toArray())}} is allowed to apply</span>
                                                    </li>
                                                @endif
                                                @if($post->additional_requirements)
                                                    {!! $post->additional_requirements !!}
                                                @endif
                                            </ul>
                                            <h6 class="sub-title">Workplace</h6>
                                            <ul>
                                                <li>{{implode(', ', $post->postWorkspaces->pluck('title')->toArray())}}</li>
                                            </ul>
                                            <h6 class="sub-title">Job Location</h6>
                                            <p>{{implode(', ', $post->postAreas->pluck('title')->toArray())}}</p>
                                            <h6 class="sub-title">Salary</h6>
                                            <ul>
                                                <li>
                                                    @if($post->is_display_salary == 1)
                                                        <span>Negotiable</span>
                                                    @else
                                                        TK.{{$post->salary_min}} - {{$post->salary_max}}
                                                        ({{$post->salary_type == 1 ? 'Hourly' : ($post->salary_type == 2 ? 'Daily' : ($post->salary_type == 3 ? 'Monthly' : 'Yearly'))}}
                                                        )
                                                    @endif
                                                </li>
                                                <li>{{$post->additional_salary_info}}</li>
                                            </ul>
                                            <h6 class="sub-title">Compensation & other benefits</h6>
                                            <ul>
                                                @foreach(isset($post->other_benefit->benefits) ? $post->other_benefit->benefits : [] as $item)
                                                    <li>{{$item->title}}</li>
                                                @endforeach
                                                <li>Lunch
                                                    Facilities: {{@$post->other_benefit->lunch_facility == 1 ? 'Partially Subsidize' : 'Full Subsidize'}}</li>
                                                <li>Festival Bonus: {{@$post->other_benefit->festival_bonus}}</li>
                                                <li>Salary
                                                    Review: {{@$post->other_benefit->salary_review === 1 ? 'Half Yearly' : 'Yearly'}}</li>
                                                @if(@$post->other_benefit->other)
                                                    <li>{{$post->other_benefit->other}}</li>
                                                @endif
                                            </ul>
                                            <h6 class="sub-title">Job Source</h6>
                                            <p><span>-</span> MoreJobs.com Online Job Posting.</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="details-category-wrapper">
                                                <p class="mb-0">{{trans('words.category')}}:
                                                    <b>{{App\Services\HelperService::formattedTitle($post->category)}}</b>
                                                </p>
                                                <a href="javascript:void(0)" class="text-primary my-2 d-block"
                                                   data-toggle="modal" data-target="#modal"
                                                   onclick=loadModal("{{url('company-list/'.$post->company_id.'/available-jobs')}}")>
                                                    {{trans('words.views_all_jobs')}}
                                                </a>
                                            </div>

                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title text-uppercase text-success">{{trans('words.job_summary')}}</h6>
                                                    <p class="card-text"><b>{{trans('words.posted_on')}}
                                                            :</b> {{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($post->created_at)->format('d M Y'))}}
                                                    </p>
                                                    <p class="card-text">
                                                        <b>{{trans('words.vacancy')}}
                                                            :</b> {{$post->no_of_vacancy ? App\Services\HelperService::formattedNumber($post->no_of_vacancy) : trans('words.not_specific')}}
                                                    </p>
                                                    <p class="card-text"><b>{{trans('words.job_nature')}}
                                                            :</b> {{implode(', ', $post->postNatures->pluck('title')->toArray())}}
                                                    </p>
                                                    <p class="card-text"><b>{{trans('words.age')}}
                                                            :</b> {{App\Services\HelperService::formattedNumber($post->age_min)}}
                                                        {{trans('words.to')}} {{App\Services\HelperService::formattedNumber($post->age_max)}} {{trans('words.years')}}
                                                    </p>
                                                    <p class="card-text"><b>{{trans('words.experience')}}
                                                            :</b> {{App\Services\HelperService::formattedNumber($post->experience_min)}}
                                                        {{trans('words.to')}} {{App\Services\HelperService::formattedNumber($post->experience_max)}} {{trans('words.years')}}
                                                    </p>
                                                    <p class="card-text"><b>{{trans('words.job_location')}}:</b>
                                                        {{count($post->postAreas) > 0 ? App\Services\HelperService::formattedArrayTitle($post->postAreas) : trans('words.any_where_bd')}}
                                                    </p>
                                                    <p class="card-text"><b>{{trans('words.salary')}}:</b>
                                                        @if($post->is_display_salary == 1)
                                                            <span>{{trans('words.negotiable')}}</span>
                                                        @else
                                                            {{trans('words.tk')}} {{App\Services\HelperService::formattedNumber($post->salary_min)}}
                                                            - {{App\Services\HelperService::formattedNumber($post->salary_max)}}
                                                            ({{$post->salary_type == 1 ? trans('words.hourly') : ($post->salary_type == 2 ? trans('words.daily') : ($post->salary_type == 3 ? trans('words.monthly') : trans('words.yearly')))}}
                                                            )
                                                        @endif
                                                    </p>
                                                    <p class="card-text">
                                                        <b>{{trans('words.application_deadline')}}
                                                            :</b> {{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($post->deadline)->format('d M Y'))}}
                                                    </p>
                                                </div>
                                            </div>

                                            @if(@$post['ads']['7'])
                                                <div class="mt-4">
                                                    @foreach(collect($post['ads']['7']) as $ad)
                                                        <div class="single-border-box">
                                                            <a href="{{$ad->url}}" target="_blank">
                                                                <img src="{{$ad->image}}" alt="" class="img-fluid">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <p class="card-text" id="shortlist_section">
                                                        <i class="fa fa-star"></i>
                                                        <a style="cursor: pointer"
                                                           onclick="shortlist()"> {{trans('words.shortlist_job')}}</a>
                                                    </p>
                                                    <hr>
                                                    <p class="card-text">
                                                        <i class="fa fa-print"></i>
                                                        <a style="cursor: pointer"
                                                           onclick="print()"> {{trans('words.print_job')}}</a>
                                                    </p>
                                                    <hr>
                                                    <p class="card-text">
                                                        <a href="javascript:void(0)" data-toggle="modal"
                                                           data-target="#modal"
                                                           onclick=loadModal("{{url('company-list/'.$post->company_id.'/available-jobs')}}")>
                                                            <i class="fa fa-eye"></i> {{trans('words.views_all_jobs')}}
                                                        </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 text-center mt-3">
                                            @if(\Carbon\Carbon::now()->toDateTimeString() < $post->deadline)
                                                <p class="sub-color"><b><u>{{trans('words.read_before_apply')}}</u></b>
                                                </p>
                                                <p>{{$post->special_instruction}}</p>
                                                @if($post->is_profile_image)
                                                    <p>{!! trans('words.photograph_instruction')  !!}</p>
                                                @endif
                                                <h6 class="mb-3">{{trans('words.apply_procedure')}}</h6>

                                                @if(@$post->resume_receiving_option->is_apply_online)
                                                    <button id="apply_online" class="btn btn-success mb-3">
                                                        {{trans('words.apply_online')}}
                                                    </button>
                                                @endif

                                                <hr>

                                                @if(@$post->resume_receiving_option->resume_receiving_option == 'email')
                                                    <p class="sub-title">{{trans('words.email')}}</p>
                                                    <p>{{trans('words.sent_cv_ins_first')}}
                                                        <b>{{@$post->resume_receiving_option->resume_receiving_details}}</b> {!! trans('words.sent_cv_ins_last') !!}
                                                        <a href="javascript:">{{trans('words.click_here')}}</a>
                                                    </p>
                                                @endif
                                                <p>{{trans('words.application_deadline')}}:
                                                    <b>{{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($post->deadline)->format('d M Y'))}}</b>
                                                </p>

                                                <hr>
                                            @endif
                                            <div class="job-m-footer">
                                                <p class="mb-1"><b>{{trans('words.publish_on')}}</b></p>
                                                <p>{{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($post->updated_at)->format('d M Y'))}}</p>

                                                <p class="mb-1"><b>{{trans('words.company_info')}}</b></p>
                                                <p class="footer-text">{{App\Services\HelperService::formattedTitle($post->company)}}</p>

                                                @if($post->company->address_en || $post->company->address_bn)
                                                    <p class="footer-text">{{trans('words.address')}}
                                                        : {{App\Services\HelperService::formattedTitle($post->company, 'address')}}</p>
                                                @endif

                                                @if($post->company->website)
                                                    <p class="footer-text">{{trans('words.web')}}:
                                                        <a href="//{{$post->company->website}}"
                                                           target="_blank">{{$post->company->website}}</a>
                                                    </p>
                                                @endif

                                                @if($post->company->about)
                                                    <p class="footer-text">{{trans('words.about')}}
                                                        : {{$post->company->about}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="float-right">
                                                        <b>{{trans('words.source')}}</b>: {{$post->source}}
                                                        ({{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($post->publish_date)->format('d M Y'))}}
                                                        )
                                                    </p>
                                                </div>

                                                <div class="col-sm-12 mt-4">
                                                    {{$post->title}}<br>
                                                    <span
                                                        class="text-success">{{App\Services\HelperService::formattedTitle($post->company)}}</span>
                                                </div>

                                                <div class="col-sm-12 mt-2">
                                                    <img class="col-12 d-block m-auto" src="{{$post->image}}">

                                                    <p class="text-center mt-2">
                                                        <a href="javascript:void(0)" class="text-primary my-2 d-block"
                                                           data-toggle="modal" data-target="#modal"
                                                           onclick=loadModal("{{url('company-list/'.$post->company_id.'/available-jobs')}}")>
                                                            {{trans('words.news_of_all_jobs')}}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>

                                            @if(\Carbon\Carbon::now()->toDateTimeString() < $post->deadline && $post->job_listing_type_id == 2)
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <button id="apply_online"
                                                                class="btn btn-sm btn-success text-center">
                                                            {{trans('words.apply_online')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="sidebar-advertisement">
                                <div class="widget">
                                    <a href=""><img src="img/ad4.jpg" alt="" class="img-fluid"></a>
                                </div>
                                <div class="widget">
                                    <a href=""><img src="img/ad6.jpg" alt="" class="img-fluid"></a>
                                </div>
                                <div class="widget">
                                    <a href=""><img src="img/ad5.jpg" alt="" class="img-fluid"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 sidebar-add-wrapper">
                        @if(@$post['ads']['1'])
                            @foreach(collect($post['ads']['1']) as $ad)
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

        @if(@$post['ads']['5'])
            @foreach(collect($post['ads']['5']) as $ad)
                <div class="container">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget">
                                    <a href="{{$ad->url}}" target="_blank">
                                        <img src="{{$ad->image}}" alt="" class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{url('job-list/:id/check-applied')}}'.replace(':id', <?php echo $post->id;?>),
                type: 'GET',
                headers: {"Authorization": 'Bearer ' + Cookies.get('access_token')}
            }).done(function (res) {
                if (res.success) {
                    if (res.data.is_applied) {
                        $("#alert-section").html(` <div class="alert alert-danger text-center" role="alert">Already Applied</div>`);
                        $("#apply_online").prop({disabled: true})
                    }

                    if (res.data.is_shortlisted) {
                        $('#shortlist_section').addClass('text-info')
                    }
                }

            }).fail(function () {
                alert('No response from server');
            });
        })

        $('#apply_online').click(function () {
            let user = Cookies.get('user');

            if (user) {
                user = jQuery.parseJSON(user);
            }

            if (user) {
                window.location.href = "{{url('job-list/'.$post->id.'/apply-online')}}";
            } else {
                window.open('{{ env('NG_URL') }}' + '/login', '_self')
            }
        })


        function shortlist() {
            $.ajax({
                url: "{{url('shortlist-job/'.$post->id)}}",
                method: 'GET',
                beforeSend: function (xhr) {
                    const token = Cookies.get('access_token');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                },
                success: function (res) {
                    responseMessage(res)
                    if (res.success) {
                        if ($('#shortlist_section').hasClass("text-info")) {
                            $('#shortlist_section').removeClass('text-info')
                        } else {
                            $('#shortlist_section').addClass('text-info')
                        }
                    }
                },
                error: function (data) {
                    swal("Error!", "Something wrong", "warning")
                }
            });
        }
    </script>
@endsection

