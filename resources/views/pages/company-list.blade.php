@extends('_partials.app')

@section('title', 'Company List')

@section('main_container')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="company-list-wrapper">
                    <div class="upload-resume-wrapper">
                        <div class="row">
                            <div class="col">
                                <div class="table-top">
                                    <div>
                                        <h6><span class="badge badge-success">103</span> employers offer jobs</h6>
                                        <small>Please click at the company name to view offering jobs</small>
                                    </div>
                                    <div class="pagination-wrapper mt-0">
                                        <!--              <ngb-pagination [collectionSize]="120" [(page)]="page" [maxSize]="5" [rotate]="true" [boundaryLinks]="true"-->
                                        <!--                              size="sm"></ngb-pagination>-->
                                    </div>
                                </div>
                                <div class="filter-wrapper">
                                    <div class="row">
                                        <div class="col">
                                            <ul class="employer-offer-filter">
                                                <li><a href="javascript:" class="active">A</a></li>
                                                <li><a href="javascript:">B</a></li>
                                                <li><a href="javascript:">C</a></li>
                                                <li><a href="javascript:">D</a></li>
                                                <li><a href="javascript:">E</a></li>
                                                <li><a href="javascript:">F</a></li>
                                                <li><a href="javascript:">G</a></li>
                                                <li><a href="javascript:">H</a></li>
                                                <li><a href="javascript:">I</a></li>
                                                <li><a href="javascript:">J</a></li>
                                                <li><a href="javascript:">K</a></li>
                                                <li><a href="javascript:">L</a></li>
                                                <li><a href="javascript:">M</a></li>
                                                <li><a href="javascript:">N</a></li>
                                                <li><a href="javascript:">O</a></li>
                                                <li><a href="javascript:">P</a></li>
                                                <li><a href="javascript:">Q</a></li>
                                                <li><a href="javascript:">R</a></li>
                                                <li><a href="javascript:">S</a></li>
                                                <li><a href="javascript:">T</a></li>
                                                <li><a href="javascript:">U</a></li>
                                                <li><a href="javascript:">V</a></li>
                                                <li><a href="javascript:">W</a></li>
                                                <li><a href="javascript:">X</a></li>
                                                <li><a href="javascript:">Y</a></li>
                                                <li><a href="javascript:">Z</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select class="form-control form-control-sm" id="type">
                                                    <option>Select Items</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name">Company Name</label>
                                                <input type="text" class="form-control form-control-sm" id="name">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group" style="display: flex;align-items: flex-end;height: 57px">
                                                <button type="button" class="btn btn-success btn-sm">Search</button>
                                                <button type="button" class="btn btn-outline-danger btn-sm ml-2">clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pagination-wrapper mb-2">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-sm">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <div class="form-inline ml-auto mbl-hidden">
                                        <div class="filter-item">
                                            Item Per Page
                                            <select class="form-control form-control-sm" id="exampleFormControlSelect1">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm mb-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Company Name</th>
                                                    <th class="text-center">No. of Jobs</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <p><a href="company-details">100 % Export Oriented Knit Garments</a></p>
                                                    </td>
                                                    <td class="text-center">3</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <p><a href="javascript:">100 % Export Oriented Knit Garments</a></p>
                                                    </td>
                                                    <td class="text-center">3</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <p><a href="javascript:">100 % Export Oriented Knit Garments</a></p>
                                                    </td>
                                                    <td class="text-center">3</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <p><a href="javascript:">100 % Export Oriented Knit Garments</a></p>
                                                    </td>
                                                    <td class="text-center">3</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="pagination-wrapper">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-sm">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <div class="form-inline ml-auto mbl-hidden mb-4">
                                        <div class="filter-item">
                                            Item Per Page
                                            <select class="form-control form-control-sm" id="exampleFormControlSelect1">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
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
