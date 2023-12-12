@extends('layouts.landing.v2.master')

@section('title', $title)

@section('_styles')


<style>
    body {
        font-family: "Open Sans", sans-serif;
        background: #f6f9ff !important;
        color: #444444;
    }

    .header_wrap {
        background: #fff !important;
    }
</style>

<style>
    .blog-box {
        background-color: #f9f9f9 !important;
        min-height: 60px !important;
        max-width: 170px !important;
        padding: 30px 10px !important;
        line-height: 15px !important;
        -webkit-box-shadow: 0px 3px 7px 0px rgba(28, 31, 33, 0.15) !important;
        -moz-box-shadow: 0px 3px 7px 0px rgba(28, 31, 33, 0.15) !important;
        box-shadow: 0px 3px 7px 0px rgba(28, 31, 33, 0.15) !important;
        margin: 10px !important;
    }

    .alink {
        font-weight: 600;
        color: #29b477;
        text-decoration: none;
        letter-spacing: 1px;
        position: relative;
    }


    .greenext {
        color: #29b477;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .badge-sm {
        margin: 0;
        font-size: 10px !important;
        line-height: 1 !important;
    }

    .carousel-item {
        height: 500px !important;
    }

    .carousel-item-other {
        height: 350px !important;
    }


    .iniaja img {
        width: 100%;
        height: 100% !important;
        object-fit: cover;
    }

    .heading_s1,
    .heading_s2 {
        margin-bottom: 15px !important;
        padding-bottom: 10px !important;
        position: relative;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    section {
        padding: 30px 0;
    }
</style>
@endsection

@section('content')

{{--
<hr class="pt-0 mt-0" style="border-bottom:1px solid rgba(0,0,0,0.2)"> --}}


<!-- START SECTION BANNER -->
<section class="banner_section p-0 pb-2 mb-2">
    <div id="carouselExampleControls" class="banner_content_wrap carousel slide slide_height_700" data-ride="carousel">
        <div class="carousel-inner">

            @foreach($carousels as $key => $carousel)

            <div class="carousel-item image-wrapper @if($key == 0) active @endif background_bg overlay_bg2"
                data-img-src="{{$carousel->smaller_image}}">
                <div class="banner_slide_content">
                    <div class="container ">

                    </div>
                </div>
                <img class="top-text logo_default animation animated fadeInDown" data-animation="fadeInDown"
                    data-animation-delay="1s" style="animation-delay: 1s; opacity: 1; right:0;"
                    src="{{ asset('assets/images/logo/logo_car_white.png') }}" width="230" alt="logo" />
            </div>



            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"><i
                class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"><i
                class="ion-chevron-right"></i></a>
    </div>
</section>

<!-- START SECTION ABOUT US -->
<section class="overflow_hide p-0 m-0">

    <style>
        .l-hub-wrapper {
            /* background-color: #fff; */
            margin: 0 auto;
            max-width: 1200px;
        }

        .c-hub-title {
            overflow: visible;
        }

        .c-hub-title {
            overflow: hidden;
            position: relative;
            text-align: center;
        }

        .c-hub-title.no-description .c-hub-title__inner {
            padding: 16px;
        }

        .c-hub-title__inner {
            width: auto;
        }

        .c-hub-title__inner {
            background-color: #f6f9ff;
            color: currentColor;
            display: inline-block;
            padding: 32px 26px 16px;
            position: relative;
        }

        .c-hub-title h2 {
            /* font-family: "Fugaz One"; */
            color: var(#687385);
            font-weight: bolder;
            /* letter-spacing: .02em; */
            line-height: 1.2;
            font-size: 2.2em;
            display: inline-block;
            margin: 0;
            vertical-align: middle;
            /* font-style: italic; */

        }

        .c-hub-title.no-description:before {
            border-left: 5px solid #2C65E1;
            border-right: 5px solid #2C65E1;
            border-top: 4px solid #2C65E1;
            border-radius: 10px 10px 0px 0px;
            content: " ";
            height: 50px;
            left: -1px;
            position: absolute;
            right: -1px;
            top: 50%;
            pointer-events: none;
        }
    </style>
    <div class="l-hub-wrapper l-wrapper d-sm-none d-md-block animation" data-animation="fadeInDown"
        data-animation-delay="0.2s">
        <div class="c-hub-title no-description">
            <span class="c-hub-title__inner">
                <h2 class="">Berita Pilihan</h2>
            </span>
        </div>
    </div>

    <style>
        .entry-meta {
            line-height: 1;
            color: #666;
        }

        .font-small {
            font-size: 12px;
        }

        .image-wrapper {
            position: relative;
            margin-bottom: 5px;
        }

        .image-wrapper .bottom-text,
        .image-wrapper .bottom-right-text,
        .image-wrapper .top-text {
            position: absolute;
            display: inline-block;
            padding: 5px 5px;
            /* background: #eee; */
            color: #000;
            z-index: 2;
        }

        .image-wrapper .top-text {
            top: 30px;
            right: 30px !important;
        }

        .image-wrapper .bottom-right-text {
            bottom: 10px;
            right: 10px;
        }

        .image-wrapper .bottom-text {
            background: transparent;
            bottom: 10px;
            left: 10px;
        }

        .border-dashed {
            border-bottom: 1.7px dashed #cfd8e0 !important;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .border-right-dashed {
            border-right: 1.25px dashed #cfd8e0 !important;
        }

        .mb-30 {
            margin-bottom: 30px !important;
        }

        .mt-30 {
            margin-top: 30px !important;
        }
    </style>
    <div class="container animation" data-animation="fadeInDown" data-animation-delay="0.2s">
        <article>
            <div class="row list-style-2">
                <div class="col-md-3">
                    {{-- #1 --}}

                    <div>
                        <div class="post_footer">
                            <div class='image-wrapper'>
                                <img src="{{ $featureds[0]->cover_small }}" class="img-fluid rounded" alt="#">
                                <div class="bottom-text entry-meta meta-0 p-0 bottom-right-text">
                                    @if($featureds[0]->category->slug == 'daerah')
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[0]->category->slug}}&id_kabkota={{$featureds[0]->id_kabkota}}">
                                        <span class="badge badge-primary">{{
                                            ucwords(strtolower($featureds[0]->kabkota->name)) }}</span>
                                    </a>
                                    @else
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[0]->category->slug}}">
                                        <span class="badge badge-primary">{{Str::ucfirst($featureds[0]->category->slug)
                                            }}</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="post_content">

                                <h6 class="post-title font-weight-bold text-limit-3-row ">
                                    <a href="{{config('isec.base_url')}}/post/{{$featureds[0]->slug}}">
                                        {{ \Illuminate\Support\Str::limit($featureds[0]->title,93, $end='...') }}
                                    </a>
                                </h6>

                                <p class="font-small small m-0">{{$featureds[0]->tanggal}} | {{ $featureds[0]->reads }}
                                    reads
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- #1 --}}
                    <div class="border-dashed pt-20"></div>
                    {{-- #2 --}}
                    <div>
                        <div class="post_footer">
                            <div class='image-wrapper'>
                                <img src="{{ $featureds[1]->cover_small }}" class="img-fluid rounded" alt="#">
                                <div class="bottom-text entry-meta meta-0 p-0 bottom-right-text">
                                    @if($featureds[1]->category->slug == 'daerah')
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[1]->category->slug}}&id_kabkota={{$featureds[1]->id_kabkota}}">
                                        <span class="badge badge-primary">{{
                                            ucwords(strtolower($featureds[1]->kabkota->name)) }}</span>
                                    </a>
                                    @else
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[1]->category->slug}}">
                                        <span class="badge badge-primary">{{Str::ucfirst($featureds[1]->category->slug)
                                            }}</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="post_content">

                                <h6 class="post-title font-weight-bold text-limit-3-row ">
                                    <a href="{{config('isec.base_url')}}/post/{{$featureds[1]->slug}}">
                                        {{ \Illuminate\Support\Str::limit($featureds[1]->title,93, $end='...') }}
                                    </a>
                                </h6>

                                <p class="font-small small m-0">{{$featureds[1]->tanggal}} | {{ $featureds[1]->reads }}
                                    reads
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- #2 --}}
                </div>
                <div class="col-md-6">
                    {{-- #3 --}}
                    <div>
                        <div class="post_footer">
                            <div class='image-wrapper'>
                                <img src="{{ $featureds[2]->cover_small }}" class="img-fluid rounded" alt="#">
                                <div class="bottom-text entry-meta meta-0 p-0 bottom-right-text">
                                    @if($featureds[2]->category->slug == 'daerah')
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[2]->category->slug}}&id_kabkota={{$featureds[2]->id_kabkota}}">
                                        <span class="badge badge-primary">{{
                                            ucwords(strtolower($featureds[2]->kabkota->name)) }}</span>
                                    </a>
                                    @else
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[2]->category->slug}}">
                                        <span class="badge badge-primary">{{Str::ucfirst($featureds[2]->category->slug)
                                            }}</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="post_content">

                                <h5 class="post-title font-weight-bold text-limit-3-row ">
                                    <a href="{{config('isec.base_url')}}/post/{{$featureds[2]->slug}}">
                                        {{ \Illuminate\Support\Str::limit($featureds[2]->title,93, $end='...') }}
                                    </a>
                                </h5>

                                <p class="font-small small m-0">{{$featureds[2]->tanggal}} | {{ $featureds[2]->reads }}
                                    reads</p>

                                <div class="mb-0 pb-0" style="font-size: smaller">
                                    <pre class="mb-0 pb-0" style="white-space: pre-wrap;">
                                {!!
                                    \Illuminate\Support\Str::limit($featureds[2]->desc,255, $end='...') !!}
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- #3 --}}
                </div>
                <div class="col-md-3">
                    {{-- #4 --}}
                    <div>
                        <div class="post_footer">
                            <div class='image-wrapper'>
                                <img src="{{ $featureds[3]->cover_small }}" class="img-fluid rounded" alt="#">
                                <div class="bottom-text entry-meta meta-0 p-0 bottom-right-text">
                                    @if($featureds[3]->category->slug == 'daerah')
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[3]->category->slug}}&id_kabkota={{$featureds[3]->id_kabkota}}">
                                        <span class="badge badge-primary">{{
                                            ucwords(strtolower($featureds[3]->kabkota->name)) }}</span>
                                    </a>
                                    @else
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[3]->category->slug}}">
                                        <span class="badge badge-primary">{{Str::ucfirst($featureds[3]->category->slug)
                                            }}</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="post_content">

                                <h6 class="post-title font-weight-bold text-limit-3-row ">
                                    <a href="{{config('isec.base_url')}}/post/{{$featureds[3]->slug}}">
                                        {{ \Illuminate\Support\Str::limit($featureds[3]->title,93, $end='...') }}
                                    </a>
                                </h6>

                                <p class="font-small small m-0">{{$featureds[3]->tanggal}} | {{ $featureds[3]->reads }}
                                    reads
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- #4 --}}
                    <div class="border-dashed pt-20"></div>
                    {{-- #5 --}}
                    <div>
                        <div class="post_footer">
                            <div class='image-wrapper'>
                                <img src="{{ $featureds[4]->cover_small }}" class="img-fluid rounded" alt="#">
                                <div class="bottom-text entry-meta meta-0 p-0 bottom-right-text">
                                    @if($featureds[4]->category->slug == 'daerah')
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[4]->category->slug}}&id_kabkota={{$featureds[4]->id_kabkota}}">
                                        <span class="badge badge-primary">{{
                                            ucwords(strtolower($featureds[4]->kabkota->name)) }}</span>
                                    </a>
                                    @else
                                    <a
                                        href="{{config('isec.base_url')}}/blog?category={{$featureds[4]->category->slug}}">
                                        <span class="badge badge-primary">{{Str::ucfirst($featureds[4]->category->slug)
                                            }}</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="post_content">

                                <h6 class="post-title font-weight-bold text-limit-3-row ">
                                    <a href="{{config('isec.base_url')}}/post/{{$featureds[4]->slug}}">
                                        {{ \Illuminate\Support\Str::limit($featureds[4]->title,93, $end='...') }}
                                    </a>
                                </h6>

                                <p class="font-small small m-0">{{$featureds[4]->tanggal}} | {{ $featureds[4]->reads }}
                                    reads
                                </p>
                            </div>
                        </div>
                    </div>
                    {{-- #5 --}}
                </div>
            </div>
        </article>
        <div class="border-dashed"></div>
        <div class="row mt-30">
            <div class="mb-30 col-md-4 border-right-dashed">
                <div class="post_footer">
                    <div class="post_img">
                        <a href="{{config('isec.base_url')}}/post/{{$featureds[5]->slug}}">
                            @if($featureds[5]->cover)
                            <img src="{{$featureds[5]->square_cover_image}}" alt="letest_post1" width="90"
                                style="border-radius: 5px;">
                            @endif
                        </a>
                    </div>
                    <div class="post_content" style="line-height: 1 !important">
                        @if($featureds[5]->category->slug == 'daerah')
                        <a
                            href="{{config('isec.base_url')}}/blog?category={{$featureds[5]->category->slug}}&id_kabkota={{$featureds[5]->id_kabkota}}">
                            <span class="badge badge-primary">{{
                                ucwords(strtolower($featureds[5]->kabkota->name)) }}</span>
                        </a>
                        @else
                        <a href="{{config('isec.base_url')}}/blog?category={{$featureds[5]->category->slug}}">
                            <span class="badge badge-primary">{{Str::ucfirst($featureds[5]->category->slug)
                                }}</span>
                        </a>
                        @endif
                        <h6><a href="{{config('isec.base_url')}}/post/{{$featureds[5]->slug}}">{{\Illuminate\Support\Str::limit($featureds[5]->title,
                                83, $end='...')}}</a>
                        </h6>
                        <p class="small m-0">{{ $featureds[5]->tanggal }} | {{ $featureds[5]->reads }} reads
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-30 col-md-4 border-right-dashed">
                <div class="post_footer">
                    <div class="post_img">
                        <a href="{{config('isec.base_url')}}/post/{{$featureds[6]->slug}}">
                            @if($featureds[6]->cover)
                            <img src="{{$featureds[6]->square_cover_image}}" alt="letest_post1" width="90"
                                style="border-radius: 5px;">
                            @endif
                        </a>
                    </div>
                    <div class="post_content" style="line-height: 1 !important">
                        @if($featureds[6]->category->slug == 'daerah')
                        <a
                            href="{{config('isec.base_url')}}/blog?category={{$featureds[6]->category->slug}}&id_kabkota={{$featureds[6]->id_kabkota}}">
                            <span class="badge badge-primary">{{
                                ucwords(strtolower($featureds[6]->kabkota->name)) }}</span>
                        </a>
                        @else
                        <a href="{{config('isec.base_url')}}/blog?category={{$featureds[6]->category->slug}}">
                            <span class="badge badge-primary">{{Str::ucfirst($featureds[6]->category->slug)
                                }}</span>
                        </a>
                        @endif
                        <h6><a href="{{config('isec.base_url')}}/post/{{$featureds[6]->slug}}">{{\Illuminate\Support\Str::limit($featureds[6]->title,
                                83, $end='...')}}</a>
                        </h6>
                        <p class="small m-0">{{ $featureds[6]->tanggal }} | {{ $featureds[6]->reads }} reads
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-30 col-md-4">
                <div class="post_footer">
                    <div class="post_img">
                        <a href="{{config('isec.base_url')}}/post/{{$featureds[7]->slug}}">
                            @if($featureds[7]->cover)
                            <img src="{{$featureds[7]->square_cover_image}}" alt="letest_post1" width="90"
                                style="border-radius: 5px;">
                            @endif
                        </a>
                    </div>
                    <div class="post_content" style="line-height: 1 !important">
                        @if($featureds[7]->category->slug == 'daerah')
                        <a
                            href="{{config('isec.base_url')}}/blog?category={{$featureds[7]->category->slug}}&id_kabkota={{$featureds[7]->id_kabkota}}">
                            <span class="badge badge-primary">{{
                                ucwords(strtolower($featureds[7]->kabkota->name)) }}</span>
                        </a>
                        @else
                        <a href="{{config('isec.base_url')}}/blog?category={{$featureds[7]->category->slug}}">
                            <span class="badge badge-primary">{{Str::ucfirst($featureds[7]->category->slug)
                                }}</span>
                        </a>
                        @endif
                        <h6><a href="{{config('isec.base_url')}}/post/{{$featureds[7]->slug}}">{{\Illuminate\Support\Str::limit($featureds[7]->title,
                                83, $end='...')}}</a>
                        </h6>
                        <p class="small m-0">{{ $featureds[7]->tanggal }} | {{ $featureds[7]->reads }} reads
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="overflow_hide p-0 m-0 pt-5 pb-5 bg-white">
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-6 col-sm-12 animation" data-animation="fadeInLeft" data-animation-delay="0.1s">
                <div class="mb-4 mb-lg-0 ">
                    <img src="{{$services[0]->square_cover_image}}" alt="about_img" />
                </div>
            </div> --}}
            <div class="col-lg-6 col-sm-12 animation align-items-center" data-animation="fadeInLeft"
                data-animation-delay="0.2s">
                <div class="bd-example">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($recent_posts as $key => $act)
                            <li data-target="#carouselExampleCaptions" data-slide-to="{{$key}}"
                                class="@if($key == 1) active @endif"></li>
                            @endforeach

                        </ol>
                        <div class="carousel-inner">
                            @foreach($recent_posts as $key => $act)

                            <div class="carousel-item carousel-item-other iniaja @if($key == 0) active @endif">
                                <img src="{{$act->cover}}" class="d-block w-100" alt="...">
                                <div class="carousel-caption">
                                    {{-- <div class="carousel-caption d-none d-md-block"> --}}

                                        <small style="color:#ffffff;">{{
                                            \Carbon\Carbon::parse($act->created_at)->format('d
                                            F Y')
                                            }}</small><br>
                                        <a style="color:#ffffff;"
                                            href="{{config('isec.base_url')}}/post/{{$act->slug}}">{{\Illuminate\Support\Str::limit($act->title,
                                            100,
                                            $end='...')}}&nbsp;</a>

                                    </div>
                                </div>
                                @endforeach


                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>


                </div>
                <div class="col-lg-6 mt-lg-0 mt-4 pt-3 pt-lg-0 animation" data-animation="fadeInRight"
                    data-animation-delay="0.2s">
                    <div class="sidebar">

                        <div class="widget">
                            <h5 class="heading_s2">Berita Terkini</h5>
                            <ul class="recent_post border_bottom_dash list_none">

                                @foreach($recent_posts as $key => $post)
                                <li>
                                    <div class="post_footer">
                                        <div class="post_img">
                                            <a href="{{config('isec.base_url')}}/post/{{$post->slug}}">
                                                @if($post->cover)
                                                <img src="{{$post->square_cover_image}}" alt="letest_post1" width="77"
                                                    style="border-radius: 5px;">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="post_content" style="line-height: 1 !important">
                                            @if($post->category->slug == 'daerah')
                                            <a
                                                href="{{config('isec.base_url')}}/blog?category={{$post->category->slug}}&id_kabkota={{$post->id_kabkota}}">
                                                <span class="badge badge-primary">{{
                                                    ucwords(strtolower($post->kabkota->name)) }}</span>
                                            </a>
                                            @else
                                            <a
                                                href="{{config('isec.base_url')}}/blog?category={{$post->category->slug}}">
                                                <span class="badge badge-primary">{{Str::ucfirst($post->category->slug)
                                                    }}</span>
                                            </a>
                                            @endif
                                            <h6><a href="{{config('isec.base_url')}}/post/{{$post->slug}}">{{\Illuminate\Support\Str::limit($post->title,
                                                    70, $end='...')}}</a>
                                            </h6>
                                            <p class="small m-0">{{ $post->tanggal }} | {{ $post->reads }} reads
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION ABOUT US -->






<!-- START SECTION BLOG -->
<section>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12 animation" data-animation="fadeInUp" data-animation-delay="0.2s">
                <div class="heading_s1 mb-md-3 text-center">
                    <h2><a href="{{ route('blog.list', 'category=utama') }}">Berita Utama Kanwil</a></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="clearfix small_divider"></div>
            </div>
        </div>
        <div class="row blog_wrap justify-content-center animation" data-animation="fadeInUp"
            data-animation-delay="0.4s">
            @foreach($main_posts as $key => $post)
            <div class="col-lg-4 col-md-6 mb-md-4 mb-2 pb-2">
                <div class="blog_post blog_style1">
                    <div class="blog_img">
                        <a href="#">
                            <img src="{{$post->cover_small}}" alt="blog_small_img1">
                        </a>
                        <span class="post_date bg_blue text-light"> {{ Str::ucfirst($post->category->slug) }}</span>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a
                                    href="{{config('isec.base_url')}}/post/{{$post->slug}}">{{$post->title}}</a>
                            </h6>
                            <ul class="list_none blog_meta">
                                <li><a href="#">{{$post->tanggal}}</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END SECTION BLOG -->

<!-- START SECTION BLOG -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 animation" data-animation="fadeInUp" data-animation-delay="0.2s">
                <div class="heading_s1 mb-md-3 text-center">
                    <h2><a href="{{ route('blog.list', 'category=daerah') }}">Berita Daerah</a></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="clearfix small_divider"></div>
            </div>
        </div>
        <div class="row blog_wrap justify-content-center animation" data-animation="fadeInUp"
            data-animation-delay="0.4s">
            @foreach($daerah_posts as $key => $post)
            <div class="col-lg-4 col-md-6 mb-md-4 mb-2 pb-2">
                <div class="blog_post blog_style1">
                    <div class="blog_img">
                        <a href="#">
                            <img src="{{$post->cover_small}}" alt="blog_small_img1">
                        </a>
                        <span class="post_date bg_blue text-light"> {{ ucwords(strtolower($post->kabkota->name))
                            }}</span>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a
                                    href="{{config('isec.base_url')}}/post/{{$post->slug}}">{{$post->title}}</a>
                            </h6>
                            <ul class="list_none blog_meta">
                                <li><a href="#">{{$post->tanggal}}</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- END SECTION BLOG -->

@endsection


@section('_scripts')
{{-- No Data --}}
@endsection