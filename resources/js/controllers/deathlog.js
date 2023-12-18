export default () => ({
    isLoading: false,
    filter: {
        'ign': '',
    },
    data: [],
    init(albionId) {
        this.isLoading = true;
        let url = '/deathlog?id=' + albionId;
        axios.get(url).then(
            response => {
                this.data = response.data.deaths;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    }


});
