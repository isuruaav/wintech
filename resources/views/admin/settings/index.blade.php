@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Site Settings</h1>
        <p class="text-gray-500 text-sm mt-1">Manage owner profile and general site information.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Owner Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-blue-600"></i>
                    Owner Profile
                </h2>
            </div>
            <div class="p-6 space-y-6">

                {{-- Photo Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Owner Photo</label>
                    <div class="flex items-center gap-6">
                        {{-- Current photo preview --}}
                        <div class="shrink-0">
                            @php $photo = $owner['owner_photo']->value ?? ''; @endphp
                            @if($photo)
                                <img id="photo-preview"
                                     src="{{ Storage::url($photo) }}"
                                     alt="Owner Photo"
                                     class="w-24 h-24 rounded-2xl object-cover border-2 border-gray-200">
                            @else
                                <div id="photo-preview-placeholder"
                                     class="w-24 h-24 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-gray-400 text-3xl"></i>
                                </div>
                                <img id="photo-preview" src="" alt="" class="w-24 h-24 rounded-2xl object-cover border-2 border-gray-200 hidden">
                            @endif
                        </div>

                        {{-- Upload button --}}
                        <div class="flex-1">
                            <label class="cursor-pointer inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors">
                                <i class="fa-solid fa-upload"></i>
                                Choose Photo
                                <input type="file" name="owner_photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                            </label>
                            <p class="text-xs text-gray-400 mt-2">JPG, PNG, WEBP — max 2MB. Recommended: square image 400×400px</p>
                            @error('owner_photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name"
                               value="{{ old('owner_name', $owner['owner_name']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="e.g. Chathuranga Dissanayaka">
                        @error('owner_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title / Position <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_title"
                               value="{{ old('owner_title', $owner['owner_title']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="e.g. Founder & Director">
                        @error('owner_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Qualification --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Education / Qualifications</label>
                        <input type="text" name="owner_qualification"
                               value="{{ old('owner_qualification', $owner['owner_qualification']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="e.g. B.Sc in IT, Diploma in Education">
                        @error('owner_qualification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="owner_phone"
                               value="{{ old('owner_phone', $owner['owner_phone']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="+94 78 416 1920">
                        @error('owner_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number <span class="text-gray-400 text-xs">(without +)</span></label>
                        <input type="text" name="owner_whatsapp"
                               value="{{ old('owner_whatsapp', $owner['owner_whatsapp']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="94784161920">
                        @error('owner_whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" name="owner_address"
                               value="{{ old('owner_address', $owner['owner_address']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                               placeholder="Kiralabokkagama, Moragollagama">
                        @error('owner_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- General Settings Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-gear text-blue-600"></i>
                    General Settings
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name <span class="text-red-500">*</span></label>
                        <input type="text" name="site_name"
                               value="{{ old('site_name', $general['site_name']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        @error('site_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                        <input type="text" name="site_tagline"
                               value="{{ old('site_tagline', $general['site_tagline']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                        <input type="email" name="site_email"
                               value="{{ old('site_email', $general['site_email']->value ?? '') }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end pb-8">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-floppy-disk"></i>
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-preview-placeholder');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection