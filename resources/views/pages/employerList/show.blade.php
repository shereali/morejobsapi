@extends('_partials.app')

@section('title', 'Home')

@section('main_container')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="company-list-wrapper">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h5 class="text-primary">{{$data->title_en}}</h5>
                                    <small class="d-block mb-2">Please click at the respective job title to view
                                        details</small>
                                </div>

                                <div class="col-sm-5">
                                    <p class="table-active text-success" id="alert_section"></p>
                                    <small class="d-block mb-3">
                                        By following you can see all job circulars of this employer at your My Morejobs
                                        Account. Never miss an opportunity of your favorite employer!
                                    </small>
                                    <div class="text-right" id="action_section"></div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-striped online-app-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="70%">Job Title</th>
                                        <th>Deadline</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($data->jobs as $key=>$item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                <p><a href="{{url('job-list/'.$item['id'].'/details')}}">{{$item->title}}</a></p>
                                            </td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{url('company-list/:id/check-followed')}}'.replace(':id', <?php echo $data->id;?>),
                type: 'GET',
                headers: {"Authorization": 'Bearer ' + Cookies.get('access_token')}
            }).done(function (res) {
                if (res.success) {
                    if (res.data.is_followed) {
                        $('#alert_section').text('You are following this employer.');
                        $('#action_section').html(` <button type="button" class="btn btn-sm btn-danger" onclick="followUnfollow()">
                                                    <i class="fa fa-times"></i> Unfollow</button>`);
                    } else {
                        $('#action_section').html(`<button type="button" class="btn btn-sm btn-success" onclick="followUnfollow()">
                                                    <i class="fa fa-plus"></i> Follow</button>`);
                    }
                }

            }).fail(function () {
                alert('No response from server');
            });
        })


        function followUnfollow() {
            $.ajax({
                url: '{{url('company-list/:id/followed-unfollow')}}'.replace(':id', <?php echo $data->id;?>),
                type: 'GET',
                headers: {"Authorization": 'Bearer ' + Cookies.get('access_token')}
            }).done(function (res) {
                if (res.success) {
                    if (res.data.action_type === 'followed') {
                        $('#alert_section').text('You are following this employer.');
                        $('#action_section').html(` <button type="button" class="btn btn-sm btn-danger" onclick="followUnfollow()">
                                                    <i class="fa fa-times"></i> Unfollow</button>`);
                    } else {
                        $('#alert_section').empty();
                        $('#action_section').html(`<button type="button" class="btn btn-sm btn-success" onclick="followUnfollow()">
                                                    <i class="fa fa-plus"></i> Follow</button>`);
                    }
                }

            }).fail(function () {
                alert('No response from server');
            });
        }
    </script>
@endsection
