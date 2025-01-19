class FilePondService{

    providerService;
    static filePond = 0;
    options;
    selector;
    defaultFile;
    constructor(providerService) {
        this.providerService = providerService;
        FilePondService.filePond++;
        FilePond.registerPlugin(
            FilePondPluginImagePreview
        );
    }

    setNodeSeletor(node) {
        this.selector = node;
        return this;
    }
    
    setdefaultFile(file) {
        this.defaultFile = file;
        return this;
    }

    setCongif(options){
        this.options = options;
        return this;
    }

    boot() {
        let pond = FilePond.create(
            document.querySelector(this.selector),
            this.options
        );

        if(this.defaultFile)
        pond.addFile(this.defaultFile);
        return pond;
    }

    exit(){
        return this.providerService;
    }
}
export default FilePondService;