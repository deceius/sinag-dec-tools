
<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('VOD') }}"/>
    </x-slot>


    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            <x-ui.card>
                <x-slot:title>
                    {{ __('Deceius VOD - Preview') }}
                </x-slot>
                <x-slot:icon>
                    <x-icons.bolt/>
                </x-slot>
                <x-slot:buttons>
                    <x-ui.button  x-bind:disabled="isLoading" x-on:click="saveBuild()" style="success" text="Save VOD" >
                        <x-slot:icon><x-icons.button.create/></x-slot>
                    </x-ui.button>
                </x-slot>
                <x-slot:content>
                    <x-markdown class="prose max-w-full">
                        {!! $markdown !!}
                    </x-markdown>

                </x-slot>
            </x-ui.card>


        </div>
    </div>
</x-app-layout>

