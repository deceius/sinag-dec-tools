export default () => ({
    isLoading: false,
    filter: {
        'ign': '',
    },
    data: [],
    init(albionId) {
        if (!albionId) { return; }
        this.isLoading = true;
        let url = '/loadchar?id=' + albionId;
        axios.get(url).then(
            response => {
                this.data = response.data.character;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },
    parseGuildName(_allianceName, _guildName){
        let allianceName = _allianceName ? "[" + _allianceName + "] " : "";
        let guildName = _guildName ? _guildName : "--";
        return allianceName + guildName;
    },
    loadFromAPI() {
        this.isLoading = true;
        let url = '/aosearch?ign=' + this.filter.ign;
        axios.get(url).then(
            response => {
                this.data = response.data.ao_characters;
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },


});
