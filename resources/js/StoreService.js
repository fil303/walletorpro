class StoreService{
    providerService;
    serviceName;
 
    store;
    callable_function = [];

    constructor(providerService, name) {
        this.providerService = providerService;
        this.serviceName = name;
        this.store = {};
    }

    initResource(url){
        $.get(
            url,(response) => {
                if(response.status){
                    if(typeof response.data == "object"){
                        this.store = response.data;
                        if(this.callable_function){
                            this.callable_function.forEach((c)=>c(this));
                        }
                    }
                }
            }
        );
        return this;
    }

    has(index){
        return this.store.hasOwnProperty(index);
    }

    put(index, value){1
        this.store[index] = value;
    }

    getStore(){
        return this.store;
    }
    
    get(index){
        return this.store[index];
    }
    
    remove(index){
        delete this.store[index];
    }

    iterable(index) {
        if (this.store[index] == null) {
            return false;
        }
        return typeof this.store[index][Symbol.iterator] === 'function';
    }

    getType(index){
        return typeof this.store[index];
    }

    callable(callable_function){
        this.callable_function.push(callable_function);
        return this;
    }

    find(index, findByIndex, findByValue){
        if(!this.iterable(index)) return null;
        return this.store[index].find((value, key)=>{
            return value[findByIndex] == findByValue;
        });
    }
    
    finds(index, findByIndex, findByValue){
        if(!this.iterable(index)) return null;
        return this.store[index].filter((value, key)=>{
            return value[findByIndex] == findByValue;
        });
    }

    where(index, search){
        if(typeof search == "object"){
            let keys = Object.keys(search);
            return this.store[index].find((value, k)=>{
                let found = true;
                keys.forEach((key)=>{
                    if(found)
                    found = value[key] == search[key];
                })
                return found;
            });
        }
        return null;
    }

    whereAll(index, search){
        if(typeof search == "object"){
            let keys = Object.keys(search);
            return this.store[index].filter((value, k)=>{
                let found = true;
                keys.forEach((key)=>{
                    if(found)
                    found = value[key] == search[key];
                })
                return found;
            });
        }
        return null;
    }

    boot() {
        if(this.serviceName) document[this.serviceName] = this;
        return null;
    }

    exit(){
        return this.providerService;
    }
}
export default StoreService;