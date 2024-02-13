<section x-data="ocBreak" x-init="init()">
    <x-ui.card>
        <x-slot:title>
            {{ __('OC Break Details') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.bolt/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.button  x-bind:disabled="isLoading" x-on:click="saveBuild()" style="success" text="Post Request" >
                <x-slot:icon><x-icons.button.create/></x-slot>
            </x-ui.button>
        </x-slot>
        <x-slot:content>
            <div class="grid grid-cols-3 max-sm:grid-cols-1">
                <div>
                    <template x-for="item in equipment">
                        <div class="mb-2">
                            <img x-show="item.items.length == 0" class="opacity-25 grayscale mb-2" x-bind:src="`https://render.albiononline.com/v1/item/QUESTITEM_TOKEN_ADC_FRAME?size=48`">

                            <div :class="{'animate-pulse': isLoading}" class="mb-2">
                                <template x-for="item_id in item.items">
                                    <img x-on:click="removeItem(item, item_id)" :class="{'opacity-25 grayscale': item_id.length === 0 }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ item_id ? item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=48`" tooltip="item.type">
                                </template>
                            </div>

                            <x-ui.search model="item.filter" click-method="load(item, true)" x-bind:placeholder="'Search Item...'" x-bind:disabled="item.disabled"/>

                        </div>
                    </template>
                    <x-ui.form.input.text placeholder="Battle ID" x-model="data.battle_id" class="min-w-full mb-2"/>
                    <x-ui.form.input.text placeholder="Pre-OC Image Proof URL" x-model="" class="min-w-full mb-2"/>
                    <x-ui.form.input.text placeholder="Post-OC Image Proof URL" x-model="" class="min-w-full"/>
                </div>

            </div>
        </x-slot>
    </x-ui.card>


</section>
