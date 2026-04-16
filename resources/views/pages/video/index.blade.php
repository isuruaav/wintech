@extends('layouts.app')
@section('title', 'Video Library')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Video <span>Library</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Watch our educational videos and recorded class sessions.</p>
    </div>

    @if($categories->count())
    <div class="flex flex-wrap gap-2 justify-center mb-8">
        <button onclick="filterVid('all')" class="vid-btn active px-4 py-2 rounded-full text-sm font-semibold border border-navy-200 bg-navy-900 text-white" data-cat="all">All</button>
        @foreach($categories as $cat)
        <button onclick="filterVid('{{ Str::slug($cat) }}')" class="vid-btn px-4 py-2 rounded-full text-sm font-semibold border border-navy-200 text-navy-700 hover:bg-navy-900 hover:text-white transition-all" data-cat="{{ Str::slug($cat) }}">{{ $cat }}</button>
        @endforeach
    </div>
    @endif

    @if($videos->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-slate-100">
        <i class="fa-brands fa-youtube text-5xl text-slate-200 mb-4"></i>
        <p class="text-slate-400">No videos yet.</p>
    </div>
    @else
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="videos-grid">
        @foreach($videos as $video)
        <div class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal"
            data-cat="{{ Str::slug($video->category ?? 'other') }}">
            <div class="relative aspect-video bg-navy-900">
                @if($video->source === 'youtube')
                <iframe src="{{ $video->embed_url }}" class="w-full h-full" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen loading="lazy"></iframe>
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fa-solid fa-circle-play text-white/40 text-5xl"></i>
                </div>
                @endif
            </div>
            <div class="p-4">
                @if($video->category)<span class="text-xs text-navy-500 font-semibold uppercase">{{ $video->category }}</span>@endif
                <h3 class="font-bold text-navy-900 mt-1">{{ $video->title }}</h3>
                @if($video->description)<p class="text-slate-500 text-xs mt-1 line-clamp-2">{{ $video->description }}</p>@endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
function filterVid(cat) {
    document.querySelectorAll('.vid-btn').forEach(btn => {
        btn.classList.toggle('bg-navy-900', btn.dataset.cat === cat);
        btn.classList.toggle('text-white', btn.dataset.cat === cat);
        btn.classList.toggle('text-navy-700', btn.dataset.cat !== cat);
    });
    document.querySelectorAll('#videos-grid [data-cat]').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
    });
}
</script>
@endsection