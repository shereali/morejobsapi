@extends('_partials.app')

@section('title', 'Home')

@section('main_container')
    <div style="position: fixed;top: auto;right: 130px;z-index: 100;">
        @include('_partials.messages')
    </div>

    <div class="apply-content-wrapper">
        <div class="card" id="content">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Submit application online</h6>
            </div>
            <div class="card-text">
                <form id="myForm">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Account Name</td>
                            <td><span id="user_name"></span></td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>{{$data->company->title_en}}</td>
                        </tr>
                        <tr>
                            <td>Position Applied</td>
                            <td>{{$data->title}}</td>
                        </tr>
                        <tr>
                            <td>Your Expected Salary *</td>
                            <td>
                                <input type="number" name="expected_salary" class="form-control"
                                       placeholder="EX: 50000" id="expected_salary">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <hr>

                    <div class="mb-3 text-right">
                        <button class="btn btn-success">Apply</button>
                        <a href="javascript:void(0)" class="btn btn-default mr-3" onclick="goBack()">Close</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
    <script type="text/javascript" src="{{asset('js/validation.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            const user = jQuery.parseJSON(Cookies.get('user') ?? null);
            if (!user) {
                window.open('{{ env('NG_URL') }}' + '/login', '_self')
            } else {
                $('#user_name').html(user.first_name + ' ' + user.last_name)
            }
        })

        $("#myForm").validate({
            rules: {
                expected_salary: {required: true},
            },
            submitHandler: function (form) {
                if ($("#myForm").valid()) {
                    $.ajax({
                        url: "{{URL::to('job-list/:id/apply-online')}}".replace(':id', <?php echo $data->id;?>),
                        data: {expected_salary: $('#expected_salary').val()},
                        method: 'PUT',
                        beforeSend: function (xhr) {
                            const token = Cookies.get('access_token');
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        },
                        success: function (res) {
                            responseMessage(res)

                            if (res.success) {
                                const user = jQuery.parseJSON(Cookies.get('user') ?? null);

                                let date = new Date();
                                const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                const currentDate = date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear();

                                const confirmHtml = `
                                    <div class="card-header">
                                        <h5>Confirmation</h5>
                                    </div>
                                    <div class="card-text">
                                        <table class="table borderless">
                                        <tbody>
                                            <tr>
                                                <td>Account Name</td>
                                                <td>${user.first_name} ${user.last_name}</td>
                                            </tr>
                                            <tr>
                                                <td>Applied Position</td>
                                                <td>{{$data->title}}</td>
                                            </tr>
                                            <tr>
                                                <td>Company Name</td>
                                                <td>{{$data->company->title_en}}</td>
                                            </tr>
                                            <tr>
                                                <td>Company Address</td>
                                                <td>{{$data->company->address_en}}</td>
                                            </tr>
                                            <tr>
                                                <td>Application Date</td>
                                                <td>${currentDate}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <p class="m-2">The employer will be able to review your application and, if needed, can contact with you.</p>
                                    </div>`

                                $("#content").html(confirmHtml)
                            }else {
                                if (res.errors.length > 0){
                                    let html = `
                                        <div class="card" style="margin: 50px 10px 100px 10px" id="content">
                                           <div class="card-header">
                                               <h5>Not eligible for this job</h5>
                                           </div>
                                           <div class="card-text">
                                                <div class="alert alert-danger">
                                                   Hi there, seems that you can't apply for the job because has defined some job application
                                                   requirements as mandatory and your cv information doesn't fully match with this mandatory
                                                   requirements.
                                                </div>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Application Criteria</th>
                                                            <th>Your Information</th>
                                                            <th>Matched</th>
                                                        </tr>
                                                    </thead>
                                                   <tbody>`;

                                                    $.each(res.errors, function( index, value ) {
                                                        html += `<tr>
                                                                    <td style="background-color: #FFF8DC">${value.title}: ${value.expected}</td>
                                                                    <td style="background-color: #C6DEFF">${value.user_info}</td>
                                                                    <td style="background-color: #C3FDB8">`;

                                                        if(value.matched)
                                                            html += `<i class="fa fa-check text-success"></i>` ;
                                                        else
                                                            html += `<i class="fa fa-times text-danger"></i>` ;


                                                        html += `</td>
                                                                 </tr>`;
                                                    });


                                    html += `</tbody>
                                                        </table>

                                                        <hr>

                                                        <div class="d-inline float-lg-right mb-3">
                                                            <div class="container">
                                                                <a href="javascript:void(0)" class="btn btn-default mr-2" onclick="goBack()">Close</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                                    $("#content").html(html)
                                }
                            }
                        },
                        error: function (data) {
                            console.log("Error!", "Something wrong", "warning")
                        }
                    });
                }
            }
        });

        function goBack() {
            window.history.back();
        }


    </script>
@endsection
