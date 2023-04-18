@extends('_partials.app')

@section('title', 'Training')

@section('main_container')
    <div class="hero-search" style="margin-top: -20px;">
        <div class="container">
            <div class="row p-4" style="background-color: whitesmoke">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <button class="btn btn-default">New Arrival</button>
                    <button class="btn btn-success">Become a Trainer</button>
                    <button class="btn btn-default">Browse Courses</button>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex align-items-center justify-content-center flex-column h-100"
                         style="width: 65%;margin: auto;min-height: 350px;">
                        <div class="search-title mt-0 mb-4">
                            <h2>Courses by industry</h2>
                        </div>
                        <div class="search-bar">
                            <select class="niceselect" name="" id="niceselect">
                                <option selected="" disabled>Select</option>
                                <option value="1">Government</option>
                                <option value="2">Semi Government</option>
                                <option value="3">NGO</option>
                                <option value="4">Private Firm/Company</option>
                                <option value="5">International Agencies</option>
                                <option value="6">Others</option>
                            </select>
                            <form>
                                <input class="form-control" name="search" placeholder="Search by Keywords: ex. Accounts"
                                       type="search">
                                <button class="btn btn-primary"><i class="icofont-search-job"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="training-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group" role="group">
                        <span class="tran-title-btn">Course Type</span>
                        {{--                        <button type="button" class="btn tran-btn active">All <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">107</span></button>--}}
                        {{--                        <button type="button" class="btn tran-btn">Daylong Courses <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">76</span></button>--}}
                        {{--                        <button type="button" class="btn tran-btn">Evening Courses <span--}}
                        {{--                                    class="badge badge-pill badge-secondary">31</span></button>--}}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        {{--                        <button type="button" class="btn tran-btn-solid"><i class="icofont-cloud-download"></i> Monthly--}}
                        {{--                            calendar--}}
                        {{--                        </button>--}}
                    </div>
                </div>
            </div>

            <div class="train-container">
                <div class="train-body">
                    <div class="list-group train-sidebar" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="all-list" data-toggle="list"
                           href="#all" role="tab">
                            <i class="icofont-listine-dots"></i> All
                        </a>
                        <a class="list-group-item list-group-item-action" id="accounts-list" data-toggle="list"
                           href="#accounts" role="tab">
                            <i class="icofont-calculator-alt-1"></i> Accounts <span>(9)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="administration-list" data-toggle="list"
                           href="#administration" role="tab">
                            <i class="icofont-search-job"></i> Administration <span>(7)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="banking-list" data-toggle="list"
                           href="#banking" role="tab">
                            <i class="icofont-bank-alt"></i> Banking <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="business-list" data-toggle="list"
                           href="#business" role="tab">
                            <i class="icofont-handshake-deal"></i> Business <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="commercial-list" data-toggle="list"
                           href="#commercial" role="tab">
                            <i class="icofont-building-alt"></i> Commercial <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="development-list" data-toggle="list"
                           href="#development" role="tab">
                            <i class="icofont-university"></i> Development / NGO <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="freelancing-list" data-toggle="list"
                           href="#freelancing" role="tab">
                            <i class="icofont-user-male"></i> Freelancing <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="hr-list" data-toggle="list"
                           href="#hr" role="tab">
                            <i class="icofont-users-alt-5"></i> Human Resource <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="it-list" data-toggle="list"
                           href="#it" role="tab">
                            <i class="icofont-architecture-alt"></i> IT <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="law-list" data-toggle="list"
                           href="#law" role="tab">
                            <i class="icofont-law-alt-1"></i> Law <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="marketing-list" data-toggle="list"
                           href="#marketing" role="tab">
                            <i class="icofont-chart-histogram"></i> Marketing/ Sales <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="career-list" data-toggle="list"
                           href="#career" role="tab">
                            <i class="icofont-users-alt-3"></i> Next Stage/ Career <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="project-management-list"
                           data-toggle="list"
                           href="#project-management" role="tab">
                            <i class="icofont-hand-drag1"></i> Project Management <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="quality-list" data-toggle="list"
                           href="#quality" role="tab">
                            <i class="icofont-badge"></i> Quality & Process <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="RMG-list" data-toggle="list"
                           href="#RMG" role="tab">
                            <i class="icofont-jersey"></i> RMG <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="skills-list" data-toggle="list"
                           href="#skills" role="tab">
                            <i class="icofont-ruler-pencil"></i> Soft Skills <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="health-list" data-toggle="list"
                           href="#health" role="tab">
                            <i class="icofont-briefcase-1"></i> Health <span>(0)</span>
                        </a>
                        <a class="list-group-item list-group-item-action" id="other-list" data-toggle="list"
                           href="#other" role="tab">
                            <i class="icofont-diamond"></i> Other <span>(0)</span>
                        </a>
                    </div>

                    <div class="tab-content content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="active-session">
                                        <span class="badge badge-pill badge-secondary">106</span> Courses found
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="list-group list-group-flush">
                                        <a href="/pages/training-details"
                                           class="list-group-item list-group-item-action course-list">
                                            <div class="admin-bg cicon">
                                                <i class="icofont-search-job"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Capacity Building Training for Administrative
                                                    Professional</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="quality-bg cicon">
                                                <i class="icofont-badge"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Basic Issues of ISO 22000:2018, Food Safety Management
                                                    System (FSMS) & It’s Audit</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="marketing-bg cicon">
                                                <i class="icofont-chart-histogram"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Taking Sales to an Advanced Level</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="hr-bg cicon">
                                                <i class="icofont-users-alt-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">HR Accounting - Concept of Human Capital
                                                    Management</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="it-bg cicon">
                                                <i class="icofont-architecture-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Microsoft Excel Dashboard and Reporting Techniques</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="commercial-bg cicon">
                                                <i class="icofont-building-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Banking, LC, Shipping & Customs Process for Commercial
                                                    & Supply Chain Professional</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="marketing-bg cicon">
                                                <i class="icofont-chart-histogram"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">WOW Factors in Advertising</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="ngo-bg cicon">
                                                <i class="icofont-university"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Writing Quality Proposal</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="accounts-bg cicon">
                                                <i class="icofont-calculator-alt-1"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">Intelligent Management of Working Capital to Protect
                                                    Business Continuity</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action course-list">
                                            <div class="rmg-bg cicon">
                                                <i class="icofont-jersey"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-2">How to open a Garments Buying House in Bangladesh</h6>
                                                <p class="mb-0"><i class="icofont-ui-calendar"></i> 19 - 20 Feb 2021 (6
                                                    Hour)</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success mt-4">
                                        View More <i class="icofont-rounded-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="accounts" role="tabpanel">B</div>
                        <div class="tab-pane fade" id="administration" role="tabpanel">C</div>
                        <div class="tab-pane fade" id="banking" role="tabpanel">D</div>
                        <div class="tab-pane fade" id="business" role="tabpanel">E</div>
                        <div class="tab-pane fade" id="commercial" role="tabpanel">F</div>
                        <div class="tab-pane fade" id="development" role="tabpanel">G</div>
                        <div class="tab-pane fade" id="freelancing" role="tabpanel">H</div>
                        <div class="tab-pane fade" id="hr" role="tabpanel">I</div>
                        <div class="tab-pane fade" id="it" role="tabpanel">J</div>
                        <div class="tab-pane fade" id="law" role="tabpanel">K</div>
                        <div class="tab-pane fade" id="marketing" role="tabpanel">L</div>
                        <div class="tab-pane fade" id="career" role="tabpanel">M</div>
                        <div class="tab-pane fade" id="project-management" role="tabpanel">N</div>
                        <div class="tab-pane fade" id="quality" role="tabpanel">O</div>
                        <div class="tab-pane fade" id="RMG" role="tabpanel">P</div>
                        <div class="tab-pane fade" id="skills" role="tabpanel">Q</div>
                        <div class="tab-pane fade" id="health" role="tabpanel">R</div>
                        <div class="tab-pane fade" id="other" role="tabpanel">S</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    function setFilter(data, key) {
        let filterData = {};
        filterData[key] = data;

        localStorage.setItem('filter', JSON.stringify(filterData));
    }
</script>
