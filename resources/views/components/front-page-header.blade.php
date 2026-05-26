@props([
    'title',
    'breadcrumb' => null,
    'breadcrumbs' => null,
    'wrapperClass' => 'mb-5',
])

@php
    $images = \App\Models\HeroSlide::bannerImageUrls();
    $carouselId = 'pageHeaderBanner-' . substr(md5($title), 0, 8);

    if ($breadcrumbs === null) {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => $breadcrumb ?? $title, 'active' => true],
        ];
    }
@endphp

<div class="front-page-header container-fluid p-0 {{ $wrapperClass }}">
    @if($images->count() > 1)
        <div
            id="{{ $carouselId }}"
            class="carousel slide carousel-fade front-page-header__carousel"
            data-bs-ride="carousel"
            data-bs-interval="5000"
            data-bs-pause="false"
        >
            <div class="carousel-inner">
                @foreach($images as $imageUrl)
                    <div @class(['carousel-item', 'active' => $loop->first])>
                        <div class="front-page-header__slide" style="background-image: url('{{ $imageUrl }}');" role="img" aria-label=""></div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="front-page-header__slide front-page-header__slide--single" style="background-image: url('{{ $images->first() }}');" role="img" aria-label=""></div>
    @endif

    <div class="container-fluid page-header-inner py-5">
        <div class="container text-center pb-5">
            <h1 class="display-3 text-white mb-3">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center text-uppercase">
                    @foreach($breadcrumbs as $crumb)
                        @if(! empty($crumb['active']))
                            <li class="breadcrumb-item text-white active" aria-current="page">{{ $crumb['label'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $crumb['url'] ?? '#' }}">{{ $crumb['label'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
