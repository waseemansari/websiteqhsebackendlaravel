<x-guest-layout>
    <form method="POST" action="{{ url('payment') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />

            <x-text-input
                id="first_name"
                class="block mt-1 w-full"
                type="text"
                name="first_name"
                value="{{ old('first_name', $firstName) }}"
                required
                autofocus
                autocomplete="given-name"
            />

            <x-input-error
                :messages="$errors->get('first_name')"
                class="mt-2"
            />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />

            <x-text-input
                id="last_name"
                class="block mt-1 w-full"
                type="text"
                name="last_name"
                value="{{ old('last_name', $lastName) }}"
                required
                autocomplete="family-name"
            />

            <x-input-error
                :messages="$errors->get('last_name')"
                class="mt-2"
            />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                value="{{ old('email', $email) }}"
                required
                autocomplete="email"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />

            <x-text-input
                id="phone"
                class="block mt-1 w-full"
                type="text"
                name="phone"
                value="{{ old('phone', $phone) }}"
                required
                autocomplete="tel"
            />

            <x-input-error
                :messages="$errors->get('phone')"
                class="mt-2"
            />
        </div>

        <!-- Amount -->
        <div class="mt-4">
            <x-input-label for="amount" :value="__('Amount')" />

            <x-text-input
                id="amount"
                class="block mt-1 w-full"
                type="number"
                name="amount"
                value="{{ old('amount', $amount) }}"
                required
                autocomplete="off"
            />

            <x-input-error
                :messages="$errors->get('amount')"
                class="mt-2"
            />
        </div>

        <!-- Merchant Param 1 -->
        <input
            type="hidden"
            name="merchant_param1"
            value="{{ $merchantParam1 }}"
        >

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('CheckOut') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>