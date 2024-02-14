
<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{!! Auth::user()->ao_character_name . __('\'s Content') !!}"/>
    </x-slot>


    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            <x-ui.card>
                <x-slot:title>
                    {{ $title }}
                </x-slot>
                <x-slot:icon>
                    <x-icons.bookmark/>
                </x-slot>
                <x-slot:buttons>
                    <x-ui.button  x-bind:disabled="isLoading" x-on:click="saveBuild()" style="success" text="Save Content" >
                        <x-slot:icon><x-icons.button.create/></x-slot>
                    </x-ui.button>
                </x-slot>
                <x-slot:content>
                    <x-markdown class="prose prose-li:my-0 prose-ol:my-0 prose-ul:my-0 max-w-full">
                        {!! $markdown !!}
                    </x-markdown>

                </x-slot>
            </x-ui.card>


        </div>
    </div>
</x-app-layout>

