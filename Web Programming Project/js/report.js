const tabs = document.querySelectorAll(".tab");
const tableReports = document.querySelectorAll('.table-report');

tabs.forEach( tab => {
    tab.addEventListener( 'click', e=>{

        const dataDetail = e.currentTarget.getAttribute('data-detail');
        hideAllReports();
        tableReports.forEach( r => {
            if( r.getAttribute('data-detail') == dataDetail ){
                r.classList.add('show');
            }
        } )
        
        if( !tab.classList.contains( 'active' ) ){
            remove();
            tab.classList.add( 'active' );
        }
        
    } )
} )

function hideAllReports(){
    tableReports.forEach( r => r.classList.remove('show') );
}

function remove(){
    tabs.forEach( tab => tab.classList.remove( 'active' ) );
}