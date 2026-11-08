@extends('layouts.profile_layout')

@section('profile_content')
<div class="flex flex-col gap-10 pt-5">
    <div class="flex justify-between items-center">
        <div>
            <span class="font-semibold font-heading text-md">Edit Profile</span>
            <p>Ubah informasi yang ditampilkan di profil kamu</p>
        </div>
        <button type="button" onclick="openEditModal()" class="btn-primary">
            Edit Profile
        </button>
    </div>
    <div class="w-full h-0.5 bg-slate-dark/20 rounded-2xl"></div>
    <details class="group rounded-2xl transition-all [&_summary::-webkit-details-marker]:hidden">
        <summary class="flex justify-between items-center cursor-pointer list-none select-none">
            <div>
                <span class="font-semibold font-heading text-md">Keamanan Akun</span>
                <p>Update informasi secara berkala untuk keamanan akun yang lebih baik</p>
            </div>
            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300 group-open:rotate-180" 
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </summary>
        <div class="bg-slate-dark/5 rounded-lg p-4 space-y-5">
            <div class="flex flex-col gap-10">
                <div>
                    <p class="font-semibold text-slate-dark">Email</p>
                    <input type="email" name="" value="{{Auth::user()->email}}" readonly>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold text-slate-dark">Password</p>
                        <input type="password" placeholder="•••••••••••">
                    </div>
                    <button type="button" onclick="openUbahPwModal()" class="btn-primary hover:bg-primary-hover cursor-pointer">
                        Update Password
                    </button>
                </div>
                
            </div>
        </div>
    </details>
    
    <div>
        <span>More</span>
        <a>Nonaktifkan akun</a>
    </div>
</div>

<!-- model edit profile -->
<div id="editProfileModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    
    <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl p-6 shadow-2xl relative text-slate-100">
        
        <div class="flex justify-between items-center border-b border-slate-800 pb-3 mb-4">
            <h3 class="font-heading font-bold text-lg">Edit Profil</h3>
            <button onclick="closeEditModal()" type="button" class="text-slate-400 hover:text-white text-xl font-bold">
                &times;
            </button>
        </div>

        <form action="{{ route('setting.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-300">Nama Tampilan</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-slate-100 focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-300">Bio</label>
                <textarea name="bio" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-slate-100 focus:outline-none focus:border-primary">{{ Auth::user()->bio ?? '' }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-full font-semibold text-sm transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ubah pw modal -->
<div id="editPwModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    
    <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl p-6 shadow-2xl relative text-slate-100">
        
        <div class="flex justify-between items-center border-b border-slate-800 pb-3 mb-4">
            <h3 class="font-heading font-bold text-lg">Ubah Password</h3>
            <button onclick="closeUbahPwModal()" type="button" class="text-slate-400 hover:text-white text-xl font-bold">
                &times;
            </button>
        </div>

        <form action="{{ route('setting.updatePassword') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-300">Password Lama</label>
                <input type="password" name="current_password" placeholder="Masukkan password lama" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-slate-100 focus:outline-none focus:border-primary">
            </div>
            
            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-300">Password Baru</label>
                <input type="password" name="password" placeholder="Masukkan password baru" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-slate-100 focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-slate-300">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required placeholder="Ketik ulang password baru" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-2 text-slate-100 focus:outline-none focus:border-primary">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="closeUbahPwModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-full font-semibold text-sm transition-colors">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    function openEditModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
    function openUbahPwModal() {
        document.getElementById('editPwModal').classList.remove('hidden');
    }

    function closeUbahPwModal() {
        document.getElementById('editPwModal').classList.add('hidden');
    }
</script>