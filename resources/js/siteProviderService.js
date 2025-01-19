import FilePondService from './FilePondService';
import DataTableService from './DataTableService';
import PaginationService from './PaginationService';
import WizardService from './WizardService';
import BindService from './BindService';
import ServerSideModal from './ServerSideModal';
import StoreService from './StoreService';

class SiteProviderService
{
    instance;
    instanceSelector = [];
    instanceIndex = 0;
    constructor() {}

    newInstance(){
        if(!this.instance)
            this.instance = [];
        return this;
    }

    createInstance(){
        return this.instance[this.instanceIndex++];
    }

    boot(){
        let loopIndex = 0;
        let response = {};
        if(this.instance){
            this.instance.forEach((instance)=>{
                let name = this.instanceSelector[loopIndex];
                response = { ...response, [name]: instance.boot()};
                loopIndex++;
            });
        }
        spinner(false);
        return response;
    }

    filePondService(name){
        this.instanceSelector.push(name)
        this.instance.push(new FilePondService(this));
        return this.createInstance();
    }
    
    dataTableService(name){
        this.instanceSelector.push(name)
        this.instance.push(new DataTableService(this));
        return this.createInstance();
    }

    paginationService(name){
        this.instanceSelector.push(name)
        this.instance.push(new PaginationService(this, name));
        return this.createInstance();
    }
    
    wizardService(name){
        this.instanceSelector.push(name)
        this.instance.push(new WizardService(this, name));
        return this.createInstance();
    }
    
    bindService(name){
        this.instanceSelector.push(name)
        this.instance.push(new BindService(this, name));
        return this.createInstance();
    }

    serverSideModal(name){
        this.instanceSelector.push(name)
        this.instance.push(new ServerSideModal(this, name));
        return this.createInstance();
    }
    
    storeService(name){
        this.instanceSelector.push(name)
        this.instance.push(new StoreService(this, name));
        return this.createInstance();
    }

}

document.siteProviderService = new SiteProviderService;
