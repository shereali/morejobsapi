<div class="top-bar d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                <div class="top-bar-left">
                    <ul>
                        <li id="job_menu" onclick="resetFilters()">
                            <a href="{{url('job-lists')}}" target="_blank"
                               class="link-changeable header_menu">{{trans('words.job_menu')}}</a>
                        </li>
                        <li id="home_menu">
                            <a href="{{env('NG_URL').'/home'}}" target="_blank"
                               class="header_menu">{{trans('words.my_job_menu')}}</a>
                        </li>
                        <li id="company_list_menu"><a href="{{env('NG_URL').'/login'}}" target="_blank"
                                                      class="header_menu">{{ trans('words.employers') }}</a>
                        </li>
                        <li id="training_menu"><a href="{{url('training-courses')}}" target="_blank"
                                                  class="link-changeable header_menu">{{trans('words.training_menu')}}</a>
                        </li>
                        <li id="_menu"><a href="{{url('/')}}" class="header_menu" target="_blank">{{trans('words.tender_eoi_menu')}}</a>
                        </li>
                        <li id="admission_menu"><a href="{{url('admission')}}" target="_blank"
                                                   class="header_menu">{{trans('words.admission_menu')}}</a></li>
                        <li id="scholarship_menu"><a href="{{url('scholarship')}}" target="_blank"
                                                     class="header_menu">{{trans('words.scholarship_menu')}}</a></li>
                        <li id="event_fair_menu"><a href="{{url('events')}}" target="_blank"
                                                    class="header_menu">{{trans('words.event_fair_menu')}}</a></li>
                        <li><a href="https://tutor.morejobsbd.net" target="_blank">{{trans('words.tutor_menu')}}</a></li>

                        <li id="articles"><a href="{{url('articles')}}" target="_blank"
                                                    class="header_menu">{{trans('words.articles')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3">
                <div class="top-bar-right float-right">
                    <ul>
                        <li><a target="_blank" href="https://www.facebook.com/MOREJOBSBD"><i class="icofont-facebook"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/MoreJobs2"><i class="icofont-twitter"></i></a></li>
                        <li><a target="_blank" href="https://www.youtube.com/channel/UC6ngxk3UEw7DJGWQ8cfsBWA"><i class="icofont-youtube-play"></i></a></li>
                        <li><a href="tel:+8801747305750"><i class="icofont-phone"></i></a></li>
                        <li class="lang">
                            <div class="btn-group">
                                <a href="javascript:void(0)" class="btn btn-sm btn-default lang" id="en_lan"
                                   onClick="onChangeLang('en')">Eng</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-transparent lang" id="bn_lan"
                                   onClick="onChangeLang('bn')">বাংলা</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- Top Bar close -->

<div class="header-area">
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand logo link-changeable" href="{{url('/')}}">
                        <img src="{{asset('img/logo.jpg')}}" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="icofont-navigation-menu"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <div id="auth_content"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{url('contact-us')}}">
                                    <i class="icofont-phone"></i> {{trans('words.contact_us')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- Header Area close -->


<script src="https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setDefaultLang();

        const user = jQuery.parseJSON(Cookies.get('user') ?? null);
        if (!user) {
            $('#auth_content').html(
                `<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sign in or Create Account
                                </a>
                                <div class="dropdown-menu loginmenudropdown" aria-labelledby="navbarDropdownMenuLink">
                                    <div class="row">
                                        <div class="col-md-6 pr-2">
                                            <div class="jobseeker bg-primary text-center">
                                                <h2>For Jobseeker</h2>
                                                <div><i class="icofont-search-job icofont-4x"></i></div>
                                                <h3>I am looking for JOB</h3>
                                                <p>Search Hundreds of Jobs</p>
                                                <div class="group-signin">
                                                    <a href="{{env('NG_URL').'/login'}}"
                                                       class="btn btn-info btn-sm font-weight-bold">Sign In</a>
                                                    <a href="{{env('NG_URL').'/registration'}}"
                                                       class="btn btn-default btn-sm font-weight-bold">Create
                                                        account</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-2">
                                            <div class="jobseeker bg-danger text-center">
                                                <h2>For Employer</h2>
                                                <div><i class="icofont-briefcase-2 icofont-4x"></i></div>
                                                <h3>I have vacancies</h3>
                                                <p>Post Your Job For Free!</p>
                                                <div class="group-signin">
                                                    <a href="{{env('NG_URL').'/login'}}"
                                                       class="btn btn-warning btn-sm font-weight-bold">
                                                        Sign In</a>
                                                    <a href="{{env('NG_URL').'/employer-registration'}}"
                                                       class="btn btn-default btn-sm font-weight-bold">
                                                        Create account</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
            )
        } else {
            let html = `
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ${user.first_name}
                        </a>`;

            if (user.user_type.id === 2) {
                html += `
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <ul>
                                <li>
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="{{env('NG_URL').'/home/edit-resume'}}">Edit Resume</a>
                                </li>
                                <li>
                                    <i class="fa fa-eye" aria-hidden="true"></i> <a href="{{env('NG_URL').'/home/view-resume?view_mode=details'}}">View Resume</a>
                                </li>
                                <li>
                                    <i class="fa fa-star" aria-hidden="true"></i> <a href="{{env('NG_URL').'/home/favorite-jobs'}}">Shortlisted Jobs</a>
                                </li>
                                <li>
                                    <i class="fa fa-heart" aria-hidden="true"></i> <a href="{{env('NG_URL').'/home/following-company'}}">Following Employers</a>
                                </li>
                                <li>
                                    <i class="fa fa-check-circle-o" aria-hidden="true"></i> <a href="{{env('NG_URL').'/home/online-application'}}">Applied Jobs</a>
                                </li>
                                <li>
                                    <i class="fa fa-key" aria-hidden="true"></i> <a href="{{env('NG_URL').'/change-password'}}">Change Password</a>
                                </li>
                                <li>
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> <a href="Javascript:void(0)" onclick="logout()">Sign Out</a>
                                </li>
                            </ul>
                        </div>`;

            } else if (user.user_type.id === 3) {
                html += `
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <ul>
                                <li>
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="{{env('NG_URL').'/company'}}">My Home</a>
                                </li>
                                <li>
                                    <i class="fa fa-eye" aria-hidden="true"></i> <a href="{{env('NG_URL').'/company/subscribe'}}">Subscribed Services</a>
                                </li>
                                <li>
                                    <i class="fa fa-star" aria-hidden="true"></i> <a href="{{env('NG_URL').'/company/edit-account'}}">Edit Account</a>
                                </li>
                                <li>
                                    <i class="fa fa-key" aria-hidden="true"></i> <a href="{{env('NG_URL').'/change-password'}}">Change Password</a>
                                </li>
                                <li>
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> <a href="Javascript:void(0)" onclick="logout()">Sign Out</a>
                                </li>
                            </ul>
                        </div>`;
            } else {
                html += `
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <ul>
                                <li>
                                        <i class="fa fa-home" aria-hidden="true"></i> <a href="{{env('NG_URL').'/admin/home'}}">Go to Dashboard</a>
                                 </li>
                                <li>
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> <a href="Javascript:void(0)" onclick="logout()">Sign Out</a>
                                </li>
                            </ul>
                        </div>`;
            }

            $('#auth_content').html(html)
        }
    })


    function logout() {
        $.ajax({
            url: "{{URL::to('account/logout')}}",
            method: 'GET',
            beforeSend: function (xhr) {
                const token = Cookies.get('access_token');
                xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            },
            success: function (res) {
                removeCookie('access_token');
                removeCookie('refresh_token');
                removeCookie('refresh_before');
                removeCookie('user');

                if (res.success) {
                    $('#auth_content').html(
                        `<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sign in or Create Account
                                </a>
                                <div class="dropdown-menu loginmenudropdown" aria-labelledby="navbarDropdownMenuLink">
                                    <div class="row">
                                        <div class="col-md-6 pr-2">
                                            <div class="jobseeker bg-primary text-center">
                                                <h2>For Jobseeker</h2>
                                                <div><i class="icofont-search-job icofont-4x"></i></div>
                                                <h3>I am looking for JOB</h3>
                                                <p>Search Hundreds of Jobs</p>
                                                <div class="group-signin">
                                                    <a href="{{env('NG_URL').'/login'}}"
                                                       class="btn btn-info btn-sm font-weight-bold">Sign In</a>
                                                    <a href="{{env('NG_URL').'/registration'}}"
                                                       class="btn btn-default btn-sm font-weight-bold">Create
                                                        account</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-2">
                                            <div class="jobseeker bg-danger text-center">
                                                <h2>For Employer</h2>
                                                <div><i class="icofont-briefcase-2 icofont-4x"></i></div>
                                                <h3>I have vacancies</h3>
                                                <p>Post Your Job For Free!</p>
                                                <div class="group-signin">
                                                    <a href="{{env('NG_URL').'/login'}}"
                                                       class="btn btn-warning btn-sm font-weight-bold">
                                                        Sign In</a>
                                                    <a href="{{env('NG_URL').'/employer-registration'}}"
                                                       class="btn btn-default btn-sm font-weight-bold">
                                                        Create account</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                    )
                } else {
                    window.open('{{ env('NG_URL') }}' + '/login', '_self')
                }

            },
            error: function (data) {
                swal("Error!", "Something wrong", "warning")
            }
        });
    }

    function gotoExternalPage(page) {
        window.open('{{ env('NG_URL') }}' + '/' + page, '_self')
    }

    function removeCookie(name) {
        let env = '{{ env('APP_ENV') }}';
        let path = '/';
        let domain = (env === 'production') ? '.morejobsbd.net' : 'localhost';
        document.cookie = name + "=" +
            ((path) ? ";path=" + path : "") +
            ((domain) ? ";domain=" + domain : "") +
            ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
    }

    function setCookie(key, value) {
        let env = '{{ env('APP_ENV') }}';
        let domain = (env === 'production') ? '.morejobsbd.net' : 'localhost';

        Cookies.set(key, value, { domain: domain })
    }
