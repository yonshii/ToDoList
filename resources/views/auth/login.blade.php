<x-layout>
    <x-slot:title>
        Sign In
    </x-slot:title>

    <div class="max-w-md mx-auto mt-6">
        <div class="card bg-white/95 shadow-md border border-sky-200 rounded-2xl">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-center text-slate-800 mb-6">Welcome Back</h1>

                <form method="POST" action="/login" class="space-y-4">
                    @csrf

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
                            autofocus
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

                    <!-- Remember Me -->
                    <div class="pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                class="checkbox rounded-md"
                            >
                            <span class="text-sm text-slate-700">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="btn w-full rounded-full border-none text-white"
                            style="background-color: #0284c7;"
                        >
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="divider text-xs text-slate-400 my-4">OR</div>

                <p class="text-center text-sm text-slate-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-sky-600 hover:underline font-medium">Register</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
