<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if (Auth::user()->global_name)
            <div>
                <x-ui.form.-label for="global_name" :value="__('Display Name')" />
                <x-ui.form.input.text id="global_name" name="global_name" type="text" class="mt-1 block w-full" :value="old('global_name', $user->global_name)" required autocomplete="global_name" disabled />
                <x-ui.form.input.error class="mt-2" :messages="$errors->get('global_name')" />
            </div>
        @endif
        <div>
            <x-ui.form.input.label for="username" :value="__('Username')" />
            <x-ui.form.input.text id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" disabled />
            <x-ui.form.input.error class="mt-2" :messages="$errors->get('username')" />
        </div>

        @if (!Auth::user()->global_name)
            <div>
                <x-ui.form.input.label for="discriminator" :value="__('Discriminator')" />
                <x-ui.form.input.text id="discriminator" name="discriminator" type="text" class="mt-1 block w-full" :value="old('discriminator', $user->discriminator)" required autocomplete="discriminator" disabled />
                <x-ui.form.input.error class="mt-2" :messages="$errors->get('discriminator')" />
            </div>
        @endif

        <div>
            <x-ui.form.input.label for="email" :value="__('Email')" />
            <x-ui.form.input.text id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? __('Unknown'))" required autocomplete="email" disabled />
            <x-ui.form.input.error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->verified)
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