</script>

{{--language section--}}
<script>
    const LANGUAGES = ['/', '/bn'];

    function setDefaultLang() {
        $('.lang').removeClass('btn-default').addClass('btn-transparent');

        const url = window.location.pathname;
        const langExceptDefault = LANGUAGES.slice(1, LANGUAGES.length);
        let currentLang = '';

        for (i = 0; i < langExceptDefault.length; i++) {
            if (url.indexOf(langExceptDefault[i]) >= 0) {
                currentLang = langExceptDefault[i];
                break;
            }
        }

        currentLang = currentLang ? currentLang.replace('/', '') : 'en';
        setCookie('lang', currentLang)
        $(`#${currentLang}_lan`).removeClass('btn-transparent').addClass('btn-default').css({'pointer-events': 'none'})


        setActiveHeaderMenu();

        resetLinks(currentLang);
    }


    function onChangeLang(value) {
        const lan = value === 'en' ? '' : value;

        setCookie('lang', lan)

        let pathname = window.location.pathname;

        if (lan) {
            pathname = '/bn' + pathname;
        } else {
            pathname = pathname.replace('/bn', lan);
        }
        if(pathname == ''){
            window.location.replace('//' + location.host);
        }else{
            window.location.replace(`${pathname}` + window.location.search)
        }
    }

    function resetLinks(currentLang) {
        currentLang = currentLang === 'en' ? '' : currentLang;

        $('.link-changeable').each(function () {
            let pathName = this.pathname;
            LANGUAGES.forEach((tag, i) => pathName = pathName.replace(new RegExp(tag), '/' + currentLang + '/'))
            pathName = pathName.replace('//', '/')

            this.href = pathName + this.search
        });
    }


    function setActiveHeaderMenu() {
        $('.header_menu').removeClass('active')

        const currentUrl = window.location.pathname.replace('/bn', '');

        if (currentUrl === '/' || currentUrl === '/job-lists') {
            $('#job_menu').addClass('active');
        } else if (currentUrl === '/company-list') {
            $('#company_list_menu').addClass('active');
        } else if (currentUrl === '/training-courses') {
            $('#training_menu').addClass('active');
        } else if (currentUrl === '/admission') {
            $('#admission_menu').addClass('active');
        } else if (currentUrl === '/scholarship') {
            $('#scholarship_menu').addClass('active');
        } else if (currentUrl === '/events') {
            $('#event_fair_menu').addClass('active');
        }
    }

    function formattedTitle(item) {
        const currentLang = Cookies.get('lang');

        if (currentLang === 'bn') {
            return item.title_bn;
        }
        return item.title_en;
    }

    function formattedUrl(url) {
        const location = document.createElement("a");
        location.href = url;

        const currentLang = Cookies.get('lang') === 'en' ? '' : '/' + Cookies.get('lang');

        return currentLang + location.pathname + location.search;
    }
</script>

