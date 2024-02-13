<section x-data="builds" x-init="editInit({{$buildInfo}})">
    <x-ui.card class="mt-6">
        <x-slot:title>
            {{ __('Build Generator') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.shield-check/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.button  x-bind:disabled="isLoading" x-on:click="saveBuild()" style="success" text="Save Changes" >
                <x-slot:icon><x-icons.button.create/></x-slot>
            </x-ui.button>
        </x-slot>
        <x-slot:content>
            <x-ui.form.select x-model="data.role_id" class="mb-2">
                <template x-for="(role, index) in roles">
                    <option x-bind:value="index" x-text="role" :selected="data.role_id == index"/>
                </template>
            </x-ui.form.select>
            <div class="grid grid-cols-4 max-sm:grid-cols-1">

                <div>

                    <template x-for="item in equipment">
                        <div class="mb-2 inline-flex">
                            <x-ui.search model="item.filter" click-method="load(item, true)" x-bind:placeholder="item.type" x-bind:disabled="item.disabled"/>
                            <img x-show="item.items.length == 0" class="opacity-25 grayscale inline" x-bind:src="`https://render.albiononline.com/v1/item/QUESTITEM_TOKEN_ADC_FRAME?size=32`">
                            <div :class="{'animate-pulse': isLoading}" class="inline">
                                <template x-for="item_id in item.items">
                                    <img x-on:click="removeItem(item, item_id)" :class="{'opacity-25 grayscale': item_id.length === 0 }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ item_id ? item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=32`" tooltip="item.type">
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
               <div>
                <template x-for="item in consumables">
                    <div class="mb-2 inline-flex">
                        <x-ui.search model="item.filter" click-method="load(item)" x-bind:placeholder="item.type" x-bind:disabled="item.disabled"/>
                        <img x-show="item.items.length == 0" class="opacity-25 grayscale inline" x-bind:src="`https://render.albiononline.com/v1/item/QUESTITEM_TOKEN_ADC_FRAME?size=32`">
                        <div :class="{'animate-pulse': isLoading}" class="inline">
                            <template x-for="item_id in item.items">
                                <img x-on:click="removeItem(item, item_id)" :class="{'opacity-25 grayscale':  item_id.length === 0 }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ item_id ? item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=32`" tooltip="item.type">
                            </template>
                        </div>
                    </div>
                </template>
               </div>
            </div>
            <x-ui.form.input.text placeholder="Notes" x-model="data.notes" class="min-w-full"/>
        </x-slot>
    </x-ui.card>

</section>
