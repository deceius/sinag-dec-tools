export default () => ({
    battleIds: '',
    roles: [
        "Off Tanks",
        "Def Tanks",
        "Healers",
        "Supports",
        "Debuff",
        "RDPS",
        "MDPS",
    ],
    status: {
        "All Status": 0,
        "Pending": "2",
        "Regeared" : "1",
        "Rejected": "-1",
    },
    isLoading: false,
    nameSearch: '',
    filter: {
        'battle_id': '',
        'status': '',
        'role_id' : '',
        'tier': '',
    },
    ui: {
        'isApprove' : true,
        'confirmHeader': '',
        'confirmPlaceholder' : '',
        'buttonStyle' : 'success',
        'remarks' : '',
        'url' : ''
    },
    result: [],
    ctaList: [],
    parseBattles() {
        this.isLoading = true;
        let url = "/parseDeaths?battleIds=" + this.battleIds;
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

    confirmRegear(url, approve = true) {
        this.ui.url = url;
        this.ui.remarks = '';
        this.ui.isApprove = approve;
        this.ui.confirmHeader = (approve) ? 'Approve Regear' : 'Reject Regear';
        this.ui.confirmPlaceholder = (approve) ? 'Regear Chest #' : 'Reason';
        this.ui.buttonStyle = (approve) ? 'success' : 'danger';
        this.$dispatch('open-modal', 'confirm-regear');
    },
    processFilters(){
        let filters = (this.filter.status ? "status=" + this.filter.status + "&" : "");
        let roleId = parseInt(this.filter.role_id) - 1;
        let battleIdFilterArray = this.filter.battle_id.split(" > ");
        let battleId = battleIdFilterArray.length > 1 ? battleIdFilterArray[0] : "";
        let tier = this.filter.tier ? this.filter.tier : "";
        let name = this.nameSearch ? this.nameSearch : "";
        filters = filters +  (roleId >= 0 ? "role_id=" + (roleId) + "&"  : "");
        filters = filters +  (battleId ? "battle_id=" + (battleId) + "&" : "");
        filters = filters +  (tier ? "tier=" + (tier) + "&"  : "");
        filters = filters +  (name ? "name=" + (name)  : "");
        return filters;
    },
    proceedRegear(){
        this.isLoading = true;
        this.$dispatch('close');
        let url = this.ui.url + '/update?remarks=' + this.ui.remarks + (this.ui.isApprove ? '' : '&reject=1');
        axios.patch(url, {}).then(
            response => {
                this.reloadData();
                this.isLoading = false;
            }
        ).catch(error => {
                this.reloadData();
                this.isLoading = false;
            }
        );
    },
    reloadData(){
        let url = '/officer/regear/fetch?' + this.processFilters();
        this.loadRegear(url);
    },
    init() {
        this.isLoading = true;
        this.$watch('filter', () => {
            this.reloadData();
        });

        let url = '/officer/regear/fetch?';
        this.loadRegear(url);
    },
    fetchRoleIcon(index){
        if (index < 0) {
            return "none";
        }

        return index;
    },
    loadRegear(url) {
        this.isLoading = true;
        axios.get(url + "&" + this.processFilters()).then(
            response => {
                this.result = response.data.deaths;
                this.ctaList =  Object.groupBy(response.data.unfiltered, ({ battle_time }) => battle_time);
                console.log(this.ctaList);
                this.isLoading = false;
            }
        ).catch(error => {
               this.isLoading = false;
            }
        );
    },



});
