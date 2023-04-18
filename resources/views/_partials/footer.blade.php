<section class="footer-area">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="widget">
                        <h3>{{trans('words.about_us')}}</h3>
                        <ul>
                            <li><a target="_blank" href="/pages/about-us">{{trans('words.about_morejobs')}}</a></li>
                            <li><a target="_blank" href="/pages/terms-and-conditions">{{trans('words.terms_condition')}}</a></li>
                            <li><a target="_blank" href="/pages/accessibility-statement">{{trans('words.accessibility_statement')}}</a></li>
                            <li><a target="_blank" href="/pages/privacy-and-policy">{{trans('words.privacy_policy')}}</a></li>
                            <li><a target="_blank" href="/pages/feedback">{{trans('words.feedback')}}</a></li>
                            <li><a target="_blank" href="{{url('contact-us')}}">{{trans('words.contact_us')}}</a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="widget">
                        <h3>{{trans('words.job_seeker')}}</h3>
                        <ul>
                            <li><a target="_blank" href="{{env('NG_URL').'/login'}}">{{trans('words.resume_edit')}}</a></li>
                            <li><a target="_blank" href="{{env('NG_URL').'/login'}}">{{trans('words.my_more_job')}}</a></li>
                            <li><a target="_blank" href="/pages/faq">{{trans('words.faq')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="widget">
                        <h3>{{trans('words.employer')}}</h3>
                        <ul>

                            <li><a target="_blank" href="{{env('NG_URL').'/employer-registration'}}">{{trans('words.create_account')}}</a></li>
                            <li><a target="_blank" href="{{url('employer-services')}}">{{trans('words.product_service')}}</a></li>
                            <li><a target="_blank" href="{{env('NG_URL').'/login'}}">{{trans('words.job_post')}}</a></li>
                            {{--<li><a target="_blank" href="/pages/faq">{{trans('words.faq')}}</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="widget">
                        <h3>{{trans('words.social_media')}}</h3>
                        <ul>
                            <li><a href="https://www.facebook.com/MOREJOBSBD"><i class="icofont-facebook"></i> {{trans('words.facebook')}}</a></li>
                            <li><a href="https://twitter.com/MoreJobsBD"><i class="icofont-twitter"></i> {{trans('words.twitter')}}</a></li>
                            <li><a href="https://www.youtube.com/channel/UC6ngxk3UEw7DJGWQ8cfsBWA"><i class="icofont-youtube"></i> {{trans('words.youtube')}}</a></li>
{{--                            <li><a href="#"><i class="icofont-linkedin"></i> {{trans('words.linked_in')}}</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div> <!--Row Close-->
        </div><!--Container Close-->
    </div><!--Footer Top Close-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="copyright">
                        {{trans('words.need_support')}} ? Call to +8801911360008 , +8801958373930
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="copyright float-right">
                        Developed By <a href="#"><img src="{{asset('img/zoomit.png')}}"
                                                      style="display:inline-block; width:80px" alt="ZOOM IT"></a>
                    </div>
                </div>
            </div> <!--Row Close-->
        </div><!--Container Close-->
    </div><!--Footer Bottom Close-->
</section><!--Footer Area Close-->
