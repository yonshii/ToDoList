<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="max-w-md mx-auto mt-6">
        <div class="card bg-white/95 shadow-md border border-sky-200 rounded-2xl">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-center text-slate-800 mb-6">Create Account</h1>

                <form method="POST" action="/register" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Name</label>
                        <input
                            type="text"
                            name="name"
                            placeholder="Anna"
                            value="{{ old('name') }}"
                            class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none @error('name') border-rose-500 @enderror"
                            required
                        >
                        @error('name')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            placeholder="mail@example.com"
                            value="{{ old('email') }}"
                            class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none @error('email') border-rose-500 @enderror"
                            required
                        >
                        @error('email')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none @error('password') border-rose-500 @enderror"
                            required
                        >
                        @error('password')
                        <p class="text-rose-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label class="block text-xs text-slate-500 mb-1">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="••••••••"
                            class="input input-bordered w-full rounded-xl border-sky-200 bg-white focus:border-sky-500 focus:outline-none"
                            required
                        >
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="btn w-full rounded-full bg-sky-600 hover:bg-sky-700 text-white border-none"
                        >
                            Register
                        </button>
                    </div>
                </form>

                <div class="divider text-xs text-slate-400 my-4">OR</div>

                <p class="text-center text-sm text-slate-600">
                    Already have an account?
                    <a href="/login" class="text-sky-600 hover:underline font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
