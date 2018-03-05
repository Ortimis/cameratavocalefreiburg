// Calculate clients viewport

function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ]};
}

var w=window,d=document,
e=d.documentElement,
g=d.getElementsByTagName('body')[0],
x=w.innerWidth||e.clientWidth||g.clientWidth; // Viewport Width

// Load preloader only on Home Page and page width larger than 1024px

// Check if it is home page
var home_page = js_vars.front_page;

if(home_page == 'front_page' && x > 1024){
    jQuery.getScript(js_vars.theme_url+'/js/loader/preloader.js');
}