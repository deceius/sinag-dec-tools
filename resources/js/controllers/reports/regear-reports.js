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
    totalPendingRegearItems: 0,
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
                console.log(this.data);
                this.totalPendingRegearItems = Object.values(this.data).reduce((accumulator, currentValue) => accumulator + currentValue.items.length, 0)

                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
               console.log(error);
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
