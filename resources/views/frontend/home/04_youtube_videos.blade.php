@if ($youtube_videos->isNotEmpty())
    <section class="services-two">
        <div class="container">

            <div class="section-title section-title--two text-center">
                <span class="section-title__tagline">VIDEO GALLERY</span>
                <h2 class="section-title__title">Our YouTube Videos</h2>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 row-cols-xl-4 g-4">
                @foreach ($youtube_videos as $item)
                    @php
                        // YouTube URL থেকে embed ID বের করো
                        $url = $item->youtube_url;
                        $video_id = '';
                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
                            $video_id = $matches[1];
                        }
                    @endphp
                    @if ($video_id)
                        <div class="col">
                            <div class="yt-video-card">
                                <div class="yt-video-thumb">
                                    <iframe src="https://www.youtube.com/embed/{{ $video_id }}" title="{{ $item->title ?? 'YouTube Video' }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>
                                </div>
                                @if (!empty($item->title))
                                    <p class="yt-video-title">{{ $item->title }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>

    <style>
        .yt-video-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .yt-video-thumb {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .yt-video-thumb iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .yt-video-title {
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
    </style>
@endif
