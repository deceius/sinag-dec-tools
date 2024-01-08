export default () => ({
    isLoading: false,
    builds: [],
    roles: [
        "Off Tanks",
        "Def Tanks",
        "Healers",
        "Supports",
        "Debuff",
        "RDPS",
        "MDPS",
    ],
    data: {
        'role_id': 0,
        'notes' : '',
        'equipment': '',
        'consumables': ''
    },
    equipment: [
        {'type': 'Weapon', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Offhand', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Head', 'items': [], 'filter': '' , 'disabled': false },
        {'type': 'Armor', 'items': [], 'filter': '' , 'disabled': false },
        {'type': 'Shoes', 'items': [], 'filter': '' , 'disabled': false },
        {'type': 'Cape', 'items': [], 'filter': '' , 'disabled': false },
    ],
    consumables: [
        {'type': 'Potion', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Food', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Mount', 'items': [], 'filter': '', 'disabled': false },
    ],
    init() {
        axios.get('/get-builds').then(
            response => {
                this.builds = response.data.builds;
                console.log(this.builds);
            }
        ).catch(
            error => {}
        );
    },
    parseImage(item) {
        return item ? item : 'QUESTITEM_TOKEN_ADC_FRAME';
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
        this.consumables.forEach(item => {
            strConsumables.push(item.items.join('|'));
        });

        this.data.equipment = strEquipment.join(',');
        this.data.consumables = strConsumables.join(',');
        console.log(this.data);

        let url = "/officer/build/save";
        axios.post(url, this.data).then(
            response => {
                location.href = '/home';
            }
        ).catch(error => {
            }
        );



    },
    load(item){
        this.isLoading = true;
        let url = '/getitems?keyword=' + item.filter;
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
