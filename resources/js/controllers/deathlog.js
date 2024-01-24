export default () => ({
    isLoading: false,
    filter: {
        'ign': '',
    },
    result: [],
    albionId: '',
    init(albionId) {
        let url = '/deathlog?';
        this.albionId = albionId;
        this.loadDeathLog(url);
    },
    loadDeathLog(url) {
        url = url + "&id=" + this.albionId;
        this.isLoading = true;
        axios.get(url).then(
            response => {
                this.result = response.data.result;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    }



});
