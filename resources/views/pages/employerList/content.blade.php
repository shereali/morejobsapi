<table class="table table-striped table-sm mb-0">
    <thead>
    <tr>
        <th>#</th>
        <th>{{trans('words.employee_list_table_company_name_column')}}</th>
        <th class="text-center">{{trans('words.employee_list_table_no_of_job_column')}}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($records as  $key=>$item)
        <tr>
            <td>{{$key + 1}}</td>
            <td>
                <a href="{{url('company-list/' .$item->id.'/details' )}}">{{$item->title_en}}</a>
            </td>
            <td class="text-center">{{App\Services\HelperService::formattedNumber($item->jobs_count)}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3">
                <p class="text-center">No record found</p>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>


{{--@forelse($records as  $item)--}}
{{--    <div class="card circular-list-wrapper">--}}
{{--        <div class="card-body">--}}
{{--            <a href="{{url('job-list/' .$item->id.'/details' )}}" class="circular-list">--}}
{{--                <h5 class="title">{{$item->title}}</h5>--}}
{{--                <p class="sub-title mb-1"><b>{{$item->company->title_en}}</b></p>--}}
{{--                <p class="mb-1"><i class="icofont-location-pin"></i> {{@$item->company->area->title_en}}</p>--}}
{{--                <p class="mb-1"><i class="icofont-graduate"></i>--}}
{{--                    {{implode(', ', $item->postDegrees->pluck('title')->toArray())}}--}}
{{--                </p>--}}
{{--                <p class="mb-1"><i class="icofont-address-book"></i>--}}
{{--                    {{$item->experience_min}} to {{$item->experience_max}} year(s)--}}
{{--                </p>--}}
{{--                <p class="deadline"><i class="icofont-ui-calendar"></i> Deadline:--}}
{{--                    <b>{{\Carbon\Carbon::parse($item->deadline)->format('d M Y')}}</b></p>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@empty--}}
{{--    <p class="text-center">No record found</p>--}}
{{--@endforelse--}}

