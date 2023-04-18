@extends('_partials.app')

@section('title', 'Contact Us')

@section('main_container')
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="title">Contact information</h3>
                            <div class="content-wrapper">
                                <h5>Address</h5>
                                <address>
                                    569/3 Moddho Monipur <br>
                                    60 Feet Road (Barek Molla Mor) <br>
                                    Mirpur-02, Dhaka-1216, Bangladesh
                                </address>
                                <ul class="list-group list-group-flush px-5">
                                    <li class="list-group-item text-primary"><i class="icofont-phone"></i> Dial <span style="font-size: 19px;font-weight: 500">+8801911360008, +8801958373930</span> from any number.</li>
                                    <li class="list-group-item p-0">
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                            <tr>
                                                <td colspan="2" class="bg-light">➤ For any sales query (for the clients outside Dhaka):</td>
                                            </tr>
                                            <tr>
                                                <td>Chittagong: +8801958373931</td>
                                                <td>Sylhet: +8801958373936</td>
                                            </tr>
                                            <tr>
                                                <td>Narayanganj:+8801958373932</td>
                                                <td>Mymensingh:+8801958373937</td>
                                            </tr>
                                            <tr>
                                                <td>Khulna:+8801958373933</td>
                                                <td>Gazipur:+8801958373935</td>
                                            </tr>
                                            <tr>
                                                <td>Barisal:+8801958373934</td>
                                                <td>Rajshahi:+8801958373939</td>
                                            </tr>
                                            <tr>
                                                <td>Rangpur:+8801958373938</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center p-1">
                                                    <p class="font-weight-bold">Click <a href="{{env('NG_URL').'/employer-registration'}}">this link</a> for your any inquiry, regarding our corporate services.</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                            <div class="content-wrapper">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14602.3863141127!2d90.3651758!3d23.797376!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xaf55f2480173c69e!2smorenewsbd.net!5e0!3m2!1sen!2sbd!4v1636646984939!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
