<div class="pagination justify-content-end" style="display: none" id="temp-paginate">
    {{$records->render()}}
</div>

@php($i=0)

@forelse($records as  $key=>$item)
    <div class="job-container-wrapper">
        <div class="card circular-list-wrapper">
            <div class="card-body">
                <a href="{{url('job-list/' .$item->id.'/details' )}}" class="circular-list link-changeable"
                   target="_blank">
                    <h5 class="title">{{$item->title}}</h5>
                    <p class="sub-title">{{$item->company->title_en}}</p>
                    <p class="source mb-1"><i class="icofont-location-pin"></i>
                        {{count($item->postAreas) > 0 ? implode(', ', $item->postAreas->pluck('title_en')->toArray()) : 'Anywhere in Bangladesh'}}
                    </p>
                    <p class="source mb-1"><i class="icofont-graduate"></i>
                        {{implode(', ', $item->postDegrees->pluck('title')->toArray())}}
                    </p>

                    @if($item->experience_min && $item->experience_max)
                        <p class="source mb-1"><i class="icofont-address-book"></i>
                            {{$item->experience_min}} to {{$item->experience_max}} year(s)
                        </p>
                    @endif

                    <p class="source deadline"><i class="icofont-ui-calendar"></i> {{trans('words.deadline')}}:
                        <b>{{App\Services\HelperService::formattedNumber(\Carbon\Carbon::parse($item->deadline)->format('d M Y'))}}</b>
                    </p>
                </a>
            </div>
        </div>
    </div>


    @if(@$data['ads']['6'] && (($key+1)%3 == 0) && @$data['ads']['6'][$i])
        @php($ad = collect($data['ads']['6'][$i]))
        <div class="col-xl-6 container  d-xl-block">
            <div class="single-border-box">
                <div class="widget">
                    <a href="{{$ad['url']}}" target="_blank">
                        <img src="{{$ad['image']}}" alt="" class="img-fluid">
                    </a>
                </div>
            </div>
        </div>
        @php($i++)
    @endif
@empty
    <p class="text-center">No record found</p>
@endforelse

<script>
    $(document).ready(function () {
        $('#paginate-section').html($('#temp-paginate').html())
    })
</script>

