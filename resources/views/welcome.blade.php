@extends('layouts.app')
 
@section('title', 'Home')
  
 
@section('content')

    <!-- Header -->
    <header class="header ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h1>Welcome to Invoice Gem</h1>
                        <p class="p-large p-heading">Your advanced incoming and outgoing invoices management system on the go.</p>
                        <a class="btn-solid-lg" href="/login"> <i class="fa fa-certificate" aria-hidden="true"></i> Get started for FREE</a>
                        <a class="btn-solid-lg" href="#how-works"> <i class="fa fa-flag-checkered" aria-hidden="true"></i> How it works?</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="image-container">
                        <img class="img-fluid" src="images/main.gif" alt="alternative" style="width: 90%;">
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
        <div class="deco-white-circle-1">
            <img src="images/decorative-white-circle.svg" alt="alternative">
        </div> <!-- end of deco-white-circle-1 -->
        <div class="deco-white-circle-2">
            <img src="images/decorative-white-circle.svg" alt="alternative">
        </div> <!-- end of deco-white-circle-2 -->
        <div class="deco-blue-circle">
            <img src="images/decorative-blue-circle.svg" alt="alternative">
        </div> <!-- end of deco-blue-circle -->
        <div class="deco-yellow-circle">
            <img src="images/decorative-yellow-circle.svg" alt="alternative">
        </div> <!-- end of deco-yellow-circle -->
        <div class="deco-green-diamond">
            <img src="images/decorative-green-diamond.svg" alt="alternative">
        </div> <!-- end of deco-yellow-circle -->
    </header> <!-- end of header -->
    <!-- end of header -->


    <!-- Small Features -->
    <div class="cards-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image"> 
                            <i class="fas fa-fast-forward" aria-hidden="true"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Fast tracking</h5>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image green">
                            <i class="fas fa-clock" aria-hidden="true"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Available 24/7</h5>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image red">
                            <i class="fas fa-industry" aria-hidden="true"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">All industries</h5>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image yellow">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Customer support</h5>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image blue">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Secures process</h5>
                        </div>
                    </div>
                    <!-- end of card -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-1 -->
    <!-- end of small features -->


    <!-- Description 1 -->
    <div id="description" class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="image-container text-center" >
                        <img class="img-fluid" src="images/about.jpg" style=" max-height: 100%;">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="text-container">
                        <h2>About Invoice Gem</h2>
                        <p>
                            Invoice Gem is an Australian owned business located in Sydney. We provide an advaced smart system for online invoice tracking. With us you will be able to add all your incoiming and outgoing insoivces quicly and easly on to go. From now on, you don't have to spend time of filling your business expences and payments neither stack them in your files.

                        </p>
                        <p>
                            Invoice Gem system is suitable for all buinsess types and sizes. With us you get access to add multiple team members to your business profile where they can manage the invoices with you. As well ass having the ability to register multiple buinsess profiles.
                        </p> 
                        <ul class="list-unstyled li-space-lg">
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Save time in tracking all your incoming and outgoing invoices.</div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Ensure fast and secured process on the go.  </div>
                            </li>
                            <li class="media">
                                <i class="fas fa-square"></i>
                                <div class="media-body">Manage your account anytime online.  </div>
                            </li>
                        </ul>
                        <a class="btn-solid-reg " href="/register">Register now</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-1 -->
    <!-- end of description 1 -->

    
     


    <!-- Description 2 -->
    <div class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="tabs-container">

                        <!-- Tabs Links -->
                        <ul class="nav nav-tabs" id="cedoTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Create
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">
                                    <i class="fas fa-list"></i>Manage
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-tab-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">
                                    <i class="far fa-calendar-alt"></i>Organise
                                </a>
                            </li>
                        </ul>
                        <!-- end of tabs links -->
                        
                        <!-- Tabs Content -->
                        <div class="tab-content" id="cedoTabsContent">
                            <!-- Tab -->
                            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                                <p><strong>Generate</strong> new incoming and outgoing invoices in simple clicks:</p>
                                <ul class="list-unstyled li-space-lg">
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Save your incoming invoices on time and attach a copy of the otiginal one.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Create new outgoing invoices and share them with others.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Allow different access types for other users to view your generated invoices.
                                        </div>
                                    </li>
                                </ul>
                                
                            </div> <!-- end of tab-pane -->
                            <!-- end of tab -->

                            <!-- Tab -->
                            <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
                                <p><strong>Control</strong> your buisiness expences and profits easily: </p>
                                
                                <ul class="list-unstyled li-space-lg">
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Access your saved invoices 24/7 online using and smart device.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Create a team linked to you business profile and allow them to add invoices as well.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Register as many business profile as you need and manage them easutly on one platform.
                                        </div>
                                    </li>
                                </ul>
                            </div> <!-- end of tab-pane -->
                            <!-- end of tab -->

                            <!-- Tab -->
                            <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3">
                                <p><strong>Arrange</strong> your business's payments and documents:</p>
                                <ul class="list-unstyled li-space-lg">
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Get your paid and pending payments counted and prepaired for Tax.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Export your saved invoices onto your device anytime through Excel files.
                                        </div>
                                    </li>
                                    <li class="media">
                                        <i class="far fa-check-square"></i>
                                        <div class="media-body">
                                            Filter and find any invoice saved in your account easly and quickly.
                                        </div>
                                    </li> 
                                </ul>
                            </div> <!-- end of tab-pane -->
                            <!-- end of tab -->
                        </div> <!-- end of tab-content -->
                        <!-- end of nav tabs content -->
                    
                    </div> <!-- end of tabs-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="image-container">
                        <img class="img-fluid" src="images/why-us.png" style="    border-radius: 50%;
                        box-shadow: 0px 5px 15px 0.5px;">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of tabs -->
    <!-- end of description 2 -->


    <!-- Features -->
    <div id="features" class="basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Special Features</h2>
                    <p class="p-heading">Sync's features are designed to help you improve your time management skills and become a better organized person. Organize your tasks, schedule your appointments and meet your personal development goals with Sync</p>
                </div> <!-- end of div -->
            </div> <!-- end of div -->
            <div class="row">
                <div class="col-lg-4">
                    <ul class="list-unstyled li-space-lg first">
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fas fa-users fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Goal Setting</h4>
                                <p>Like any self improving process, everything starts with setting your goals and committing to them</p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x green"></i>
                                <i class="fas fa-code fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Situation Analysis</h4>
                                <p>Sync provides a well designed and ergonomic visual editor for you to edit your quick notes</p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x red"></i>
                                <i class="fas fa-cog fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Tasks Settings</h4>
                                <p>Each option packaged in the app's menus is provided in order to improve you personally</p>
                            </div>
                        </li>
                    </ul>
                </div> <!-- end of col -->
                <div class="col-lg-4">
                    <img class="img-fluid" src="images/features-app.jpg" alt="alternative">
                </div> <!-- end of col -->
                <div class="col-lg-4">
                    <ul class="list-unstyled li-space-lg">
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x yellow"></i>
                                <i class="fas fa-comments fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Social Interaction</h4>
                                <p>Schedule your appointments, meetings and periodical evaluations using the tools</p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x blue"></i>
                                <i class="fas fa-rocket fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Get Things Done</h4>
                                <p>Reading focus mode for long form articles, ebooks and other materials with long text</p>
                            </div>
                        </li>
                        <li class="media">
                            <span class="fa-stack">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fas fa-download fa-stack-1x"></i>
                            </span>
                            <div class="media-body">
                                <h4>Good Foundation</h4>
                                <p>Get a solid foundation for your self development efforts. Try Sync mobile app for devices</p>
                            </div>
                        </li>
                    </ul>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of basic-2 -->
    <!-- end of features -->


    <!-- Screenshots -->
    <div id="screens" class="slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Image Slider -->
                    <div class="slider-container">
                        <div class="swiper-container image-slider">
                            <div class="swiper-wrapper">
                                
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-1.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-1.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-2.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-2.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-3.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-3.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-4.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-4.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-5.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-5.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-1.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-6.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-2.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-7.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-3.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-8.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-4.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-9.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <a href="images/screenshot-5.jpg" class="popup-link" data-effect="fadeIn">
                                        <img class="img-fluid" src="images/screenshot-10.jpg" alt="alternative">
                                    </a>
                                </div>
                                <!-- end of slide -->
                                
                            </div> <!-- end of swiper-wrapper -->

                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- end of add arrows -->

                        </div> <!-- end of swiper-container -->
                    </div> <!-- end of slider-container -->
                    <!-- end of image slider -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of slider -->
    <!-- end of screenshots -->


    <!-- Testimonials -->
    <div class="cards-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>User Testimonials</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">I love using Sync for my personal development needs. It meets all my requirements and it actually helps a lot with focusing skills.</div>
                            <div class="testimonial-author">Rick Jones - Designer</div>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">After trying out a large number of personal coaching apps I decided to give Sync a try and what a wonderful surprise it was.</div>
                            <div class="testimonial-author">Lynda Marquez - Developer</div>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">Never dreamed I could learn so fast how to focus on my personal goals and improve my life to levels I never thought possible.</div>
                            <div class="testimonial-author">Jay Frisco - Marketer</div>
                        </div>
                    </div>
                    <!-- end of card -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="image-container">
                        <img class="img-fluid" src="images/customer-logo-1.png" alt="alternative">
                        <img class="img-fluid" src="images/customer-logo-2.png" alt="alternative">
                        <img class="img-fluid" src="images/customer-logo-3.png" alt="alternative">
                        <img class="img-fluid" src="images/customer-logo-4.png" alt="alternative">
                        <img class="img-fluid" src="images/customer-logo-5.png" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">I got so much value from using Sync in my daily life for which I am very grateful and would recommend it to everybody</div>
                            <div class="testimonial-author">Frank Gibson - Manager</div>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">If you have great goals but can't figure out a way to keep focused then you should definitely give Sync a try and see the results</div>
                            <div class="testimonial-author">Rita Longmile - Designer</div>
                        </div>
                    </div>
                    <!-- end of card -->

                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <hr class="testimonial-line">
                        </div>
                        <div class="card-body">
                            <div class="testimonial-text">I've been looking for a great organizer app for such a long time but now I am really happy that I found Sync. It's beeen working great</div>
                            <div class="testimonial-author">Jones Smith - Developer</div>
                        </div>
                    </div>
                    <!-- end of card -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of cards-2 -->
    <!-- end of testimonials -->


    <!-- Statistics -->
    <div class="counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <!-- Counter -->
                    <div id="counter">
                        <div class="cell">
                            <i class="fas fa-users"></i>
                            <div class="counter-value number-count" data-count="231">1</div>
                            <p class="counter-info">Happy Users</p>
                        </div>
                        <div class="cell">
                            <i class="fas fa-code green"></i>
                            <div class="counter-value number-count" data-count="385">1</div>
                            <p class="counter-info">Issues Solved</p>
                        </div>
                        <div class="cell">
                            <i class="fas fa-cog red"></i>
                            <div class="counter-value number-count" data-count="159">1</div>
                            <p class="counter-info">Good Reviews</p>
                        </div>
                        <div class="cell">
                            <i class="fas fa-comments yellow"></i>
                            <div class="counter-value number-count" data-count="127">1</div>
                            <p class="counter-info">Case Studies</p>
                        </div>
                        <div class="cell">
                            <i class="fas fa-rocket blue"></i>
                            <div class="counter-value number-count" data-count="211">1</div>
                            <p class="counter-info">Orders Received</p>
                        </div>
                    </div>
                    <!-- end of counter -->

                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of counter -->
    <!-- end of statistics -->


    <!-- Download -->
    <div id="download" class="basic-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="image-container">
                        <img class="img-fluid" src="images/download-iphone.png" alt="alternative">
                    </div> <!-- end of image-container -->
                    <p class="p-large">Do you feel like you're wasting time with small stuff instead of working towards your goals? Start using Sync to organize your time and get a grip on your personal development</p>
                    <a class="btn-solid-lg" href="#your-link"><i class="fab fa-apple"></i>DOWNLOAD</a>
                    <a class="btn-solid-lg" href="#your-link"><i class="fab fa-google-play"></i>DOWNLOAD</a>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
        <div class="deco-white-circle-1">
            <img src="images/decorative-white-circle.svg" alt="alternative">
        </div> <!-- end of deco-white-circle-1 -->
        <div class="deco-white-circle-2">
            <img src="images/decorative-white-circle.svg" alt="alternative">
        </div> <!-- end of deco-white-circle-2 -->
        <div class="deco-blue-circle">
            <img src="images/decorative-blue-circle.svg" alt="alternative">
        </div> <!-- end of deco-blue-circle -->
        <div class="deco-yellow-circle">
            <img src="images/decorative-yellow-circle.svg" alt="alternative">
        </div> <!-- end of deco-yellow-circle -->
        <div class="deco-green-diamond">
            <img src="images/decorative-green-diamond.svg" alt="alternative">
        </div> <!-- end of deco-yellow-circle -->
    </div> <!-- end of basic-3 -->
    <!-- end of download -->

