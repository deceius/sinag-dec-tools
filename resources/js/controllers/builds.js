export default () => ({
    isLoading: false,
    equipment: [
        {'type': 'Weapon', 'item_id': null, 'filter': '', 'disabled': false },
        {'type': 'Offhand', 'item_id': null, 'filter': '', 'disabled': false },
        {'type': 'Head', 'item_id': null, 'filter': '' , 'disabled': false },
        {'type': 'Armor', 'item_id': null, 'filter': '' , 'disabled': false },
        {'type': 'Shoes', 'item_id': null, 'filter': '' , 'disabled': false },
    ],
    validateOffhand(validate) {
        console.log(equipment);
    },
    load(item){
        this.isLoading = true;
        let url = '/getitems?keyword=' + item.filter;
        axios.get(url).then(
            response => {
                let foundItem = response.data.item;
                item.item_id = foundItem.item_id;
                if (item.type == "Weapon") {
                    if (item.item_id.includes('_2H_')) {
                        this.equipment[1].disabled = true;
                        this.equipment[1].item_id = null;
                        this.equipment[1].filter = '';
                    } else {
                        this.equipment[1].disabled = false;
                    }
                }
                this.isLoading = false;
            }
        ).catch(error => {
                this.isLoading = false;
                item.item_id = null;
                item.filter = '';
                this.equipment[1].disabled = this.equipment[0].item_id ? this.equipment[0].item_id.includes('_2H_') : false;
            }
        );
    }


});
