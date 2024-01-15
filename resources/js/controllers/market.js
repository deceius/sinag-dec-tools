// resources/js/components/market.js

export default () => ({
    isLoading: false,
    data: [],
    filter: {
        keyword: '',
        tier: '',
        city: '',
        enchantment: ''
    },

    filter() {
        this.isLoading = true;
        this.data = [];
        let url = '/market?itemSearch=' + this.filter.keyword + '&locationSearch=' + (this.filter.city ?? '') + "&tierSearch=" + (this.filter.tier ?? '') + "&enchantmentSearch=" + (this.filter.enchantment ?? '');
        axios.get(url).then(
            response => {
                console.log(response.data.market_data[0]);
                this.data = response.data.market_data;
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
