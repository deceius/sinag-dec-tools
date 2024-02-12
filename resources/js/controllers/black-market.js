export default () => ({
    isLoading: false,
    data: [],
    filters: {
        'tier' : 8,
        'enchant': 3
    },
    init() {
        this.isLoading = true;
        this.data = [];
        let url = '/black-market?tier=' + this.filters.tier + (this.filters.enchant > 0 ? '&enchant=' + this.filters.enchant : '');
        axios.get(url).then(
            response => {
                this.data = response.data.market_data;
                this.data.sort(
                    (p1, p2) => (p1.buy_price_min < p2.buy_price_min) ? 1 : (p1.buy_price_min > p2.buy_price_min) ? -1 : 0);
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );}
})
