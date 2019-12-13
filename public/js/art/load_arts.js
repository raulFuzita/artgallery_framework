
var searchBox = document.getElementsByClassName("searchBox");
var previous =  "previous-page", next = "next-page", pagination = "page", active = "page-item.active", like = "like-Art";

loadContent();

function loadContent(){
    // Load all content from a database table
    Controller = "../App/Controller/Art/Arts/LoadArts.Controller.php";
    displayTo = "ajax-content";
    ajaxRequest(displayTo, Controller);

    drawPagination(0);
}

function drawPagination(currentPage){
    // Load the Pagination
    Controller = "../App/Controller/Art/Arts/LoadPagination.Controller.php?page="+currentPage;
    displayTo = "numPagination";
    ajaxRequest(displayTo, Controller);
}

function onclickDetected(target){

    targetClass = target.className.split(" ")[0];

    if(targetClass == "page"){

        if (searchBox[0].value != "") {
            searchBox[0].value = "";
        }

        id = validateId(target);
        number = (id - 1) * 10;
        number = (number < 0) ? 0 : number;
        // Load all content from a database table
        Controller = "../App/Controller/Art/Arts/PageArts.Controller.php?page="+number;
        displayTo = "ajax-content";
        ajaxRequest(displayTo, Controller);

        drawPagination(id);

    } else if (targetClass == like){
        
        let elLike = target.id;

        Controller = "../App/Controller/Art/Features/AjaxLikeClick.Controller.php?idArt="+elLike;
        displayTo = "ajax-content";
        ajaxRequest(displayTo, Controller);

        page = findPagination();

        drawPagination(page);

    } else {

        if(target.tagName == "A"){
            link = target.href;
            window.location = link;
        }
    }
}


function searchContent(text){

    text = callTrim(text);

    if(text.length == 0){
        loadContent();
    } else {
        // Load all content from a database table
        Controller = "../App/Controller/Art/Arts/SearchArts.Controller.php?search="+text;
        displayTo = "ajax-content";
        ajaxRequest(displayTo, Controller);
    }
}

function callTrim(x) {
    return x.replace(/^\s+|\s+$/gm,'');
}


function validateId(target){

    let id = target.id;
    let element = document.getElementsByClassName(pagination);
    let elActive = document.querySelector('li.'+active+' > a');
    let size = element.length;

    if(!isNaN(id)){
        return (id < 0) ? 0 : id;
    } else if(id == previous || id == next){

        if(size > 2 && elActive != null){
            
            if(id == previous){
                min = (elActive.id > element[1].id) ? parseInt(elActive.id)-1 : element[1].id;
                return min;
            } else {
                max = (elActive.id < size-1) ? parseInt(elActive.id)+1 : size-1;
                return max;
            }
        }
    }
    return 0;
}

function findPagination(){

    let elActive = document.querySelector('li.'+active+' > a');

    if(elActive != null){
        return elActive.id;
    }
    return 0;
}