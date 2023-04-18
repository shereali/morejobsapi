@foreach($records as $item)
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

<div class="col-12 mt-3 mb-4">
    <div class="col-sm-6 m-auto">
        {{$records->render()}}
    </div>
</div>
