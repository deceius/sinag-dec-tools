// resources/js/components/market.js

export default () => ({
    isLoading: false,
    goatData: null,
    killsData: null,
    init() {
        this.isLoading = true;
        this.data = [];
        let url = '/get-guild-data';
        axios.get(url).then(
            response => {
                this.goatData = response.data.goat;
                this.killsData = response.data.kills;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
     }
})
