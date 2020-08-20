import Types from "../types/global-types";

const bodyElement = document.querySelector('body');

function setGlobalType(type){
    clearGlobalTypes();
    bodyElement.classList.add('global-'+type);
}

function clearGlobalTypes(){
    bodyElement.classList.forEach(function(item){
        if(item.includes('global-'))
            bodyElement.classList.remove(item);
    });
}

function pauseTabata(){
    bodyElement.classList.toggle('pause');
}
export default {
    setGlobalType,
    clearGlobalTypes,
    pauseTabata,
    Types
};
