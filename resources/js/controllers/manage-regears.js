export default () => ({
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
    filter: {
        'battle_id': '',
        'status': '',
        'role_id' : ''
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
        filters = filters +  (roleId >= 0 ? "role_id=" + (roleId) + "&"  : "");
        filters = filters +  (battleId ? "battle_id=" + (battleId)  : "");
        return filters;
    },
    init() {
        this.isLoading = true;
        this.$watch('filter.status', () => {
            this.result = [];
            let url = '/officer/regear/fetch?' + this.processFilters();
            this.loadRegear(url);
        });
        this.$watch('filter.role_id', () => {
            this.result = [];
            let url = '/officer/regear/fetch?' + this.processFilters();
            this.loadRegear(url);
        });

        this.$watch('filter.battle_id', () => {
            this.result = [];
            let url = '/officer/regear/fetch?' + this.processFilters();
            this.loadRegear(url);
        });
        let url = '/officer/regear/fetch?' + this.processFilters();
        this.loadRegear(url);
    },
    loadRegear(url) {
        console.log(url);
        axios.get(url).then(
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
    loadPage(url){
        if (url) {
            this.loadRegear(url + "&" + this.processFilters());
        }
    },



});
