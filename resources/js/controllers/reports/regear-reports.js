export default () => ({
    status: [
        0, // unfiled
        1, // pending
        2 // approved, for regearing
    ],
    isLoading: false,
    filter: {
        'battleIds': '',
    },
    data: [],
    losses: [],
    init() {
        this.loadLosses('/reports/regear/fetch/losses');
        this.loadPendingItems('/reports/regear/fetch/pendingitems');
    },
    loadPendingItems(url) {
        this.isLoading = true;
        axios.get(url).then(
            response => {
                this.data = response.data.result;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },
    loadLosses(url) {
        this.isLoading = true;
        axios.get(url).then(
            response => {
                this.losses = response.data.result;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },


});
