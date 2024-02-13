export default () => ({
    isLoading: false,
    data: [],
    filters: {
        'keyword': '',
        'tier' : 8,
        'enchant': 4
    },
    init() {
        if (this.filters.keyword.trim().length == 0 && (this.filters.tier <= 0 || this.filters.enchant <= 0)) {
            alert('Item keyword required if searching all tier and enchant.');
            return;
        }
        this.isLoading = true;
        this.data = [];
        let url = '/black-market?';
        url = url + (this.filters.tier > 0 ? 'tier=' + this.filters.tier + '&' : '');
        url = url + (this.filters.enchant > 0 ? 'enchant=' + (this.filters.enchant - 1) + '&' : '');
        url = url + (this.filters.keyword.trim().length != 0 ? 'keyword=' + this.filters.keyword : '');
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
