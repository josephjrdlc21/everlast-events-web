@extends('frontend._layouts.web')

@section('content')
<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">  
                <div class="header-text text-center">
                    <span class="category text-white">Event Management System</span>
                    @if($banner && $banner->count() > 0)
                    <h2 class="text-white mt-5">{{$banner->title}}</h2>
                    <div class="mt-2">{!!$banner->content!!}</div>
                    @endif
                </div>    
            </div>
        </div>
    </div>
</div>

@if($about && $about->count() > 0)
<div class="section about-us" id="about">
    <div class="container">
        <div class="row">
            @if($faqs && $faqs->count() > 0)
            <div class="col-lg-6 offset-lg-1">
                <div class="accordion" id="accordionExample">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{$faq->id}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false" aria-controls="collapse{{$faq->id}}">
                                {{$faq->question}}
                            </button>
                        </h2>
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$faq->id}}" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">
                                {!!$faq->answer!!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <div class="col-lg-5 align-self-center">
                <div class="section-heading">
                    <h6>{{$about->type}}</h6>
                    <h2>{{$about->title}}</h2>
                    <div>{!!$about->content!!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($events && $events->count() > 0)
<div class="section events" id="events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Schedule</h6>
                    <h2>Upcoming Events</h2>
                </div>
            </div>
            @foreach($events as $index => $event)
            <div class="col-lg-12 col-md-6">
                <div class="item">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="image">
                                <img src="{{"{$event->directory}/{$event->filename}"}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <ul>
                                <li>
                                    <span class="category">{{$event->category->title}}</span>
                                    <h4>{{$event->name}}</h4>
                                </li>
                                <li>
                                    <span>Date Start:</span>
                                    <h6>{{Carbon::parse($event->event_start)->format('m/d/Y')}}</h6>
                                </li>
                                <li>
                                    <span>Date End:</span>
                                    <h6>{{Carbon::parse($event->event_end)->format('m/d/Y')}}</h6>
                                </li>
                                <li>
                                    <span>Duration:</span>
                                    <h6>{{Carbon::parse($event->event_start)->format('g:i A')}} - {{Carbon::parse($event->event_end)->format('g:i A')}}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($sponsors && $sponsors->count() > 0)
<section class="section courses" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Events Sponsors</h6>
                    <h2>Sponsors</h2>
                </div>
            </div>
        </div>
        <div class="row event_box" style="position: relative; height: 880.844px;">
            @foreach($sponsors as $index => $sponsor)
            <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6" style="position: absolute; left: 0px; top: 0px;">
                <div class="events_item">
                    <div class="thumb">
                        <a href="#"><img src="{{"{$sponsor->directory}/{$sponsor->filename}"}}" alt=""></a>
                        <span class="category">{{$sponsor->name}}</span>
                    </div>
                    <div class="down-content">
                        <h4></h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($contact && $contact->count() > 0)
<div class="contact-us section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  align-self-center">
                <div class="section-heading">
                    <h6>{{$contact->type}}</h6>
                    <h2>{{$contact->title}}</h2>
                    <div>{!!$contact->content!!}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-us-content">
                    <form id="contact-form" action="" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                            <fieldset>
                                <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required="">
                            </fieldset>
                            </div>
                            <div class="col-lg-12">
                            <fieldset>
                                <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                            </fieldset>
                            </div>
                            <div class="col-lg-12">
                            <fieldset>
                                <textarea name="message" id="message" placeholder="Your Message"></textarea>
                            </fieldset>
                            </div>
                            <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" id="form-submit" class="orange-button">Send Message Now</button>
                            </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop