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
                                    <h5 class="text-primary">Demo company1</h5>
                                    <p><b>Business : </b> 100% Export Oriented Composite Knit Garments</p>
                                    <small class="d-block mb-2">Please click at the respective job title to view details</small>
                                </div>
                                <div class="col-sm-5">
                                    <small class="d-block mb-3">By following you can see all job circulars of this employer at your My Morejobs Account.
                                        Never miss an opportunity of your favorite employer!</small>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-sm btn-success">Follow</button>
                                    </div>
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
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <p><a href="javascript:">Tianna Hyatt</a></p>
                                        </td>
                                        <td>2021-08-01 (6 days left)</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            <p><a href="javascript:">Tianna Hyatt</a></p>
                                        </td>
                                        <td>2021-08-01 (6 days left)</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            <p><a href="javascript:">Tianna Hyatt</a></p>
                                        </td>
                                        <td>2021-08-01 (6 days left)</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            <p><a href="javascript:">Tianna Hyatt</a></p>
                                        </td>
                                        <td>2021-08-01 (6 days left)</td>
                                    </tr>
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
