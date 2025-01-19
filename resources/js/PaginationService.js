class PaginationService{
    static pagination = 0;
    PaginationName;
    providerService;

    currentPage = 1;
    perPage = 0;
    resourcesPath;
    utility = true;

    renderSelector;
    paginationSelector;
    responseSelector;
    
    beforeHtmlResponseNodes = "";
    htmlResponseNodes = "";
    afterHtmlResponseNodes = "";
    nodes = "";

    has_data = true;
    has_page = true;
    dataNotFound;

    search;
    filter = {};

    constructor(providerService, name = null) {
        this.providerService = providerService;
        PaginationService.pagination++;
        if(name) this.PaginationName = name;
    }

    setResourcesPath(path) {
        this.resourcesPath = path;
        return this;
    }

    setPage(page){
        this.currentPage = page;
        return this;
    }

    setSearch(value){
        this.search = value;
    }

    setUtility(enable = true){
        this.utility = enable;
        return this;
    }

    setBeforeResponse(html){
        this.beforeHtmlResponseNodes = html;
        return this;
    }

    setFilter(slug, value){
        this.filter[slug] = value;
    }

    setAfterResponse(html){
        this.afterHtmlResponseNodes = html;
        return this;
    }

    createElements(){

        if(!this.responseSelector && !this.paginationSelector){
            let renderAt = document.querySelector(this.renderSelector);
            if(renderAt) this.dataNotFound = renderAt?.children[0]?.cloneNode(true);
            if(this.htmlResponseNodes && renderAt) renderAt.innerHTML = "";

            this.responseSelector = "#response_pagination_" + this.PaginationName || PaginationService.pagination;
            this.paginationSelector = "#pagination_pagination_" + this.PaginationName || PaginationService.pagination;

            const responseDiv = document.createElement("div");
            const paginationDiv = document.createElement("div");
            const utilityDiv = document.createElement("div");

            utilityDiv.innerHTML = (`
                <div class="flex flex-wrap justify-between items-center sm:justify-center">
                    <div class="join sm:mb-2">
                        <select class="select select-bordered select-sm w-full max-w-xs" onchange="document.pagination${this.PaginationName || PaginationService.pagination}.renderPerPageItem(this.value)">
                            <option selected>10</option>
                            <option>20</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="join">
                        <input class="input input-sm input-bordered join-item" oninput="document.pagination${this.PaginationName || PaginationService.pagination}.setSearch(this.value)" />
                        <button class="btn btn-sm join-item rounded-r-full" onclick="document.pagination${this.PaginationName || PaginationService.pagination}.renderSearch()">
                            <span class="text-xl icon-[line-md--search-twotone]"></span>
                        </button>
                    </div>
                </div>
            `);
            utilityDiv.setAttribute("id", "util_pagination_" + this.PaginationName || PaginationService.pagination);
            utilityDiv.setAttribute("class", "mb-2");

            responseDiv.setAttribute("id", "response_pagination_" + this.PaginationName || PaginationService.pagination);
            responseDiv.setAttribute("class", "mb-2");

            paginationDiv.setAttribute("id", "pagination_pagination_" + this.PaginationName || PaginationService.pagination);
            paginationDiv.setAttribute("class", "text-sm flex");

            if(renderAt){
                
                if(this.htmlResponseNodes && this.utility)
                    renderAt.appendChild(utilityDiv);

                renderAt.appendChild(responseDiv);
                if(this.has_page) renderAt.appendChild(paginationDiv);
            }
        }
    }

    makeQueryPath(){
        spinner();
        let url = this.resourcesPath;
        let page = this.currentPage;
        let perPage = this.perPage;
        let search = this.search ? this.search : '';
        var filterUrl = '';

        for (const slug in this.filter) {
           filterUrl += `&${slug}=${this.filter[slug]}`;
        }

        let query_url = `?page=${page}&per_page=${perPage?perPage:''}&search=${search?search:''}${filterUrl}`;
        return url+query_url;
    }

    makeResponseNode(responseData){
        responseData.forEach((item)=>{
            if(item.html){
                this.htmlResponseNodes += item.html;
            }
        });
    }

    makePaginationNode(paginationData){
        let opening = '<div class="join mx-auto">';
        let closed = '</div>';
        let nodes = "";

        let linkLength = paginationData.length;
        let total_loop = 0;
        paginationData.forEach((p)=>{
            let allow = false;
            let nextStep = this.currentPage + 1
            let preStep = this.currentPage - 1

            if(allow){
                if(nextStep >= this.currentPage){
                    if(
                        total_loop <= nextStep && 
                        total_loop >= this.currentPage
                    )   allow = true;
                }
                
                if(preStep >= 1 && preStep <= this.currentPage){
                    if(
                        total_loop >= preStep && 
                        total_loop <= this.currentPage
                    )   allow = true;
                }

                if(total_loop == this.currentPage) allow = true;

                if(
                    total_loop == 0 || 
                    total_loop == 1 ||
                    total_loop == linkLength - 1 ||
                    total_loop == linkLength - 2
                )   allow = true;
            }else{
                allow = true;
            }

            if(allow){
                let label = total_loop == 0  ? "<<" : p.label;
                if(total_loop == (linkLength - 1)){
                    label = ">>";
                }
                nodes += `
                    <input 
                        class="join-item btn btn-square rounded" 
                        type="radio" 
                        name="options" 
                        aria-label="${label}" 
                        ${p.active ? "checked" : ""}
                        ${p.url ? 'onchange="document.pagination'+(this.PaginationName || PaginationService.pagination)+'.renderPage(\''+ p.label +'\')"' : ""}
                    />
                `;
            }
            
            total_loop++;
        });

        this.nodes = opening+nodes+closed;
    }

    renderAt(node){
        this.renderSelector = node;
        return this;
    }

    renderPage(page){
        if(page && !isNaN(page)) this.currentPage = page;
        this.rerender(this.makeQueryPath());
    }

    async rerender(url){
        await $.get(
            url,
            (response) => {
                if(response.data && response.data.length){
                    this.has_data = true;
                    this.htmlResponseNodes = "";
                    this.nodes = "";
                    this.makePaginationNode(response.links);
                    this.makeResponseNode(response.data);
                }else{
                    this.has_data = false;
                    this.nodes = " ";
                    this.htmlResponseNodes = this.dataNotFound ? this.dataNotFound : "Data Not Found";
                }
            }
        )

        this.renderAtTarget();
    }

    async renderPerPageItem(items){
        if(this.resourcesPath){
            this.currentPage = 1;
            this.perPage = items;
            await this.rerender(this.makeQueryPath());
        }
    }

    async renderSearch(){
        await this.rerender(this.makeQueryPath());
    }

    renderAtTarget(){
        // render response data in div
        let response = document.querySelector(this.responseSelector);
        if(response && this.htmlResponseNodes){
            if(this.has_data){
                response.innerHTML = 
                    this.beforeHtmlResponseNodes
                    +this.htmlResponseNodes+
                    this.afterHtmlResponseNodes;
            }else{
                response.innerHTML = 
                    this.beforeHtmlResponseNodes
                    +this.afterHtmlResponseNodes;
                response.append(this.htmlResponseNodes);
            }
        }

        // render response  pagination in div
        let pagination = document.querySelector(this.paginationSelector);
        if(pagination && this.nodes){
            pagination.innerHTML = this.nodes;
        }
        spinner(false);
    }

    async boot() {
        if(!this.resourcesPath){
            console.log("resourcesPath path not found");
        }

        await $.get(
            this.resourcesPath,
            //this.processResponseData
            (response) => {
                if(response.data && response.data.length){
                    this.has_page = response.last_page > 1;
                    this.makePaginationNode(response.links);
                    this.makeResponseNode(response.data);
                }
            }
        )

        this.createElements();
        this.renderAtTarget();
        
        if(this.PaginationName) document[this.PaginationName] = this;
        document['pagination'+this.PaginationName || PaginationService.pagination] = this;
        return this;
    }

    exit(){
        return this.providerService;
    }
}
export default PaginationService;