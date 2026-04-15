<x-guest-layout>
    <div class="w-full max-w-2xl mx-auto relative ">
        
        <!-- Red Register Pill - Title Badge -->
        <div class="absolute -top-24 left-0 right-0 flex justify-center z-50">
            <div class="bg-[#DC2626] text-white px-20 py-4 rounded-[40px] shadow-lg">
                <span class="text-3xl font-medium tracking-wide">Register</span>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6 mt-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Data Diri Section -->
                <div class="md:col-span-2 mb-2">
                    <h3 class="text-lg font-bold text-gray-500 uppercase tracking-widest border-b-2 border-gray-200 pb-2">Data Diri</h3>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-lg font-medium text-black mb-2">Nama Lengkap</label>
                    <input id="name" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-lg font-medium text-black mb-2">NIK</label>
                    <input id="nik" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="text" name="nik" :value="old('nik')" required />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>

                 <!-- No HP -->
                <div>
                     <label for="no_hp" class="block text-lg font-medium text-black mb-2">Nomor HP</label>
                    <input id="no_hp" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="text" name="no_hp" :value="old('no_hp')" required />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>

                <!-- Alamat -->
                <div>
                     <label for="alamat" class="block text-lg font-medium text-black mb-2">Alamat Domisili</label>
                    <input id="alamat" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="text" name="alamat" :value="old('alamat')" required />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- Data Akun Section -->
                <div class="md:col-span-2 mt-6 mb-2">
                     <h3 class="text-lg font-bold text-gray-500 uppercase tracking-widest border-b-2 border-gray-200 pb-2">Data Akun</h3>
                </div>

                <!-- No Anggota -->
                <div>
                    <label for="no_anggota" class="block text-lg font-medium text-black mb-2">Nomor Anggota</label>
                    <input id="no_anggota" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="text" name="no_anggota" :value="old('no_anggota')" required placeholder="Auto/Admin" />
                    <x-input-error :messages="$errors->get('no_anggota')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-lg font-medium text-black mb-2">Email (Opsional)</label>
                    <input id="email" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="email" name="email" :value="old('email')" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-lg font-medium text-black mb-2">Password</label>
                    <input id="password" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-lg font-medium text-black mb-2">Konfirmasi Password</label>
                    <input id="password_confirmation" class="w-full px-5 py-3 rounded-full border border-gray-500 focus:border-[#DC2626] focus:ring-0 transition duration-200 outline-none text-gray-900 text-lg" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-12 pt-6">
                <a class="underline text-lg text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <button type="submit" class="px-10 py-4 bg-[#DC2626] hover:bg-red-700 text-white font-bold rounded-full shadow-lg transition transform hover:-translate-y-1 text-xl">
                    {{ __('DAFTAR') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
