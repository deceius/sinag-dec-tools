export default () => ({
    isLoading: false,
    filter: {'role_id' : 0 },
    builds: [],
    data: {
        'role_id': 0,
        'notes' : '',
        'equipment': '',
    },
    equipment: [
        {'type': 'OC Break', 'items': [], 'filter': '', 'disabled': false },
    ],
    init() {
        this.$watch('filter.role_id', () => {
            console.log(this.filter.role_id - 1);
            this.loadBuilds();
        });
        this.loadBuilds();
    },
    editInit(buildInfo) {
        this.data.id = buildInfo.id;
        this.data.role_id = buildInfo.role_id;
        this.data.notes = buildInfo.notes;
        for (var i = 0; i < this.equipment.length; i++) {
            buildInfo.equipment_list[i].forEach(element => {
                this.silentLoad(this.equipment[i], element);
            });
        }
    },
    loadBuilds(){
        this.isLoading = true;
        let roleIdFilter = this.filter.role_id - 1;
        this.builds = [];
        let url = '/get-builds' +  (roleIdFilter >= 0 ? '?role_id=' + roleIdFilter : '');
        axios.get(url).then(
            response => {
                this.isLoading = false;
                this.builds = response.data.builds;
                console.log(this.builds);
            }
        ).catch(
            error => {}
        );
    },
    parseImage(item) {
        return item.length === 0 ? item : 'QUESTITEM_TOKEN_ADC_FRAME';
    },
    removeItem(item, item_id) {
        item.filter = '';
        if (item_id == null) { return; }
        let index = item.items.indexOf(item_id);
        if (index > -1) {
            item.items.splice(index, 1);

          }
        if (item.type == "Weapon") {
            let isTwoHanded = this.equipment[0].items.some(v => v.includes('_2H_'));
            this.equipment[1].disabled = this.equipment[0].items ? isTwoHanded : false;
        }
    },
    saveBuild(){
        this.isLoading = true;
        var strEquipment = [];
        var strConsumables = [];
        this.equipment.forEach(item => {
            strEquipment.push(item.items.join('|'));
        });

        this.data.equipment = strEquipment.join(',');
        this.data.consumables = strConsumables.join(',');
        console.log(this.data);

        let url = "/officer/build/save";
        axios.post(url, this.data).then(
            response => {
                location.href = '/officer/build/index';
            }
        ).catch(error => {
            console.log(error);
            }
        );
    },
    load(item, isEquip = false){
        this.isLoading = true;
        let url = '/getitems?keyword=' + item.filter + (isEquip ? '&equip=1' : '');
        axios.get(url).then(
            response => {
                item.filter = '';
                let foundItem = response.data.item;
                if (item.items.length <= 2) {
                    item.items.push(foundItem.item_id);
                }
                else {

                }
                if (item.type == "Weapon") {
                    console.log(item);
                    let isTwoHanded = item.items.some(v => v.includes('_2H_'));
                    if (isTwoHanded) {
                        this.equipment[1].disabled = true;
                        this.equipment[1].items = [];
                        this.equipment[1].filter = '';
                    } else {
                        this.equipment[1].disabled = false;
                    }
                }
                this.isLoading = false;
            }
        ).catch(error => {
                this.isLoading = false;
                item.item_id = [];
                item.filter = '';

                let isTwoHanded = this.equipment[0].items.some(v => v.includes('_2H_'));
                this.equipment[1].disabled = this.equipment[0].items ? isTwoHanded : false;
            }
        );
    },
    silentLoad(item, filter){
        this.isLoading = true;
        let url = '/getitems?keyword=' + filter;
        axios.get(url).then(
            response => {
                item.filter = '';
                let foundItem = response.data.item;
                if (item.items.length <= 2) {
                    item.items.push(foundItem.item_id);
                }
                else {

                }
                if (item.type == "Weapon") {
                    console.log(item);
                    let isTwoHanded = item.items.some(v => v.includes('_2H_'));
                    if (isTwoHanded) {
                        this.equipment[1].disabled = true;
                        this.equipment[1].items = [];
                        this.equipment[1].filter = '';
                    } else {
                        this.equipment[1].disabled = false;
                    }
                }
                this.isLoading = false;
            }
        ).catch(error => {
                this.isLoading = false;
                item.item_id = [];
                item.filter = '';

                let isTwoHanded = this.equipment[0].items.some(v => v.includes('_2H_'));
                this.equipment[1].disabled = this.equipment[0].items ? isTwoHanded : false;
            }
        );
    }


});
