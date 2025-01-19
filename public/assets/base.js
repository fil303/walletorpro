function smSidebarToggle() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle("sm:hidden");
}

document.addEventListener('DOMContentLoaded', () => {
    // Toggle sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    let tog   = 0;
    let toged = 2;

    sidebarToggle.addEventListener('click', () => {
        tog++;
        if( tog == toged ){
            // sidebar.classList.toggle('hidden');
            const smMediaQuery = window.matchMedia('(min-width: 640px)').matches;
            if (!smMediaQuery) {
                if (sidebar.classList.contains("hidden"))
                    sidebar.classList.remove("hidden");

                sidebar.classList.toggle("sm:hidden");
            } else {
                sidebar.classList.toggle("hidden");
            }
            tog = 0;
        }
    });
});

function spinner(turnOn = true){
    if(turnOn){
        if (document.querySelector(".spinner").classList.contains("hidden")){
            document.querySelector(".spinner").classList.remove("hidden");
        }
    }else{
        if (!document.querySelector(".spinner").classList.contains("hidden")){
            document.querySelector(".spinner").classList.add("hidden");
        }
    }
}

window.addEventListener("load", (event) => {
    spinner(false);
});

