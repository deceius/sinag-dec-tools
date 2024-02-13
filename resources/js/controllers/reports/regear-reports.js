export default () => ({
    status: {
        "All Status": 0,
        "Pending": "2",
        "Regeared" : "1",
        "Rejected": "-1",
    },
    isLoading: false,
    filter: {
        'battleIds': '',
        'status': 0
    },
    data: [],
    totalPendingRegearItems: 0,
    losses: [],
    deathStats: [],
    init() {
        this.loadLosses('/reports/regear/fetch/losses');
        this.loadPendingItems('/reports/regear/fetch/pendingitems');
        this.loadDeathStats('/reports/regear/fetch/deathstats');
        this.$watch('filter.status', () => {
            this.loadDeathStats('/reports/regear/fetch/deathstats?');
        });
    },
    loadDeathStats(url) {
        url = url + (this.filter.status != 0 ? ('&status=' + this.filter.status) : '');
        this.isLoading = true;
        axios.get(url).then(
            response => {
                this.deathStats = response.data.result;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
               console.log(error);
            }
        );
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
