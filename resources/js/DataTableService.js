class DataTableService{

    providerService;
    static table = 0;
    options;
    selector;
    constructor(providerService) {
        this.providerService = providerService;
        DataTableService.table++;
    }

    setNodeSeletor(node) {
        this.selector = node;
        return this;
    }

    setCongif(options){
        this.options = options;
        return this;
    }

    boot() {
        return new DataTable(this.selector, this.options);
    }

    exit(){
        return this.providerService;
    }
}
export default DataTableService;