@extends('layouts.app')
@section('title', 'Courses')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Our <span>Courses</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Professional IT courses designed to give you real-world skills and industry-recognized certifications.</p>
    </div>

    {{-- Category Filter --}}
    <div class="flex flex-wrap gap-2 justify-center mb-10">
        <button onclick="filterCat('all')" class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold border border-navy-200 bg-navy-900 text-white transition-all" data-cat="all">
            All Courses
        </button>
        @foreach($categories as $cat)
        <button onclick="filterCat('{{ Str::slug($cat->name) }}')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold border border-navy-200 text-navy-700 hover:bg-navy-900 hover:text-white transition-all" data-cat="{{ Str::slug($cat->name) }}">
            {{ $cat->name }}
        </button>
        @endforeach
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="courses-grid">
        @foreach($courses as $course)
        <a href="{{ route('courses.show', $course) }}"
            class="card-hover bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal"
            data-cat="{{ $course->category ? Str::slug($course->category->name) : 'other' }}">
          <div class="bg-gradient-to-br from-navy-800 to-navy-950 h-40 flex items-center justify-center relative overflow-hidden">
    @php $img = $course->thumbnail ?? $course->image ?? null; @endphp
    @if($img)
    <img src="{{ asset('storage/' . $img) }}"
         alt="{{ $course->title }}"
         class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500"
         onerror="this.style.display='none'">
    <div class="absolute inset-0 bg-navy-950/40"></div>
    @endif
    <i class="fa-solid fa-book-open text-gold-400 text-5xl relative z-10 {{ $img ? 'opacity-0' : '' }}"></i>
    @if($course->is_featured)
    <span class="absolute top-3 right-3 bg-gold-500 text-navy-900 text-xs font-bold px-2.5 py-1 rounded-full z-10">Featured</span>
    @endif
</div>
            <div class="p-5">
                @if($course->category)
                <span class="text-xs text-navy-500 font-semibold uppercase tracking-wide">{{ $course->category->name }}</span>
                @endif
                <h3 class="font-bold text-navy-900 text-base mt-1 mb-2">{{ $course->title }}</h3>
                <p class="text-slate-500 text-sm line-clamp-2 leading-relaxed">{{ $course->description }}</p>
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-3 text-xs text-slate-400">
                        @if($course->duration)<span><i class="fa-regular fa-clock mr-1"></i>{{ $course->duration }}</span>@endif
                        @if($course->level)
                        <span class="bg-slate-100 px-2 py-0.5 rounded-full">{{ $course->level }}</span>
                        @endif
                    </div>
                    @if($course->fee)
                    <span class="font-extrabold text-navy-900">Rs. {{ number_format($course->fee) }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<script>
function filterCat(cat) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.toggle('bg-navy-900', btn.dataset.cat === cat);
        btn.classList.toggle('text-white', btn.dataset.cat === cat);
        btn.classList.toggle('text-navy-700', btn.dataset.cat !== cat);
    });
    document.querySelectorAll('#courses-grid [data-cat]').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
    });
}
</script>
@endsection