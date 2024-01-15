// resources/js/components/market.js

export default () => ({
    isLoading: false,
    goatData: [],
    killsData: [],
    init() {
        this.isLoading = true;
        this.data = [];
        let url = '/get-guild-data';
        axios.get(url).then(
            response => {
                console.log(response.data);
                this.goatData = response.data.goat;
                this.killsData = response.data.kills;
                console.log(this.goatData);
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
        // console.log(this.data);
        // this.data = [{'city': 'Bridgewatch', 'item_id': 'T1_MAIN_SWORD', 'quality': 1, 'buy_price_max': 0, 'buy_price_min': 0, 'sell_price_max': 0, 'sell_price_min': 1}];
    }
})
