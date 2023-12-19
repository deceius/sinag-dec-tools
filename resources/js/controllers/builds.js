export default () => ({
    isLoading: false,
    equipment: [
        {'type': 'Weapon', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Offhand', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Head', 'items': [], 'filter': '' , 'disabled': false },
        {'type': 'Armor', 'items': [], 'filter': '' , 'disabled': false },
        {'type': 'Shoes', 'items': [], 'filter': '' , 'disabled': false },
    ],
    consumables: [
        {'type': 'Potion', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Food', 'items': [], 'filter': '', 'disabled': false },
        {'type': 'Mount', 'items': [], 'filter': '', 'disabled': false },
    ],
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
    load(item){
        this.isLoading = true;
        let url = '/getitems?keyword=' + item.filter;
        axios.get(url).then(
            response => {
                item.filter = '';
                let foundItem = response.data.item;
                item.items.push(foundItem.item_id);
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
