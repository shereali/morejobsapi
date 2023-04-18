<script type="text/javascript">
    $(".modal-title").text("Company Information");
</script>

<div class="col-sm-12">
    <h6>{{$data->title_en}}</h6>
    <p>Please click at the respective job title to view details</p>

    <table class="table">
        <thead class="table-active">
        <tr>
            <th class="" style="width: 5%">SL.</th>
            <th>Job Title</th>
            <th class="" style="width: 30%">Deadline</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data->jobs as $key=>$item)
            <tr>
                <td>{{$key + 1}}</td>
                <td><a href="{{url("job-list/$item->id/details")}}" target="_blank" class="btn-link">{{$item->title}}</a></td>
                <td>{{\Carbon\Carbon::parse($item->deadline)->toFormattedDateString()}}
                    ({{\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($item->deadline))}}
                    days left)
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No jobs found!</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