{{--
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-col first">
                        <h5>About Sync</h5>
                        <p class="p-small">Sync is a landing page HTML template built with Bootstrap 4 for presenting mobile apps</p>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col second">
                        <h5>Contact Info</h5>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li class="media">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="media-body">22 Innovation Street, CA, US</div>
                            </li>
                            <li class="media">
                                <i class="fas fa-envelope"></i>
                                <div class="media-body"><a href="#your-link">office@syncmobile.com</a></div>
                            </li>
                            <li class="media">
                                <i class="fas fa-phone-alt"></i>
                                <div class="media-body"><a href="#your-link">+44 376 945 23</a></div>
                            </li>
                        </ul>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col third">
                        <h5>Value Links</h5>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li><a href="terms-conditions.html">Terms & Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="article-details.html">Article Details</a></li>
                        </ul>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col fourth">
                        <h5>Other Apps</h5>
                        <ul class="list-unstyled li-space-lg p-small">
                            <li><a href="#your-link">Scientific Calculator</a></li>
                            <li><a href="#your-link">Advanced Timer</a></li>
                            <li><a href="#your-link">Music Store</a></li>
                        </ul>
                    </div> <!-- end of footer-col -->
                    <div class="footer-col fifth">
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-twitter fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-pinterest-p fa-stack-1x"></i>
                            </a>
                        </span>
                        <span class="fa-stack">
                            <a href="#your-link">
                                <i class="fas fa-circle fa-stack-2x"></i>
                                <i class="fab fa-instagram fa-stack-1x"></i>
                            </a>
                        </span>
                    </div> <!-- end of footer-col -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of footer -->  
    <!-- end of footer -->


    <!-- Copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright © 2020 <a href="https://inovatik.com">Inovatik</a> - All rights reserved</p>
                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> <!-- end of copyright --> 
    <!-- end of copyright -->
     --}}
@endsection

