@extends('_partials.app')

@section('title', 'Employer Services | Pricing')

@section('main_container')
    <style>
        .table > tbody > tr > td {
            vertical-align: middle;
        }
    </style>
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" valign="middle">
                                <thead>
                                <tr>
                                    <th>Package Type</th>
                                    <th width="50%">Description</th>
                                    <th>Pricing</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Basic</td>
                                        <td>
                                            <ul>
                                                <li>Jobs displayed in the Category/Classified section.</li>
                                                <li>Job will be live for 30 days (max).</li>
                                                <li>Sort matching CVs, short-list, interview scheduling through convenient employer's panel.</li>
                                                <li>10 times cheaper than a newspaper advertisement.</li>
                                                <li>10 times Each job post costs 2,950 BDT only.</li>
                                            </ul>
                                        </td>
                                        <td>2950 TK</td>
                                        <td>
                                            <a href="{{env('NG_URL').'/company/packages/jobs'}}" class="btn btn-primary btn-sm">ORDER NOW</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stand Out Listing(Regular)</td>
                                        <td>
                                            <ul>
                                                <li>Jobs displayed in the Category/Classified section.</li>
                                                <li>Job will be live for 30 days (max).</li>
                                                <li>Sort matching CVs, short-list, interview scheduling through convenient employer's panel.</li>
                                                <li>10 times cheaper than a newspaper advertisement.</li>
                                                <li>10 times Each job post costs 3900 BDT only.</li>
                                            </ul>
                                        </td>
                                        <td>3900 TK</td>
                                        <td>
                                            <a href="{{env('NG_URL').'/company/packages/jobs'}}" class="btn btn-primary btn-sm">ORDER NOW</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stand Out Listing(Premium)</td>
                                        <td>
                                            <ul>
                                                <li>Jobs displayed in the Category/Classified section.</li>
                                                <li>Job will be live for 30 days (max).</li>
                                                <li>Sort matching CVs, short-list, interview scheduling through convenient employer's panel.</li>
                                                <li>10 times cheaper than a newspaper advertisement.</li>
                                                <li>10 times Each job post costs 4900 BDT only.</li>
                                            </ul>
                                        </td>
                                        <td>4900 TK</td>
                                        <td>
                                            <a href="{{env('NG_URL').'/company/packages/jobs'}}" class="btn btn-primary btn-sm">ORDER NOW</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hot Job Listing(Regular)</td>
                                        <td>
                                            <ul>
                                                <li>Jobs displayed in the Category/Classified section.</li>
                                                <li>Job will be live for 30 days (max).</li>
                                                <li>Sort matching CVs, short-list, interview scheduling through convenient employer's panel.</li>
                                                <li>10 times cheaper than a newspaper advertisement.</li>
                                                <li>10 times Each job post costs 11000 BDT only.</li>
                                            </ul>
                                        </td>
                                        <td>11000 TK</td>
                                        <td>
                                            <a href="{{env('NG_URL').'/company/packages/jobs'}}" class="btn btn-primary btn-sm">ORDER NOW</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hot Job Listing(Premium)</td>
                                        <td>
                                            <ul>
                                                <li>Jobs displayed in the Category/Classified section.</li>
                                                <li>Job will be live for 30 days (max).</li>
                                                <li>Sort matching CVs, short-list, interview scheduling through convenient employer's panel.</li>
                                                <li>10 times cheaper than a newspaper advertisement.</li>
                                                <li>10 times Each job post costs 13500 BDT only.</li>
                                            </ul>
                                        </td>
                                        <td>13500 TK</td>
                                        <td>
                                            <a href="{{env('NG_URL').'/company/packages/jobs'}}" class="btn btn-primary btn-sm">ORDER NOW</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
