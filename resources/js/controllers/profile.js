export default () => ({
    isLoading: false,
    filter: {
        'ign': ''
    },
    data: [],
    init() {
    },
    loadFromAPI() {
        let url = '/aosearch?ign=' + this.filter.ign;
        axios.get(url).then(
            response => {
                this.data = response.data.ao_characters;
                console.log(this.data);
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },


});
