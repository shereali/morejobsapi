@extends('_partials.app')

@section('title', 'Accessibility Statement')

@section('main_container')
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="title">Morejobsbd.net Accessibility Statement</h3>
                            <div class="content-wrapper">
                                <p>We are committed to make our site accessible for everyone, regardless of
                                    disabilities. We are
                                    constantly working towards improving the accessibility of our website to ensure we
                                    provide
                                    equal access for all users. <br>
                                    We wanted to make sure that our the site is flexible and adaptable to different
                                    users’ needs or
                                    preferences and is accessible through a variety of different technologies or
                                    assistive technologies.
                                    We tried to improve the accessibility of our website for users with disabilities as
                                    follows:
                                    <br>
                                    Adjust the font size <br>
                                    Maintain colour/contrast ratios for text <br>
                                    Keyboard accessible navigation <br>
                                    Exposing information to the accessibility API through the use of ARIA attributes</p>

                                <h5>Web Content Accessibility Guidelines (WCAG) 2.1</h5>
                                <p class="mb-0">As a part of our commitment we provide level AA of the Web Content
                                    Accessibility
                                    Guidelines (WCAG 2.1). These guidelines outline four main principles that state that
                                    sites should be:</p>
                                <p class="mb-0"><b>Perceivable</b> - Information and user interface components must be
                                    presentable to
                                    users in ways they can perceive</p>
                                <p class="mb-0"><b>Operable</b> - User interface components and navigation must be
                                    operable</p>
                                <p class="mb-0"><b>Understandable</b> - Information and the operation of user interface
                                    must be understandable</p>
                                <p class="mb-0"><b>Robust</b> - Content must be robust enough that it can be interpreted
                                    reliably by a wide variety of
                                    user agents, including assistive technologies</p>
                                <br>
                                <h5>How accessible this website is</h5>
                                <p class="mb-0">Almost full website is accessible, except</p>
                                <p>Many documents are in PDF format and are not accessible</p>

                                <h5>Screen Reader Access</h5>
                                <p class="mb-0">People with visual impairments access the website using assistive
                                    technologies, such as screen
                                    readers. Our website can be accessible with any assistive tools. Again, We listed
                                    some screen
                                    readers below with website link so that user can download easily.</p>
                                <p class="mb-0">Screen reader</p>
                                <p class="mb-0">Website</p>
                                <p class="mb-0">Free or Commercial</p>
                                <p class="mb-0">Screen Access For All (SAFA)</p>
                                <p class="mb-0">- <a href="https://safa-reader.software.informer.com/download/">https://safa-reader.software.informer.com/download/</a>
                                </p>
                                <p class="mb-0">Free</p>
                                <p class="mb-0">Non Visual Desktop Access (NVDA)</p>
                                <p class="mb-0">- <a href="https://www.nvda-project.org/">https://www.nvda-project.org/</a></p>
                                <p class="mb-0">Free</p>
                                <p class="mb-0">System Access To Go</p>
                                <p class="mb-0">- <a href="https://www.satogo.com/">https://www.satogo.com/</a></p>
                                <p class="mb-0">Free</p>
                                <p class="mb-0">Thunder</p>
                                <p class="mb-0">- <a href="https://www.screenreader.net/index.php?pageid=11">https://www.screenreader.net/index.php?pageid=11/</a></p>
                                <p class="mb-0">Free</p>
                                <p class="mb-0">WebAnywhere</p>
                                <p class="mb-0">- <a href="https://webanywhere.cs.washington.edu/wa.php">https://webanywhere.cs.washington.edu/wa.php</a></p>
                                <p class="mb-0">Free</p>
                                <p class="mb-0">Hal</p>
                                <p class="mb-0">- <a href="https://www.yourdolphin.co.uk/productdetail.asp?id=5">https://www.yourdolphin.co.uk/productdetail.asp?id=5</a></p>
                                <p class="mb-0">Comercial</p>
                                <p class="mb-0">JAWS</p>
                                <p class="mb-0">- <a href="https://www.freedomscientific.com/Products/Blindness/JAWS">https://www.freedomscientific.com/Products/Blindness/JAWS</a></p>
                                <p class="mb-0">Comercial</p>
                                <p class="mb-0">Supernova</p>
                                <p class="mb-0">- <a href="https://www.yourdolphin.co.uk/productdetail.Supernova asp?id=1">https://www.yourdolphin.co.uk/productdetail.Supernova asp?id=1</a></p>
                                <p class="mb-0">Comercial</p>
                                <p class="mb-0">Window-Eyes</p>
                                <p class="mb-0">- <a href="https://www.nvda-project.org/">https://www.nvda-project.org/</a></p>
                                <p class="mb-0">Comercial</p>
                                <br>
                                <h5>Reporting accessibility problems</h5>
                                <p>If you find any problems that are not listed on this page or you think we’re not meeting the
                                    accessibility requirements, Please provide your valuable <a href="#">feedback</a>.</p>

                                <h5>Contact Us</h5>
                                <p>If you need any accessibility-related assistance, <a href="{{url('contact-us')}}">inform us from our contact us page</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
