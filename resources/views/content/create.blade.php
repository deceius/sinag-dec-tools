<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Content Creation') }}"/>
    </x-slot>


    <div class="py-12"  x-data="manageRegears"  x-init="init()">

        <div class="max-w-full sm:px-6 lg:px-8">
            @push('cdn')
            <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
            <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
            @endpush
            <section>

                <form method="POST" action="{{ url('test-form')}}">
                    @csrf
                    <x-ui.card>
                        <x-slot:title>
                            {{ __('Create new content') }}
                        </x-slot>
                        <x-slot:icon>
                            <x-icons.list/>
                        </x-slot>
                        <x-slot:buttons>
                            <x-ui.button type="submit" text="Post content" style="success">
                                <x-slot:icon>
                                    <x-icons.button.create/>
                                </x-slot:icon>
                            </x-ui.button>
                        </x-slot:buttons>
                        <x-slot:content>
                            <x-ui.form.input.text type="text" name="title" placeholder="Enter Title..." class="min-w-full mb-4 " />
                            <x-easy-mde name="about" :options="[
                                'spellChecker' => false,
                                'status' => false,
                                'previewClass' => ['prose', 'prose-li:my-0', 'prose-ol:my-0','prose-ul:my-0',  'bg-gray-900', 'pt-[60px]', 'max-w-full', 'p-3','border-gray-700', 'rounded-lg'],
                                'toolbar' => [ 'bold', 'italic', 'strikethrough', '|', 'heading', 'quote', '|', 'link', 'image', 'unordered-list', 'ordered-list', 'code', 'horizontal-rule', 'table', '|', 'preview']
                                ]"/>

                        </x-slot>
                    </x-ui.card>

                </form>


            </section>

        </div>
    </div>
</x-app-layout>


