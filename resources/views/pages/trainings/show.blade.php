@extends('_partials.app')

@section('title', 'Home')

@section('main_container')
    <div class="jumbotron" style="padding: 40px 2rem;margin-top: -20px;background: #4BA75C;color: #ffffff">
        <div class="container">
            <p class="mb-4" style="font-size: 14px"><a href="javascript:"
                                                       class="text-white font-weight-bold">{{$course->trainingType->title}}</a>
            </p>
            <div style="width: 60%">
                <h2 style="font-weight: 500">{{$course->title}}</h2>
                <ul class="list-inline" style="line-height: 26px;">
                    <li class="list-inline-item"><i class="icofont-ui-calendar"></i>
                        Date : <b>{{\Carbon\Carbon::parse($course->start_date)->day}}
                            - {{\Carbon\Carbon::parse($course->end_date)->format('d M Y')}}</b>
                    </li>
                    <li class="list-inline-item"><i class="icofont-clock-time"></i> Duration :
                        <b>{{$course->class_timetable}}</b></li>
                    <li class="list-inline-item"><i class="icofont-listine-dots"></i> No. of Classes/ Sessions :
                        <b>{{$course->no_of_sessions}}</b></li>
                    <li class="list-inline-item"><i class="icofont-clock-time"></i> Class Schedule :
                        <b>{{$course->class_schedule}}</b></li>
                    <li class="list-inline-item"><i class="icofont-ui-calendar"></i> Last Date of Registration :
                        <b>{{\Carbon\Carbon::parse($course->deadline)->format('d M Y')}}</b></li>
                    <li class="list-inline-item"><i class="icofont-ui-calendar"></i> Venue : <b>{{$course->venue}}</b>
                    </li>
                </ul>
                {{--                <ul class="list-inline mt-3">--}}
                {{--                    <li class="list-inline-item"><p class="text-dark font-weight-bold" style="font-size: 16px">(Enjoy--}}
                {{--                            10% Discount on Bkash Payment)</p></li>--}}
                {{--                </ul>--}}
            </div>
        </div>
    </div>

    <div class="train-details-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    {{$course->details}}

                    <hr>

                    <h4 class="text-dark my-4">Related Courses</h4>
                    @if(count($relatedCourses) > 0)
                        <div class="row">
                            @foreach($relatedCourses as $item)
                                <div class="col-sm-6">
                                    <div class="card-course">
                                        <div class="course-header-wrapper">
                                            <h5 class="course-header">
                                                <i class="icofont-jersey"></i>
                                                <a href="{{url('training-courses', $item->id)}}">{{$item->title}}</a>
                                            </h5>
                                            <div class="price">
                                                Price {{$item->price}} Tk + VAT
                                            </div>
                                        </div>
                                        <div class="course-body">
                                            <div class="img-section">
                                                <div class="img-wrapper">
                                                    <img src="{{asset('img/User-avatar.png')}}" alt="">
                                                    <p>{{$item->trainer->first_name}} {{$item->trainer->last_name}}</p>
                                                </div>
                                                <div class="wish-notice">
                                                    <a href="javascript:" data-toggle="tooltip" data-placement="top"
                                                       title="Not registered"><i class="icofont-badge"></i></a>
                                                    <a href="javascript:" data-toggle="tooltip" data-placement="top"
                                                       title="Not wishlisted"><i class="icofont-ui-love"></i></a>
                                                </div>
                                            </div>
                                            <p class="timeline">
                                                <i class="icofont-ui-calendar"></i>
                                                {{\Carbon\Carbon::parse($item->start_date)->day}}
                                                - {{\Carbon\Carbon::parse($item->end_date)->format('d M Y')}}
                                            </p>
                                            <p class="history">This training will boost your knowledge of IE and help
                                                you</p>
                                            <div class="course-footer">
                                                <p><a href="javascript:"><i
                                                            class="icofont-tags"></i> {{implode(', ', $item->courseCategories->pluck('title')->toArray())}}
                                                    </a></p>
                                                {{--                                                <div class="btn-group justify-content-end w-100" role="group"--}}
                                                {{--                                                     aria-label="Basic example">--}}
                                                {{--                                                    <button type="button" class="btn btn-sm btn-default">Register--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                    <button type="button" class="btn btn-sm btn-default"--}}
                                                {{--                                                            data-toggle="tooltip"--}}
                                                {{--                                                            data-placement="top" title="Add to wishlist"><i--}}
                                                {{--                                                            class="icofont-check"></i> Wishlist--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-sm-12">
                                <div class="text-right">
                                    <a href="{{url('training-course-list')}}" class="btn btn-success mb-4" >
                                        View More <i class="icofont-rounded-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-center">No records found!</p>
                    @endif
                </div>
                <div class="col-sm-4">
                    <div class="card price-wrapper">
                        <div class="card-body text-center">
                            <h3>PRICE: <span class="text-success">TK. {{$course->price}}+VAT</span></h3>
                            {{--                            <p class="text-secondary mb-4">(15% VAT is applicable in every purchase.)</p>--}}
                            {{--                            <a href="javascript:" class="btn btn-default reg-btn">Register</a>--}}
                            {{--                            <a href="javascript:" class="btn btn-outline-success wish-btn"><i--}}
                            {{--                                    class="icofont-ui-love"></i> Add to Wishlist</a>--}}
                            {{--                            <h5>CONTACT</h5>--}}
                            {{--                            <hr>--}}
                            {{--                            <p class="text-left"><i class="icofont-ui-dial-phone"></i> 01717249225, 01681522443</p>--}}
                            {{--                            <p class="text-left mb-0"><i class="icofont-email"></i> <a href="javascript:">workshop@morejobs.com</a>--}}
                            {{--                            </p>--}}
                        </div>
                    </div>

                    <div id="accordion" class="accordion">
                        <div class="card">
                            <a href="javascript:" class="card-header" id="attend" data-toggle="collapse"
                               data-target="#collapseAttend" aria-expanded="true" aria-controls="collapseAttend">
                                Who can Attend
                                <span class="pull-right">
                                    <i class="icofont-dotted-down" style="font-size: 21px"></i>
                                </span>
                            </a>

                            <div id="collapseAttend" class="collapse show" aria-labelledby="attend"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    {{$course->who_can_attend}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                    <div id="accordion" class="accordion">--}}
                    {{--                        <div class="card">--}}
                    {{--                            <a href="javascript:" class="card-header" id="boarding" data-toggle="collapse"--}}
                    {{--                               data-target="#collapseBoarding" aria-expanded="true" aria-controls="collapseBoarding">--}}
                    {{--                                Boarding (Static)--}}
                    {{--                                <span class="pull-right">--}}
                    {{--                                    <i class="icofont-dotted-down" style="font-size: 21px"></i>--}}
                    {{--                                </span>--}}
                    {{--                            </a>--}}

                    {{--                            <div id="collapseBoarding" class="collapse show" aria-labelledby="boarding"--}}
                    {{--                                 data-parent="#accordion">--}}
                    {{--                                <div class="card-body">--}}
                    {{--                                    Arrangement for Certificate, lunch and two tea-break would be made by the Organizer--}}
                    {{--                                    during the workshop.--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div id="accordion" class="accordion">
                        <div class="card">
                            <a href="javascript:" class="card-header" id="person" data-toggle="collapse"
                               data-target="#collapsePerson" aria-expanded="true" aria-controls="collapsePerson">
                                Resource Person
                                <span class="pull-right"><i class="icofont-dotted-down"
                                                            style="font-size: 21px"></i></span>
                            </a>

                            <div id="collapsePerson" class="collapse show" aria-labelledby="person"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img src="{{asset('img/User-avatar.png')}}" class="person-img" alt="">
                                        <h5 class="person-name">{{$course->trainer->first_name}} {{$course->trainer->last_name}}</h5>
                                        <p class="text-secondary">{{$course->trainer->designation}}</p>
                                    </div>
                                    <p class="person-doc">{{$course->trainer->about}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    function setFilter(data, key) {
        let filterData = {};
        filterData[key] = data;

        localStorage.setItem('filter', JSON.stringify(filterData));
    }
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
