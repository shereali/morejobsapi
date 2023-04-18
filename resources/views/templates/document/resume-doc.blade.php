<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Morejobs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
            padding: 0;
            color: rgba(0, 0, 0, 0.7);
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
        }

        .view-resume-wrapper .details-cover .cover-header {
            padding: 3px 8px;
            background: #e9e9e9;
        }

        .view-resume-wrapper .details-cover .cover-body {
            padding: 12px 15px;
        }

        .sidebar {
            margin: 0 auto;
            padding: 0 20px;
            background: #f5f5f5;
            text-align: center;
        }

        .main-container {
            background: #ffffff;
        }

        .sidebar, .main-container, .academic-wrapper {
            overflow: hidden;
        }

        .main-wrapper .main-container {
            margin-top: 15px;
        }

        .academic-wrapper{
            margin: 20px;
        }

        .academic-item {
            margin: 20px 0 0;
        }
        .academic-inside {
            margin-top: 5px;
        }

        .master-hr {
            margin: 20px 40px 20px 30px;
            border-color: #cecaca;
        }

        .academic-wrapper {
            margin: 20px;
        }
    </style>
</head>
<body>

@if($resumeType == 'details')
    <div class="view-resume-wrapper">
        <div class="details-header d-flex align-items-center justify-content-between mt-4 mb-4">
            <div class="details-item">
                <p style="color: #1366ED; font-size: 20px;">{{$resume->first_name}} {{$resume->last_name}}</p>
                <p class="mb-1">Address: {{@$resume->profile->present_address}}</p>
                <p class="mb-1">Mobile No
                    : {{implode(', ', $resume->contactMobiles->pluck('title')->values()->toArray())}}</p>
                <p class="mb-1">E-mail
                    : {{implode(', ', $resume->contactEmails->pluck('title')->values()->toArray())}}</p>
            </div>

            <div class="details-item">
                <img width="140" alt="" src="">
            </div>
        </div>

        <div class="details-cover">
            <div class="cover-header">
                <p class="mb-0">Career Objective:</p>
            </div>
            <div class="cover-body"><p>{{@$resume->profile->objective}}</p></div>
        </div>

        <div class="details-cover">
            <div class="cover-header">
                <p class="mb-0">Career Summary:</p>
            </div>
            <div class="cover-body">
                <p>{{@$resume->profile->career_summary}}</p>
            </div>
        </div>

        <div class="details-cover">
            <div class="cover-header">
                <p class="mb-0">Special Qualification:</p>
            </div>
            <div class="cover-body">
                <p>{{@$resume->profile->specialization}}</p>
            </div>
        </div>

        <div class="details-cover">
            <div class="cover-header">
                <p class="mb-0">Employment History:</p>
            </div>
            <div class="cover-body">
                <p><b>Total Year of Experience :</b> 6.5 Year(s)</p>
                <ol class="employment-history">
                    @foreach($resume->jobExperiences as $item)
                        <li class="ng-star-inserted"><p class="mb-1"><b>{{$item->designation}} ( {{$item->from}}
                                    - {{$item->is_current ? 'Continuing' : $item->to}})</b></p>
                            <p class="mb-1"><b>{{$item->company_name}}</b></p>
                            <p class="mb-1">Company Location : {{$item->address}}</p>
                            <p class="mb-1">Department: {{$item->department}}</p>
                            <div class="mb-1">
                                <p class="mb-0">Duties/Responsibilities :</p>
                                <ul>
                                    {!! $item->responsibilities !!}
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header"><p class="mb-0">Academic Qualification:</p></div>
            <div class="cover-body">
                <table
                    class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th width="20%">Exam Title</th>
                        <th width="20%">Concentration/Major</th>
                        <th width="20%">Institute</th>
                        <th width="13%">Result</th>
                        <th width="13%">Pas.Year</th>
                        <th width="13%">Duration</th>
                        <th width="13%">Achievement</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resume->educations as $item)
                        <tr class="ng-star-inserted">
                            <td>{{$item->degree->title}}</td>
                            <td>{{$item->educationLevel->title}}</td>
                            <td>{{$item->institute_name}}</td>
                            <td>{{$item->cgpa}}</td>
                            <td>{{$item->passing_year}}</td>
                            <td>{{$item->duration}}</td>
                            <td>{{$item->achievement ? $item->achievement : '-'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header"><p
                    class="mb-0">Training Summary:</p>
            </div>
            <div class="cover-body">
                <table
                    class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th width="20%">Training Title
                        </th>
                        <th width="20%">Topic</th>
                        <th width="20%">Institute</th>
                        <th width="10%">Country</th>
                        <th width="10%">Location</th>
                        <th width="10%">Year</th>
                        <th width="10%">Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resume->trainings as $item)
                        <tr>
                            <td>{{$item->title}}</td>
                            <td>{{$item->topic}}</td>
                            <td>{{$item->institute_name}}</td>
                            <td>{{$item->country->title}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->year}}</td>
                            <td>{{$item->duration}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header">
                <p class="mb-0">Career and Application Information:</p>
            </div>
            <div class="cover-body">
                <table
                    class="table table-borderless table-sm">
                    <tbody>
                    <tr>
                        <td width="35%">Preferred Job Category</td>
                        <td>
                            : {{implode(', ', $resume->preferredJobCategories->pluck('title_en')->values()->toArray())}}</td>
                    </tr>
                    <tr>
                        <td width="35%">Looking For</td>
                        <td>: {{@$resume->profile->jobLevel->title}}</td>
                    </tr>
                    <tr>
                        <td width="35%">Available For</td>
                        <td>: {{@$resume->profile->jobNature->title}}</td>
                    </tr>
                    @if(@$resume->profile->expected_salary)
                        <tr *ngIf="$resume->profile->expected_salary">
                            <td width="35%">Expected Salary</td>
                            <td>: Tk. {{$resume->profile->expected_salary}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="35%">Preferred District</td>
                        <td>: {{implode(', ', $resume->preferredAreas->pluck('title_en')->values()->toArray())}}</td>
                    </tr>
                    <tr>
                        <td width="35%">Preferred Country</td>
                        <td>
                            : {{implode(', ', $resume->preferred_areas_outside_bd->pluck('title_en')->values()->toArray())}}</td>
                    </tr>
                    <tr>
                        <td width="35%">Preferred Organization Types</td>
                        <td>
                            : {{implode(', ', $resume->preferredOrganizationTypes->pluck('title_en')->values()->toArray())}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header">
                <p class="mb-0">Specialization:</p>
            </div>
            <div class="cover-body">
                <ul>
                    @foreach($resume->specializations as $item)
                        <li>{{$item->title}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header">
                <p class="mb-0">Language Proficiency:</p>
            </div>
            <div class="cover-body">
                <table
                    class="table table-bordered table-sm">
                    <thead>
                    <tr>
                        <th width="25%">Language</th>
                        <th width="25%">Reading</th>
                        <th width="25%">Writing</th>
                        <th width="25%">Speaking</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resume->languageProficiencies as $item)
                        <tr class="text-center">
                            <td>{{$item->title}}</td>
                            <td>{{$item->reading_skill->title}}</td>
                            <td>{{$item->writing_skill->title}}</td>
                            <td>{{$item->speaking_skill->title}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header">
                <p class="mb-0">Personal Details:</p>
            </div>
            <div class="cover-body">
                <table
                    class="table table-borderless table-sm">
                    <tbody>
                    <tr>
                        <td width="25%">Father's Name</td>
                        <td>: {{@$resume->profile->father_name}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Mother's Name</td>
                        <td>: {{@$resume->profile->mother_name}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Date of Birth</td>
                        <td>: {{@$resume->profile->dob}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Gender</td>
                        <td>: {{@$resume->profile->gender->title}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Marital Status</td>
                        <td>: {{@$resume->profile->marital_status->title}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Nationality</td>
                        <td>: {{@$resume->profile->country->title}}</td>
                    </tr>
                    <tr>
                        <td width="25%">National Id No.</td>
                        <td>: {{@$resume->profile->nid_no}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Religion</td>
                        <td>: {{@$resume->profile->religion->title}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Permanent Address</td>
                        <td>: {{@$resume->profile->permanent_address}}</td>
                    </tr>
                    <tr>
                        <td width="25%">Current Location</td>
                        <td>: {{@$resume->profile->present_area->title_en}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="details-cover ng-star-inserted">
            <div class="cover-header">
                <p class="mb-0">Reference (s):</p>
            </div>
            <div class="cover-body">
                @if(count($resume->references) > 0)
                    <table class="table table-borderless table-sm">
                        <thead>
                        <tr>
                            <th class="text-left border-bottom-0"></th>
                            @foreach($resume->references as $key=>$item)
                                <th class="text-left border-bottom-0">
                                    Reference: {{$key + 1}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="20%">Name</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->name}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">Organization</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->organization}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">Designation</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->designation}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">Address</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->address}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">Mobile</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->mobile}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">E-Mail</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->email}}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td width="20%">Relation</td>
                            @foreach($resume->references as $key=>$item)
                                <td width="40%">: {{$item->relation_type.title}}</td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="container-fluid p-0">
        <div class="row" style="position: relative;margin: 15px 0;border: 1px solid #ddd;">
            <div class="col-sm-6 col-md-4 sidebar">
                <div class="img-fram-wrapper">
                    <img src="{{ $resume->image ?  $resume->image : 'assets/images/avatar.png'}}" alt="">
                </div>
                <h2 class="name-plate"><span>{{$resume->first_name}}</span> {{$resume->last_name}}</h2>
                @if(count($resume->jobExperiences) > 0)
                    <h3 class="designation">{{$resume->jobExperiences[0]->designation}}</h3>
                @endif
                <p style="margin-bottom: 0;"><i
                        class="fas fa-phone-square-alt"></i> {{implode(', ', $resume->contactMobiles->pluck('title')->values()->toArray())}}
                </p>
                <p style="margin-bottom: 0;"><i
                        class="fas fa-envelope-square"></i> {{implode(', ', $resume->contactEmails->pluck('title')->values()->toArray())}}
                </p>
                <p style="margin-bottom: 0;"><i
                        class="fas fa-map-marker-alt"></i> {{@$resume->profile->permanent_address}}</p>


                <hr class="sidebar-hr">
                <div class="profile-wrapper">
                    <h4><i class="fa fa-user" aria-hidden="true"></i> Personal Information</h4>
                    <p>
                        <label>Father's Name</label><br>
                        <strong>{{@$resume->profile->father_name}}</strong>
                    </p>
                    <p>
                        <label>Mother's Name</label><br>
                        <strong>{{@$resume->profile->mother_name}}</strong>
                    </p>
                    <p>
                        <label>Gender</label><br>
                        <strong>{{@$resume->profile->gender->title}}</strong>
                    </p>
                    <p>
                        <label>Date of Birth</label><br>
                        <strong>{{@$resume->profile->dob}}</strong>
                    </p>
                    <p>
                        <label>Nationality</label><br>
                        <strong>{{@$resume->profile->country->title}}</strong>
                    </p>
                    <p>
                        <label>Permanent Address</label><br>
                        <strong>{{@$resume->profile->permanent_area->title_en}}</strong>
                    </p>
                </div>
            </div>

            <div class="col-sm-6 col-md-8 main-container">
                <div class="academic-wrapper mt-0">
                    <h2><i class="fa fa-briefcase" aria-hidden="true"></i> Employment History</h2>
                    @foreach($resume->jobExperiences as $item)
                        <div class="academic-item" *ngFor="let item of $resume->job_experiences">
                            <div class="academic-title">
                                <h3>{{$item->designation}}</h3>
                                <span><i>{{$item->from}} - {{$item->is_current ? 'Continuing' : $item->to}}</i></span>
                            </div>
                            <div class="academic-inside">
                                <p><b>{{$item->company_name}}</b></p>
                                <p><i>{{$item->address}}</i></p>
                                <p><i>Department : {{$item->department}}</i></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr class="master-hr">
                <div class="academic-wrapper">
                    <h2><i class="fa fa-laptop" aria-hidden="true"></i> Profesional skills</h2>
                    <div class="academic-item">
                        <ul class="computer-skill">
                            <li *ngFor="let item of $resume->specializations">
                                <p>{{$item->title}}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr class="master-hr">
                <div class="academic-wrapper">
                    <h2><i class="fa fa-graduation-cap" aria-hidden="true"></i> Training Summary</h2>
                    <div class="academic-item" *ngFor="let item of $resume->trainings">
                        <div class="academic-title">
                            <h3>{{$item->title}}</h3>
                            <span><i>{{$item->passing_year}}</i></span>
                        </div>
                        <div class="academic-inside">
                            <p><label>Topic: </label> <b>{{$item->topic}}</b></p>
                            <p><label>Institute: </label> <b>{{$item->institute_name}}</b></p>
                            <p class="certificate-detail">Duration - {{$item->duration}}</p>
                        </div>
                    </div>
                </div>

                <hr class="master-hr">
                <div class="academic-wrapper">
                    <h2><i class="fa fa-graduation-cap" aria-hidden="true"></i> Academic Qualification</h2>
                    <div class="academic-item" *ngFor="let item of $resume->educations">
                        <div class="academic-title">
                            <h3>{{@$item->educationLevel->title}}</h3>
                            <span><i>{{$item->passing_year}}</i></span>
                        </div>
                        <div class="academic-inside">
                            <p><b>- {{@$item->degree->title}}</b></p>
                            <p><i>{{$item->institute_name}}</i></p>
                        </div>
                    </div>
                </div>
                <hr class="master-hr">
                <div class="academic-wrapper">
                    <h2><i class="fa fa-flag" aria-hidden="true"></i> Certificate & Awards</h2>
                    <div class="academic-item" *ngFor="let item of $resume->certifications">
                        <div class="academic-title">
                            <h3>{{$item->title}} <span
                                    class="certificate-date"><i>{{$item->from}}- {{$item->to}}</i></span></h3>
                        </div>
                        <div class="academic-inside">
                            <p class="certificate-detail"> - {{$item->institute_name}}</p>
                            <p><i>{{$item->address}}</i></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

</body>
</html>
