@extends('layouts.app')
@section('title', 'Downloads')

@section('content')

<section class="relative bg-gradient-to-br from-navy-950 to-navy-800 pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block bg-gold-500/20 text-gold-400 text-xs font-bold px-4 py-2 rounded-full border border-gold-500/20 mb-6">
            <i class="fa-solid fa-download mr-1"></i> Downloads
        </span>
        <h1 class="text-4xl font-extrabold text-white mb-3">Study <span class="text-gold-400">Materials</span></h1>
        <p class="text-white/50">Download notes, papers and resources for your studies.</p>
    </div>
</section>

<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Category Filter --}}
        @if($categories->count())
        <div class="flex flex-wrap gap-2 mb-8">
            <button onclick="filterCat('all')" class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold border bg-navy-900 text-white border-navy-900" data-cat="all">
                All
            </button>
            @foreach($categories as $cat)
            <button onclick="filterCat('{{ $cat }}')" class="filter-btn px-4 py-2 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 hover:bg-navy-900 hover:text-white transition-all" data-cat="{{ $cat }}">
                {{ $cat }}
            </button>
            @endforeach
        </div>
        @endif

        {{-- Downloads Grid --}}
        @if($downloads->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" id="downloads-grid">
            @foreach($downloads as $dl)
            @php
            $ext = pathinfo($dl->file ?? '', PATHINFO_EXTENSION);
            $iconMap = ['pdf'=>['fa-file-pdf','text-red-500','bg-red-50'],'doc'=>['fa-file-word','text-blue-500','bg-blue-50'],'docx'=>['fa-file-word','text-blue-500','bg-blue-50'],'zip'=>['fa-file-zipper','text-amber-500','bg-amber-50'],'rar'=>['fa-file-zipper','text-amber-500','bg-amber-50'],'ppt'=>['fa-file-powerpoint','text-orange-500','bg-orange-50'],'pptx'=>['fa-file-powerpoint','text-orange-500','bg-orange-50'],'xls'=>['fa-file-excel','text-green-500','bg-green-50'],'xlsx'=>['fa-file-excel','text-green-500','bg-green-50']];
            [$icon, $color, $bg] = $iconMap[strtolower($ext)] ?? ['fa-file','text-slate-500','bg-slate-50'];
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 hover:shadow-md transition-shadow"
                 data-cat="{{ $dl->category }}">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 {{ $bg }} rounded-xl flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $icon }} {{ $color }} text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-navy-900 text-sm mb-1 leading-tight">{{ $dl->title }}</h3>
                        @if($dl->description)
                        <p class="text-slate-400 text-xs leading-relaxed line-clamp-2 mb-2">{{ $dl->description }}</p>
                        @endif
                        @if($dl->category)
                        <span class="inline-block text-xs bg-navy-50 text-navy-600 px-2 py-0.5 rounded-full font-medium">
                            {{ $dl->category }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ $dl->file_url }}"
                       target="_blank"
                       download
                       class="flex items-center justify-center gap-2 bg-navy-900 hover:bg-navy-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors w-full">
                        <i class="fa-solid fa-download text-gold-400"></i>
                        Download {{ strtoupper($ext) }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-download text-3xl text-slate-300"></i>
            </div>
            <h3 class="font-bold text-navy-900 text-lg mb-2">No Downloads Yet</h3>
            <p class="text-slate-400 text-sm">Check back soon for study materials.</p>
        </div>
        @endif
    </div>
</section>

<script>
function filterCat(cat) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const active = btn.dataset.cat === cat;
        btn.classList.toggle('bg-navy-900', active);
        btn.classList.toggle('text-white', active);
        btn.classList.toggle('border-navy-900', active);
        btn.classList.toggle('text-slate-600', !active);
        btn.classList.toggle('border-slate-200', !active);
    });
    document.querySelectorAll('#downloads-grid [data-cat]').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
    });
}
</script>

@endsection