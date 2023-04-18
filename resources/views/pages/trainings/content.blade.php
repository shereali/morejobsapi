<div class="list-group list-group-flush">
    <div class="form-row">
        @forelse($records as  $item)
            <div class="col-sm-6 ">
                <a href="{{url('training-courses', $item->id)}}" target="_blank"
                   class="list-group-item list-group-item-action course-list">
                    <div class="admin-bg cicon">
                        <i class="icofont-search-job"></i>
                    </div>
                    <div>
                        <h6 class="mb-2">{{$item->title}}</h6>
                        <p class="mb-0">
                            <i class="icofont-ui-calendar"></i>
                            {{\Carbon\Carbon::parse($item->start_date)->toFormattedDateString()}}
                            - {{\Carbon\Carbon::parse($item->end_date)->toFormattedDateString()}}
                        </p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-md-12 mt-5">
                <p class="text-center">No courses found!</p>
            </div>
        @endforelse
    </div>
</div>

<div class="row mt-5">
    <div class="col-sm-6 m-auto">
        {{$records->render()}}
    </div>
</div>
