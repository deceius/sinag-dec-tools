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
        this.isLoading = true;
        let url = '/reports/regear/fetch';
        axios.get(url).then(
            response => {
                this.data = response.data.gears;
                this.losses = response.data.losses;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },



});
