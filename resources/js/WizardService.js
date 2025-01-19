class WizardService{

    providerService;
    serviceName;
    static wizard = 0;
    currentWizard = 0;

    step = 0;
    currentStep;
    stepNodesElement;
    stepNodes = {};
    renderNodes;
    validation = {};
    hasValidation = true;

    nextBtn;
    preBtn;
    submitBtn;

    constructor(providerService, name = "wizardService") {
        this.providerService = providerService;
        this.serviceName = name;
        WizardService.wizard++;
        this.currentWizard = WizardService.wizard;
        this.currentStep = 1;
    }

    setStep(step){
        this.step = step;
        return this;
    }
    setCurrentStep(step){
        this.currentStep = step;
        return this;
    }

    setRenderNodes(node){
        this.renderNodes = node;
        return this;
    }

    setStepNodesElement(elements){
        this.stepNodesElement = elements;
        return this;
    }

    setNextButton(elements){
        this.nextBtn = elements;
        return this;
    }
    
    setPreviousButton(elements){
        this.preBtn = elements;
        return this;
    }
    
    setSubmitButton(elements){
        this.submitBtn = elements;
        return this;
    }

    setStepNodes(){
        let step = 1;
        (this.stepNodesElement).forEach((e)=>{
            let element = document.querySelector(e);
            if(element){
                //this.stepNodes[step] = element.cloneNode(true);
                element.classList.add("hidden");
                // element.remove();
            }
            step++;
        });
    }

    renderStepNodes(){
        this.setStepNodes();
        let step = this.currentStep;
        let step_node = this.stepNodesElement[step - 1];//this.stepNodes[step];
        //let _class = `.step_${step}`;

        let element = document.querySelector(step_node); //document.querySelector(this.renderNodes);
        if(element) {
            element.classList.remove("hidden");
            // element.appendChild(step_node);
        }
    }

    saveWizardData(e){
        let value = e.value;
        let index = e.dataset.index;

        let newDate = new Date();
        let today = newDate.getDay();
        let storageIndex = `wizard_${this.currentWizard}`;

        let wizardData = localStorage.getItem('wizard');
        if(wizardData){
            let data = JSON.parse(wizardData);
            if(data.hasOwnProperty(today) && data.hasOwnProperty(storageIndex)){
                data[today][storageIndex] = {
                    ...data[today][storageIndex],
                    [index]: value
                };
            } else if(data.hasOwnProperty(today)){
                data[today][storageIndex] = {[index]: value};
            }
            localStorage.removeItem('wizard');
            localStorage.setItem('wizard', JSON.stringify(data));
        }else{
        }
    }

    createRenderNodes()
    {
        let renderAt = document.querySelector(this.renderNodes);
        if(renderAt) renderAt.innerHTML = "";

        for(let i = 1; i <= this.step; i++){
            const div = document.createElement("div");
            div.setAttribute("id", "step_" + i);
            renderAt.appendChild(div);
        }
    }

    disableAllButtons(){
        let p = document.querySelector(this.preBtn);
        let n = document.querySelector(this.nextBtn);
        let s = document.querySelector(this.submitBtn);

        if(p) p.setAttribute("disabled", "true");
        if(n) n.setAttribute("disabled", "true");
        if(s) s.setAttribute("disabled", "true");
    }

    enableNextButton()
    {
        let n = document.querySelector(this.nextBtn);
        if(n) n.removeAttribute("disabled");
    }
    
    enablePreviousButton()
    {
        let p = document.querySelector(this.preBtn);
        if(p) p.removeAttribute("disabled");
    }
    
    enableSubmitButton()
    {
        let s = document.querySelector(this.submitBtn);
        if(s) s.removeAttribute("disabled");
    }

    selectCurrentStep()
    {
        this.disableAllButtons();
        this.renderStepNodes();
        if(this.currentStep == 1){
            this.enableNextButton(); return;
        }
        
        if(this.currentStep == this.step){
            this.enablePreviousButton();
            this.enableSubmitButton(); 
            return;
        }

        if(this.currentStep > 1 && this.currentStep < this.step)
        {
            this.enablePreviousButton();
            this.enableNextButton(); return;
        }
        
        if(this.currentStep < this.step)
        {
            this.enableNextButton();
            return;
        }
        
        if(this.currentStep > 1)
        {
            this.enablePreviousButton();
            return;
        }
    }

    checkThisObjectValidation(){
        let response = {
            fail: false,
            message: "ok"
        };

        if(this.step < 1){
            response.fail = true;
            response.message = "Initial step invalid";
            return response;
        }

        if(!this.renderNodes){
            response.fail = true;
            response.message = "Initial renderNodes not set";
            return response;
        }
        
        if(!(Array.isArray(this.stepNodesElement) && (this.stepNodesElement.length >= 1))){
            response.fail = true;
            response.message = "Initial step Nodes Element required at list 1";
            return response;
        }

        return response;
    }

    nextStep()
    {
        if(
            this.validationProcess() && 
            this.currentStep >= 1 && 
            this.currentStep != this.step
        ){
            this.currentStep++;
            this.selectCurrentStep();
        }
    }

    previousStep()
    {
        if(this.currentStep <= this.step && this.currentStep != 1){
            this.currentStep--;
            this.selectCurrentStep();
        }
    }

    validate(element, step, rules = [])
    {
        if(this.validation.hasOwnProperty(step) && this.validation[step].length){

            // remove item if already exists
            this.validation[step].forEach((i, index)=>{
                if(i.e == element)
                this.validation[step].splice(index, 1);
            });

            // add item in validator collection
            this.validation[step].push = {
                e: element,
                r: rules
            };
        }else{
            // add item in new validator
            this.validation[step] = [{
                e: element,
                r: rules
            }];
        }
    }

    validationProcess(){
        let step = this.currentStep;
        let pass = true;
        let elements = document.querySelectorAll(`[wizard-validate-step="${step}"]`);

        if(elements.length){
            elements.forEach((e)=>{
                let v = e.value || "";
                let rules = e.dataset.rules || "";
                rules = rules.split("|");
                if(rules.length){
                    rules.forEach((rule)=>{
                        if(rule == "") return true;
                        if(rule == "required"){
                            console.log("e", e, "v", v);
                            if(!v.length || v == 0 || (v < 0) || v == null || v == ""){
                                e.classList.toggle("input-error");
                                e.classList.toggle("input-bordered");
                                setTimeout(function(){
                                    e.classList.toggle("input-error");
                                    e.classList.toggle("input-bordered");
                                }, 5000);
                                pass =  false;
                            }
                        }
                    });
                }
            });
        }

        return pass;
    }

    boot() {
        let validation = this.checkThisObjectValidation();
        if(validation?.fail){
            return null;
        }
        
        //this.createRenderNodes();
        this.setStepNodes();
        this.renderStepNodes();
        this.selectCurrentStep();

        document[this.serviceName] = this;
        return this;
    }

    exit(){
        return this.providerService;
    }
}
export default WizardService;