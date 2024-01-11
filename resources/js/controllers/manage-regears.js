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
    parseBattles() {
        this.isLoading = true;
        let url = "/parseDeaths?battleIds=" + this.filter.battleIds;
        axios.get(url).then(
            response => {
                this.isLoading = false;
                window.location.reload();
            }
        ).catch(error => {
            this.isLoading = false;
            console.log(error);
            }
        );
    },
    init() {
        this.isLoading = true;
        let url = '/officer/regear/fetch';
        axios.get(url).then(
            response => {
                this.data = response.data.deaths;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },



});
