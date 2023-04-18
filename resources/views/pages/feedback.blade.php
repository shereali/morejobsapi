@extends('_partials.app')

@section('title', 'Feedback')

@section('main_container')
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="title">Provide Feedback</h3>
                            <div class="content-wrapper">
                                <h5 class="mb-3">User Feedback</h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="site" class="h6">1. Choose a site <span class="text-danger">*</span></label>
                                            <select class="form-control ml-3" id="site">
                                                <option>Select</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="h6">2. How satisfied you are with this module <span class="text-danger">*</span></label>
                                            <div class="custom-control custom-radio mb-2 ml-3">
                                                <input type="radio" id="Excellent" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="Excellent">Excellent</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-2 ml-3">
                                                <input type="radio" id="VeryGood" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="VeryGood">Very Good</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-2 ml-3">
                                                <input type="radio" id="Good" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="Good">Good</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-2 ml-3">
                                                <input type="radio" id="Satisfactory" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="Satisfactory">Satisfactory</label>
                                            </div>
                                            <div class="custom-control custom-radio ml-3">
                                                <input type="radio" id="NotSatisfactory" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="NotSatisfactory">Not Satisfactory</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="facingProblem" class="h6">3. Are you facing any problem?</label>
                                            <textarea class="form-control ml-3" id="facingProblem" rows="5" placeholder="Type your message here..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="suggestions" class="h6">4. Do you have any suggestions?</label>
                                            <textarea class="form-control ml-3" id="suggestions" rows="5" placeholder="Type your message here..."></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="h6">5. Email ID</label>
                                            <input type="email" class="form-control ml-3" id="email" placeholder="Enter your email address">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="h6">6. Phone No</label>
                                            <input type="number" class="form-control ml-3" id="phone" placeholder="Enter your phone number">
                                        </div>
                                        <button type="submit" class="btn btn-success ml-3 font-weight-bold">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
