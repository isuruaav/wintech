@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="section-title mb-3">Contact <span>Us</span></h1>
        <p class="text-slate-500 max-w-xl mx-auto">Get in touch with us for course inquiries, enrollment, or any questions.</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-10">
        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-5 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Your Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input @error('name') border-red-400 @enderror" placeholder="John Silva" required>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy-900 mb-1.5">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="07X XXX XXXX">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="you@email.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="form-input" placeholder="Course inquiry...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy-900 mb-1.5">Message *</label>
                    <textarea name="message" rows="5" class="form-input resize-none @error('message') border-red-400 @enderror" placeholder="Write your message..." required>{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full justify-center py-3">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

        {{-- Info --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-navy-900 mb-4">Get In Touch</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-navy-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">Address</p>
                            <p class="text-slate-500 text-sm">Kiralabokkagama, Moragollagama</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-navy-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">Phone</p>
                            <a href="tel:+94784161920" class="text-navy-700 hover:text-gold-500 text-sm">+94 78 416 1920</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-navy-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-envelope text-navy-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-navy-900 text-sm">Email</p>
                            <a href="mailto:info@wintech.lk" class="text-navy-700 hover:text-gold-500 text-sm">info@wintech.lk</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-navy-800 to-navy-950 rounded-2xl p-6 text-white">
                <h3 class="font-bold mb-2">Quick Enrolment</h3>
                <p class="text-white/60 text-sm mb-4">Chat with us directly on WhatsApp for fast enrolment.</p>
                <a href="https://wa.me/94784161920" target="_blank" class="btn-gold w-full justify-center">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Chat on WhatsApp
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-navy-900 mb-3">Office Hours</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Monday – Friday</span><span class="font-semibold text-navy-900">8:00 AM – 6:00 PM</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Saturday</span><span class="font-semibold text-navy-900">8:00 AM – 4:00 PM</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Sunday</span><span class="font-semibold text-navy-900">9:00 AM – 2:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection