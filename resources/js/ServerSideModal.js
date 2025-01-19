class ServerSideModal{
    providerService;
    serviceName
    modalRoute;
    modalParent;
    modal;
    callable;
    constructor(providerService, name) {
        this.providerService = providerService;
        this.serviceName = name;
    }

    setModalRoute(route) {
        this.modalRoute = route;
        return this;
    }
    
    setModalParent(parentDiv) {
        let parentDivElement = document.querySelector(parentDiv);
        this.modalParent = parentDivElement;
        return this;
    }

    setCallable(callable){
        this.callable = callable;
        return this;
    }

    closeModal(){
        if(this.modal){
            this.modal.close();
        }
    }

    getModal(route)
    {
        $.get(route, (response) => {
            if(response && response.html.length){
                this.modalParent.innerHTML = '';
                this.modalParent.innerHTML = response.html;
                this.modal = document.querySelector(`#${response.modal_id}`);
                this.modal.showModal();
                if(this.callable) this.callable();
            }else{
                Notify("Modal not found");
            }
        });
    }

    boot() {
        if(! this.modalParent){
            console.log("Server side modal parent element not found");
        }

        if(this.serviceName) document[this.serviceName] = this;
        return null;
    }

    exit(){
        return this.providerService;
    }
}
export default ServerSideModal;