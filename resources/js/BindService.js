class BindService{

    providerService;
    serviceName;
    static bindService = 0;

    constructor(providerService, name) {
        this.providerService = providerService;
        BindService.bindService++;
        this.serviceName = name;
    }

    async bindTo(target, value){
        let targets = document.querySelectorAll(`[bind-with="${target}"]`);
        if(targets.length){
            // targets.forEach(async (e)=>{
            for (const e of targets) {
                let val = value; 

                if(e.dataset.callback){
                    val = await window[e.dataset.callback](val);
                }

                if(e.dataset.bind == 'select'){
                    e.innerHTML = val;
                }

                if(e.dataset.bind == 'text'){
                    e.innerHTML = val;
                }

                if(e.dataset.bind == 'html'){
                    e.innerHTML = val;
                }
                
                if(e.dataset.bind == 'input'){
                    e.value = val;
                }
                
                if(e.dataset.bind == 'checkbox'){
                    e.checked = !e.checked;
                }
            };
        }
    }

    async flush(target){
        let targets = document.querySelectorAll(`[bind-with="${target}"]`);
        if(targets.length){
            targets.forEach(async (e)=>{
                if(e.dataset.bind == 'select')
                    e.children[0].selected = true;

                if(e.dataset.bind == 'input')
                    e.value = "";
                
            });
        }
    }

    boot() {
        document[this.serviceName] = this;
        return;
    }

    exit(){
        return this.providerService;
    }
}
export default BindService;